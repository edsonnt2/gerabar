<?php
if($busca_cmd_bar=="busca_comanda_mesa"){
include($inclu."_classes/Mesas.class.php");
$parteMesa=true;
}else{
include($inclu."_classes/Comandas.class.php");
}
	$countCmd = count($arraCmd);
	$aumentaCmd=0;
	$valDescontar=0;
	$valTotalPagar=0;
	$valorDeCada='';
	foreach($arraCmd as $comanda){	
	$aumentaCmd++;
	
	if(isset($parteMesa)){
		$comanda = (int)$comanda;		
		$buscCmd=Mesas::selMesaPagar($id_empresa,$comanda);
		$numMesaCmd=$buscCmd['num'];
		$consumoMesaCmd=0;
		$qualDesconta='mesa';
	}else{
		if(strlen($comanda)==1){
		$comanda = '0'.$comanda;
		}
		$cmdBusCliente=Comandas::clienteCmd($id_empresa,$comanda);
		$numMesaCmd=$cmdBusCliente['num'];
		$consumoMesaCmd=$cmdBusCliente['dados'][2];
		$qualDesconta='comanda';
	}
	
	if($numMesaCmd>0){
		$mostrabotao=true;
		if($aumentaCmd==1){
		echo '<span style="display:none;" id="countLinha">'.$countCmd.'</span>';
		echo '<div class="info_topo_cad" style="margin-top:20px;"></div><!--fecha info topo cad-->
			<div id="info-nomeCmd">';
				if(isset($parteMesa)){
				echo '<div id="if_nome" style=" width:530px;">comanda mesa</div>';
				}else{
	            echo '<div id="if_nome">nome do cliente</div>
               	<div id="if_comanda">comanda</div>';
				}
                echo '<div id="if_valTotCmd">valor <span>da comanda</span></div>
                <div id="if_acao">ação</div>
            </div><!--info-nomeCmd-->';
		}
			echo '<div class="cont-nomeCmd">';
				if(isset($parteMesa)){
					$cmdMesa=($comanda<10)?'0'.$comanda:$comanda;
				echo '<div class="ct_nome" style=" width:530px;">MESA <span class="sp_cmd_pegar-'.$aumentaCmd.'">'.$cmdMesa.'</span></div>';
				$valBuscCliente="";
				}else{
	            echo '<div class="ct_nome">'.$cmdBusCliente['dados'][0].'</div>
                <div class="ct_comanda"><span class="sp_cmd_pegar-'.$aumentaCmd.'">'.$comanda.'</span></div>';				
				$buscCmd=Comandas::trazesCmdBar($id_empresa,$comanda); 
				if($cmdBusCliente['dados'][1]<>""){
				$valBuscCliente=$cmdBusCliente['dados'][1];	
				}else{
				$valBuscCliente=($cmdBusCliente['dados'][3]=="sim")?"0":$cmdBusCliente['dados'][1];
				}
				
				}
                echo '<div class="ct_valTotCmd">R$ <span class="sp_cmd_val-'.$aumentaCmd.'">0,00</span></div>
                <div class="ct_acao">'; 
				if($valBuscCliente<>"" || $buscCmd['num']>0){
				echo '<a href="javascript:void(0);" id="mostra-'.$aumentaCmd.'" >'; if($aumentaCmd==$countCmd){ echo 'esconder <span class="s_esconder">comanda</span>';}else{ echo 'mostrar <span class="s_mostrar">comanda</span>';} echo '</a>'; 
				}
				echo '</div>
            </div><!--cont-nomeCmd-->';
            echo '
			<span style=" display:none;" class="consumo-'.$aumentaCmd.'">'; echo ($consumoMesaCmd==1)?'1':'0'; echo'</span>
            <ul class="ul_consulta_cmd" '; if($aumentaCmd==$countCmd){ echo 'style="display:block;"';} echo ' id="tudo-'.$aumentaCmd.'">';			
				$valTotalProd=0;
				if($valBuscCliente<>"" || $buscCmd['num']>0){
				echo '<li class="topo_consulta_cmd">
	            <div class="tp_produto">produto</div>
                <div class="tp_garcon">garçon</div>            
                <div class="tp_valUnitario">valor unit.</div>
				<div class="tp_quant">quant.</div>
                <div class="tp_valTotal">valor<span class="s_data_toda"> total</span></div>
				<div class="tp_dataHora">data<span class="s_data_toda"> e hora</span></div>
                <div class="tp_acao">ação</div>
	            </li><!--topo_consulta_cmd-->';
				}
				if($buscCmd['num']>0){
				foreach($buscCmd['dados'] as $asCmdBar){
				$valTotalCmd=$asCmdBar['quantidade']*$asCmdBar['valor'];
				$valTotalProd=$valTotalProd+$valTotalCmd;
				$nomeDoProd=($asCmdBar['id_produto']==0)?$asCmdBar['descricao'].' '.$asCmdBar['marca']:$asCmdBar['marca'].' '.$asCmdBar['descricao'];									
				echo '<li id="liCmd-'.$asCmdBar['id'].'" class="'.$asCmdBar['id_produto'].'">
                <div class="li_tp_produto">'.limitiCaract($nomeDoProd,40).'</div>
                <div class="li_tp_garcon d_mostra_garcon"><span class="s_li_tp_respansivo">garçon:&nbsp;</span> <span class="pega_mostra_garcon">'.$asCmdBar['garcon'].'</span>
				<div class="mostra_garcon loading-garcon">
					<div class="ponta-info-func"></div>
					<div class="cont-garcon"></div>
				</div>
				</div>
                <div class="li_tp_valUnitario"><span class="s_li_tp_respansivo">valor unit.:&nbsp;</span> R$ '.number_format($asCmdBar['valor'],2,',','.').'</div>
				<div class="li_tp_quant"><span class="s_li_tp_respansivo">quant.:&nbsp;</span> <span class="numQuantDel">'.$asCmdBar['quantidade'].'</span></div>
                <div class="li_tp_valTotal"><span class="s_li_tp_respansivo">valor total:&nbsp;</span> R$ <span id="pegaCmdVal-'.$asCmdBar['id'].'" class="'.$valTotalCmd.'">'.number_format($valTotalCmd,2,',','.').'</span></div>
				<div class="li_tp_dataHora">'.date('d/m/Y H:i:s',strtotime($asCmdBar['cadastro'])).'</div>
                <div class="li_tp_acao"><a href="javascript:void(0);" id="'.$asCmdBar['id'].'-'.$aumentaCmd.'-cmdId" class="cmd_delete" title="Excluir produto da comanda"></a></div>
                </li>';
				}}
				
			if(isset($parteMesa)==false){
				if($cmdBusCliente['dados'][1]<>""){
				echo '<li>
                <div class="li_tp_produto">';
				echo ($cmdBusCliente['dados'][2]==1)?'CONSUMAÇÃO DE R$ ':'ENTRADA NO VALOR DE R$ ';
				echo number_format($cmdBusCliente['dados'][1],2,',','.'); echo ($cmdBusCliente['dados'][6]==1)?' (pago)':''; echo '</div>
                <div class="li_tp_garcon d_mostra_garcon"><span class="s_li_tp_respansivo">garçon:&nbsp;</span> <span class="pega_mostra_garcon">'.$cmdBusCliente['dados'][7].'</span>
				<div class="mostra_garcon loading-garcon">
					<div class="ponta-info-func"></div>
					<div class="cont-garcon"></div>
				</div>				
				</div>
                <div class="li_tp_valUnitario"><span class="s_li_tp_respansivo">valor unit.:&nbsp;</span> R$ '; echo ($cmdBusCliente['dados'][6]==1)?'-':''; echo number_format($cmdBusCliente['dados'][1],2,',','.').'</div>
				<div class="li_tp_quant"><span class="s_li_tp_respansivo">quant.:&nbsp;</span> 1</div>
                <div class="li_tp_valTotal"><span class="s_li_tp_respansivo">valor total:&nbsp;</span> R$ '; echo ($cmdBusCliente['dados'][6]==1)?'-':''; echo number_format($cmdBusCliente['dados'][1],2,',','.').'</div>
				<div class="li_tp_dataHora">'.date('d/m/Y H:i:s',strtotime($cmdBusCliente['dados'][5])).'</div>
                <div class="li_tp_acao"></div>
                </li>';
				}
				
				if($cmdBusCliente['dados'][3]=="sim"){
					echo '<li>
					<div class="li_tp_produto">VALE CONSUMAÇÃO</div>
					<div class="li_tp_garcon d_mostra_garcon"><span class="s_li_tp_respansivo">garçon:&nbsp;</span> <span class="pega_mostra_garcon">'.$cmdBusCliente['dados'][7].'</span>
					<div class="mostra_garcon loading-garcon">
					<div class="ponta-info-func"></div>
					<div class="cont-garcon"></div>
					</div>
					</div>
					<div class="li_tp_valUnitario"><span class="s_li_tp_respansivo">valor unit.:&nbsp;</span> R$ -'.number_format($cmdBusCliente['dados'][4],2,',','.').'</div>
					<div class="li_tp_quant"><span class="s_li_tp_respansivo">quant.:&nbsp;</span> 1</div>
					<div class="li_tp_valTotal"><span class="s_li_tp_respansivo">valor total:&nbsp;</span> R$ -'.number_format($cmdBusCliente['dados'][4],2,',','.').'</div>
					<div class="li_tp_dataHora">'.date('d/m/Y H:i:s',strtotime($cmdBusCliente['dados'][5])).'</div>
					<div class="li_tp_acao"></div>
					</li>';
					$valTotalProd=$valTotalProd-$cmdBusCliente['dados'][4];
				}
				
			}else{
				
				//COLOCA PARA ATIVAR NAS CONFIGURAÇÕES
				/*
				$porcGarcon=($valTotalProd/100)*10;
				echo '<li>
					<div class="li_tp_produto">serviço</div>
					<div class="li_tp_garcon"><span class="s_li_tp_respansivo">garçon:&nbsp;</span> isento</div>
					<div class="li_tp_valUnitario"><span class="s_li_tp_respansivo">valor unit.:&nbsp;</span> 10%</div>
					<div class="li_tp_quant"><span class="s_li_tp_respansivo">quant.:&nbsp;</span> 1</div>
					<div class="li_tp_valTotal"><span class="s_li_tp_respansivo">valor total:&nbsp;</span> R$ <span class="sp_cmd_servico-'.$aumentaCmd.'">'.number_format($porcGarcon,2,',','.').'</span></div>
					<div class="li_tp_dataHora">'.date('d/m/Y H:i:s').'</div>
					<div class="li_tp_acao"><a href="javascript:void(0);" id="0-'.$aumentaCmd.'-cmdId" class="cmd_delete" title="Excluir serviço da comanda"></a></div>
					</li>';
					$valTotalProd=$valTotalProd+$porcGarcon;
					*/
			}
			
			$descontar=Cadastros::trazerDescontar($id_empresa,$comanda,$qualDesconta);
			if($descontar['num']>0){
				foreach($descontar['dados'] as $asDescontar){
				echo '<li id="liCmdDesc-'.$asDescontar['id'].'" class="0">
                <div class="li_tp_produto">VALOR DESCONTADO</div>
                <div class="li_tp_garcon d_mostra_garcon"><span class="s_li_tp_respansivo">garçon:&nbsp;</span> <span class="pega_mostra_garcon">'.$asDescontar['garcon'].'</span>
				<div class="mostra_garcon loading-garcon">
					<div class="ponta-info-func"></div>
					<div class="cont-garcon"></div>
				</div>				
				</div>
                <div class="li_tp_valUnitario"><span class="s_li_tp_respansivo">valor unit.:&nbsp;</span> R$ -'.number_format($asDescontar['valor'],2,',','.').'</div>
				<div class="li_tp_quant"><span class="s_li_tp_respansivo">quant.:&nbsp;</span> <span class="numQuantDel">1</span></div>
				<div class="li_tp_valTotal"><span class="s_li_tp_respansivo">valor total:&nbsp;</span> R$ <span id="pegaCmdValDesc-'.$asDescontar['id'].'" class="-'.$asDescontar['valor'].'">-'.number_format($asDescontar['valor'],2,',','.').'</span></div>
				<div class="li_tp_dataHora">'.date('d/m/Y H:i:s',strtotime($asDescontar['cadastro'])).'</div>
				<div class="li_tp_acao"><a href="javascript:void(0);" id="'.$asDescontar['id'].'-'.$aumentaCmd.'-descontarId" class="cmd_delete" title="Excluir desconto da comanda"></a></div>
                </li>';
				$valDescontar=$valDescontar+$asDescontar['valor'];
				}
			}
				
			if($countCmd>1){
			$valorEntrada=($cmdBusCliente['dados'][1]=="")?0:$cmdBusCliente['dados'][1];
			echo '<li class="li_valFinal_cmd_junta" id="totalCada-'.$aumentaCmd.'">';
				if($consumoMesaCmd==1){
					$valTotalProd-=$valDescontar;
					$valDescontar=0;
					if($valTotalProd<$valorEntrada){						
						$valResta = $valorEntrada-$valTotalProd;					
						if($cmdBusCliente['dados'][6]==1){
						$novo=0;
						echo '<div class="'.$valorEntrada.'">RESTA CONSUMIR R$ <span id="resto_val" class="'.$valResta.'">'.number_format($valResta,2,',','.').'</span> DA CONSUMAÇÃO<span id="valTotalComanda-'.$aumentaCmd.'" class="'.$valTotalProd.'" style="display:none;">'.number_format($novo,2,',','.').'</span></div>';
						}else{
						$novo=$valorEntrada;
						echo '<div class="'.$novo.'">resta R$ <span id="resto_val" class="'.$valResta.'">'.number_format($valResta,2,',','.').'</span> DA CONSUMAÇÃO DE R$ <span id="valTotalComanda-'.$aumentaCmd.'" class="'.$valTotalProd.'">'.number_format($novo,2,',','.').'</span></div>';
						}					
						$valTotalPagar+=$novo;
						$valorDeCada.=number_format($novo,2,',','.');					
					}else{					
						if($cmdBusCliente['dados'][6]==1){ $valTotalProd=$valTotalProd-$valorEntrada; $novo=0;}else{$novo=$valorEntrada;}						
						echo '<div class="'.$novo.'">valor total da comanda R$ <span id="valTotalComanda-'.$aumentaCmd.'" class="'.$valTotalProd.'">'.number_format($valTotalProd,2,',','.').'</span></div>';
						$valTotalPagar+=$valTotalProd;
						$valorDeCada.=number_format($valTotalProd,2,',','.');
					}
					
				}else{
					if(isset($parteMesa)==false){
					$valTotalProd=$valTotalProd+$valorEntrada;
					if($valTotalProd<$valorEntrada){
					$valTotalProd=$valorEntrada;
					}
					if($cmdBusCliente['dados'][6]==1){ $valTotalProd=$valTotalProd-$valorEntrada;}
					$dados1=$valorEntrada;
					}else{
					$dados1=0;
					}
					$valTotalProd-=$valDescontar;
					$valDescontar=0;
				echo '<div class="'.$dados1.'">valor total da comanda R$ <span id="valTotalComanda-'.$aumentaCmd.'" class="'.$valTotalProd.'">'.number_format($valTotalProd,2,',','.').'</span></div>';
				$valTotalPagar+=$valTotalProd;
				$valorDeCada.=number_format($valTotalProd,2,',','.');
				}
			echo '</li>';
			}
			echo '</ul><!--ul_consulta_cmd-->';
			if($aumentaCmd==$countCmd){
			echo '<div id="mosta_total_cmd" class="0">';
			if($countCmd==1){
			if($consumoMesaCmd==1){
				if($valTotalProd<$cmdBusCliente['dados'][1]){
					
					$valResta = $cmdBusCliente['dados'][1]-$valTotalProd;
					if($cmdBusCliente['dados'][6]==1){ 
					$novo=0;
					echo '<div class="'.$cmdBusCliente['dados'][1].'">RESTA CONSUMIR R$ <span id="resto_val" class="'.$valResta.'">'.number_format($valResta,2,',','.').'</span> DA CONSUMAÇÃO<span id="valTotalComanda" class="'.$valTotalProd.'" style="display:none;">'.number_format($novo,2,',','.').'</span></div>';
					}else{ 
					$novo=$cmdBusCliente['dados'][1];
					echo '<div class="'.$novo.'">resta R$ <span id="resto_val" class="'.$valResta.'">'.number_format($valResta,2,',','.').'</span> DA CONSUMAÇÃO DE R$ <span id="valTotalComanda" class="'.$valTotalProd.'">'.number_format($novo,2,',','.').'</span></div>';
					}
					$valTotalPagar+=$novo;
					$valorDeCada.=number_format($novo,2,',','.');
					
				}else{
					if($cmdBusCliente['dados'][6]==1){ $valTotalProd=$valTotalProd-$cmdBusCliente['dados'][1]; $novo=0;}else{$novo=$cmdBusCliente['dados'][1];}
					echo '<div class="'.$novo.'">valor total da comanda R$ <span id="valTotalComanda" class="'.$valTotalProd.'">'.number_format($valTotalProd,2,',','.').'</span></div>';
					$valTotalPagar+=$valTotalProd;
					$valorDeCada.=number_format($valTotalProd,2,',','.');
				}
			}else{
				if(isset($parteMesa)==false){
					if($cmdBusCliente['dados'][1]<>""){
						$valTotalProd=$valTotalProd+$cmdBusCliente['dados'][1];
						if($valTotalProd<$cmdBusCliente['dados'][1]){
						$valTotalProd=$cmdBusCliente['dados'][1];
						}				
						if($cmdBusCliente['dados'][6]==1){ $valTotalProd=$valTotalProd-$cmdBusCliente['dados'][1];}				
						$dados1=$cmdBusCliente['dados'][1];
					}else{
						if($valTotalProd<0){$valTotalProd=0;}
						$dados1=0;
					}
				
				}else{
				$dados1=0;
				}
				$valTotalProd-=$valDescontar;
				$valDescontar=0;
				
			echo '<div class="'.$dados1.'">valor total da comanda R$ <span id="valTotalComanda" class="'.$valTotalProd.'">'.number_format($valTotalProd,2,',','.').'</span></div>';
			
			$valTotalPagar+=$valTotalProd;
			$valorDeCada.=number_format($valTotalProd,2,',','.');
			}
			}else{			
			echo '<div class="0">valor total a ser pago R$ <span id="valTotalComanda" class="'.$valTotalPagar.'">'.number_format($valTotalPagar,2,',','.').'</span></div>';
			}
			echo '</div>';
			}
			$valorDeCada.='|';			
			if($aumentaCmd==$countCmd){ echo '<span class="valorDeCada" style="display:none;">'.$valorDeCada.'</span>';}
	}else{
		echo '<div id="mosta_total_cmd" class="1"><div style="float:left; margin-left:'; echo (isset($caixa))?'55':'10'; echo 'px;">'; if(isset($parteMesa)){ echo 'Mesa não aberta ou';}else{ echo 'Comanda';} echo ' não encontrada !</div></div>';
	}
	}
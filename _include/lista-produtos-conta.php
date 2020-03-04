<?php
if(!isset($valDesconto)){$valDesconto=0;}
if(isset($agrupa) AND $agrupa=='sim'){
	$condicaoData = false;
	}else{
	$condicaoData = date('Y-m-d', strtotime("-1 days"));
	$listaConta1 = Clientes::selectConta($idCliente,$id_empresa,0,$condicaoData,true);
	if($listaConta1['num']>0){
		foreach($listaConta1['dados'] as $Aslista1){
			$nomeProd=($Aslista1["id_produto"]==0)?$Aslista1["nome_produto"].' (diversos)':$Aslista1["nome_produto"];
			echo '
			<li class="li-inner" id="'.$Aslista1["id"].'-li">
				 <input type="hidden" class="idProd" value="'.$Aslista1['id_produto'].'" />'; 
				 if($colocaIdConta==0){ 											 
					echo '<input type="hidden" class="idContaCliente" value="'.$Aslista1['id_conta'].'" />';
				   $colocaIdConta=1;
				 } 
				 echo '<div class="d_produto_contas'; if($Aslista1['testeQuant']==$Aslista1['quantidade']){ echo ' marginTopConta';} echo '">'.limitiCaract($nomeProd,40).'</div>';											 
				 if($Aslista1['testeQuant']<$Aslista1['quantidade']){
				 echo '<div class="d_func_contas">agrup.</div>';
				 }else{
					echo '<div class="d_func_contas d_mostra_garcon"><span class="s_li_abreFecha_respansivo">nº func.:&nbsp;</span> <span class="pega_mostra_garcon">'.$Aslista1["codigo_operador"].'</span>
					 <div class="mostra_garcon loading-garcon">
						<div class="ponta-info-func"></div>
						<div class="cont-garcon"></div>
					 </div>
					 </div>';
				 }
				 echo '<div class="d_val_contas"><span class="s_li_abreFecha_respansivo">valor unit.:&nbsp;</span> R$ <span class="valParaPagar">'.number_format($Aslista1["valor"],2,',','.').'</span></div>
				 <div class="d_quant_contas"><span class="s_li_abreFecha_respansivo">quant.:&nbsp;</span> <span class="quantParaPagar">'.$Aslista1["quantidade"].'</span></div>
				 <div class="d_valtotal_contas"><span class="s_li_abreFecha_respansivo">valor total:&nbsp;</span> R$ <span class="valProdConta">'.number_format($Aslista1['total'],2,',','.').'</span></div>
				 <div class="d_data_contas">'.date('d/m/Y H:i:s',strtotime($Aslista1["data"])).'</div>';
				 if($Aslista1['testeQuant']==$Aslista1['quantidade']){
					echo '<div class="d_acao_contas">
					<span class="s_paga_conta">
						<a href="javascript:void(0);" title="Pagar esse produto" class="addImgPagar"><!--Pagar--></a>
					</span>
					<span class="s_delete_conta">
						<a href="javascript:void(0);" title="Excluir" class="addImgDel"><!--excluir--></a>
					</span></div>';
				 }
				  echo '
			  </li>';
			$total = ($Aslista1['total']+$total);
		}
	}
	}
	$listaConta = Clientes::selectConta($idCliente,$id_empresa,0,$condicaoData);
	if($listaConta['num']>0){
		foreach($listaConta['dados'] as $Aslista){
			$total+=$Aslista['total'];
			$nomeProd=($Aslista["id_produto"]==0)?$Aslista["nome_produto"].' (diversos)':$Aslista["nome_produto"];			
			echo '
				<li class="li-inner" id="'.$Aslista["id"].'-li">
					 <input type="hidden" class="idProd" value="'.$Aslista['id_produto'].'" />'; 
					 if($colocaIdConta==0){ 											 
						echo '<input type="hidden" class="idContaCliente" value="'.$Aslista['id_conta'].'" />';
					   $colocaIdConta=1;
					 } 
					 echo '<div class="d_produto_contas marginTopConta">'.limitiCaract($nomeProd,40).'</div>
					 <div class="d_func_contas d_mostra_garcon"><span class="s_li_abreFecha_respansivo">nº func.:&nbsp;</span> <span class="pega_mostra_garcon">'.$Aslista["codigo_operador"].'</span>
					 <div class="mostra_garcon loading-garcon">
						<div class="ponta-info-func"></div>
						<div class="cont-garcon"></div>
					 </div>											 
					 </div>
					 <div class="d_val_contas"><span class="s_li_abreFecha_respansivo">valor unit.:&nbsp;</span> R$ <span class="valParaPagar">'.number_format($Aslista["valor"],2,',','.').'</span></div>
					 <div class="d_quant_contas"><span class="s_li_abreFecha_respansivo">quant.:&nbsp;</span> <span class="quantParaPagar">'.$Aslista["quantidade"].'</span></div>
					 <div class="d_valtotal_contas"><span class="s_li_abreFecha_respansivo">valor total:&nbsp;</span> R$ <span class="valProdConta">'.number_format($Aslista['total'],2,',','.').'</span></div>
					 <div class="d_data_contas">'.date('d/m/Y H:i:s',strtotime($Aslista["data"])).'</div>
					 <div class="d_acao_contas">
						<span class="s_paga_conta">
							<a href="javascript:void(0);" title="Pagar esse produto" class="addImgPagar"><!--Pagar--></a>
						</span>
						<span class="s_delete_conta">
							<a href="javascript:void(0);" title="Excluir" class="addImgDel"><!--excluir--></a>
						</span>
					  </div>
				  </li>';
		}		
	}
	
	$descontar=Cadastros::trazerDescontar($id_empresa,$idCliente,'conta');
	if($descontar['num']>0){
		$numInner=0;		
		foreach($descontar['dados'] as $asDescontar){
			echo '<li class="'; if($numInner==0){ echo 'inner-desconta'; $numInner=1;}else{ echo 'inner-desc';} echo '" id="'.$asDescontar["id"].'-liDesc">
					<div class="d_produto_contas marginTopConta">VALOR DESCONTADO</div>
					 <div class="d_func_contas d_mostra_garcon"><span class="s_li_abreFecha_respansivo">nº func.:&nbsp;</span> <span class="pega_mostra_garcon">'.$asDescontar["garcon"].'</span>
					 <div class="mostra_garcon loading-garcon">
						<div class="ponta-info-func"></div>
						<div class="cont-garcon"></div>
					 </div>											 
					 </div>
					 <div class="d_val_contas"><span class="s_li_abreFecha_respansivo">valor unit.:&nbsp;</span> R$ <span class="valParaPagar">-'.number_format($asDescontar["valor"],2,',','.').'</span></div>
					 <div class="d_quant_contas"><span class="s_li_abreFecha_respansivo">quant.:&nbsp;</span> <span class="quantParaPagar">1</span></div>
					 <div class="d_valtotal_contas"><span class="s_li_abreFecha_respansivo">valor total:&nbsp;</span> R$ <span class="valProdConta">-'.number_format($asDescontar['valor'],2,',','.').'</span></div>
					 <div class="d_data_contas">'.date('d/m/Y H:i:s',strtotime($asDescontar["cadastro"])).'</div>
					 <div class="d_acao_contas">
						<span class="s_delete_conta">
							<a href="javascript:void(0);" title="Excluir" class="addImgDel"><!--excluir--></a>
						</span>
					  </div>
				  </li>';
				  $valDesconto+=$asDescontar['valor'];
		}
	}
	$total-=$valDesconto; 
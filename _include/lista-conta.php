<div id="div_info_credito">
			<span id="so_contas">contas de clientes</span>
			<span id="codigo_credito">cód. conta</span>
        	<span id="nome_credito">nome cliente</span>
            <span id="val_credito">valor total</span>
            <span id="status_credito">data aberta</span>
            <span id="acao_credito">ação</span>
        </div>
        
        <ul id="ul_lista_contas">		
			<?php			
			$valTotalDescontar=DB::getConn()->prepare("SELECT SUM(valor) AS total FROM descontar WHERE id_empresa=? AND idCMC=? AND qualTBL=? AND idfechado=0");			
			foreach($trasDadosForm['dados'] as $asDados){
			$dadosClient=Cadastros::selectArray($user_id_empresa,"clientes",false,false,$asDados["id_cliente"]);			
			$valTotalDescontar->execute(array($user_id_empresa,$asDados["id_cliente"],'conta'));
			if($valTotalDescontar->rowCount()>0){
			$valorTotalDesc=$valTotalDescontar->fetch(PDO::FETCH_ASSOC);
			$valorTotalDesconto=$valorTotalDesc['total'];
			}else{
			$valorTotalDesconto=0;
			}			
        	echo '<li class="'.$asDados["id_cliente"].'">
            <div class="separa_conta_0"><span class="s_conta_abreFecha_respansivo">cód. conta: &nbsp;</span><span class="numContaCli">'.$asDados["id_conta"].'</span></div>
            <div class="separa_conta_1">'.$dadosClient['dados']["nome"].'</div>
            <div class="separa_conta_2"><span class="s_conta_abreFecha_respansivo">valor total: &nbsp;</span>R$ <span class="valTotalContaCli">'.number_format($asDados['total']-$valorTotalDesconto,2,',','.').'</span></div>
            <div class="separa_conta_3">';
				// Calcula a diferença de segundos entre as duas datas:
				$diferenca = geraTimestamp(date('d/m/Y'))-geraTimestamp(date('d/m/Y',strtotime($dadosClient['dados']["data_status_conta"]))); // 19522800 segundos
				// Calcula a diferença de dias
				$dias = (int)floor( $diferenca / (60 * 60 * 24));				
				echo '<span class="';
				echo ($dias<=31)?'s_emdia':'s_atrasado';				
				echo '">'.date('d/m/Y',strtotime($dadosClient['dados']["data_status_conta"])).'</span>';
				
            echo '</div>
            <div class="separa_conta_4">
            	<span class="s_acrescenta_conta"><a href="'.getUrl().'contas-clientes.php?cad=contas-abertas&cliente='.removeAcentos($dadosClient['dados']['nome'],'-').'&cod='.$asDados["id_cliente"].'" class="'.$asDados["id_cliente"].'|'.$dadosClient['dados']["nome"].'" title="Editar conta"><!--acrescentar--></a></span>
				<span class="s_fecha_conta"><a href="javascript:void(0);" title="Pagar conta"><!--fecha conta--></a></span>
            </div>
            
            </li>'; } ?>				
			</ul><!--fecha ul_lista_contas-->
			<?php
			if($pgs>1){
			?>
        <div id="pgTudo">
			<div id="d_pri" <?php if($menos==0){ echo 'style="display:none;"';} ?>><a href="<?php echo getUrl(); ?>contas-clientes.php?cad=contas-abertas&pg=1" class="1">Primeiro</a></div>
			<div id="d_ante" <?php if($menos<=1){ echo 'style="display:none;"';} ?>><a href="<?php echo getUrl(); ?>contas-clientes.php?cad=contas-abertas&pg=<?php echo $menos; ?>" class="<?php echo $menos; ?>">Anterior</a></div>
			
    		<span id="select_produto" class="naofaz">
            <span id="select_pg"><?php echo $pagina; ?></span>
            <span class="select_abre_bt" id="select_bt"></span>
            <ul>
            <?php
            	for($i=1;$i <= $pgs;$i++) {
					echo '<li><a href="'.getUrl().'contas-clientes.php?cad=contas-abertas&pg='.$i.'">'.$i.'</a></li>';
				}
            ?>
            </ul>
    	    </span>
	        <div id="d_pro" <?php if($mais>=$pgs){ echo 'style=" display:none;"';} ?>><a href="<?php echo getUrl(); ?>contas-clientes.php?cad=contas-abertas&pg=<?php echo $mais; ?>" class="<?php echo $mais; ?>">Próxima</a></div>
	        <div id="d_ult" <?php if($mais>$pgs){ echo 'style=" display:none;"';} ?>><a href="<?php echo getUrl(); ?>contas-clientes.php?cad=contas-abertas&pg=<?php echo $pgs; ?>" class="<?php echo $pgs; ?>">Último</a></div>
	    </div>
        
        <?php } 
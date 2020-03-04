<?php 
if($qualCad!="comandas-abertas" && $qualCad!="contas-abertas"){ 
?>
<ul class="d_select_lista">
    <li class="s_selecionar"><a href="javascript:void(0);">Selecionar para Deletar</a></li>
    <li class="s_selecionar_tudo"><a href="javascript:void(0);">Selecionar Tudo</a></li>
    <li class="s_acao_sel"><a href="javascript:void(0);">Deletar Selecionados</a></li>
    <li class="s_cancelar_selecao"><a href="javascript:void(0);">Cancelar</a></li>
</ul><!--d_select_lista-->
<?php } ?>

<div id="cont_cmd_abertaFechada" class="cont_so_fechada">
                
            <div id="topo_cmd_abertaFechada" class="<?php if($qualCad=="mesas-fechadas"){ echo 'pg_mesaFecha';}elseif($qualCad=="contas-fechadas"){ echo 'pg_contaFecha';}elseif($qualCad=="vendas-fechadas"){ echo 'pg_vendaFecha';}elseif($qualCad=="caixas-abertos" || $qualCad=="caixas-fechados"){ echo 'pg_caixaFecha';}else{ echo 'pg_cmdFecha';} ?>">
            	<?php				
				if($qualCad=="mesas-fechadas"){
					echo '<div id="tp_nome_cmdFecha" class="fecha_com_mesa">comanda mesa</div>';
				}elseif($qualCad=="vendas-fechadas" || $qualCad=="caixas-abertos" || $qualCad=="caixas-fechados"){
					echo '<div id="tp_nome_cmdFecha" class="fecha_com_mesa">operador</div>';
				}else{
				echo '<div id="tp_nome_cmdFecha">nome '; echo ($qualCad=="contas-fechadas")?'cliente':'completo'; echo '</div>
                <div id="tp_comanda_cmd" class="cmdRespansivoFecha">';  echo ($qualCad=="contas-fechadas")?'conta':'comanda'; echo '</div>';
				}
				?>                
                <div id="tp_valor_cmd">valor <?php echo ($qualCad=="caixas-abertos" || $qualCad=="caixas-fechados")?"caixa":"pago"; ?></div>
                <div id="tp_data_cmd">fechada<span class="s_data_toda"> em</span></div>
                <div id="tp_acao_cmd">ação</div>
                <div id="tp_acao_cmdFecha"></div>
            
            </div><!--topo_resc_busc_cliente-->
            
            <ul id="ul_cmd_abertaFechada">
                <?php
				$bFuncionario=false;
                
				if($qualCad=="contas-fechadas"){
				$ContaCmd="id_conta";
				$garconFunc="func.";
				$operaGarcon='codigo_operador';
				$dataCad='data';
				$monstraEsconde="conta";
				$fechadapor='conta_fechada_por';
				}elseif($qualCad=="vendas-fechadas" || $qualCad=="caixas-abertos" || $qualCad=="caixas-fechados"){
                include($acres."_classes/Operadores.class.php");
                if($qualCad=="caixas-abertos" || $qualCad=="caixas-fechados"){
                $monstraEsconde="caixa";
                $fechadapor='funcionario';
                }else{
                $monstraEsconde="venda";
                $fechadapor='frente_fechada_por';
                }
                $garconFunc="func.";
                $operaGarcon='funcionario';
                $dataCad='cadastro';
                $bFuncionario=true;
                }else{
				$ContaCmd="comanda";
				$garconFunc="garçon";
				$operaGarcon='garcon';
				$dataCad='cadastro';
				$monstraEsconde="comanda";
				$fechadapor='cmd_fechada_por';
				}
                
				$nDel=1;
                foreach($cmdFechadas['dados'] as $AsCmdFechadas){
					if($qualCad!="vendas-fechadas" && $qualCad!="mesas-fechadas" && $qualCad!="caixas-abertos" && $qualCad!="caixas-fechados"){
					if($qualvai=="busca"){
					$nomeCliente=$AsCmdFechadas['nome'];
					}else{
						$selNome=DB::getConn()->prepare("SELECT nome FROM clientes WHERE id=? LIMIT 1");
						$selNome->execute(array($AsCmdFechadas['id_cliente']));
						if($selNome->rowCount()>0){
						$trasNome=$selNome->fetch(PDO::FETCH_ASSOC);
						$nomeCliente=$trasNome['nome'];
						}else{
						$nomeCliente="(CLIENTE APAGADO)";
						}
					}
					}
                echo '<li id="del_cmd_'.$AsCmdFechadas['id'].'" class="liFecha1">                
                    <div class="d_select_list" id="delSelect_'.$AsCmdFechadas['id'].'"><span id="sDel_'.$nDel.'">SELECIONADO</span></div><!--d_select_list-->';
                    $nDel+=1;
				if($qualCad=="vendas-fechadas" || $qualCad=="caixas-abertos" || $qualCad=="caixas-fechados"){
                    if($AsCmdFechadas[$fechadapor]=='a'){
                        $operador='Administrador';
                    }elseif($AsCmdFechadas[$fechadapor]=='isento'){
                        $operador='Universal';
                    }else{
                    $selOpera=Operadores::selUmOperador($id_empresa,$AsCmdFechadas[$fechadapor]);
                    $operador=($selOpera['num']>0)?$selOpera['dados']['nome_operador']:'(OPERADOR APAGADO)';
                    }
                    
				echo '<div class="li_nome_cmdFecha fecha_com_mesa">'.$operador.'</div>';
				}elseif($qualCad=="mesas-fechadas"){
				$cmdMesa=($AsCmdFechadas['cmd_mesa']<10)?'0'.$AsCmdFechadas['cmd_mesa']:$AsCmdFechadas['cmd_mesa'];
				echo '<div class="li_nome_cmdFecha fecha_com_mesa">MESA <span>'.$cmdMesa.'</span></div>';
				}else{
                echo '<div class="li_nome_cmdFecha">'.limitiCaract($nomeCliente,40,false,false).'</div>
                <div class="li_comanda_cmd cmdRespansivoFecha">'.$AsCmdFechadas[$ContaCmd].'</div>';
				}
				echo '<div class="li_valor_cmd">R$ ';
                    if($qualCad=="caixas-abertos" || $qualCad=="caixas-fechados"){
                    $funcFechado=($qualCad=="caixas-abertos")?$AsCmdFechadas[$fechadapor]:$AsCmdFechadas["id_fechado"];
                    $valCxs=AbrirFecharCaixa::valorCaixa($id_empresa,$status,$funcFechado);
                    $ValPagoUp=$valCxs['totalPago']+$valCxs['totalTroco'];
                    }else{
                    $ValPagoUp=$AsCmdFechadas['valor_pago'];    
                    }
                    echo number_format($ValPagoUp,2,',','.').'</div>
                <div class="li_data_cmd"><span class="s_data_toda">'.date('d/m/Y H:i:s',strtotime($AsCmdFechadas['cadastro'])).'</span><span class="s_data_respansiva">'.date('d/m/Y',strtotime($AsCmdFechadas['cadastro'])).'</span></div>
                <div class="li_acao_cmd"><a href="javascript:void(0);" class="'.$AsCmdFechadas['id'].'">mostrar <span class="s_'; 
                    if($monstraEsconde=="comanda"){ echo 'cmd';}elseif($monstraEsconde=="venda"){ echo 'venda';}elseif($monstraEsconde=="caixa"){ echo 'caixa';}else{echo 'conta';}
                    echo '_mostrar">'.$monstraEsconde.'</span></a></div>
                <div class="li_acao_cmdFecha"><a href="javascript:void(0);" class="'.$AsCmdFechadas['id'].'" title="Excluir '.$monstraEsconde.'"></a></div>
                
                    <ul class="ul_mostra_comanda" id="cmdVer-'.$AsCmdFechadas['id'].'">';						
						$valTotalProd=0;
						$mostraTopoProd="";
						if($qualCad=="contas-fechadas"){
						$buscCmd=Clientes::selectConta($AsCmdFechadas['id_cliente'],$id_empresa,$AsCmdFechadas['id']);
						$qualDesconta='conta';
						$qualCMC=$AsCmdFechadas['id_cliente'];
						}elseif($qualCad=="caixas-abertos" || $qualCad=="caixas-fechados"){
                        $buscCmd=AbrirFecharCaixa::selectCaixa($id_empresa,$funcFechado,$status);
						$qualDesconta=false;
                        }elseif($qualCad=="mesas-fechadas"){
						$buscCmd=Mesas::selMesaPagar($id_empresa,$AsCmdFechadas['cmd_mesa'],$AsCmdFechadas['id']);
						$qualDesconta='mesa';
						$qualCMC=$AsCmdFechadas['cmd_mesa'];
						}elseif($qualCad=="vendas-fechadas"){
						$buscCmd=FrenteCaixa::selCaixaPagar($id_empresa,$AsCmdFechadas['frente_fechada_por'],$AsCmdFechadas['id']);
						$qualDesconta='frente_caixa';
						$qualCMC=$AsCmdFechadas['frente_fechada_por'];
						}else{
                        $buscCmd=Comandas::trazesCmdBar($id_empresa,$AsCmdFechadas['comanda'],$AsCmdFechadas['id']);
						$mostraTopoProd=$AsCmdFechadas['valor_entrada'];
						$qualDesconta='comanda';
						$qualCMC=$AsCmdFechadas['comanda'];
						}
                    
                    if($qualCad=="caixas-abertos" || $qualCad=="caixas-fechados"){
                        
                        if($buscCmd['num']>0){
                            echo '<li class="topo_mostra_comanda">
                            <div class="tp_descricao_caixa">descrição</div>
                            <div class="tp_garcon_comanda">'.$garconFunc.'</div>
                            <div class="tp_data_caixa">data e hora</div>                           
                            </li>';
                            $nn=1;
                            foreach($buscCmd['dados'] as $asCmdBar){
                            echo '<li>
                                <div class="li_tp_pago_caixa">PAGO EM DINHEIRO R$ '.number_format($asCmdBar['pago_dinheiro'],2,',','.').'</div>
                                <div class="li_tp_pago_caixa">PAGO EM CARTÃO R$ '.number_format($asCmdBar['pago_cartao'],2,',','.').'</div>
                                <div class="li_tp_garcon_comanda d_mostra_garcon"><span class="s_li_abreFecha_respansivo">garçon:&nbsp;</span> <span class="pega_mostra_garcon">'.$asCmdBar[$operaGarcon].'</span>
                                <div class="mostra_garcon loading-garcon">
                                <div class="ponta-info-func"></div>
                                <div class="cont-garcon"></div>
                                </div>
                                </div>                           
                                <div class="li_tp_data_caixa">'.date('d/m/Y H:i:s',strtotime($asCmdBar[$dataCad])).'</div>
                            </li>';
                                
                                if($nn<$buscCmd['num']){
                                   $nn++; 
                                }else{
                                    echo '<li>
                                <div class="li_tp_troco_caixa">TROCO EM CAIXA R$ '.number_format($asCmdBar['troco'],2,',','.').'</div>
                            </li>';
                                    
                                }
                                
                            }
                            
                        }
                        
                    }else{
						
						if($mostraTopoProd<>"" || $buscCmd['num']>0 || $AsCmdFechadas['id_descontar']<>0){
                        echo '<li class="topo_mostra_comanda">
                            <div class="tp_produto_comanda">produto</div>
                            <div class="tp_garcon_comanda">'.$garconFunc.'</div>
                            <div class="tp_valUnitario_comanda">valor unit.</div>
							<div class="tp_quant_comanda">qtd</div>
                            <div class="tp_valTotal_comanda">valor total</div>
                            <div class="tp_dataHora_comanda">data e hora</div>
                            <div class="tp_acao_comanda">ação</div>                                
                        </li>';
						}
                        
                        foreach($buscCmd['dados'] as $asCmdBar){
                            $valTotalCmd=$asCmdBar['quantidade']*$asCmdBar['valor'];
                            $valTotalProd=$valTotalProd+$valTotalCmd;
							if($qualCad=="contas-fechadas"){
							$nomeProd=($asCmdBar["id_produto"]==0)?$asCmdBar["nome_produto"].' (diversos)':$asCmdBar["nome_produto"];							
							}elseif($qualCad=="vendas-fechadas"){
							$nomeProd=($asCmdBar["id_produto"]==0)?$asCmdBar["nome_produto"].' (diversos)':$asCmdBar["nome_produto"];							
							}else{
							$nomeProd=($asCmdBar['id_produto']==0)?$asCmdBar['descricao'].' '.$asCmdBar['marca']:$asCmdBar['marca'].' '.$asCmdBar['descricao'];	
							}							
                        echo '<li>
                            <div class="li_tp_produto_comanda">'.limitiCaract($nomeProd,40).'</div>
                            <div class="li_tp_garcon_comanda d_mostra_garcon"><span class="s_li_abreFecha_respansivo">garçon:&nbsp;</span> <span class="pega_mostra_garcon">'.$asCmdBar[$operaGarcon].'</span>
							<div class="mostra_garcon loading-garcon">
							<div class="ponta-info-func"></div>
							<div class="cont-garcon"></div>
							</div>
							</div>                           
                            <div class="li_tp_valUnitario_comanda"><span class="s_li_abreFecha_respansivo">valor unit.:&nbsp;</span> R$ '.number_format($asCmdBar['valor'],2,',','.').'</div>
							<div class="li_tp_quant_comanda"><span class="s_li_abreFecha_respansivo">quant.:&nbsp;</span> '.$asCmdBar['quantidade'].'</div>
                            <div class="li_tp_valTotal_comanda"><span class="s_li_abreFecha_respansivo">valor total:&nbsp;</span> R$ '.number_format($valTotalCmd,2,',','.').'</div>
                            <div class="li_tp_dataHora_comanda">'.date('d/m/Y H:i:s',strtotime($asCmdBar[$dataCad])).'</div>
                            <div class="li_tp_acao_comanda"></div>
                        </li>';
                        }
                        if($qualCad!="contas-fechadas" && $qualCad!="vendas-fechadas"){
							
						if($qualCad!="mesas-fechadas"){	
						if($AsCmdFechadas['valor_entrada']<>""){
                        echo '<li>
                            <div class="li_tp_produto_comanda">';
                            echo ($AsCmdFechadas['consuma']==1)?'CONSUMAÇÃO DE R$ ':'ENTRADA NO VALOR DE R$ ';
                            echo number_format($AsCmdFechadas['valor_entrada'],2,',','.').'</div>
                            <div class="li_tp_garcon_comanda d_mostra_garcon"><span class="s_li_abreFecha_respansivo">garçon:&nbsp;</span> <span class="pega_mostra_garcon">'.$AsCmdFechadas['cmd_aberta_por'].'</span>
								<div class="mostra_garcon loading-garcon">
								<div class="ponta-info-func"></div>
								<div class="cont-garcon"></div>
								</div>
							</div>
                            <div class="li_tp_valUnitario_comanda"><span class="s_li_abreFecha_respansivo">valor unit.:&nbsp;</span> R$ '.number_format($AsCmdFechadas['valor_entrada'],2,',','.').'</div>
							<div class="li_tp_quant_comanda"><span class="s_li_abreFecha_respansivo">quant.:&nbsp;</span> 1</div>
                            <div class="li_tp_valTotal_comanda"><span class="s_li_abreFecha_respansivo">valor total:&nbsp;</span> R$ '.number_format($AsCmdFechadas['valor_entrada'],2,',','.').'</div>
                            <div class="li_tp_dataHora_comanda">'.date('d/m/Y H:i:s',strtotime($AsCmdFechadas['data_aberta'])).'</div>
                            <div class="li_tp_acao_comanda"></div>
                        </li>';
						}
						if($AsCmdFechadas['vale_pedagio']=="sim"){
							echo '<li>
							<div class="li_tp_produto_comanda">VALE CONSUMAÇÃO</div>
							<div class="li_tp_garcon_comanda d_mosrtra_garcon"><span class="s_li_abreFecha_respansivo">garçon:&nbsp;</span> <span>'.$AsCmdFechadas['cmd_aberta_por'].'</span>
								<div class="mostra_garcon loading-garcon">
								<div class="ponta-info-func"></div>
								<div class="cont-garcon"></div>
								</div>
							</div>							
							<div class="li_tp_valUnitario_comanda"><span class="s_li_abreFecha_respansivo">valor unit.:&nbsp;</span> R$ -'.number_format($AsCmdFechadas['valor_pedagio'],2,',','.').'</div>
							<div class="li_tp_quant_comanda"><span class="s_li_abreFecha_respansivo">quant.:&nbsp;</span> 1</div>
							<div class="li_tp_valTotal_comanda"><span class="s_li_abreFecha_respansivo">valor total:&nbsp;</span> R$ -'.number_format($AsCmdFechadas['valor_pedagio'],2,',','.').'</div>
							<div class="li_tp_dataHora_comanda">'.date('d/m/Y H:i:s',strtotime($AsCmdFechadas['data_aberta'])).'</div>
							<div class="li_tp_acao_comanda"></div>
							</li>';
						}
						
						}else{
						
						//COLOCA PARA ATIVAR NAS CONFIGURAÇÕES - PREFERENCIAS
						/*
                        echo '<li>
                        <div class="li_tp_produto_comanda">serviço</div>
                        <div class="li_tp_garcon_comanda"><span>isento</span>
						</div>                        
                        <div class="li_tp_valUnitario_comanda">10%</div>
						<div class="li_tp_quant_comanda">1</div>
                        <div class="li_tp_valTotal_comanda">R$ '.number_format($AsCmdFechadas['tx_servico'],2,',','.').'</div>
                        <div class="li_tp_dataHora_comanda">'.date('d/m/Y H:i:s',strtotime($AsCmdFechadas['cadastro'])).'</div>
                        <div class="li_tp_acao_comanda"></div>
                        </li>';
                    	*/
						
						}
					
						$pago_junto=$AsCmdFechadas['pago_junto'];
						}else{
						$pago_junto=0;
						}
						$descontar=Cadastros::trazerDescontar($id_empresa,$qualCMC,$qualDesconta,$AsCmdFechadas['id'],$bFuncionario);
						if($descontar['num']>0){
							foreach($descontar['dados'] as $asDescontar){
								
							echo '<li>
								<div class="li_tp_produto_comanda">VALOR DESCONTADO</div>
								<div class="li_tp_garcon_comanda d_mostra_garcon"><span class="s_li_abreFecha_respansivo">garçon:&nbsp;</span> <span class="pega_mostra_garcon">'.$asDescontar['garcon'].'</span>
								<div class="mostra_garcon loading-garcon">
								<div class="ponta-info-func"></div>
								<div class="cont-garcon"></div>
								</div>
								</div>                           
								<div class="li_tp_valUnitario_comanda"><span class="s_li_abreFecha_respansivo">valor unit.:&nbsp;</span> R$ -'.number_format($asDescontar['valor'],2,',','.').'</div>
								<div class="li_tp_quant_comanda"><span class="s_li_abreFecha_respansivo">quant.:&nbsp;</span> 1</div>
								<div class="li_tp_valTotal_comanda"><span class="s_li_abreFecha_respansivo">valor total:&nbsp;</span> R$ -'.number_format($asDescontar['valor'],2,',','.').'</div>
								<div class="li_tp_dataHora_comanda">'.date('d/m/Y H:i:s',strtotime($asDescontar['cadastro'])).'</div>
								<div class="li_tp_acao_comanda"></div>
							</li>';
							}
						}
						
						
						if(isset($AsCmdFechadas['id_descontar']) && $AsCmdFechadas['id_descontar']<>0){
							echo '<li>
                            <div class="li_tp_produto_comanda">VALOR DESCONTADO</div>
                            <div class="li_tp_garcon_comanda d_mostra_garcon"><span class="s_li_abreFecha_respansivo">garçon:&nbsp;</span> <span class="pega_mostra_garcon">'.$AsCmdFechadas[$fechadapor].'</span>
							<div class="mostra_garcon loading-garcon">
							<div class="ponta-info-func"></div>
							<div class="cont-garcon"></div>
							</div>
							</div>                           
                            <div class="li_tp_valUnitario_comanda"><span class="s_li_abreFecha_respansivo">valor unit.:&nbsp;</span> R$ '.number_format($AsCmdFechadas['valor_pago'],2,',','.').'</div>
							<div class="li_tp_quant_comanda"><span class="s_li_abreFecha_respansivo">quant.:&nbsp;</span> 1</div>
                            <div class="li_tp_valTotal_comanda"><span class="s_li_abreFecha_respansivo">valor total:&nbsp;</span> R$ '.number_format($AsCmdFechadas['valor_pago'],2,',','.').'</div>
                            <div class="li_tp_dataHora_comanda">'.date('d/m/Y H:i:s',strtotime($AsCmdFechadas['cadastro'])).'</div>
                            <div class="li_tp_acao_comanda"></div>
                        </li>';
						}
                        
						if($pago_junto==0){
                        if($AsCmdFechadas['forma_pagamento']==1){
							echo '<li class="li_valFecha_comanda" style="padding-top:10px;"><div>valor total de <span>R$ '.number_format($AsCmdFechadas['valor_pago'],2,',','.').'</span> pago em dinheiro</div></li>';
							echo '<li class="li_valFecha_comanda" style="border-top:0;"><div>valor pago pelo cliente <span>R$ '.number_format($AsCmdFechadas['pago_ou_cartao'],2,',','.').'</span></div></li>';									
							echo '<li class="li_valFecha_comanda" style="border-top:0; padding-bottom:10px;"><div>valor de troco <span>R$ '.number_format($AsCmdFechadas['pago_ou_cartao']-$AsCmdFechadas['valor_pago'],2,',','.').'</span></div></li>';
                        }else{                            
                            echo '<li class="li_valFecha_comanda" style="padding-top:10px;"><div>valor total de <span>R$ '.number_format($AsCmdFechadas['valor_pago'],2,',','.').'</span> pago com '.$AsCmdFechadas['pago_ou_cartao'].'</div></li>';
                            $autoriza = ($AsCmdFechadas['autorizacao_cartao']=="")?0:$AsCmdFechadas['autorizacao_cartao'];                            
                        	echo '<li class="li_valFecha_comanda" style="border-top:0; padding-bottom:10px;"><div>autorização do cliente: <span> '.$autoriza.'</span></div></li>';
                        }
						}else{
							echo '<li class="li_valFecha_comanda" style="padding-top:10px;"><div>valor total de <span>R$ '.number_format($AsCmdFechadas['valor_pago'],2,',','.').'</span> pago em dinheiro</div></li>';
							echo '<li class="li_valFecha_comanda" style="border-top:0; padding-bottom:10px;"><div>(comanda paga junta com outra)</div></li>';							
						}
                    
                }//CHAVE FECHA MOSTRA TUDO
                    
                        echo '</ul><!--ul_mostra_comanda-->
                </li>';
            
            } ?>
            </ul><!--ul_cmd_abertaFechada-->
            <?php
			$qualPagina= 'administracao';
            if($pgs>1){
            ?>
            <div id="pgTudo" style="margin-top:30px;">
                <div id="d_pri" <?php if($menos==0){ echo 'style="display:none;"';} ?>><a href="<?php echo getUrl().$qualPagina.'.php?cad='.$qualCad.$linkData; ?>&pg=1" class="1">Primeiro</a></div>
                <div id="d_ante" <?php if($menos<=1){ echo 'style="display:none;"';} ?>><a href="<?php echo getUrl().$qualPagina.'.php?cad='.$qualCad.$linkData; ?>&pg=<?php echo $menos; ?>" class="<?php echo $menos; ?>">Anterior</a></div>
                
                <span id="select_produto" class="naofaz">
                <span id="select_pg"><?php echo $pagina; ?></span>
                <span class="select_abre_bt" id="select_bt"></span>
                <ul>
                <?php
                    for($i=1;$i <= $pgs;$i++) {
                        echo '<li><a href="'.getUrl().$qualPagina.'.php?cad='.$qualCad.$linkData.'&pg='.$i.'">'.$i.'</a></li>';
                    }
                ?>
                </ul>
                </span>
                <div id="d_pro" <?php if($mais>=$pgs){ echo 'style=" display:none;"';} ?>><a href="<?php echo getUrl().$qualPagina.'.php?cad='.$qualCad.$linkData; ?>&pg=<?php echo $mais; ?>" class="<?php echo $mais; ?>">Próxima</a></div>
                <div id="d_ult" <?php if($mais>$pgs){ echo 'style=" display:none;"';} ?>><a href="<?php echo getUrl().$qualPagina.'.php?cad='.$qualCad.$linkData; ?>&pg=<?php echo $pgs; ?>" class="<?php echo $pgs; ?>">Último</a></div>
        </div>
     
         <?php } ?>
        </div><!--fecha cont_cmd_abertaFechada-->
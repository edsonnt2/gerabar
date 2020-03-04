<?php ob_start(); include('_include/header.php'); ?>
<div id="corpo">
<?php if($codStatus==0){ ?>
<div id="loadingOne" style="height:260px;"></div>
	 <div id="troca_cadastros">
<?php
if($codStatus==0){
	if($qualPasso==1){
		include('_include/cadastro_empresa.php');
	}elseif($qualPasso==2){
		include('_include/cadastro_confAmb.php');
	}elseif($qualPasso==3){
		include('_include/cadastro_pronto.php');
	}else{
		echo "<h2>Passo não encontrado !</h2>";
	}
}
?>
</div><!--fecha troca cadastros-->
<?php }else{ ?>
<div id="cont_tudo_index">
<?php
    
if(isset($limiteAmbiente)){ 
    
echo '<div id="index_cima" style="margin-top:120px;">
        <h2>Ambientes de trabalho bloqueados !</h2>
    </div>
    <div id="index_centro">
        <p>O Plano Premium para '.$nomeEmpresa.' expirou !</p>
        <p>Renove seu plano ou delete os ambientes acima do limite do </br>Plano Grátis (máximo 2 cadastros).</p>
    </div><!--index_centro-->';
    
}elseif($identificar==1 && !isset($codigoDoOperador)){ ?>

<div id="index_cima" style="margin-top:120px;">
	<h2>Identificação do operador !</h2>
</div>
<div id="cont_identifica">
	<p id="p_ident_cima">coloque seu código e senha para liberar o ambiente <?php echo $user_nome_amb; ?></p>
    <form action="" method="post">
    <div class="linha_form">            
            	<div class="d_alinha_form">
                    <span><label for="cd_codigoOpe" class="formLabIdent">código:</label></span>
                    <input type="text" id="cd_codigoOpe" onKeyPress="return SomenteNumero(event);" autocomplete="off" placeholder="Seu código aqui" />
                    <div class="d_aviso_erro" id="erro_cd_codigoOpe"><div class="d_ponta-erro"></div><p></p></div><!--d_aviso_erro-->
                </div>                
                <div class="d_alinha_form">
                    <span><label for="cd_senhaOpe" class="formLabIdent">senha:</label></span>
                    <input type="password" id="cd_senhaOpe" placeholder="Sua senha aqui" />
                    <div class="d_aviso_erro" id="erro_cd_senhaOpe"><div class="d_ponta-erro"></div><p></p></div><!--d_aviso_erro-->
                </div>                
                <div class="d_alinha_form">
	                <span><label class="formLabIdent">&nbsp;</label></span>
                    <button type="submit" class="cd_envia_dados" id="acesso_operario">enviar</button>
                </div>                
            </div><!--fecha linha form-->
    </form>    
    <p id="p_ident_baixo">*caso não lembre seu código ou sua senha, por favor, contate o administrador.</p>
</div><!--cont_identifica-->
<?php
}else{

	if(!in_array("",$liberarPg)){		
		if(in_array(1,$liberarPg) || in_array("frente_caixa",$liberarPg)){
		?>        
     <script type="text/javascript">
		$(function(){
			$('input.for-valor').priceFormat({
			prefix: '',
			centsSeparator: ',',
			thousandsSeparator: '.'
			});			
			$('input#i_porc_desconto').priceFormat({
			prefix: '',
			centsSeparator: '',
			thousandsSeparator: '.',
			centsLimit: 0
			});				
		});
	</script>        
    <?php            
    include("_classes/FrenteCaixa.class.php");    
    $ultFrente=FrenteCaixa::selectFrente($user_id_empresa,$funcionario,true);            
    if($ultFrente['num']>0){        
        $countProd= $ultFrente['num'];
        $ultId=$ultFrente['dados']['id'];
        $ultCodInterno=$ultFrente['dados']['codigo_interno'];
        $ultProduto=$ultFrente['dados']['nome_produto'];
        $ultIdProduto=$ultFrente['dados']['id_produto'];
        $ultValorCompra=$ultFrente['dados']['valor_compra'];
        $ultValor=$ultFrente['dados']['valor'];
        $ultQuant=$ultFrente['dados']['quantidade'];
        $ultValTotalProd=$ultFrente['dados']["valor"]*$ultFrente['dados']['quantidade'];
        $trasFrente=FrenteCaixa::selectFrente($user_id_empresa,$funcionario);
    }
    ?>
    <div id="todo-frente-caixa"<?php if(isset($ultId))echo ' class="'.$ultId.'"'; ?>>    
    <div id="frenteleft">    
        <div id="divbusca1">    
        <input id="busca_frente_caixa" type="text" autofocus="autofocus"<?php if($numCxAberto==0) echo ' disabled="disabled"'; ?> placeholder="BUSQUE POR CÓDIGO OU NOME DO PRODUTO..." autocomplete="off"/>
        <button type="submit" title="ATALHO (ENTER)" id="enviabusca1"<?php if($numCxAberto==0) echo ' disabled="disabled"'; ?>>ENVIAR</button>
        <ul id="ul_lista_busca_caixa"></ul>
        </div><!--divbusca1-->        
        <div id="divprodprincipal1">    
            <div class="descriprinc">DESCRIÇÃO DO ITEM</div><!--descriprinc-->
            <div id="codigoprinc"><?php if(isset($ultCodInterno)) echo $ultCodInterno; ?></div>
            <div id="nomeprinc"><?php if(isset($ultProduto)) echo limitiCaract($ultProduto,30); ?></div>
        </div><!--divprodprincipal1-->        
        <div id="d_cx_livre"<?php if(isset($countProd)) echo ' style="display:none;"'; ?>>
            <?php if($numCxAberto==0){
            echo '<h2 class="cx-fechado">CAIXA FECHADO</h2>';
            }else{
            echo '<h2 class="fa-blink">CAIXA LIVRE</h2>';
            }
            ?>
        </div>        
            <div id="primdivmostra"<?php if(isset($countProd)) echo ' style="display:block;"'; ?>>
                <span class="most0">PRODUTOS</span>
                <span class="most1">CÓDIGO</span>
                <span class="most2">PRODUTO</span>
                <span class="most4">VALOR UNIT.</span>
                <span class="most3">QUANT.</span>
                <span class="most5 mostUlti5">VALOR TOTAL</span>
            </div><!--primdivmostra-->        
            <ul id="ulmostraprod"<?php if(isset($countProd)) echo ' style="display:block;"'; ?>>
            <?php 
            $volumeTotal=0;
            $valorTotalCompra=0;
            $numLi=0;
            if(isset($countProd)){
                foreach($trasFrente['dados'] as $astrasFrente){
                    $numLi+=1;
                    $volumeTotal+=$astrasFrente['quantidade'];
                    $valProdTotal=$astrasFrente['valor']*$astrasFrente['quantidade'];
                    $valorTotalCompra+=$valProdTotal;
                    echo '<li class="'.$astrasFrente['id'].'">
                        <input type="hidden" class="cx_valCompra" value="'.$astrasFrente['valor_compra'].'" />
                        <div class="most1"><span class="s_li_cx_respansivo">código:&nbsp;</span> <span class="s_cod_cx">'.$astrasFrente['codigo_interno'].'</span></div>
                        <div class="most2"><span class="s_nome_cx">'.limitiCaract($astrasFrente['nome_produto'],30).'</span></div>
                        <div class="most4"><span class="s_li_cx_respansivo">valor unit.:&nbsp;</span> <span class="s_valUnit_cx">R$ '.number_format($astrasFrente['valor'],2,',','.').'</span></div>
                        <div class="most3"><span class="s_li_cx_respansivo">quant.:&nbsp;</span> <span class="s_quant_cx">'.$astrasFrente['quantidade'].'</span></div>
                        <div class="most5"><span class="s_li_cx_respansivo">valor total:&nbsp;</span> <span class="s_valTotal_cx">R$ '.number_format($valProdTotal,2,',','.').'</span></div>
                        <div class="most6"><a href="javascript:void(0);" id="'.$astrasFrente['id_produto'].'-'.$numLi.'-cxId" class="frente_delete" title="Excluir produto da comanda"><!--exclui--></a></div>
                        </li>';
                }
                
            }
                ?>
            </ul><!--ulmostraprod-->        
    </div><!--frenteleft-->    
	<div id="frenteright">    
        <div class="divsepara">                
            <div id="descriprinc1">
                <span>VALOR UNITÁRIO</span>
                <span class="s_hide_quant">QUANTIDADE</span>
            </div><!--descriprinc-->                   
            <div id="unitprinc">
                <input type="hidden" id="valcompracx" value="<?php if(isset($ultValorCompra)) echo $ultValorCompra; ?>" />
            	<div class="<?php if(isset($ultIdProduto) && $ultIdProduto==0)echo 'd_hide_frente '; ?>salvaValor" id="d_val_unitario" title="ATALHO (F4)"><span>R$</span> <?php echo(isset($ultValor))?number_format($ultValor,2,',','.'):'0,00'; ?></div>                
                <div class="d_show_frente" id="d_mostra_inp_unitario">
                <span>R$</span>
                <input type="text" class="for-valor i_for_frente" autocomplete="off" id="i_val_unitario" />
                <div class="d_aviso_erro" id="erro_i_val_unitario" style="margin-top:29px;"><div class="d_ponta-erro"></div><p></p></div><!--d_aviso_erro-->
                </div>                
            </div>
            <div id="xis">x</div>            
            <div id="descriprinc2">
                <span>QUANTIDADE</span>
            </div><!--descriprinc-->            
            <div id="quantprinc">
                <div id="d_alt_unidade"<?php if(isset($ultQuant))echo ' class="d_hide_frente"'; ?> title="ATALHO (F5)"><?php echo(isset($ultQuant))?$ultQuant:'0'; ?></div>
                <input type="text" class="i_for_frente d_show_frente" id="i_quant_unitario" onKeyPress="return SomenteNumero(event);" maxlength="11" />
                <div class="d_aviso_erro" id="erro_i_quant_unitario" style=" margin-top:29px;"><div class="d_ponta-erro"></div><p></p></div><!--d_aviso_erro-->
            </div>            
            <div class="descriprincDiv"><span>VALOR TOTAL</span></div><!--descriprinc-->                        
            <div class="forvermeprinc salvaValor" id="d_val_total"><span>R$</span> <?php echo(isset($ultValTotalProd))?number_format($ultValTotalProd,2,',','.'):'0,00'; ?></div>                
        </div><!--divsepara-->        
        <div class="divsepara">        
        <div class="descriprincDiv"><span>VOLUMES</span></div><!--descriprinc-->
            <div class="forvermeprinc" id="d_quant_volume"><?php echo $volumeTotal; ?></div>
        </div><!--divsepara-->        
        <div class="divsepara">
            <div class="descriprincDiv"><span>DESCONTO</span></div><!--descriprinc-->
            <div class="forvermeprinc">
                <?php 
                $descFrente=FrenteCaixa::selDescontarFrente($user_id_empresa,$funcionario);
                $valDesconto=($descFrente['num']>0)?$descFrente['dados']['valor']:'0';
                $valorTotalCompra-=$valDesconto;
                ?>            
            <div id="d_desconto_frente"<?php if(isset($countProd))echo ' class="d_hide_frente"'; ?> title="ATALHO (F3)"><span>R$</span> <?php echo number_format($valDesconto,2,',','.'); ?></div>            
            <div class="d_show_frente" id="d_mostra_val_desconto">
                <span>R$</span>
                <input type="text" class="for-valor i_for_frente" autocomplete="off" id="i_val_desconto" />
                <div class="d_aviso_erro" id="erro_i_val_desconto" style="margin-top:29px;"><div class="d_ponta-erro"></div><p></p></div><!--d_aviso_erro-->
            </div>            
            </div>
        </div><!--divsepara-->        
        <div class="divsepara">
            <div class="descriprincDiv"><span>VALOR DA COMPRA</span></div><!--descriprinc-->
            <div class="forvermeprinc" id="d_valorTotal"><span>R$</span> <?php echo number_format($valorTotalCompra,2,',','.'); ?></div>
        </div><!--divsepara-->                
        <div id="divopcional1">
                <?php
            echo '<span id="s_abrir_caixa" class="a_abrir_caixa"'; if($numCxAberto!=0) echo ' style="display:none;"'; echo '><a href="javascript:void(0);">ABRIR CAIXA</a></span>
                <span id="s_finaliza_frente"'; if(!isset($countProd))echo ' class="desCursor"'; if($numCxAberto==0) echo ' style="display:none;"'; echo '><a href="javascript:void(0);" title="ATALHO (F2)">FINALIZAR VENDA (F2)</a></span>
                <span id="s_transferir_frente"'; if(!isset($countProd))echo ' class="desCursor"'; if($numCxAberto==0) echo ' style="display:none;"'; echo '><a href="javascript:void(0);">TRANSFERIR PARA CONTA</a></span>
                <span id="s_cancelar_cx"'; if(!isset($countProd)) echo ' class="desCursor"'; if($numCxAberto==0) echo ' style="display:none;"'; echo '><a href="javascript:void(0);">CANCELAR OPERAÇÃO</a></span>';
            ?>            	
        </div><!--divopcional1-->    
    </div><!--frenteright-->    
    	<?php
			if(isset($codigoDoOperador)){
				include('_classes/Operadores.class.php');
				$dadosOpera=Operadores::selUmOperador($user_id_empresa,$codigoDoOperador);
				$noneOpera=($dadosOpera['num']==1)?$dadosOpera['dados']['nome_operador']:'Universal';
			}else{
				$noneOpera=($table=="usuarios")?'Administrador':'Universal';
			}
		?>
        <div id="divOperador">
                <div class="descriprinc">OPERADOR ATUAL</div><!--descriprinc-->
                <span id="nomeopera"><?php echo $noneOpera; ?></span>                
            </div><!--divOperador-->    
    </div><!--todo-cont-->        
		<?php			
		}else{
			if($liberarPg[0]=="abrir_caixa"){
			header("Location:".getUrl()."caixa.php");
			exit();
			}elseif($liberarPg[0]=="comanda_bar"){
			header("Location:".getUrl()."comanda-bar.php");
			exit();
			}elseif($liberarPg[0]=="contas_clientes"){
			header("Location:".getUrl()."contas-clientes.php");
			exit();
			}elseif($liberarPg[0]=="estoque"){
			header("Location:".getUrl()."estoque.php");
			exit();
			}elseif($liberarPg[0]=="clientes"){
			header("Location:".getUrl()."clientes.php");
			exit();
			}elseif($liberarPg[0]=="cadastros"){
			header("Location:".getUrl()."cadastros.php");
			exit();
            }elseif($liberarPg[0]=="administracao"){
			header("Location:".getUrl()."administracao.php");
			exit();
			}else{
				echo '<div id="index_cima" style="margin-top:120px;">
					<h2>Logado no ambiente "'.$user_nome_amb.'" !</h2>
				  </div>
				  <div id="index_centro">';	
				if(isset($codigoDoOperador)){
					include('_classes/Operadores.class.php');
					$dadosOpera=Operadores::selUmOperador($user_id_empresa,$codigoDoOperador);
					if($dadosOpera['num']==1){
					echo '<p>Olá '.$dadosOpera['dados']['nome_operador'].',</p>';
					}
				}
				echo '	<p>Navegue pelo menu ao lado para começar a usar .</p>
				</div><!--index_centro-->';	
			}
		}
	}else{        
        echo '<div id="index_cima" style="margin-top:120px;">
        <h2>';
            if($table=="usuarios"){
			echo 'Ambiente com páginas bloqueadas !'; 
            }else{
            echo 'Ambiente "'.$user_nome_amb.'" ainda bloqueado !';     
            }
        echo '</h2>
		</div>
		<div id="index_centro">
			<p>';
            if($table=="usuarios"){
			echo 'Vá em <a href="'.getUrl().'configuracoes.php">configurações</a> para liberar as páginas do ambiente "Admin".'; 
            }else{
            echo 'Por favor, contate o administrador para liberar páginas.';
            }
        echo '</p>
		</div><!--index_centro-->';
	}
}
 ?>
</div><!--cont_tudo_index-->
<?php } ?>
</div><!--fecha corpo-->
</div><!-- fecha cAlign-->
<?php include('_include/footer.php');
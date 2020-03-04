<?php if(isset($_POST['inclui'])){ if(isset($_SESSION)==false){session_start(); }
include('../_classes/DB.class.php');
function getUrl(){ return 'http://localhost/myforadmin/';}
		if(!isset($_SESSION['Gerabar_uid']) || is_null($_SESSION['Gerabar_uid']) || empty($_SESSION['Gerabar_uid'])){
		include('../_classes/Login.class.php');
		$objLogin=new Login;
			if(!$objLogin->logado()){
			?>
			<script type="text/javascript">
            	$(function(){ red:window.location.href="<?php echo getUrl(); ?>"; });
            </script>
			<?php
			exit();
			}
		}
$idDaSessao = $_SESSION['Gerabar_uid'];
$tabela = $_SESSION['Gerabar_table'];
include('../_classes/Cadastros.class.php');
include('../_classes/formata_texto.php');
$idEmp = Cadastros::selectIdEmpresa($idDaSessao,$tabela);
$user_id_empresa = $idEmp['dados'][0];
?>
<script type="text/javascript">$(function(){$('input.for-val').priceFormat({prefix:'',centsSeparator:',',thousandsSeparator:'.'});});</script>
<?php
$acre="../";
if(isset($_POST['cliente'])){$nomeCliente=$_POST['cliente'];}
if(isset($_POST['cod'])){$codCliente=(int)$_POST['cod'];}
}else{
if(isset($_GET['cliente'])){$nomeCliente=$_GET['cliente'];}
if(isset($_GET['cod'])){$codCliente=(int)$_GET['cod'];}
$acre="";
if(!isset($table) || $table!="ambientes"){
include('_classes/Cadastros.class.php');
}
}
include($acre."_classes/Clientes.class.php");
include($acre."_classes/remove_caracteres.php");
$exNome = explode('-',$nomeCliente); 
$novoNome="";
for($n=0;$n<count($exNome);$n++){
$novoNome .= $exNome[$n]." ";
}
?>
<div id="d_cadastro_produto" class="<?php echo $codCliente; ?>">       
                	<h2 class="h_topo_lista_conta"><span id="dentro-h2">conta de <span id="s_nome_do_cliente" class="<?php echo removeAcentos($novoNome,'-'); ?>"><?php echo limitiCaract($novoNome,14,false,false); ?></span></span>
                    <span id="dentro2-h2" style=" <?php	echo (Clientes::countAgrupaConta($codCliente,$user_id_empresa)>0)?'display:block;':'display:none;'; ?>">
					<?php 				
					echo '<a href="contas-clientes.php?cad=contas-abertas&cliente='.removeAcentos($novoNome,'-').'&cod='.$codCliente;					
					echo (isset($_GET['desagrupa']) AND $_GET['desagrupa']=='sim')?'">agrupar conta</a>':'&desagrupa=sim">desagrupar</a>';					
					?></span>
                    </h2>
                    <div class="d_top_contas">                    	
                    	<span class="so_produtos">produtos</span>
                    	<span class="s_produto_contas">nome do produto</span>
                        <span class="s_func_contas">nº func.</span>
                        <span class="s_val_contas">valor unit.</span>
                        <span class="s_quant_contas">quant.</span>
                        <span class="s_valtotal_contas">valor total</span>
                        <span class="s_data_contas">data e hora</span>
                        <span class="s_acao_contas">ação</span>
                    </div>
                    <ul class="u_lista_conta">
                        <?php
							$total=0;
							$colocaIdConta=0;
							$valDesconto=0;
							if(isset($codCliente)){
								$idCliente=$codCliente;
								$id_empresa=$user_id_empresa;
								if(isset($_GET['desagrupa'])){$agrupa=$_GET['desagrupa'];}
								include($acre."_include/lista-produtos-conta.php");
							}
						 ?>
                        <li class="inner">
                        <div class="d_produto_contas d_tds_conta">
                        	<input type="hidden" value="0" class="i_id_prod" />
                            <input type="hidden" value="" class="i_valor_compra_prod" />
                            <input type="hidden" value="" class="i_valor_prod" />
                            <input type="hidden" value="0" class="i_quant_prod" />
	                        <input type="text" id="i_nome_prod_contas" autofocus="autofocus" placeholder="Digite o nome do produto..." autocomplete="off" />
                            <div class="d_aviso_erro" id="erro_i_nome_prod_contas"><div class="d_ponta-erro"></div><p></p></div><!--d_aviso_erro-->
                            <ul id="submenu_prod_conta"></ul><!--fecha submenu_prod_conta-->
                        </div>
                        <div class="d_func_contas d_tds_conta">
                        		<span class="s_li_abreFecha_respansivo">nº func.:&nbsp;</span> 
                                <input type="text" id="i_cod_func" onKeyPress="return SomenteNumero(event);" maxlength="11" autocomplete="off" />
                                <div class="d_aviso_erro" id="erro_i_cod_func"><div class="d_ponta-erro"></div><p></p></div><!--d_aviso_erro-->
                        </div>                        
                        <div class="d_val_contas d_tds_conta">
                        <span id="s_escondeCampoVal">
                        <span class="s_li_abreFecha_respansivo">valor unit.:&nbsp;</span>
                        <span id="rs_val">R$</span> <span id="s_mostraVal">0,00</span>
                        </span><!--s_escondeCampoVal-->                        
                        <span id="s_mostraCampo">
                        <span class="s_li_abreFecha_respansivo" id="s_valDoDiverso">valor unit.:&nbsp;</span>
                        <span id="s_rs_diverso">R$</span><input type="text" value="0,00" onfocus="if(this.value=='0,00')this.value='';" id="i_val_diverso" autocomplete="off" class="for-val" />
                        <div class="d_aviso_erro" id="erro_i_val_diverso" style=" margin-top:26px;"><div class="d_ponta-erro"></div><p></p></div><!--d_aviso_erro-->
                        </span>
                        </div>                        
                        <div class="d_quant_contas d_tds_conta">
                        		<span class="s_li_abreFecha_respansivo">quant.:&nbsp;</span> 
                                <input type="text" id="novaQuantProd" class="travaInput" value="0" onKeyPress="return SomenteNumero(event);" maxlength="11" autocomplete="off" />
                                <div class="d_aviso_erro" id="erro_novaQuantProd"><div class="d_ponta-erro"></div><p></p></div><!--d_aviso_erro-->
                        </div>
                        <div class="d_valtotal_contas d_tds_conta"><span class="s_li_abreFecha_respansivo">valor total:&nbsp;</span> R$ <span class="valAltera">0,00</span></div>                        
						<div class="d_lancar_contas d_tds_conta"><button type="submit" id="lanca_prd_conta" class="travaInput" >lançar produto</button></div>
                        </li>
                    </ul>
                    <div class="somaValor_conta">valor total da conta R$ <span id="car_val_total" class="<?php echo $total; ?>"><?php echo number_format($total,2,',','.'); ?></span></div>
                    <span id="linkVoltar"><a href="<?php echo getUrl(); ?>contas-clientes.php?cad=novas-contas">voltar para burcar conta</a></span>
                    <span id="pagarContaTotal" class="s_fecha_conta" <?php if($colocaIdConta==0){ echo 'style="display:none;"'; } ?>><a href="javascript(0);" title="ATALHO (F2)">Pagar Conta (F2)</a></span>
                    <span id="descontarCx" class="descontaConta" <?php if($colocaIdConta==0){ echo 'style="display:none;"'; } ?>><a href="javascript:void(0);" class="conta|descontar" title="ATALHO (F3)">descontar (F3)</a></span>
        </div><!--fecha d_cadastro_produto-->
<?php session_start();
if(!isset($_GET["carRecupera"])){
include("../_classes/DB.class.php");
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
}else{
?>
<div id="dentroRecupera">
<div class="topoRec"><span class="textTopoRec">Recuperar senha</span> <span class="botaoTopoRec"><a href="javascript:void(0);" id="fechaRecupera">Cancelar</a></span></div>
<div id="corpoRecupera" class="contRecupera">
    <div class="textCima">Enviaremos um link para recuperar sua senha no e-mail que você informar abaixo, sendo que seu e-mail esteja cadastrado em no sistema.</div>
    <form method="post" action="">
    <div class="comtEmailRecu">
        <input type="text" id="recuperaEmail" class="recemail" placeholder="seuemail@mail.com" />
        <div class="d_aviso_erro" id="erro_recuperaEmail" style="margin:36px 0 0 20px;"><div class="d_ponta-erro"></div><p></p></div><!--d_aviso_erro-->
    </div>
    <div class="comtEmailRecu">                
    	<button type="submit" class="enviarRecu" id="enviaRecupera" >ENVIAR</button>
        <span class="carre-recu"></span>
    </div>
    </form>
</div>
</div><!--dentroRecupera-->
<?php
exit();
}
extract($_POST);
include("../_classes/Cadastros.class.php");
$idDaSessao = $_SESSION['Gerabar_uid'];
$table = $_SESSION['Gerabar_table'];
$idEmpre = Cadastros::selectIdEmpresa($idDaSessao,$table);
if($idEmpre['num']>0){
$id_empresa = $idEmpre['dados'][0];
}else{
$id_empresa = 0;
}
if(isset($abrirCaixa)){

if(isset($_SESSION['Gerabar_Ocodigo'])){
    include('../_classes/Operadores.class.php');
    $dadosOpera=Operadores::selUmOperador($id_empresa,$_SESSION['Gerabar_Ocodigo']);
    $noneOpera=($dadosOpera['num']==1)?$dadosOpera['dados']['nome_operador']:'Universal';
}else{
    $noneOpera=($table=="usuarios")?'Administrador':'Universal';
}

if($table=="usuarios"){
    $fechada_por="a";
    }elseif(isset($_SESSION['Gerabar_Ocodigo'])){
    $fechada_por=$_SESSION['Gerabar_Ocodigo'];
    }else{
    $fechada_por="isento";
    }
include('../_classes/AbrirFecharCaixa.class.php');
if($abrirFecharCx=="a_abrir_caixa" || $abrirFecharCx=="reabrir_caixa"){
    $valTroco='0,00';
    $valLimite='0,00';
    $txtTopo='';
    $style='';
    include('abrir_fechar_caixa.php');
}else{
    
    $qualFechar=AbrirFecharCaixa::selAbrirCaixa($id_empresa,$fechada_por);    
    if($qualFechar['num']>0){
        
        $txt='<ul id="u_abrirCaixa">
            <li><span class="s_topo_ulCx">DINHEIRO</span><span>'.number_format($qualFechar['dados']['pago_dinheiro'],2,',','.').'</spa></li>
            <li><span class="s_topo_ulCx">CARTÃO</span><span>'.number_format($qualFechar['dados']['pago_cartao'],2,',','.').'</spa></li>
            <li><span class="s_topo_ulCx">TROCO</span><span>'.number_format($qualFechar['dados']['troco'],2,',','.').'</spa></li>
            <li><span class="s_topo_ulCx">LIMITE</span><span>'.number_format($qualFechar['dados']['limite_caixa'],2,',','.').'</spa></li>
        </ul>';
    }else{
        $txt='<p id="p_fecha_caixa">Fechar caixa aberto por '.$noneOpera.'</p>';
    }
    
?>
<div id="abrirCaixa-dentro">
    <div id="abrirCaixa-topo"><span>FECHAR CAIXA</span></div><!--tranferi-centro-->
    <div id="abrirCaixa-cima">
        <h2 id="add_nome_caixa">FECHAR CAIXA DE <?php echo $noneOpera; ?></h2>
        <?php echo $txt; ?>
        <span class="s_fechando_cx"><a href="javascript:void(0);">FECHAR CAIXA</a></span>
    </div><!--abrirCaixa-cima-->
    <div
     id="abrirCaixa-baixo">
        <span id="voltar-abrirCaixa"><a href="javascript:void(0);">VOLTAR</a></span>            
    </div><!--abrirCaixa-baixo-->
</div><!--abrirCaixa-dentro-->

<?php
}   

}elseif(isset($novaCmd)){
	
include("../_classes/formata_texto.php");
$selEntra=DB::getConn()->prepare("SELECT * FROM entradas WHERE id_empresa=?");
$selEntra->execute(array($id_empresa));
$contaEntrada=$selEntra->rowCount();
	
?>
<script type="text/javascript">
$(function(){		
	$('#val_pedagio_cad_cliente').priceFormat({
	prefix: '',
	centsSeparator: ',',
	thousandsSeparator: '.'
	});
});
</script>
<div id="cmdAdd-dentro">
    	<div id="cmdAdd-topo"><span>ABRIR COMANDA</span></div><!--confirm-centro-->        
        <div id="cmdAdd-cima">
        	<?php echo '<h2 id="add_nome_cmd" class="'.$idCliente.'">'.$nomeCliente.'</h2>'; ?>
            <form method="post" action="">
                
            <div class="linha_form">
                <div class="d_alinha_form" style="margin-left:10px;">
                    <span><label for="cmd_cad_cliente">cadastrar comanda:</label></span>
                    <input type="text" id="cmd_cad_cliente" onKeyPress="return SomenteNumero(event);" autocomplete="off" />
                    <div class="d_aviso_erro" id="erro_cmd_cad_cliente"><div class="d_ponta-erro"></div><p></p></div><!--d_aviso_erro-->
                </div>

                <div class="d_alinha_form" style="margin-left:10px;">
                    <span><label for="pagar_cad_cliente">pagar na entrada ?</label></span>
                    <select id="pagar_cad_cliente"<?php if($contaEntrada==0){ echo ' disabled="disabled"';} ?> >
                        <option value="">SELECIONE</option>
                        <option value="sim">SIM</option>
                        <option value="nao">NÃO</option>
                    </select>
                    <div class="d_aviso_erro" id="erro_pagar_cad_cliente"><div class="d_ponta-erro"></div><p></p></div><!--d_aviso_erro-->
                </div>
                
            </div><!--fecha linha form-->
            
            <div class="linha_form" style="margin-top:4px;">
                <div class="d_alinha_form" style="margin-left:10px;">
                    <span><label for="opc_cmd_cliente">opções de entrada:</label></span>                    
                    <select id="opc_cmd_cliente"<?php if($contaEntrada==0){ echo ' disabled="disabled"';} ?> >
                        <option value="">SELECIONE</option>
                        <?php 
						if($contaEntrada>0){
							foreach($selEntra->fetchAll() as $asSelEntra){
							 echo '<option value="'.$asSelEntra['valor_entrada'].'-'.$asSelEntra['consuma'].'">'.converter($asSelEntra['entradas'],1).' (R$ '.number_format($asSelEntra['valor_entrada'],2,',','.').')</option>';
							}
						}
						?>                        
                    </select>
                    <div class="d_aviso_erro" id="erro_opc_cmd_cliente"><div class="d_ponta-erro"></div><p></p></div><!--d_aviso_erro-->
                </div>
                
            </div><!--fecha linha form-->
            
            <div class="linha_form" style="margin-top:5px;">
                <div class="d_alinha_form" style="margin-left:10px;">
                    <span><label for="pedagio_cad_cliente">vale consumo:</label></span>
                    <select id="pedagio_cad_cliente">
                        <option value="">SELECIONE</option>
                        <option value="sim">SIM</option>
                        <option value="nao">NÃO</option>
                    </select>
                    <div class="d_aviso_erro" id="erro_pedagio_cad_cliente"><div class="d_ponta-erro"></div><p></p></div><!--d_aviso_erro-->
                </div>
                
                <div class="d_alinha_form">
                    <span><label for="val_pedagio_cad_cliente">colocar valor do vale:</label></span>
                    <input type="text" id="val_pedagio_cad_cliente" value="0,00" onfocus="if(this.value=='0,00')this.value='';" autocomplete="off" />
                    <div class="d_aviso_erro" id="erro_val_pedagio_cad_cliente"><div class="d_ponta-erro"></div><p></p></div><!--d_aviso_erro-->
                </div>
            </div><!--fecha linha form-->
                
            <div class="linha_form">    
                <div class="d_alinha_form" style="margin-left:10px;">
                	<button type="submit" class="cd_envia_dados" id="envia_cmd_cad_cliente" >cadastrar</button>
                </div>
            </div><!--fecha linha form-->
            
            </form>
        
        </div><!--confirm-cima-->
        
        <div id="cmdAdd-baixo">
            <span id="cancelar-cmdAdd"><a href="javascript:void(0);">CANCELAR</a></span>
        </div><!--confirm-baixo-->
</div><!--confirm-dentro-->
<?php }elseif(isset($_GET["buscBarCmd"])){ extract($_GET); ?>

<div id="subBusca-dentro">
    	<div id="subBusca-topo"><span>BUSCAR <?php echo ($linhaProduto=="cd_comanda" || $linhaProduto=="cd_consulta_cmd")?'COMANDA':'PRODUTO'; ?></span></div><!--subBusca-centro-->
        <div id="subBusca-cima">
        <?php 		
			
			if($linhaProduto=="cd_comanda" || $linhaProduto=="cd_consulta_cmd"){
			include("../_classes/Comandas.class.php");
			$produtos = Comandas::trazerCmdAberta($id_empresa,0,30);
			}else{
			$produtos = Cadastros::selectArray($id_empresa,'produtos',false,false,false,true);
			}
			
			if($produtos['num']>0){
				echo '				
				<input type="text" placeholder="Busque '; echo ($linhaProduto=="cd_comanda" || $linhaProduto=="cd_consulta_cmd")?'pela comanda ou cliente':'pelo produto'; echo ' !" id="i_subBuscaTxt" autocomplete="off" />
				<button id="i_subBuscaEnvia" class="'.$linhaProduto.'"></button>
					
				<ul id="subbusca_'.$linhaProduto.'">';
				$n=1;
				foreach($produtos['dados'] as $AsProdutos){
					if($linhaProduto=="cd_comanda" || $linhaProduto=="cd_consulta_cmd"){
					$cmdCodigo=$AsProdutos['comanda'];
					$descriNome=$AsProdutos['nome'];
					}else{
					$cmdCodigo=$AsProdutos['codigo_interno'];
					$descriNome=$AsProdutos['marca'].' '.$AsProdutos['descricao'];
					}
					
					echo '<li '; if($n==1){ echo 'class="bAtivo"';} $n++; echo '><span class="'.$cmdCodigo.'">'.$cmdCodigo.' - '.$descriNome.'</span></li>';
				}
				echo '</ul>';
			}else{
				echo '<h1 class="faltaNaBusca">'; echo ($linhaProduto=="cd_comanda" || $linhaProduto=="cd_consulta_cmd")?'Nenhuma comanda foi encontrada ':'Nenhum produto foi encontrado '; echo '!</h1>';
			}
		 ?>
        </div><!--subBusca-cima-->
        <div id="subBusca-baixo">
            <span id="cancelar-subBusca"><a href="javascript:void(0);">CANCELAR</a></span>
        </div><!--subBusca-baixo-->
</div><!--subBusca-dentro-->
<?php }elseif(isset($_GET["tranfCmd"])){ extract($_GET); ?>

<div id="tranferi-dentro"<?php if($tranfCmd=="frente_caixa") echo ' style="height: 414px; margin-bottom: -212px; margin-top: -212px;"'; ?>>
    	<div id="tranferi-topo"><span>TRANSFERIR PARA CONTA DE CLIENTE</span></div><!--tranferi-centro-->
        <div id="tranferi-cima"<?php if($tranfCmd=="frente_caixa") echo ' style="height: 334px;"'; ?>>
        
            <div id="d_transfere"<?php if($tranfCmd=="frente_caixa") echo ' style="display:none;"'; ?>>
            <?php
            if($tranfCmd!="frente_caixa"){
			include("../_classes/Comandas.class.php");
			$comanda=$tranfCmd;
			if(strlen($comanda)==1){
			$comanda = '0'.$comanda;
			}
			$cmdBusCliente=Comandas::clienteCmd($id_empresa,$comanda);
            $quantCmd=$cmdBusCliente['num'];
            $idCliente=$cmdBusCliente['dados'][8];
            $nomeCliente=$cmdBusCliente['dados'][0];
            }else{
            $quantCmd=1;
            $idCliente='';
            $nomeCliente='';
            }
			if($quantCmd>0){
			echo '<p class="'.$idCliente.'">Transferir '; 
            echo ($tranfCmd!="frente_caixa")?'comanda <span id="transComanda">'.$comanda.'</span>':'a <span id="transComanda">compra</span>'; 
            echo ' no valor de R$ '.$totalCmd.' para <span id="transNome">'.$nomeCliente.'</span> ?</p>
            <span id="s_transferir"><a href="javascript:void(0);">transferir</a></span>
            <span id="s_escTransf"><a href="javascript:void(0);">escolher outra conta</a></span>';
			}else{
			echo '<h1 class="faltaNaBusca">Nenhuma comanda foi encontrada !</h1>';
			}
			 ?>             
        </div>
        <div id="d_outroTransfere"><?php 
            
            if($tranfCmd=="frente_caixa"){
                
            $clientes = Cadastros::selectArray($id_empresa,'clientes',0,30);
			if($clientes['num']>0){
				echo '
				<input type="text" placeholder="Busque por nome, cpf, rg, e-mail ou telefone..." id="i_subBuscaTxt" autocomplete="off" />
				<button id="i_subBuscaEnvia" class="buscaTransferi"></button>
				<ul id="subbusca_buscaTransferi">';
				$n=1;
				foreach($clientes['dados'] as $AsClientes){
					echo '<li '; if($n==1){ echo 'class="bAtivo"';} $n++; echo '><span class="'.$AsClientes['id'].'">'.$AsClientes['nome'].'</span></li>';
				}
				echo '</ul>';
			}else{
				echo '<h1 class="faltaNaBusca">Nenhum cliente foi encontrado !</h1>';
			}
            
            }
            
            ?></div>
        
        </div><!--tranferi-cima-->
        <div
         id="tranferi-baixo">
	        <span id="cancelar-tranferi"><a href="javascript:void(0);">CANCELAR</a></span>
        	<span id="voltar-tranferi"><a href="javascript:void(0);">VOLTAR</a></span>            
        </div><!--tranferi-baixo-->
</div><!--tranferi-dentro-->

<?php }elseif(isset($_GET["prodBarCmd"])){ extract($_GET); ?>
<script type="text/javascript">
$(function(){
	$('input.for-valor').priceFormat({
	prefix: '',
	centsSeparator: ',',
	thousandsSeparator: '.'
	});		
});
</script>
<div class="linha_form comandaDoBar cmdExtraBar">
    <div class="d_alinha_form">
        <?php					
        echo '
        <span><label for="cd_produto_cmd-'.$contProQuant.'">produto '.($contProQuant+1).':</label></span>
        <div class="d_alinha_subbusca">
        <div class="bt_diversos" id="cd_btDiverso_cmd_'.$contProQuant.'" title="Produto diverso"><span class="diverso-false"></span></div>
        <input type="text" id="cd_produto_cmd-'.$contProQuant.'" placeholder="Código do produto..." onKeyUp="return SemEspaco(this);" onkeypress="return maisMenos(this);" autocomplete="off" />
        <div class="bt_subbusca" title="Buscar por produto"><span class="cd_produto_cmd-'.$contProQuant.'"></span></div>								
        </div><!--d_alinha_subbusca-->						
        <div class="d_aviso_erro" id="erro_cd_produto_cmd-'.$contProQuant.'"><div class="d_ponta-erro"></div><p></p></div><!--d_aviso_erro--> 
    </div>
    
    <div class="d_alinha_form campoValDiverso" id="openVal-cd_produto_cmd-'.$contProQuant.'">
        <span><label for="cd_valDiv_cmd_'.$contProQuant.'">valor diverso '.($contProQuant+1).':</label></span>';
        ?>
        <input type="text" id="cd_valDiv_cmd_<?php echo $contProQuant; ?>" value="0,00" onfocus="if(this.value=='0,00')this.value='';" class="for-valor" autocomplete="off" />
        <?php
        echo '<div class="d_aviso_erro" id="erro_cd_valDiv_cmd_'.$contProQuant.'"><div class="d_ponta-erro"></div><p></p></div><!--d_aviso_erro-->
    </div>
    <div class="d_alinha_form campoQuant" id="smallQuant-cd_produto_cmd-'.$contProQuant.'">
        <span><label for="cd_qtd_cmd_'.$contProQuant.'">quantidade '.($contProQuant+1).':</label></span>
        <input type="text"  id="cd_qtd_cmd_'.$contProQuant.'" onKeyPress="return SomenteNumero(event);" autocomplete="off" />
        <div class="d_aviso_erro" id="erro_cd_qtd_cmd_'.$contProQuant.'"><div class="d_ponta-erro"></div><p></p></div><!--d_aviso_erro-->
    </div>';
echo '</div>';

}elseif(isset($_GET["mostraFunc"])){
	extract($_GET);
	if($mostraFunc=='A' || $mostraFunc=='a'){
		echo '<h2>funcionário:</h2><p>administrador</p>';		
	}elseif($mostraFunc=='isento' ||  $mostraFunc=='ISENTO'){
		echo '<h2>funcionário:</h2><p>não especificado !</p>';
	}else{
		include("../_classes/Operadores.class.php");
		$trasFunc=Operadores::selUmOperador($id_empresa,$mostraFunc);
		if($trasFunc['num']==1){
			$dados=$trasFunc['dados'];
			echo '<h2>funcionário: '.$dados['codigo'].'</h2><p>'.$dados['nome_operador'].'</p>';		
		}else{			
			echo '<h2>funcionário:</h2><p>não encontrado !</p>';
		}	
	}
	
	
}elseif(isset($descontarCmd)){ ?>
<script type="text/javascript">
$(function(){
$('#money-descontar').priceFormat({
	prefix: '',
	centsSeparator: ',',
	thousandsSeparator: '.'
	});
});
</script>
<div id="payCount-dentro" style="height: 400px; margin-bottom: -205px; margin-top: -205px;">
    	<div id="payCount-topo"><span>DESCONTAR DE CONTA</span></div><!--confirm-centro-->    	
        <div id="payCount-cima" style="height: 320px;">
        	
            <div id="money-payCount" style="display:block;">
            <form method="post" action="">
            <p class="p1-payCount">&nbsp;</p>
            <div class="div-payCount">
            <p class="p2-payCount">VALOR TOTAL DA CONTA:</p>
            <h2 class="val-payCount"><?php echo $totalCmd; ?></h2>
            </div>
            <div class="div-payCount">
            <p class="p2-payCount">VALOR A SER DESCONTADO:</p>
            <input type="text" id="money-descontar" autocomplete="off" />
            <div class="d_aviso_erro" id="erro_money-descontar" style="margin-left:15px;"><div class="d_ponta-erro"></div><p></p></div><!--d_aviso_erro-->
            <input type="hidden" id="salvaMoneyResto" />
            </div>
            
            <div class="div-payCount">
            <p class="p2-payCount">VALOR RESTANTE:</p>
            <h2 id="valTroco-payCount"><?php echo $totalCmd; ?></h2>
            </div>
           
            <div style="background:#fff;" class="div-payCount">
            <button type="submit" id="final-descontar-payCount" >fazer desconto</button>
            </div>
            </form>
            </div><!--money-payCount-->
            
        </div><!--confirm-cima-->
        
        <div id="payCount-baixo">
            <span id="cancelar-payCount"><a href="javascript:void(0);">CANCELAR</a></span>
        </div><!--confirm-baixo-->
    </div><!--confirm-dentro-->
	

<?php }elseif(isset($pagarCmd)){

include('../_classes/Empresas.class.php');
$selEmpresa = Empresas::selectEmpresa(0,$id_empresa);
$sangria=($selEmpresa['num']>0)?$selEmpresa['dados'][18]:0;
    
if($sangria==1){    
if($table=="usuarios"){
$fechada_por="a";
}elseif(isset($_SESSION['Gerabar_Ocodigo'])){
$fechada_por=$_SESSION['Gerabar_Ocodigo'];
}else{
$fechada_por="isento";
}
include('../_classes/AbrirFecharCaixa.class.php');
$selCxAberto=AbrirFecharCaixa::selAbrirCaixa($id_empresa,$fechada_por);
$numCxAberto=$selCxAberto['num'];
    if($numCxAberto==0){
        $valTroco='0,00';
        $valLimite='0,00';
        $txtTopo='';
        $style='';
        $abrirFecharCx="a_abrir_caixa";
        if(isset($_SESSION['Gerabar_Ocodigo'])){
            include('../_classes/Operadores.class.php');
            $dadosOpera=Operadores::selUmOperador($id_empresa,$_SESSION['Gerabar_Ocodigo']);
            $noneOpera=($dadosOpera['num']==1)?$dadosOpera['dados']['nome_operador']:'Universal';
        }else{
            $noneOpera=($table=="usuarios")?'Administrador':'Universal';
        }

        include('abrir_fechar_caixa.php');
        exit();
    }
}
        
?>
<script type="text/javascript">
$(function(){
$('#money-pago').priceFormat({
	prefix: '',
	centsSeparator: ',',
	thousandsSeparator: '.'
	});
});
</script>
<div id="payCount-dentro">
    	<div id="payCount-topo"><span>PAGAMENTO DE CONTA</span></div><!--confirm-centro-->    	
        <div id="payCount-cima">
        	
            <div id="money-payCount">           	
            <form method="post" action="">
            <p class="p1-payCount">fazer pagamento em dinheiro:</p>            
            <div class="div-payCount">
            <p class="p2-payCount">valor total a ser pago:</p>
            <h2 class="val-payCount"><?php echo $totalCmd; ?></h2>
            </div>

            <div class="div-payCount">
            <p class="p2-payCount">valor pago:</p>
            <input type="text" id="money-pago" autocomplete="off" />
            <div class="d_aviso_erro" id="erro_money-pago" style="margin-left:15px;"><div class="d_ponta-erro"></div><p></p></div><!--d_aviso_erro-->            
            <input type="hidden" id="salvaMoneyTroco" />
            <input type="hidden" id="idCliente-payCount" value="<?php echo $idCliente; ?>" />            
			<input type="hidden" value="<?php if(isset($idPago)){ echo $idPago.'|'.$quant; }elseif(isset($qlCmdMesa) AND $qlCmdMesa!="busca_cmd"){ echo $qlCmdMesa;} ?>" id="quantIdConta" />
            </div>
            
            <div class="div-payCount">
            <p class="p2-payCount">valor do troco:</p>
            <h2 id="valTroco-payCount">0,00</h2>
            </div>
           
            <div style="background:#fff;" class="div-payCount">
            <button type="submit" id="final-money-payCount">finalizar pagamento</button>
            </div>
            </form>
            </div><!--money-payCount-->
            
            <div id="card-payCount">
            	<form method="post" action="">
            	<p class="p1-payCount">fazer pagamento com cartão:</p>
            
                <div class="div-payCount">
                <p class="p2-payCount">valor total a ser pago:</p>
                <h2 class="val-payCount"><?php echo $totalCmd; ?></h2>
                </div>
                
                <div class="div-payCount">
                <p class="p2-payCount">forma de pagamento:</p>
                <select id="card-formPaga">
                        <option value="">selecione</option>
                        <option value="cartão visa débito">cartão visa débito</option>
                        <option value="cartão visa crédito">cartão visa crédito</option>
                        <option value="cartão mastercard débito">cartão mastercard débito</option>
                        <option value="cartão mastercard crédito">cartão mastercard crédito</option>
                        <option value="cartão elo débito">cartão elo débito</option>
                        <option value="cartão elo crédito">cartão elo crédito</option>
                    </select>                
                <div class="d_aviso_erro" id="erro_card-formPaga" style="margin-left:15px;"><div class="d_ponta-erro"></div><p></p></div><!--d_aviso_erro-->            
                </div>
                
                <div class="div-payCount">
                <p class="p2-payCount">autorização do cartão:</p>
                <input type="text" id="card-autoriza" onKeyPress="return SomenteNumero(event);" />
                <div class="d_aviso_erro" id="erro_card-autoriza" style="margin-left:15px;"><div class="d_ponta-erro"></div><p></p></div><!--d_aviso_erro-->
                </div>
               
                <div style="background:#fff;" class="div-payCount">
                <button type="submit" id="final-card-payCount">finalizar pagamento</button>
                </div>
            	</form>
            </div><!--card-payCount-->
            
            <div id="forma-payCount">
            
        	<p class="p1-payCount">por favor, selecione a forma de pagamento:</p>
            
            <span><a href="javascript:void(0);" id="dinheiro-payCount">dinheiro</a></span>
            <span><a href="javascript:void(0);" id="cartao-payCount">cartão</a></span>
            
            </div><!--forma-payCount-->
        
        </div><!--confirm-cima-->
        
        <div id="payCount-baixo">        	
            <span id="cancelar-payCount"><a href="javascript:void(0);">CANCELAR</a></span>
            <span id="voltar-payCount"><a href="javascript:void(0);">VOLTAR</a></span>
        </div><!--confirm-baixo-->
    </div><!--confirm-dentro-->

<?php }elseif(isset($_GET["juntaCmd"])){ ?>
<div id="juntaCmd-dentro">
    	<div id="juntaCmd-topo"><span>JUNTAR <?php echo ($_GET["juntaCmd"]=="busca_comanda_mesa")?"OUTRA MESA":"COMANDAS DE CLIENTES"; ?></span></div><!--juntaCmd-centro-->
        
        <div id="juntaCmd-cima">
   
            <form method="post" action="">
                
            <div class="linha_form" style="margin-top:20px;">
                <div class="d_alinha_form" style="margin-left:10px;">
                    <span><label for="cmd_junta">adicionar <?php echo ($_GET["juntaCmd"]=="busca_comanda_mesa")?"mesa":"comanda"; ?>:</label></span>
                    <input type="text" id="cmd_junta" onKeyPress="return SomenteNumero(event);" autocomplete="off" />
                    <div class="d_aviso_erro" id="erro_cmd_junta"><div class="d_ponta-erro"></div><p></p></div><!--d_aviso_erro-->
                </div>
            
                <div class="d_alinha_form">
                	<span><label>&nbsp;</label></span>
                    <button type="submit" class="cd_envia_dados" id="envia_cmd_junta">juntar</button>
                </div>
            </div><!--fecha linha form-->
            
            </form>
        
        </div><!--juntaCmd-cima-->
        
        <div id="juntaCmd-baixo">
            <span id="cancelar-juntaCmd"><a href="javascript:void(0);">CANCELAR</a></span>
        </div><!--juntaCmd-baixo-->
</div><!--juntaCmd-dentro-->
<?php }elseif(isset($senhaMaster)){ ?>
<div id="senhaMaster-dentro">
    <div id="senhaMaster-topo"><span>PERMISSÃO</span></div><!--senhaMaster-topo-->
    <div id="senhaMaster-cima">
    	<h2>NECESSÁRIO SENHA MASTER PARA EXCLUIR</h2>
    	<form method="post" action="">
            <div class="linha_form">
                <div class="d_alinha_form" style="margin-left:10px;">
                    <span><label for="senha_master">coloque a senha master:</label></span>
                    <input type="password" id="senha_master" class="<?php echo $classMaster; ?>" autocomplete="off" />
                    <div class="d_aviso_erro" id="erro_senha_master"><div class="d_ponta-erro"></div><p></p></div><!--d_aviso_erro-->
                </div>
            </div><!--fecha linha form-->
            <div class="linha_form">
                <div class="d_alinha_form" style="margin-left:10px;">
                    <button type="submit" class="cd_envia_dados" id="envia_senha_master">avançar</button>
                </div>
            </div><!--fecha linha form-->
        </form>
    
    </div><!--senhaMaster-cima-->
    <div id="senhaMaster-baixo">
        <span><a href="javascript:void(0);">CANCELAR</a></span>
    </div><!--senhaMaster-baixo-->
</div><!--senhaMaster-dentro-->
<?php }elseif(isset($_GET["altSenha"])){ extract($_GET); ?>
<div id="tdAltSenha-dentro">
    <div id="tdAltSenha-topo"><span><?php echo $txtTopo; ?></span></div><!--tdAltSenha-topo-->
    <div id="tdAltSenha-cima">    
    	<form method="post" action="">                
            <div class="linha_form d_senha_respansivo">
                <div class="d_alinha_form" style="margin-left:10px;">
                    <span><label for="alt_senha_atual">coloque sua senha atual:</label></span>
                    <input type="password" id="alt_senha_atual" class="<?php echo $qualSenha; ?>" />
                    <div class="d_aviso_erro" id="erro_alt_senha_atual"><div class="d_ponta-erro"></div><p></p></div><!--d_aviso_erro-->
                </div>
            </div><!--fecha linha form-->            
            <div class="linha_form d_senha_respansivo">
                <div class="d_alinha_form" style="margin-left:10px;">
                    <span><label for="alt_nova_senha">coloque sua nova senha:</label></span>
                    <input type="password" id="alt_nova_senha" />
                    <div class="d_aviso_erro" id="erro_alt_nova_senha"><div class="d_ponta-erro"></div><p></p></div><!--d_aviso_erro-->
                </div>
                <div class="d_alinha_form" style="margin-left:10px;">
                    <span><label for="alt_repetNova_senha">repita sua nova senha:</label></span>
                    <input type="password" id="alt_repetNova_senha" />
                    <div class="d_aviso_erro" id="erro_alt_repetNova_senha"><div class="d_ponta-erro"></div><p></p></div><!--d_aviso_erro-->
                </div>
            </div><!--fecha linha form-->
                
            <div class="linha_form d_senha_respansivo_buttom">    
                <div class="d_alinha_form" style="margin-left:10px;">
                    <button type="submit" class="cd_envia_dados" id="envia_alt_senha" >alterar</button>
                </div>
            </div><!--fecha linha form-->            
            </form>
    
    </div><!--tdAltSenha-cima-->
    <div id="tdAltSenha-baixo">
        <span><a href="javascript:void(0);">CANCELAR</a></span>
    </div><!--tdAltSenha-baixo-->
</div><!--tdAltSenha-dentro-->
<?php }else{
echo "<h2>Ocorreu algum erro inesperado, por favor, tente novamente mais tarde !</h2>";
}
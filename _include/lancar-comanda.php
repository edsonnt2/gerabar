<?php if(isset($_POST['inclui'])){ if(isset($_SESSION)==false){session_start();}
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
$idEmp = Cadastros::selectIdEmpresa($idDaSessao,$tabela);
$idEmpresa = $idEmp['dados'][0];
if(isset($_POST['idMesa']) AND $_POST['idMesa']!=""){
	$idMesa=(int)$_POST['idMesa']; 
	if($idMesa<10){
	$idMesa= '0'.$idMesa;
	}
}else{
	$idMesa='';
}
$cad=$_POST['inclui'];
}else{
$idEmpresa = $user_id_empresa;
if(!isset($table) || $table!="ambientes"){
include('_classes/Cadastros.class.php');
}    
if(isset($_GET['idMesa']) AND $_GET['idMesa']!=""){
	$idMesa=(int)$_GET['idMesa']; 
	if($idMesa<10){
	$idMesa= '0'.$idMesa;
	}
}else{
	$idMesa='';
}
$cad=(isset($_GET['cad']))?$_GET['cad']:'';
}
?>
<script type="text/javascript">
$(function(){
	$('input.for-valor').priceFormat({
	prefix: '',
	centsSeparator: ',',
	thousandsSeparator: '.'
	});
});
</script>
   <div id="cont_form_comanda" class="<?php if($idMesa<>""){ echo 'mesa';}else{ echo 'comanda';} ?>">
        	<div class="info_topo_cad"><h1>lançamento <?php echo ($idMesa=="")?'de comanda':'em mesa'; ?></h1></div><!--fecha info topo cad-->
            <form action="" method="post">
            <input type="hidden" id="contProQuant" value="1" />
            <div class="linha_form comandaDoBar">
            	<div class="d_alinha_form">
                    <span><label for="cd_garcon">garçon / funcionário:</label></span>
                    <input type="text" id="cd_garcon" onKeyPress="return SomenteNumero(event);" autofocus="autofocus" autocomplete="off" />
                    <div class="d_aviso_erro" id="erro_cd_garcon"><div class="d_ponta-erro"></div><p></p></div><!--d_aviso_erro-->
                </div>
                <div class="d_alinha_form">
                    <span><label for="cd_comanda">comanda<?php echo ($idMesa<>"")?' mesa':''; ?>:</label></span>
                    <?php if($idMesa==""){?>
                    <div class="d_alinha_subbusca subCmdBar">
                    <input type="text" id="cd_comanda" value="<?php if(isset($_GET['idcomanda'])){ echo $_GET['idcomanda'];} ?>" onKeyPress="return SomenteNumero(event);" autocomplete="off" />
                     <div class="bt_subbusca" title="ATALHO (F1)"><span class="cd_comanda"></span></div>
                    </div><!--d_alinha_subbusca-->
					<?php }else{ ?>
                    <input type="text" id="cd_comanda" value="<?php echo $idMesa; ?>" disabled="disabled" autocomplete="off" />
					<?php } ?>
                    <div class="d_aviso_erro" id="erro_cd_comanda"><div class="d_ponta-erro"></div><p></p></div><!--d_aviso_erro-->
                </div>
            </div><!--fecha linha form-->
            <div class="info_topo_cad" style="margin-top:20px;"></div><!--fecha info topo cad-->
            <div class="linha_form comandaDoBar">
            	<div class="d_alinha_form">
                    <span class="MaisMenosProduto" id="maisProdutos"><a href="javascript:void(0);" title="ATALHO (+)">mais produtos</a></span>
                </div>
                <div class="d_alinha_form">
                    <span class="MaisMenosProduto" id="menosProdutos"><a href="javascript:void(0);" title="ATALHO (-)">menos produtos</a></span>
                </div>
            </div><!--fecha linha form-->
            <div class="linha_form comandaDoBar" id="cmdBarBaixo">
                <div class="d_alinha_form">
                    <span><label for="cd_produto_cmd-0">produto:</label></span>
						<div class="d_alinha_subbusca">
                        <div class="bt_diversos" id="cd_btDiverso_cmd_0" title="Produto diverso"><span class="diverso-false"></span></div>
						<input type="text" id="cd_produto_cmd-0" value="<?php if(isset($_GET['idproduto'])){echo $_GET['idproduto']; } ?>" placeholder="Código do produto..." onKeyUp="return SemEspaco(this);" onkeypress="return maisMenos(this);" autocomplete="off" />
						<div class="bt_subbusca" title="Buscar por produto"><span class="cd_produto_cmd-0"></span></div>
						</div><!--d_alinha_subbusca-->                        
                    <div class="d_aviso_erro" id="erro_cd_produto_cmd-0"><div class="d_ponta-erro"></div><p></p></div><!--d_aviso_erro-->
                </div>
                <div class="d_alinha_form campoValDiverso" id="openVal-cd_produto_cmd-0">
                    <span><label for="cd_valDiv_cmd_0">valor diverso:</label></span>
                    <input type="text" id="cd_valDiv_cmd_0" class="for-valor" value="0,00" onfocus="if(this.value=='0,00')this.value='';" autocomplete="off" />
                    <div class="d_aviso_erro" id="erro_cd_valDiv_cmd_0"><div class="d_ponta-erro"></div><p></p></div><!--d_aviso_erro-->
                </div>
                <div class="d_alinha_form campoQuant" id="smallQuant-cd_produto_cmd-0">
                    <span><label for="cd_qtd_cmd_0">quantidade:</label></span>
                    <input type="text"  id="cd_qtd_cmd_0" onKeyPress="return SomenteNumero(event);" autocomplete="off" />
                    <div class="d_aviso_erro" id="erro_cd_qtd_cmd_0"><div class="d_ponta-erro"></div><p></p></div><!--d_aviso_erro-->
                </div>
            </div><!--fecha linha form-->
            <div class="linha_form">
                <div class="d_alinha_form">
                	<button type="submit" class="cd_envia_dados" id="envia_cmd_bar" title="ATALHO (ENTER)">lançar <?php echo ($idMesa<>"")?'em mesa':''; ?></button>
                    <input type="hidden" value="<?php echo $cad; ?>" id="pgAbaMesa" />
                </div>
                <?php if($idMesa<>""){
					$linkVai=($cad=="comanda-mesa")?'comanda-bar.php?cad=comanda-mesa':'caixa.php?cad=opcao-mesa';
                echo '<div class="d_alinha_form">
                    <a class="volta_mesas styleVolMesa" href="'.$linkVai.'">voltar</a>
                </div>';
				} ?>
            </div><!--fecha linha form-->
            </form>
        </div><!--fecha form comanda-->
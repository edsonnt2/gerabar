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
	$table = $_SESSION['Gerabar_table'];
	include('../_classes/Empresas.class.php');
	include('../_classes/Cadastros.class.php');
	$idEmpre = Cadastros::selectIdEmpresa($idDaSessao,$table);
	$user_id_empresa=($idEmpre['num']>0)?$idEmpre['dados'][0]:0;
	}
	if(isset($_POST['inclui']) || isset($_GET['cad'])){
	$idEmpresa = Empresas::selectEmpresa(0,$user_id_empresa);
	}
	$qMesa = ($idEmpresa['dados'][16]<10)?'0'.$idEmpresa['dados'][16]:$idEmpresa['dados'][16];
 ?>
<div id="cont-cadastro-mesa">
	<div class="info_topo_cad"><h1>comandas por mesa</h1></div><!--fecha info topo cad-->
    
		    <div class="d-alinha-mesa">
                <p>quantidade de mesa:</p>
                <div id="d-cx-quant">
                    <input type="text" value="<?php echo $qMesa; ?>" onKeyPress="return SomenteNumero(event)" onBlur="if(this.value=='') this.value='<?php echo $qMesa; ?>';" maxlength="3" id="i-quant-mesa" />
					<span id="s-mais-mesa"><a href="javascript:void(0);"></a></span>
                    <span id="s-menos-mesa"><a href="javascript:void(0);"></a></span>
                 </div><!--d-cx-quant-->
             </div>
    <span id="envia-mesa"><a href="javascript:void(0);">salvar mesa</a></span>

</div><!--cont-cadastro-mesa-->
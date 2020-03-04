<?php if(isset($_POST['inclui'])){ if(isset($_SESSION)==false){session_start(); }
		include('../_classes/DB.class.php');
		function getUrl(){return 'http://localhost/myforadmin/';}
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
		include('../_classes/Empresas.class.php');
        $idEmpresa = Empresas::selectEmpresa($idDaSessao);
        $sangria=$idEmpresa['dados'][18];
		}
    
/*
<h1 class="h1_error">Função em desenvolvimento, em breve disponível !</h1>
*/
?>
<div id="cont_dados_referencia">
    <h1 id="h1TopoUsuario">PREFERÊNCIAS</h1>
    <div id="d_sangria_cx">
        <h3>ATIVAR SANGRIA DE CAIXA:</h3>
        <div class="tudo_txt_ajuda">
            <span class="ico-ajuda"></span>
            <div class="cx_txt_ajuda"><div class="ponta_ajuda"></div><p>A sangria serve para abrir o caixa e ter controle de troco, do limite de dinheiro no caixa e do funcionário que está operando no ambiente.</p></div><!--cx_txt_ajuda-->
        </div><!--tudo_txt_ajuda-->
        <?php echo '<div class="d_toggle"><label'; if($sangria==0){ echo ' id="l_toggle_desativado"'; }else{ echo ' id="l_toggle_ativado" class="label_ativo"'; } echo '></label><div class="carregador_toggle"></div></div>'; ?>
    </div><!--d_sangria_cx-->
</div><!--fecha cont_dados_referencias-->
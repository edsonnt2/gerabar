<?php if(isset($_POST['status']) AND $_POST['status']=="altera"){ if(isset($_SESSION)==false){session_start(); }
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
		include('../_classes/Cadastros.class.php');
		$idEmpre = Cadastros::selectIdEmpresa($idDaSessao,'usuarios');
		if($idEmpre['num']>0){
		$idEmpresa = $idEmpre['dados'][0];
		}else{
		$idEmpresa = 0;
		}
		if(Cadastros::altStatusEmpresa(3,$idEmpresa)){
			Cadastros::altStatusOpera($idDaSessao,1,'usuarios');
		}
	}
?>
<div id="cont_pronto_empresa">
	<h1>Primeiros Passos Concluídos !</h1>
    <h2>Agora você já pode usufruir completamente do seu Gerabar. Começe indo até a <a href="<?php echo getUrl(); ?>cadastros.php?cad=produtos" title="Página de Cadastros">página de cadastros</a> e colocando tudo que seu negócio precisar.</h2>
    <a class="pronto_empresa" href="<?php echo getUrl(); ?>" title="Finalizar primeiros passos">Finalizar primeiros passos</a>
	<p>*Todas as informações colocadas até agora, podem ser alteradas a qualquer momento indo em <a href="<?php echo getUrl(); ?>configuracoes.php">configurações</a>.</p>
</div><!--fecha cont pronto empresa-->
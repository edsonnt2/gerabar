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
	$idEmpresa = $idEmp['dados'][0];
	$acres="../";
	}else{$acres="";
	$idEmpresa = $user_id_empresa; 
    if($table=="usuarios"){
	include('_classes/Cadastros.class.php');
    }
	}
	include($acres."_classes/Mesas.class.php");
	$trasData=Mesas::DataMesaFechado($idEmpresa,"cmd_mesa");
	$DBdataFinal=date('d/m/Y',strtotime($trasData['dados'][0]));
	$valData=explode('/',$DBdataFinal);
	$DBdataInicial = date('d/m/Y',mktime(0,0,0,$valData[1],$valData[0]-1,$valData[2]));
	$dataInicial=false;
	$dataFinal=false;
	$qualAtivo="data";
	$linkData="";
	if(isset($_GET["tudo"])){				
	$linkData="&tudo=true";
	$qualAtivo="tudo";
	}elseif(isset($_GET["busca"])){
	$qualAtivo="busca";
	}elseif(isset($_GET['dataInicial']) AND isset($_GET['dataFinal'])){
	$dataInicial=$_GET['dataInicial'];
	$dataFinal=$_GET['dataFinal'];
	$linkData="&dataInicial=".$dataInicial."&dataFinal=".$dataFinal;
	}else{
	$dataInicial=$DBdataInicial;
	$dataFinal=$DBdataFinal;
	$linkData="&dataInicial=".$dataInicial."&dataFinal=".$dataFinal;
	}

	$countCmdAbertas=Mesas::selMesaAberta($idEmpresa,$dataInicial,$dataFinal);

	if($countCmdAbertas['num']>0){
?>
<div class="d_volta_admin"><a href="<?php echo getUrl(); ?>administracao.php?relatorio=mesas">Voltar para início de Administração</a></div>
<div id="tudo_cmd_aberta">

<div class="info_topo_cad"><h1>mesas em aberto</h1></div><!--fecha info topo cad-->

<?php 
$pgOndefiltra='mesas-abertas';
$countTudoAbreFecha=$countCmdAbertas['num'];
include($acres.'_include/filtro.php'); 
?>

<div id="tudoCarregaCmd">
<?php
	if($qualAtivo=="busca"){
	$pgs = 0;
	if($_GET["busca"]==""){
	$numCmd=0;
	}else{
	$cmdAbertas=Mesas::selMesaPagar($idEmpresa,$_GET["busca"],0,true);
	$numCmd=$cmdAbertas['num'];
	}
	}else{
	$count=$countCmdAbertas['num'];
	if(isset($_GET['pg']) AND $_GET['pg']!=0){
	$pagina = (int)$_GET['pg'];
	}else{
	$pagina = 1;
	}
	$maximo = 30;
	$inicio = $pagina - 1;
	$inicio = $maximo * $inicio;
	$menos = $pagina - 1;
	$mais = $pagina + 1;
	$pgs = ceil($count / $maximo);
        
	$cmdAbertas=Mesas::selMesaAberta($idEmpresa,$dataInicial,$dataFinal,$inicio,$maximo);
	$numCmd=$cmdAbertas['num'];
        
	}
	if($numCmd>0){
	include($acres."_include/lista-comandas-abertas.php");
	 }else{				
	if($qualAtivo=="busca"){
		if($_GET["busca"]<>""){
		echo '<div class="tudo_cmd_vazio">
			<h1>Nada foi encontrado em sua busca !</h1>
		</div>';
		}
	}else{
	echo '<div class="tudo_cmd_vazio">
		<h1>Página não encontrada !</h1>
	</div>';
	}
	 } ?>
	 </div><!--fecha tudoCarregaCmd-->
</div><!--tudo_cmd_aberta-->
 <?php } ?>
<div class="tudo_cmd_vazio" <?php if($countCmdAbertas['num']>0){ echo 'style=" display:none;" ';} ?>>
	<h1>sem mesas em aberto !</h1>
</div>
<div class="d_volta_admin"><a href="<?php echo getUrl(); ?>administracao.php?relatorio=mesas" id="qualPgEsta" class="mesas">Voltar para início de Administraço</a></div>
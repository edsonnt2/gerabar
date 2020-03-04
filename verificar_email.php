<?php include('_include/header_inicio.php'); ?>
<div class="cAlign">
<div id="form-H" style="float:left;">
<h1 style="margin-left:20px;">Verificação de e-mail</h1>
</div>
</div><!--.cAlign-->
</div><!--#topo-->

<div class="cAlign">

<div id="tudo_termos">

<?php 

if((isset($_GET['utilizador']) AND $_GET['utilizador']<>'') AND (isset($_GET['confirmacao']) AND $_GET['confirmacao']<>'')){ 
include('_classes/Recuperar.class.php');
$verifChave = Recuperar::statusVerifica(strip_tags($_GET['utilizador']),strip_tags($_GET['confirmacao']));
	if($verifChave['num']>0){

		if($verifChave['dados'][0]==0){
		
		if($alteraChave=Recuperar::salvaVerifica(strip_tags($_GET['utilizador']),strip_tags($_GET['confirmacao']))){		
			echo '<h2>E-mail verificado com sucesso !</h2>	
			<p>Obrigado por verificar o e-mail '.strip_tags($_GET['utilizador']).'.</p>		
			<p><a href="'.getUrl().'">Clique aqui</a> para volta ao início e aproveite do melhor que o Gerabar pode oferecer.</p>';
		}else{
			echo '<h2>Não foi possível verificar sua conta !</h2>	
			<p>Ocorreu um erro em nosso sistema ou tentar verificar seu e-mail, por favor, tente novamente.</p>	
			<p><a href="'.getUrl().'">Clique aqui</a> para volta ao início.</p>';		
		}
		
		}else{			
		echo '<h2>E-mail já verificado !</h2>	
		<p>O e-mail edson_nt2@hotmail.com já está válido em nosso sistema.</p>		
		<p><a href="'.getUrl().'">Clique aqui</a> para volta ao início e aproveite do melhor que o Gerabar pode oferecer.</p>';
		}
	
	}else{
	echo '<h2>Não foi possível verificar sua conta !</h2>	
	<p>Verifique seu e-mail ou a chave de confirmação e tente novamente.</p>	
	<p><a href="'.getUrl().'">Clique aqui</a> para volta ao início.</p>';	
	}

}else{
echo '<h2>Não foi possível verificar sua conta !</h2>
<p>Verifique seu e-mail ou a chave de confirmação e tente novamente.</p>
<p><a href="'.getUrl().'">Clique aqui</a> para volta ao início.</p>';
}

?>

</div><!--tudo_termos-->

</div><!--.cAling-->

<?php include('_include/footer_inicio.php'); ?>
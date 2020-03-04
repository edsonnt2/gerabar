<?php 
include('_include/header_inicio.php'); ?>
<div class="cAlign">
<div id="form-H" style="float:left;">
<h1 style="margin-left:20px;">ERROR 404 !</h1>
</div>
</div><!--.cAlign-->

</div><!--#topo-->

<div class="cAlign">
<style type="text/css">
#erroPg{ float:left; margin:40px 0 0 20px;}
h1{ font:bold 32px Arial, Helvetica, sans-serif; color:#444; text-shadow:1px 0 1px #eee; text-transform:uppercase;}
#erroPg h2{ font:bold 24px/50px Arial, Helvetica, sans-serif; color:#444; text-shadow:1px 0 1px #eee; text-transform:uppercase;}
#erroPg h2 a{ text-decoration:none; color:#069;}
#erroPg h2 a:hover{ text-decoration:underline; color:#069;}

</style>
<div id="erroPg">
<h1>Página não encontrada !</h1>
<h2><a href="<?php echo getUrl(); ?>" title="Inicío">clique aqui</a> para voltar para o inicío.</h2>
</div>

</div><!--.cAling-->
<?php include('_include/footer_inicio.php'); ?>
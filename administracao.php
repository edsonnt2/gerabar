<?php include('_include/header.php'); ?>
<div id="corpo">
<div id="cont_tudo_index">
    <?php
    
    $getCad=(isset($_GET['cad']))?$_GET['cad']:"";    
    
        if($getCad=="caixas-abertos" || $getCad=="caixas-fechados"){
            include('_include/caixas-fechadas.php');
        }elseif($getCad=="vendas-abertas"){
            include('_include/vendas-abertas.php');
        }elseif($getCad=="vendas-fechadas"){
            include('_include/vendas-fechadas.php');
        }elseif($getCad=="comandas-abertas"){
            include('_include/comandas-abertas.php');
        }elseif($getCad=="comandas-fechadas"){
            include('_include/comandas-fechadas.php');
        }elseif($getCad=="mesas-abertas"){
            include('_include/mesas-abertas.php');
        }elseif($getCad=="mesas-fechadas"){
            include('_include/mesas-fechadas.php');
        }elseif($getCad=="contas-fechadas"){
            include('_include/contas-fechadas.php');
        }else{
        include("_include/cont_admin.php");
        }
    
    ?>
</div><!--cont_tudo_index-->
</div><!--fecha corpo-->
</div><!-- fecha cAlign-->
<?php include('_include/footer.php');
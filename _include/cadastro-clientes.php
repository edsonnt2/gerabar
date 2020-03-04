<?php
if(isset($_POST['inclui'])){
include("../_classes/DB.class.php");
$acres="../";}else{$acres="";}
if(!isset($table) || $table!="ambientes"){
include($acres.'_classes/Cadastros.class.php');
}
echo '<div id="for_cadCliente_caixa" class="ativo">';
include($acres.'_include/cadastro_clientes.php');
echo '</div>';
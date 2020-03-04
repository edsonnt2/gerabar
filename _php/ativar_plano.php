<?php
session_start();
extract($_POST);
$exPlano = explode('_',$salvaPlano);
$numPlano = end($exPlano);
$_SESSION['salvar_plano'] = $numPlano;

include('../_classes/DB.class.php');
include('../_classes/Login.class.php');
$objLogin=new Login;
if($objLogin->logado()){
    echo 'logado|';    
}else{
    echo '|';
}
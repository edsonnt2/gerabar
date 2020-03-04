<?php
include("../_classes/DB.class.php");
$condicaoData = date('Y-m-d', strtotime("-1 days"));
DB::getConn()->query("DELETE FROM recuperar_senha WHERE DATE_ADD(data,INTERVAL 1 DAY) < NOW()");

echo '<h1>Página Restrita !</h1>';
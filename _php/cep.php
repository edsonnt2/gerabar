<?php

if(isset($_POST['cep'])==false OR $_POST['cep']==''){
	
return false;

}else{

$explode = explode('-',strip_tags($_POST['cep']));
function busca_cep($c){
$ret="";
$site = "http://republicavirtual.com.br/web_cep.php?cep=".urlencode($c)."&formato=query_string";
$str = @file_get_contents($site);
if(!$str){$str = "&resultado=0";}
parse_str($str,$ret);
return $ret;
}

$cep = $explode[0].$explode[1];

if(isset($cep) AND $cep!=false){
	$ender = busca_cep($cep);	
	if($ender['resultado']>0){		
		$resulCep =utf8_encode($ender['tipo_logradouro']).': '.utf8_encode($ender['logradouro']).'|'.utf8_encode($ender['bairro']).'|'.utf8_encode($ender['cidade']).'|'.utf8_encode($ender['uf']);		
		if(isset($apenasCidade)){		
		if(utf8_encode($ender['cidade'])==$apenasCidade){		
		echo $resulCep;		
		}else{
		echo 'erro-1';
		}		
		}else{		
		echo $resulCep;
		}
	}else{
	return false;
	}
}}

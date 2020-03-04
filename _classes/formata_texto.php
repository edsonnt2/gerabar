<?php
function converter($term,$tp){
switch($tp) {
//Converte uma string para minúsculas
case "1":
$palavra = strtr(strtoupper($term),"àáâãäåæçèéêëìíîïðñòóôõö÷øùüúþÿ","ÀÁÂÃÄÅÆÇÈÉÊËÌÍÎÏÐÑÒÓÔÕÖ×ØÙÜÚÞß");
break;
//Converte uma string para maiúsculas
case "2":
$palavra = strtr(strtolower($term),"ÀÁÂÃÄÅÆÇÈÉÊËÌÍÎÏÐÑÒÓÔÕÖ×ØÙÜÚÞß","àáâãäåæçèéêëìíîïðñòóôõö÷øùüúþÿ");
break;
//Converte para maiúscula o primeiro caractere de uma string
case "3":
$palavra = strtr(ucfirst($term),"ÀÁÂÃÄÅÆÇÈÉÊËÌÍÎÏÐÑÒÓÔÕÖ×ØÙÜÚÞß","àáâãäåæçèéêëìíîïðñòóôõö÷øùüúþÿ");
break;
//Converte para maiúsculas o primeiro caractere de cada palavra
case "4":
$palavra = strtr(ucwords($term),"ÀÁÂÃÄÅÆÇÈÉÊËÌÍÎÏÐÑÒÓÔÕÖ×ØÙÜÚÞß","àáâãäåæçèéêëìíîïðñòóôõö÷øùüúþÿ");
break;
}
return $palavra;
}

function _auxiliar_cria_clicavel_URL($combinacoes) {
    $tratadoTexto = '';
    $url = $combinacoes[2];
    if ( empty($url) )
        return $combinacoes[0];
    if ( in_array(substr($url, -1), array('.', ',', ';', ':')) === true ) {
        $tratadoTexto = substr($url, -1);
        $url = substr($url, 0, strlen($url)-1);
    }
    return $combinacoes[1] . "<a href=\"$url\" class=\"email_url\" target=\"_blank\" rel=\"nofollow\">$url</a>" . $tratadoTexto;
}

function _auxiliar_cria_clicavel_FTP($combinacoes) {
    $tratadoTexto = '';
    $originalTexto = $combinacoes[2];
    $originalTexto = $originalTexto;

    if ( empty($originalTexto) )
        return $combinacoes[0];
    if ( in_array(substr($originalTexto, -1), array('.', ',', ';', ':')) === true ) {
        $tratadoTexto = substr($originalTexto, -1);
        $originalTexto = substr($originalTexto, 0, strlen($originalTexto)-1);
    }
    return $combinacoes[1] . "<a href=\"http://$originalTexto\" class=\"email_url\" target=\"_blank\" rel=\"nofollow\">$originalTexto</a>" . $tratadoTexto;
}
function _auxiliar_cria_clicavel_EMAIL($combinacoes) {
    $email = $combinacoes[2] . '@' . $combinacoes[3];
    return $combinacoes[1] . "<a href=\"mailto:$email\" class=\"email_url\">$email</a>";
}
function cria_clicavel($tratadoTexto) {
	
	$tratadoTexto = htmlspecialchars($tratadoTexto);
	$tratadoTexto = preg_replace("/=/", "=\"\"", $tratadoTexto);
	$tratadoTexto = preg_replace("/&quot;/", "&quot;\"", $tratadoTexto);
	$tags = "/&lt;(\/|)(\w*)(\ |)(\w*)([\\\=]*)(?|(\")\"&quot;\"|)(?|(.*)?&quot;(\")|)([\ ]?)(\/|)&gt;/i";
	$replacement = "<$1$2$3$4$5$6$7$8$9$10>";
	$tratadoTexto = preg_replace($tags, $replacement, $tratadoTexto);
	$tratadoTexto = preg_replace("/=\"\"/", "=", $tratadoTexto);
	$tratadoTexto = preg_replace("@<(a|img)[^>]*?>.*?@si", "", $tratadoTexto);
	
    $tratadoTexto = ' ' . $tratadoTexto;
    $tratadoTexto = preg_replace_callback('#([\s>])([\w]+?://[\w\\x80-\\xff\#$%&~/.\-;:=,?@\[\]+]*)#is', '_auxiliar_cria_clicavel_URL', $tratadoTexto);
    $tratadoTexto = preg_replace_callback('#([\s>])((www|ftp)\.[\w\\x80-\\xff\#$%&~/.\-;:=,?@\[\]+]*)#is', '_auxiliar_cria_clicavel_FTP', $tratadoTexto);
    $tratadoTexto = preg_replace_callback('#([\s>])([.0-9a-z_+-]+)@(([0-9a-z-]+\.)+[0-9a-z]{2,})#i', '_auxiliar_cria_clicavel_EMAIL', $tratadoTexto);

    $tratadoTexto = preg_replace("#(<a( [^>]+?>|>))<a [^>]+?>([^>]+?)</a></a>#i", "$1$3</a>", $tratadoTexto);
    $tratadoTexto = trim($tratadoTexto);
    return $tratadoTexto;
}

function limitiCaract($texto,$limite,$pontos=true,$quebra=true){
	$colPontos=($pontos==true)?"...":"";
	$tamanho = strlen($texto);
	if($tamanho<= $limite){
	$novo_texto = $texto;
	}else{
		if($quebra==true){
		$novo_texto = trim(substr($texto,0,$limite)).$colPontos;
		}else{
		$ultimo_espaco = strrpos(substr($texto,0,$limite), " ");
		$novo_texto = trim(substr($texto,0,$ultimo_espaco)).$colPontos;
		}	
	}
	return $novo_texto;
}

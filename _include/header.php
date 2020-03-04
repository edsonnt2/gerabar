<?php if(isset($_SESSION)==false){session_start(); }
/*
$htp = explode('.',$_SERVER['SERVER_NAME']);
if(!isset($_SERVER['HTTPS'])){
$linkServer = ($htp[0]=="www")?$htp[1].'.'.$htp[2].'.'.$htp[3]:$htp[0].'.'.$htp[1].'.'.$htp[2];
header('Location: https://'.$linkServer.$_SERVER['REQUEST_URI']);
exit();
}
if($htp[0]=="www"){
header('Location: https://'.$htp[1].'.'.$htp[2].'.'.$htp[3].$_SERVER['REQUEST_URI']);
exit();
}
*/
include('_classes/DB.class.php');
include('_classes/Login.class.php');
$pegarPg= explode("/",str_replace(strrchr(strtolower($_SERVER["REQUEST_URI"]), "?"), "", strtolower($_SERVER["REQUEST_URI"])));
$pgAtua = explode(".",end($pegarPg));
$pgAtua = reset($pgAtua);

function getUrl(){
return 'http://localhost/myforadmin/';
}

$objLogin=new Login;
if(!$objLogin->logado()){
	if($pgAtua=="" OR $pgAtua=="index"){
	if(!isset($_GET['inicio'])){
	header('Location:'.getUrl().'?inicio=true');
	}else{
	$indexTrue=true;
	include('pg_inicial.php');
	}
	exit();
	}else{
	header('Location:'.getUrl());
	exit();
	}
}

include('_classes/Empresas.class.php');
include('_classes/formata_texto.php');
$idDaSessao = $_SESSION['Gerabar_uid'];
$logado = $_SESSION['Gerabar_logado'];
$table = $_SESSION['Gerabar_table'];
$planoAtivo=$_SESSION['Gerabar_plano'];
$dados = $objLogin->getDados($idDaSessao,$table);
extract($dados,EXTR_PREFIX_ALL,'user');

function img_empresa($imag){
	return ($imag<>'' AND file_exists('_uploads/_negocios/'.$imag)) ? $imag : 'sem-imagem.jpg';
}

if(isset($_SESSION['Gerabar_Ocodigo'])){
	$codigoDoOperador=$_SESSION['Gerabar_Ocodigo'];
}
$identificar=(isset($user_identificar))?$user_identificar:0;

if($table=="usuarios"){
	$codStatus = $user_codStatus;
    $liberarPg=(isset($user_pgs_amb))?explode(',',$user_pgs_amb):array(1);
}else{
	$codStatus = 1;	
	if(isset($user_pgs_amb)){
	$liberarPg=explode(',',$user_pgs_amb);
	}else{
	$objLogin->sair();
	header('Location:'.getUrl().'?inicio=true');
	exit();
	}
}

if(isset($_GET['sair']) AND $_GET['sair']=='logOut'){
	$objLogin->sair();
	header('Location:'.getUrl().'?inicio=true');
	exit();
}
if(($pgAtua!="" && $pgAtua!="index") && ($codStatus==0 || ($identificar==1 && !isset($codigoDoOperador)))){ header('Location:'.getUrl());exit();}

if($table=="ambientes"){
    include('_classes/Cadastros.class.php');
    if(Cadastros::plano_cadastro_ativo($planoAtivo,$user_id_empresa,"ambientes",3)==false){ 
    $limiteAmbiente=true;
    }
}

if($pgAtua=="cadastros"){
if((!in_array(1,$liberarPg) AND !in_array("cadastros",$liberarPg)) || isset($limiteAmbiente)){ header('Location:'.getUrl());exit();}
$title = 'Cadastros';
}elseif($pgAtua=="configuracoes"){
if($table!="usuarios"){ header('Location:'.getUrl());exit();}
$title = 'Configurações';
}elseif($pgAtua=="administracao"){
if((!in_array(1,$liberarPg) AND !in_array("administracao",$liberarPg)) || isset($limiteAmbiente)){ header('Location:'.getUrl());exit();}
$title = 'Administração';
}elseif($pgAtua=="estoque"){
if((!in_array(1,$liberarPg) AND !in_array("estoque",$liberarPg)) || isset($limiteAmbiente)){ header('Location:'.getUrl());exit();}
$title = 'Estoque';
}elseif($pgAtua=="clientes"){
if((!in_array(1,$liberarPg) AND !in_array("clientes",$liberarPg)) || isset($limiteAmbiente)){ header('Location:'.getUrl());exit();}	
$title = 'Clientes';
}elseif($pgAtua=="caixa"){
if((!in_array(1,$liberarPg) AND !in_array("abrir_caixa",$liberarPg)) || isset($limiteAmbiente)){ header('Location:'.getUrl());exit();}
$title = 'Opções de caixa';
}elseif($pgAtua=="comanda-bar"){
if((!in_array(1,$liberarPg) AND !in_array("comanda_bar",$liberarPg)) || isset($limiteAmbiente)){ header('Location:'.getUrl());exit();}
$title = 'Controle de comanda';
}elseif($pgAtua=="contas-clientes"){
if((!in_array(1,$liberarPg) AND !in_array("contas_clientes",$liberarPg)) || isset($limiteAmbiente)){ header('Location:'.getUrl());exit();}
$title = 'Conta de clientes';
}elseif($pgAtua=="" OR $pgAtua=="index"){
$title = 'Gerabar';
if($codStatus==0){	
	if(isset($_GET['passos'])){
		if((int)$_GET['passos']<=3){
		$qualPasso = (int)$_GET['passos'];
		}else{
		$qualPasso = "1";
		}
	}else{
	$qualPasso = "1";
	}	
	if($qualPasso==2 || $qualPasso==3){	
		if($qualPasso==2){
		if(Empresas::statusEmpresa($idDaSessao,2)>0){
		header('Location:'.getUrl().'?passos=3');
		exit();
		}
		}else{
		if(Empresas::statusEmpresa($idDaSessao,1)>0){
		header('Location:'.getUrl().'?passos=2');
		exit();
		}
		}
		$idEmpresa = Empresas::selectEmpresa($idDaSessao);
		if($idEmpresa['num']==0){
			header('Location:'.getUrl().'?passos=1');
			exit();
		}
	}else{
		if(Empresas::statusEmpresa($idDaSessao,1)>0){
		header('Location:'.getUrl().'?passos=2');
		exit();
		}elseif(Empresas::statusEmpresa($idDaSessao,2)>0){
		header('Location:'.getUrl().'?passos=3');
		exit();
		}
	}
}
}else{
$title = 'Gerabar';
}
$imgEmpresa = Empresas::selectImgEmpresa($user_id_empresa);
$imgEmpre = ($imgEmpresa['num']>0)?$imgEmpresa['dados']['nome_img_1']:'';
$tInicio=(in_array(1,$liberarPg))?'Administração':'Início';

$selEmpresa = Empresas::selectEmpresa(0,$user_id_empresa);
if($selEmpresa['num']>0){
$nomeEmpresa=limitiCaract($selEmpresa['dados'][2],18,false,false);
$sangria=$selEmpresa['dados'][18];
}else{
$nomeEmpresa='NOVA EMPRESA';
$sangria=0;
}


?>
<!DOCTYPE HTML>
<html lang="pt-br">
<head>
<meta charset="utf-8" />
<meta name="description" content="Gerabar é um sistema de gerenciamento online para comércios com sistema de controle de comandas, mesas, contas de clientes e estoque. Cadastre-se e deixe o Gerabar fazer parte do seu dia a dia." /><!-- Colocar frase sobre o conteúdo do site -->
<meta name="keywords" content="geranciador, plataforma, sistema, gestao, comercio, bar, bares, balada, lanchonete, restaurante, loja, mercearia, store, loja, bebida, comida, barato, bom preço, comprar, vender, organiza, empresa, estoque, mesas, comandas, controle, clientes." /><!-- Colocar palavras-chave -->
<meta name="msvalidate.01" content="163D0FA0332110EB33CBFF592E0893A1" />
<meta name="rating" content="general" />
<meta name="robots" content="NOODP" />
<meta name="googlebot" content="NOODP, nofollow" />
<meta name="revisit-after" content="7 days" />
<meta name="mssmarttagspreventparsing" content="true" />
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" />
<link rel="shortcut icon" type="image/ico" href="<?php echo getUrl(); ?>_img/favicon.png" />
<link type="text/css" rel="stylesheet" href="<?php echo getUrl(); ?>_css/style.css" />
<link type="text/css" rel="stylesheet" href="<?php echo getUrl(); ?>_css/style-bares.css" />
<link type="text/css" rel="stylesheet" href="<?php echo getUrl(); ?>_css/style-respansive.css" />
<script type="text/javascript" src="<?php echo getUrl(); ?>_js/jquery.js"></script>
<?php if($pgAtua=="administracao" || $pgAtua=="contas-clientes"){ ?>
<link type="text/css" rel="stylesheet" href="<?php echo getUrl(); ?>_css/jquery-ui.css" />
<script type="text/javascript" src="<?php echo getUrl(); ?>_js/jquery-ui.min.js"></script>
<?php } ?>
<script type="text/javascript" src="<?php echo getUrl(); ?>_js/maskinput.js"></script>
<script type="text/javascript" src="<?php echo getUrl(); ?>_js/price_format.js"></script>
<script type="text/javascript" src="<?php echo getUrl(); ?>_js/java-main.js"></script>
<?php if($table=="usuarios" || in_array("cadastros",$liberarPg) || in_array("estoque",$liberarPg)){ ?>
<script type="text/javascript" src="<?php echo getUrl(); ?>_js/java-admin.js"></script>
<script type="text/javascript" src="<?php echo getUrl(); ?>_js/ajaxupload.3.5.js"></script>
<?php } ?>
<script type="text/javascript" src="<?php echo getUrl(); ?>_js/java-bares.js"></script>
<title><?php echo $title; ?></title>
</head>
<body <?php if(isset($_GET['fecharcomanda']) || isset($_GET['idMesa'])){ ?>onLoad="getValorComanda();" <?php } ?>>
<div id="carregador"><div id="dentroCarrega">Carregando...</div></div>
<div id="dentroOk" class="dentroRespansivo"></div>
<div id="confirm">
	<div id="confirm-dentro">
    	<div id="confirm-topo"><span>CONFIRMAÇÃO</span></div><!--confirm-centro-->
        <div id="confirm-cima"><p class="p_confDentro"></p></div><!--confirm-cima-->
        <div id="confirm-baixo">
            <span id="spannao"><a href="javascript:void(0);">NÃO</a></span>
            <span id="spansim"><a href="javascript:void(0);">SIM</a></span>
        </div><!--confirm-baixo-->
    </div><!--confirm-dentro-->
</div><!--confirm-->
<div id="alert">
	<div id="alert-dentro">
    	<div id="alert-topo"><span>AVISO</span></div><!--confirm-centro-->
        <div id="alert-cima"><p></p></div><!--alert-cima-->
        <div id="alert-baixo">
            <span id="spanalert"><a href="javascript:void(0);">OK</a></span>
        </div><!--alert-baixo-->
    </div><!--alert-dentro-->
</div><!--alert-->
<div id="fundo_branco"></div><!--fecha #fundo_branco-->
<div id="fundo_preto"></div><!-- fecha #fundo_preto-->
<div id="fundo_tour"></div><!-- fecha #fundo_preto-->    
<span id="qualPaginaAtivo"><?php echo $pgAtua; ?></span>
<div id="wrap"> 
<div id="main">
<?php if($codStatus==1){  echo '<div id="ajusta-fixed-top"></div>';} ?>
<div id="topo_mostra_inicio" <?php if($codStatus==1){ echo 'class="fixa_top"';} ?>>
	<?php if($codStatus==0){		
		 if($pgAtua=="" OR $pgAtua=="index"){ ?>
	<div class="faixa-topo1" style="margin-top:10px;"></div><!--#faixa-topo1-->    
	<div class="todo_site">
	<div class="acerta_barra"></div>
	<div class="cAlign">
        <div id="cont_empresa_h">
            <h1>Olá <?php echo $user_nome; ?>,</h1>
            <h2>bem-vindo ao Gerabar, o sistema que vai administrar o seu negócio.</h2>
        </div><!--cont_empresa_h-->
     </div><!--fecha cAlign-->
    </div><!-- fecha todo_site -->
    <?php } ?>
        <div class="faixa-topo1"></div><!--#faixa-topo1-->
        
        <div class="todo_site">
        <div class="acerta_barra"></div>
        <div class="cAlign">
        	
        	<?php 
				if($pgAtua=="" OR $pgAtua=="index"){ ?>
        
            <p class="for_p_primeiro">Para começar a usar você precisa completar os 3 passos.</p>
            
            <div id="div_passos">
            
            	<div class="separa_passos <?php if($qualPasso==2 || $qualPasso==3){ echo 'bt_respansivo';} ?>" id="separa_one">
                	<span id="passo_1" <?php if($qualPasso!=2 AND $qualPasso!=3){ echo 'class="passso_ativo"';} ?>></span>
                    <p>Preencha o formulário abaixo com os dados do seu negócio.</p>
                </div>
                <div class="separa_passos <?php if($qualPasso==1 || $qualPasso==3){ echo 'bt_respansivo';} ?>" id="separa_two">
                	<span id="passo_2" <?php if($qualPasso==2){ echo 'class="passso_ativo"';} ?>></span>
                    <p>Estamos quase acabando, falta apenas algumas configurações finais.</p>
                </div>
                <div class="separa_passos <?php if($qualPasso==1 || $qualPasso==2){ echo 'bt_respansivo';} ?>" id="separa_three">
                	<span id="passo_3" <?php if($qualPasso==3){ echo 'class="passso_ativo"';} ?>></span>
                    <p>Tudo pronto, estamos finalizando os primeiros passos.</p>
                </div>
            </div><!--fecha div passos-->
            
            <?php }else{ ?>
            	<p class="for_p_primeiro">Complete os <a href="<?php echo getUrl(); ?>?passos=1" title="Primeiros Passos">primeiros passos</a> para que possa usar o gerenciador completamente.</p>
            <?php } ?>
            
        </div><!--fecha cAlign-->
        </div><!-- fecha todo_site -->
        
        <?php }else{ ?> 
		
        <div class="todo_site">
        <div class="acerta_barra"></div>
        <div class="cAlign">
        
        <span id="logo_principal">
        	<a href="<?php echo getUrl(); ?>" title="Gerabar">
            	<img src="<?php echo getUrl(); ?>_img/gerabar_logo.png" class="img_logo_grande" />
                <img src="<?php echo getUrl(); ?>_img/gerabar_logo-2.png" class="img_logo_grande-2" />
            </a>
         </span><!--logo_principal-->        
        <?php 	if((in_array(1,$liberarPg) || in_array("abrir_caixa",$liberarPg) || in_array("comanda_bar",$liberarPg) || in_array("contas_clientes",$liberarPg)) AND ($identificar<>1 || isset($codigoDoOperador))  AND !isset($limiteAmbiente)){
			$varLiberarPg='';
			for($e=0; $e<count($liberarPg); $e++){
			$varLiberarPg.=$liberarPg[$e];
				if($e<(count($liberarPg)-1)){
				$varLiberarPg.=',';
				}
			}
		?>
        <div id="d_busca_tudo">
        	<input type="text" id="i_busca_txt_tudo" autocomplete="off" placeholder="Busque por produto ou cliente..." />
            <button type="button" title="Buscar" id="i_busca_envia_tudo"><!--Buscar--></button>
            <input type="hidden" id="liberarPg" value="<?php echo $varLiberarPg; ?>" />
            <ul id="busca_do_topo"></ul>            
        </div><!--d_busca_tudo-->
        <?php } ?>
        <ul id="menu_topo">
        	<li class="li_princ_menu"><a href="javascript:void(0);" id="a_abre_menu_topo"><span><?php echo $nomeEmpresa; ?></span></a>
                <ul>
                <?php if($codStatus<>0 AND ($identificar<>1 || isset($codigoDoOperador))){ 
				if($table=="usuarios"){?>
                <li><a href="<?php echo getUrl(); ?>configuracoes.php" title="Configurações" id="configura-gerabar"><span>CONFIGURAÇÕES</span></a></li>
                <?php }} 
                    //<li><a href="javascript:void(0);" title="Atalhos" id="atalhos-gerabar"><span>ATALHOS</span></a></li>
                    ?>
                <li><a href="<?php echo getUrl(); ?>ajuda.php" title="Ajuda" id="ajuda-gerabar"><span>AJUDA</span></a></li>
                <li><a href="<?php echo getUrl(); ?>?sair=logOut" class="sair_logOut" title="Sair" id="sair-gerabar"><span>SAIR</span></a></li>            
                </ul>
            </li>
        </ul><!--menu_topo-->
                
        </div><!--fecha cAlign-->
        </div><!-- fecha todo_site -->
		
		<?php } ?>
</div><!--fecha topo mostra inicio-->
<div class="todo_site">

<div class="acerta_barra"></div>

<div class="cAlign">

<ul id="barra_principal">
	<li id="logo"><a href="<?php echo getUrl(); ?>" title="Gerabar - <?php echo $tInicio; ?>">
    	<img src="<?php echo getUrl(); ?>_img/ico-gerabar.png" id="ico_gerabar" alt="Gerabar - <?php echo $tInicio; ?>" />
        <img src="<?php echo getUrl(); ?>_uploads/_negocios/<?php echo img_empresa($imgEmpre); ?>" id="logo_gerabar" alt="Gerabar - <?php echo $tInicio; ?>" />
        <h1>Gerabar Gerenciador</h1>
    </a></li>
    
    <?php 
	if($codStatus<>0 AND !isset($limiteAmbiente) AND ($identificar<>1 || isset($codigoDoOperador))){
        
    $arMenu=array(
        0=>array('frente_caixa','Frente de Caixa','index','frente_caixa'),
        1=>array('abrir_caixa','Opções de Caixa','caixa','caixa'),
        2=>array('comanda_bar','Comanda Bar','comanda-bar','sistema_bar'),
        3=>array('contas_clientes','Contas de Clientes','contas-clientes','conta_cliente'),
        4=>array('estoque','Estoque','estoque','estoque'),
        5=>array('clientes','Clientes','clientes','clientes'),
        6=>array('cadastros','Cadastros','cadastros','cadastros'),
        7=>array('administracao','Administração','administracao','admin')
    );

    for($e=0; count($arMenu)>$e;$e++){            
        if(in_array(1,$liberarPg) || in_array($arMenu[$e][0],$liberarPg)){ ?>
        <li<?php 
        if($arMenu[$e][0]=="frente_caixa"){
            if($pgAtua==$arMenu[$e][2] || $pgAtua==""){ echo ' class="li_ativo_princ"'; }
            $linkPg="";
            }else{
            if($pgAtua==$arMenu[$e][2]){ echo ' class="li_ativo_princ"'; }
            $linkPg=$arMenu[$e][2].'.php';
            }
        ?>>
        <?php
        echo '<a href="'.getUrl().$linkPg.'" id="li_'.$arMenu[$e][3].'" title="'.$arMenu[$e][1].'"><span class="span_fecha">&nbsp;</span><span class="span_abre">'.$arMenu[$e][1].'</span></a>';
        ?> </li> <?php 
        } 
    }
    if(in_array(1,$liberarPg) || in_array('frente_caixa',$liberarPg) || in_array('abrir_caixa',$liberarPg) || in_array('contas_clientes',$liberarPg)){
    include('_classes/AbrirFecharCaixa.class.php');
        
        if(isset($codigoDoOperador)){
        $funcionario=$codigoDoOperador;
        }elseif($table=="usuarios"){
            $funcionario="a";
        }else{
            $funcionario="isento";
        }
        
        if($sangria==1){        
        $selCxAberto=AbrirFecharCaixa::selAbrirCaixa($user_id_empresa,$funcionario);
        $numCxAberto=$selCxAberto['num'];
        if($numCxAberto==0){
            echo '<li><a href="javascript:void(0);" id="li_abrir_fecha_caixa" class="a_abrir_caixa" title="Abrir Caixa"><span class="span_fecha">&nbsp;</span><span class="span_abre">Abrir Caixa</span></a></li>';
        }else{
            echo '<li><a href="javascript:void(0);" id="li_abrir_fecha_caixa" class="a_fechar_caixa" title="Fechar Caixa"><span class="span_fecha">&nbsp;</span><span class="span_abre">Fechar Caixa</span></a></li>';
        }
        }else{
            $numCxAberto=1;
        }
    }
        
   }
   if($codStatus==0 AND ($identificar==1 || !isset($codigoDoOperador))){ ?>   
    <li><a href="<?php echo getUrl(); ?>?sair=logOut" id="li_sair" class="sair_logOut" title="Sair"><span class="span_fecha">&nbsp;</span><span class="span_abre">sair</span></a></li>
    <?php } ?>

</ul><!-- fecha barra principal-->
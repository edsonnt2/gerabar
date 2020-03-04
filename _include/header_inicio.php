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
$pegarPg= explode("/",str_replace(strrchr(strtolower($_SERVER["REQUEST_URI"]), "?"), "", strtolower($_SERVER["REQUEST_URI"])));
$pgAtua = explode(".",end($pegarPg));
$pgAtual = reset($pgAtua);
if(!isset($indexTrue)){
function getUrl(){	return 'http://localhost/myforadmin/';}
}
if($pgAtual=="planos" || $pgAtual=="contato" || $pgAtual=="ajuda" || $pgAtual=="quem_somos" || $pgAtual=="privacidade" || $pgAtual=="termos" || $pgAtual=="recuperar_senha" || $pgAtual=="verificar_email" || $pgAtual=="pg_inicial" || $pgAtual=="checkout"){
	include('_classes/DB.class.php');
	include('_classes/Login.class.php');
	$objLogin=new Login;
	if($objLogin->logado()){
        
		if($pgAtual=="pg_inicial"){
			header("Location:".getUrl());
			exit();
		}else{
			$recLogado=true;
		}        
        if($pgAtual=="checkout" || $pgAtual=="planos"){
            $idDaSessao = $_SESSION['Gerabar_uid'];
            $table = $_SESSION['Gerabar_table'];
            $dados = $objLogin->getDados($idDaSessao,$table);
            extract($dados,EXTR_PREFIX_ALL,'user');
        }        
	}else{
        if($pgAtual=="checkout"){
            header("Location:".getUrl());
			exit();
        }
    }
}

if($pgAtual=="contato"){
$title = 'Fale Conosco';
}elseif($pgAtual=="ajuda"){
$title = 'Precisa de Ajuda ?';
}elseif($pgAtual=="quem_somos"){
$title = 'Conheça o Gerabar';
}elseif($pgAtual=="privacidade"){
$title = 'Página de Privacidade';
}elseif($pgAtual=="termos"){
$title = 'Nossos Termos';
}elseif($pgAtual=="planos"){
$title = 'Nossos Planos';
}elseif($pgAtual=="checkout"){
$title = 'Checkout';    
if(isset($_SESSION['salvar_plano'])){
$planoContrata=$_SESSION['salvar_plano'];
}else{
    header("Location:".getUrl());
    exit();
}
    
}elseif($pgAtual=="recuperar_senha"){
$title = 'Recuperação de Senha';
}elseif($pgAtual=="pg_inicial"){
$title = 'Gerabar - Gerenciador online para comércios completo, rápido e seguro';
}else{
$title = 'Gerabar - Gerenciador online para comércios completo, rápido e seguro';
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
<link type="text/css" rel="stylesheet" href="<?php echo getUrl(); ?>_css/inicio.css" />
<script type="text/javascript" src="<?php echo getUrl(); ?>_js/jquery.js"></script>
<script type="text/javascript" src="<?php echo getUrl(); ?>_js/java-inicio.js"></script>
<?php if($pgAtual=="checkout"){ ?>
<script type="text/javascript" src="<?php echo getUrl(); ?>_js/maskinput.js"></script>
<script type="text/javascript">
    $(function(){        
        $("#pcd_cep").mask("99999-999");
        $('.f_cpf').mask("999.999.999-99");
        $(".f_tel").mask("(99) 9999-9999?9");
    });
</script>
<?php } ?>
<title><?php echo $title; ?></title>
</head>
<body>
<div id="fundoRecupera"></div><!--fundoRecupera-->    
<div id="carregador"><div id="dentroCarrega">Carregando...</div></div>
<div id="dentroOk"></div>
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
<div id="wrap"> 
<div id="main">
<div id="topo">
<div id="faixa-topo1"></div><!--#faixa-topo1-->
<div class="cAlign" id="cont-loga-tudo">    
	<div id="logo"><a href="<?php echo getUrl(); ?><?php if(isset($recLogado)==false){ echo '?inicio=true'; } ?>" title="Gerabar"><img src="<?php echo getUrl(); ?>_img/gerabar.png" title="Gerabar" alt="Gerabar" /></a></div><!--#logo-->
    <?php if($pgAtual<>"erro_404" && isset($recLogado)==false){ ?>    
    <span id="s_loga_resp"><a href="javascript:void(0);">Entrar</a></span>    
    <div id="campologa">
      <div id="ponta-login"></div>
      <form method="post" action="">
        <div id="logaleft">
        <label for="emailloga" class="logaLabel">Usuário:</label>        
        <div class="bordaInput">
            <div class="bordaInput1">
            <input placeholder="Coloque o nome de usuário..." tabindex="1" id="emailloga" type="text" />
            <div class="d_aviso_erro" id="erro_emailloga" style="margin-top:28px;"><div class="d_ponta-erro"></div><p></p></div><!--d_aviso_erro-->
            </div><!--bordaInput1-->
        </div><!--bordaInput-->        
        <label id="labelConecta">
        <input id="conectado" type="checkbox" checked="checked" /> <span>Mantenha-me conectado</span>
        </label>        
        </div><!--logaleft-->        
        <div id="logacenter">
        <label for="senhaloga" class="logaLabel">Senha:</label>        
        <div class="bordaInput">
            <div class="bordaInput1">
            <input placeholder="Coloque sua senha..." onKeyUp="return SemEspaco(this);" tabindex="2" id="senhaloga" type="password" />
            <div class="d_aviso_erro" id="erro_senhaloga" style="margin-top:28px;"><div class="d_ponta-erro"></div><p></p></div><!--d_aviso_erro-->
            </div><!--bordaInput-->
        </div><!--bordaInput-->
        <a href="javascript:void(0);" id="a_rememberKey">esqueceu sua senha ?</a>
        </div><!--logarcenter-->        
        <div id="logaright">        
      	<div class="bordaInput">            
            <div class="bordaInput1">
            <button type="submit" tabindex="3" id="entraloga">ENTRAR</button>
            <span id="fechaLoga"><a href="javascript:void(0);">CANCELAR</a></span>
            </div><!--bordaInput1-->
        </div><!--bordaInput-->
        </div><!--logaright-->
      </form>
    </div><!--#campologa-->
    <?php }else{
    echo '<ul id="ul_topo_sair">
        <li><a href="'.getUrl().'">INÍCIO</a></li>
        <li><a href="javascript:void(0);" class="sair_logOut">SAIR</a></li>
        </ul>';
} ?>
</div><!--.cAlign-->
<div id="faixa-topo2"></div><!--#faixa-topo2-->
<?php if(isset($_POST['voltaInclui'])){ if(isset($_SESSION)==false){session_start(); }
	include('../_classes/DB.class.php');
	function getUrl(){ return 'http://localhost/myforadmin/';}
		if(!isset($_SESSION['Gerabar_uid']) || is_null($_SESSION['Gerabar_uid']) || empty($_SESSION['Gerabar_uid'])){
		include('../_classes/Login.class.php');
		$objLogin=new Login;
			if(!$objLogin->logado()){
			?>
			<script type="text/javascript">
            	$(function(){ red:window.location.href="<?php echo getUrl(); ?>"; });
            </script>
			<?php
			exit();
			}
		}
	$idDaSessao = $_SESSION['Gerabar_uid'];
	$table = $_SESSION['Gerabar_table'];
	include('../_classes/Cadastros.class.php');
	include('../_classes/formata_texto.php');
	$idEmp = Cadastros::selectIdEmpresa($idDaSessao,$table);
	$user_id_empresa = $idEmp['dados'][0];
    if($table!="ambientes"){
	$dadosUser=Cadastros::selDadosUsuario($idDaSessao);
    $user_nome=$dadosUser['dados']['nome'];
    $user_sobrenome=$dadosUser['dados']['sobrenome'];
    }
    $rel=$_POST['voltaInclui'];
    $acre="../";
    
    include('../_classes/Empresas.class.php');
    $selEmpresa = Empresas::selectEmpresa(0,$user_id_empresa);
    $sangria=($selEmpresa['num']>0)?$selEmpresa['dados'][18]:0;
	}else{
        if(!isset($table) || $table!="ambientes"){
         include('_classes/Cadastros.class.php');
        }
    $rel=(isset($_GET['relatorio']))?$_GET['relatorio']:'';
    $acre="";
    }
?>

<div id="index_cima" style=" border-bottom:0;">
        <h2>
        <?php echo ($table!="ambientes")?'Olá '.$user_nome.' '.$user_sobrenome.' !':'&nbsp;'; ?>
        </h2>
    <span>Você está na página de administração.</span>
	</div>
    
    <div id="cont_admin">
        
            <?php if($sangria==1){ ?>
            <div class="d_menu_relatorio"><a href="<?php echo getUrl(); ?>administracao.php?relatorio=caixa-aberto-fechado" <?php if($rel=="caixa-aberto-fechado"){ echo 'class="menu_relAberto"';} ?>><span class="caixa-aberto-fechado">Caixas abertos e Fechados</span></a></div>
            <div class="d_tudo_relatorio" id="rel_caixa-aberto-fechado">
            <?php
			if($rel=="caixa-aberto-fechado"){
			include($acre.'_include/relatorio_caixa-aberto-fechado.php'); 
			}
			?>
            </div><!--d_tudo_relatorio-->
            <?php } ?>
    		
            <div class="d_menu_relatorio"><a href="<?php echo getUrl(); ?>administracao.php?relatorio=frente-caixa" <?php if($rel=="frente-caixa"){ echo 'class="menu_relAberto"';} ?>><span class="frente-caixa">Relatório de Frente de Caixa</span></a></div>            
            <div class="d_tudo_relatorio" id="rel_frente-caixa">
            <?php
			if($rel=="frente-caixa"){		
			include($acre.'_include/relatorio_frente-caixa.php'); 
			}
			?>
            </div><!--d_tudo_relatorio-->
        
        	<div class="d_menu_relatorio"><a href="<?php echo getUrl(); ?>administracao.php?relatorio=comandas" <?php if($rel=="comandas"){ echo 'class="menu_relAberto"';} ?>><span class="comandas">Relatório de Comandas</span></a></div>            
            <div class="d_tudo_relatorio" id="rel_comandas">
            <?php
			if($rel=="comandas"){		
			include($acre.'_include/relatorio_comandas.php'); 
			}
			?>
            </div><!--d_tudo_relatorio-->
            
            <div class="d_menu_relatorio"><a href="<?php echo getUrl(); ?>administracao.php?relatorio=mesas" <?php if($rel=="mesas"){ echo 'class="menu_relAberto"';} ?>><span class="mesas">Relatório de Mesas</span></a></div>
            <div class="d_tudo_relatorio" id="rel_mesas">
            <?php
			if($rel=="mesas"){			
			include($acre.'_include/relatorio_mesas.php'); 
			}
			?>
            </div><!--d_tudo_relatorio-->
            
            <div class="d_menu_relatorio"><a href="<?php echo getUrl(); ?>administracao.php?relatorio=contas" <?php if($rel=="contas"){ echo 'class="menu_relAberto"';} ?>><span class="contas">Relatório de Contas de Clientes</span></a></div>            
            <div class="d_tudo_relatorio" id="rel_contas">
            <?php
			if($rel=="contas"){
			include($acre.'_include/relatorio_contas.php'); 
			}
			?>
            </div><!--d_tudo_relatorio-->
        
        <div class="d_tudo_relatorio_baixo">
        <div class="admin_left">
        <div id="ad_cmd_produtos" class="div_form_admin">
        <a href="estoque.php" title="Produtos Cadastrados">
        	<h1>PRODUTOS CADASTRADOS</h1>
            <p class="ad_p1"><?php echo Cadastros::countArray($user_id_empresa,'produtos'); ?></p>
        </a>
        </div><!--ad_cmd_produtos-->
        </div><!--admin_left-->
        <div class="admin_right">
        <div id="ad_cmd_clientes" class="div_form_admin">
        <a href="clientes.php" title="Clientes Cadastrados">
        	<h1>CLIENTES CADASTRADOS</h1>
            <p class="ad_p1"><?php echo Cadastros::countArray($user_id_empresa,'clientes'); ?></p>
        </a>
        </div><!--ad_cmd_clientes-->
        </div><!--admin_right-->
        </div><!--d_tudo_relatorio-->
        
    </div><!--cont_admin-->
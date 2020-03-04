<?php if(isset($_POST['inclui'])){ if(isset($_SESSION)==false){session_start();}
	include('../_classes/DB.class.php');
	include('../_classes/Login.class.php');
	function getUrl(){ return 'http://localhost/myforadmin/';}
	//include('../_classes/Cadastros.class.php');
	$objLogin=new Login;
	if(!$objLogin->logado()){
	?>
			<script type="text/javascript">
            	$(function(){ red:window.location.href="<?php echo getUrl(); ?>"; });
            </script>
			<?php
	exit();
	}
	$idDaSessao = $_SESSION['Gerabar_uid'];
	$table = $_SESSION['Gerabar_table'];	
	$dados = $objLogin->getDados($idDaSessao,$table);
	extract($dados,EXTR_PREFIX_ALL,'user');	
	}
?>
<script type="text/javascript">
$(function(){$("#usuario_nascimento").mask("99/99/9999");});
</script>
<div id="cont_dados_empresa">
<h1 id="h1TopoUsuario">MEUS DADOS DE USÚARIO</h1>
<form method="post" action="">    
<div class="linha_empresa">
    <div class="alinha_empresa">
        <span><label for="usuario_nome">nome:</label></span>
        <input type="text" id="usuario_nome" value="<?php echo $user_nome; ?>" />
        <div class="d_aviso_erro" id="erro_usuario_nome"><div class="d_ponta-erro"></div><p></p></div><!--d_aviso_erro-->
    </div>
    
    <div class="alinha_empresa">
        <span><label for="usuario_sobrenome">sobrenome:</label></span>
        <input type="text" id="usuario_sobrenome" value="<?php echo $user_sobrenome; ?>" />
        <div class="d_aviso_erro" id="erro_usuario_sobrenome"><div class="d_ponta-erro"></div><p></p></div><!--d_aviso_erro-->
    </div>
    
    <div class="alinha_empresa">
        <span><label for="usuario_nascimento">data nascimento:</label></span>
        <input type="text" id="usuario_nascimento" value="<?php echo date('d/m/Y',strtotime($user_nascimento)); ?>" placeholder="XX/XX/XXXX" />
        <div class="d_aviso_erro" id="erro_usuario_nascimento"><div class="d_ponta-erro"></div><p></p></div><!--d_aviso_erro-->
    </div>

</div><!--fecha linha empresa-->

<div class="linha_empresa">

	<div class="alinha_empresa">
        <span><label for="usuario_sexo">sexo:</label></span>        
        <select id="usuario_sexo">
        	<option value="">selecione</option>
            <option value="M"<?php if($user_sexo=="M"){ echo ' selected="selected"';} ?> >HOMEM</option>
            <option value="F"<?php if($user_sexo=="F"){ echo ' selected="selected"';} ?> >MULHER</option>
        </select>
        <div class="d_aviso_erro" id="erro_usuario_sexo"><div class="d_ponta-erro"></div><p></p></div><!--d_aviso_erro-->
    </div>
    
    <div class="alinha_empresa">
        <span><label for="usuario_nomeUser">nome usuário:</label></span>
        <input type="text" id="usuario_nomeUser" value="<?php echo $user_nome_usuario; ?>" />
        <div class="d_aviso_erro" id="erro_usuario_nomeUser"><div class="d_ponta-erro"></div><p></p></div><!--d_aviso_erro-->
    </div>
    
    <div class="alinha_empresa">
        <span><label for="usuario_email">e-mail:</label></span>
        <input type="text" id="usuario_email" value="<?php echo $user_email; ?>" placeholder="EX: NOME@MAIL.COM" />
        <div class="d_aviso_erro" id="erro_usuario_email"><div class="d_ponta-erro"></div><p></p></div><!--d_aviso_erro-->
    </div>
</div><!--fecha linha empresa-->

<div class="linha_empresa">
    <div class="alinha_empresa">
    	<button type="submit" id="atualizar_usuario" >atualizar dados</button>
    </div>
</div><!--fecha linha empresa-->

</form>

<div id="ad_cmd_senhaAcesso"><a href="javascript:void(0);" class="alt_senha_admim">ALTERAR SENHA DE ACESSO</a></div><!--ad_cmd_senhaAcesso-->
<div id="ad_cmd_senhaMaster"><a href="javascript:void(0);" class="alt_senha_admim">ALTERAR SENHA MASTER</a></div><!--ad_cmd_senhaMaster-->

</div><!--fecha cont_dados_empresa-->
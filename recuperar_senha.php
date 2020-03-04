<?php include('_include/header_inicio.php'); ?>
<div class="cAlign">
<div id="form-H" style="float:left;">
<h1 style="margin-left:20px;">Recuperar Senha</h1>
</div>
</div><!--.cAlign-->
</div><!--#topo-->

<div class="cAlign">
    
    	<div id="cont-recupera" class="contRecupera">
			<?php if((isset($_GET['utilizador']) AND $_GET['utilizador']<>'') AND (isset($_GET['confirmacao']) AND $_GET['confirmacao']<>'')){ 
            include('_classes/Recuperar.class.php');
            $verifChave = Recuperar::dadosRecupera(strip_tags($_GET['utilizador']),strip_tags($_GET['confirmacao']));
            if($verifChave['num']==1){
            $nomePessoa = Recuperar::dadosEmail(strip_tags($_GET['utilizador']));
            ?>
            <div class="cont-nome-recupera">Redefinição de senha</div>
            
            <div class="cont-cont-recupera">
            <p class="textRec"><span style="font-size:13px">Olá <?php echo $nomePessoa['dados']['nome'].' '.$nomePessoa['dados']['sobrenome']; ?></span>, para redefinir sua senha preencha os campos abaixo:</p>
            <form method="post" action="">
            <div><label for="novasenha">Nova Senha:</label></div>
            <div style="overflow:hidden; margin-bottom:10px;"><input type="password" id="novasenha" onKeyUp="return SemEspaco(this);" />                
             <div class="d_aviso_erro" id="erro_novasenha" style="margin:38px 0 0 0;"><div class="d_ponta-erro"></div><p></p></div><!--d_aviso_erro-->   
                
             </div>
             <div><label for="repnovasenha">Repita a Senha:</label></div>
             <div style="overflow:hidden;"><input type="password" id="repnovasenha" onKeyUp="return SemEspaco(this);" />
             <div class="d_aviso_erro" id="erro_repnovasenha" style="margin:38px 0 0 0;"><div class="d_ponta-erro"></div><p></p></div><!--d_aviso_erro-->
             <input type="hidden" id="email-altera" value="<?php echo $_GET['utilizador']; ?>"  />
             <input type="hidden" id="confirma-conta" value="<?php echo $_GET['confirmacao']; ?>"  />
             </div>
             
             <div style="overflow:hidden;"><button type="submit"id="recupera-senha">ENVIAR</button><a href="<?php echo getUrl(); ?>" id="cancel-recup">CANCELAR</a><span class="carre-recu" style="margin-top:9px;"></span></div>
            
            </form>
            </div>
            <?php 
            }else{
            echo '<div class="cont-nome-recupera">Redefinição de senha</div>
            <div class="cont-cont-recupera"><p class="textRec" style="font-size:14px;">A chave de confirmação para a redefinição de senha expirou ou está incorreta, por favor, <a href="'.getUrl().'recuperar_senha.php">clique aqui</a> para enviar outro e-mail para redefinir sua senha.</p></div>';            
            }            
            }else{ ?>            
            
            <div class="cont-nome-recupera">Enviar e-mail para a recupeção da senha</div>
            
            <div class="cont-cont-recupera">
            
            
                <p class="textRec">Enviaremos um link para recuperar sua senha no e-mail que você informar abaixo, <br />sendo que seu e-mail esteja cadastro em nosso sistema.</p>
             <form method="post" action="">
                <div style="overflow:hidden;"><input type="text" id="email-recu" class="recemail" placeholder="seuemail@mail.com" />
                <div class="d_aviso_erro" id="erro_email-recu" style="margin:38px 0 0 0;"><div class="d_ponta-erro"></div><p></p></div><!--d_aviso_erro-->
                
                </div>
                <div style="overflow:hidden;"><button type="submit" class="enviarRecu" id="envia-recu">ENVIAR</button><a href="<?php echo getUrl(); ?>" id="cancel-recup">CANCELAR</a><span class="carre-recu" style="margin-top:9px;"></span></div>
            
            </form>
            
            </div>
            <?php } ?>
            
        </div><!--cont-recupera-->

</div><!--.cAling-->
<?php include('_include/footer_inicio.php'); ?>
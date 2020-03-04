<?php include('_include/header_inicio.php'); ?>
<div class="cAlign">
<div id="form-H">
<h1>Cadastre-se !</h1>
<h2>O sistema de gestão simples para o seu negócio.</h2>
</div>
</div><!--.cAlign-->
</div><!--#topo-->
<div class="cAlign">
<div id="img-ref1">
	<img src="<?php echo getUrl(); ?>_img/gerabar_home.png" alt="imagem referencia" />
</div>
<div id="contforminicial">        
    <form method="post" action="">    
    <div class="contcadinicial" style="border-top:0;">    
        <div class="forleftcad">
        <label for="nomecad">Nome Completo:</label>
        </div><!--forleftcad-->
        <input type="text" placeholder="Seu nome completo aqui..." id="nomecad" class="txtInput" />
        <div class="d_aviso_erro" id="erro_nomecad" style="margin-top:36px; margin-left:170px;"><div class="d_ponta-erro"></div><p></p></div><!--d_aviso_erro-->
    </div><!--contcadinicial-->    
    <div class="contcadinicial">        
        <div class="forleftcad">
        <label for="nomeUsuariocad">Nome de usuário:</label>
        </div><!--forleftcad-->
        <input type="text" placeholder="Seu nome de usuário..." onKeyUp="return SemEspaco(this);" maxlength="30" id="nomeUsuariocad" class="txtInput" />
    	<div class="d_aviso_erro" id="erro_nomeUsuariocad" style="margin-top:36px; margin-left:170px;"><div class="d_ponta-erro"></div><p></p></div><!--d_aviso_erro-->
    </div><!--contcadinicial-->    
    <div class="contcadinicial">        
        <div class="forleftcad">
        <label for="emailcad">E-mail:</label>
        </div><!--forleftcad-->
        <input type="text" placeholder="Seu e-mail aqui..." id="emailcad" class="txtInput" />
    	<div class="d_aviso_erro" id="erro_emailcad" style="margin-top:36px; margin-left:170px;"><div class="d_ponta-erro"></div><p></p></div><!--d_aviso_erro-->
    </div><!--contcadinicial-->        
    <div class="contcadinicial">        
        <div class="forleftcad">
        <label for="senhacad">Nova senha:</label>
        </div><!--forleftcad-->
        <div id="d_acertaSenha">
        <input type="password" placeholder="Seu nova senha aqui..." onKeyUp="return SemEspaco(this);" id="senhacad" class="txtInput" />
        <a href="javascript:void(0);" class="olho-amb" title="Mostrar Senha"><!--mostrar senha---></a>
        </div><!--d_acertaSenha-->
    	<div class="d_aviso_erro" id="erro_senhacad" style="margin-top:36px; margin-left:170px;"><div class="d_ponta-erro"></div><p></p></div><!--d_aviso_erro-->
    </div><!--contcadinicial-->    
    <div class="contcadinicial">    
        <div class="forleftcad">
        <span>Data de nascimento:</span>
        </div><!--forleftcad-->
        <select id="diacad">
            <option value="">Dia:</option>
            <?php
            for($d=1;$d<=31;$d++){
                if($d<10){$dia = '0'.$d;}else{$dia = $d;}
                echo '<option value="'.$d.'">'.$dia.'</option>';
            }
            ?>
        </select>        
        <select id="mescad">
            <option value="">Mês:</option>
            <?php
            $mes = array('','Janeiro','Fevereiro','Março','Abril','Maio','Junho','Julho','Agosto','Setembro','Outubro','Novembro','Dezembro');
            for($m=1;$m<=12;$m++){
            echo '<option value="'.$m.'">'.$mes[$m].'</option>';
            }
             ?>
        </select>        
        <select id="anocad">
            <option value="">Ano:</option>
            <?php
            for($ano=date('Y');$ano>=(date('Y')-100);$ano--){
            echo '<option value="'.$ano.'">'.$ano.'</option>';
            }
            ?>            
        </select>
    	<div class="d_aviso_erro" id="erro_diacad" style="margin-top:34px; margin-left:170px;"><div class="d_ponta-erro"></div><p></p></div><!--d_aviso_erro-->
    </div><!--contcadinicial-->    
    <div class="contsexocadinicial">    
    <div class="forleftcad">
    <span>Você é:</span>
    </div><!--forleftcad-->
    <div class="contrightsexo">
    <label><input type="radio" name="sexo" value="M" /><span>Homem</span></label>
    <span>ou</span>
    <label><input type="radio" name="sexo" value="F" /><span>Mulher</span></label>            
    </div><!--contrightsexo-->
    <div class="d_aviso_erro" id="erro_radio" style="margin-top:24px; margin-left:170px;"><div class="d_ponta-erro"></div><p></p></div><!--d_aviso_erro-->
    </div><!--contsexocadinicial-->    
    <div class="contsexocadinicial">    
    <div class="forTermos">
    <label>
    <input type="checkbox" id="i_termos" />
    <span>Eu concordo com os <a href="<?php echo getUrl(); ?>termos.php" target="_blank">Termos</a> e <a href="privacidade.php" target="_blank">Privacidade</a> do Gerabar.</span>
    </label>
    </div><!--forTermos-->
    <div class="d_aviso_erro" id="erro_i_termos" style="margin-top:10px; margin-left:30px;"><div class="d_ponta-erro" style="margin-left: 80px;"></div><p></p></div><!--d_aviso_erro-->
    </div><!--contsexocadinicial-->    
    <div class="contsexocadinicial" style="border:0;">    
    <button type="submit" class="envia_cadastro" id="cadastroinicial">Inscreva-se</button>
    </div><!--contsexocadinicial-->    
    </form>
</div><!--contforminicial-->
</div><!--.cAling-->
<div class="txt_inicio">
	<div class="cAlign">        
    <div class="d_txt_center" style="margin-bottom: 40px;">
        <h1>Conheça os planos que temos para o seu négocio</h1>
	</div>
    <span id="s_ver_planos">
        <a href="<?php echo getUrl(); ?>planos.php">VEJA NOSSOS PLANOS</a>
    </span>
	<div class="d_txt_center">
        <h1>Você tem um bar, lanchonete ou qualquer outro tipo de comércio ?</h1>
        <p>Então você precisa conhecer o sistema Gerabar.</p>	
	</div>
    <div class="d_txt_left">
		<img src="<?php echo getUrl(); ?>_img/caderno-inicio.png" alt="Caderno Gerabar" />
    </div>
    <div class="d_txt_right">
    <p>Sabe aquela anotação diária que você tem que fazer no caderno e ter que somar tudo quando o cliente quer fazer o pagamento, então, pensando nisso que o Gerabar criou o <strong>controle de contas de clientes</strong>. Agora deixe que cuidaremos dessa tarefa e você só tem que se preocupar em receber.</p>    
    </div>
    </div><!--.cAling-->
</div><!--txt_inicio-->
	<div class="cAlign">
    <div class="d_txt_center" style="margin-bottom:60px;">
        <h1 class="border_h1">O Gerabar conta também com muitas outras funções, como:</h1>        
        <div class="d_contro_center">
            <h2>Frente de Caixa</h2>
            <p>Tenha controle sobre todas as suas vendas passando seus produtos pela nossa frente de caixa.</p>
            <h2>Controle de Comada</h2>
            <p>Abra uma comanda individual por cliente com ou sem valor de entrada, e marque o que seu cliente for consumindo.</p>
            <h2>Controle de Mesa</h2>
            <p>Cadastre quantas mesas quiser, e controle por mesa o que for vendido.</p>
            <h2>Controle de Estoque</h2>
            <p>Cadastre os produtos com os quais trabalha, e deixe o resto por nossa conta.</p>
            <h2>Controle de Clientes</h2>
            <p>Cadastre seus clientes e tenha um contro melhor sobre negócio.</p>
            <h2>Controle de Contas de Clientes</h2>
            <p>Caso você venda mensalmente para seus clientes ("fiado"), use essa função para marcar o que seu cliente pegua e feche a conta assim que ele pagar.</p>
            <h2>Produtos Avulsos</h2>
            <p>Caso o produto que vai vender ainda não esteja no sistema, não tem problema, pois temos a opção de produto avulso para não perde sua venda.</p><h2>Controle de Ambiente</h2>
            <p>Cadastre ambientes deferentes para cada parte do seu negócio, como bar ou caixa, e tenha controle de onde seus funcionários trabalham.</p>
            <h2>Financeiro</h2>
            <p>Contamos com um sistema de sangria de caixa, caixas abertos e fechados, operador ativo no ambiente, controle de comandas, mesas e contas de clientes abertas e fechadas para que você possa controlar melhor tudo o que é vendido em seu negócio.</p>
        </div>
        <h1 class="border_h1">Inscreva-se e deixe o Gerabar fazer parte do seu dia a dia.</h1>
	</div>
    </div><!--.cAling-->
<?php include('_include/footer_inicio.php'); ?>
<?php include('_include/header_inicio.php'); ?>
<div class="cAlign">
<div id="form-H" style="float:left;">
<h1 style="margin-left:20px;">Conheça nossos planos</h1>
</div>
</div><!--.cAlign-->
</div><!--#topo-->
<div class="cAlign">    
    <div class="d_txt_plano">        
        <?php 
        echo '<h1 class="border_h1">';
        echo (isset($user_plano_ativo) AND $user_plano_ativo==1)?'Veja o plano ativo atualmente em seu negócio.':'Escolha o melhor plano que combina com o seu negócio.'; 
        echo '</h1>';            
        $planoUser=(isset($user_plano))?$user_plano+1:'';
        $planoEscolhido=(isset($_SESSION['salvar_plano']))?$_SESSION['salvar_plano']:$planoUser; ?>
            <ul id="u_plano_center"<?php echo ($planoEscolhido!='')?' class="plano_'.$planoEscolhido.'"':''; ?>>                
                <li>
                    <span class="s_plano_descri<?php echo ($planoEscolhido!='')?' margim_plano':''; ?>" style="padding:0; height:2px; margin: 0 2%; ">&nbsp;</span>
                    <div class="d_quadro_click plano_1<?php echo ($planoEscolhido=='1')?' plano_ativo':''; ?>"><a href="javascript:void(0);" class="a_padding_plano">Gratís</a></div>
                    <div class="d_quadro_click plano_2<?php echo ($planoEscolhido=='2')?' plano_ativo':''; ?>"><a href="javascript:void(0);">Premium Anual</a></div>
                    <div class="d_quadro_click plano_3<?php echo ($planoEscolhido=='3')?' plano_ativo':''; ?>"><a href="javascript:void(0);">Premium Mensal</a></div>
                </li>
                <li>
                    <span class="s_plano_descri<?php echo ($planoEscolhido!='')?' margim_plano':''; ?>">Premium Anual Recomendado</span>
                    <span class="plano_1"><p id="pegar_plano_1"<?php echo ($planoEscolhido=='1')?' class="plano_ativo"':''; ?>>R$ 0,00</p></span>
                    <span class="plano_2"><p id="pegar_plano_2"<?php echo ($planoEscolhido=='2')?' class="plano_ativo"':''; ?>>R$ 79,90</p></span>
                    <span class="plano_3"><p id="pegar_plano_3"<?php echo ($planoEscolhido=='3')?' class="plano_ativo"':''; ?>>R$ 14,90</p></span>
                </li>                
                <?php
                $descriPlano = array(
                    'Frente de caixa ilimitado',
                    'Cadastro de clientes ilimitado',
                    'Cadastro de produtos ilimitado',
                    'Cadastro de comandas ilimitado',
                    'Quantidade de mesas ilimitada',
                    'Contas de clientes ilimitada',
                    'Relatório de comandas, mesas e contas de clientes',
                    'Ambientes de trabalho ilimitado',
                    'Cadastro de operadores ilimitado',
                    'Login ilimitado');
                
                    for($n=0;$n<count($descriPlano);$n++){
                        echo '
                        <li>
                            <span class="s_plano_descri'; echo ($planoEscolhido!='')?' margim_plano':''; echo '">'.$descriPlano[$n].'</span> 
                            <span class="'; echo ($n==0 || $n==6 || $n==8 || $n==9)?'li_plano_v':'li_plano_x'; echo ' plano_1"><p'; echo ($planoEscolhido=='1')?' class="plano_ativo"':''; echo '><!--x--></p></span>                        
                            <span class="li_plano_v plano_2"><p'; echo ($planoEscolhido=='2')?' class="plano_ativo"':''; echo '><!--v--></p></span>
                            <span class="li_plano_v plano_3"><p'; echo ($planoEscolhido=='3')?' class="plano_ativo"':''; echo '><!--v--></p></span>
                        </li>
                        ';
                    }
                ?>
            </ul><!--u_plano_center-->
	</div>
    <?php
    if(isset($user_plano_ativo) AND $user_plano_ativo==1){
    echo '<span id="s_cancel_plano">
        <a href="'.getUrl().'configuracoes.php?cad=plano_contratado">VEJA SEU PLANO ATUAL</a>
    </span>';        
    }else{
    echo '<span id="s_continua_plano">
        <a href="javascript:void(0);">CONTINUAR</a>
    </span>';
    }
    ?>
</div><!--.cAling-->
<div id="loginCadastroPlano">
<div class="txt_plano">
	<div class="cAlign">
	<div class="d_txt_plano">
        <h1 id="muda_txt_cadLoga1">Cadastre-se para contratar seu novo plano.</h1>
	</div>
    </div><!--.cAling-->
</div><!--txt_inicio-->
<div class="cAlign">
<div id="contforminicial" style="float:left;">
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
    <div class="d_aviso_erro" id="erro_i_termos" style="margin-top:10px; margin-left:30px;"><div class="d_ponta-erro"></div><p></p></div><!--d_aviso_erro-->
    </div><!--contsexocadinicial-->    
    <div class="contsexocadinicial" style="border:0;">    
    <button type="submit" class="envia_cadastro" id="cadastroplano">Inscreva-se</button>
    </div><!--contsexocadinicial-->    
    </form>
</div><!--contforminicial-->    
<div id="d_cont_login_plano">        
    <form method="post" action="">    
    <div class="contcadinicial" style="border-top:0;">        
        <div class="forleftcad">
        <label for="usuariologaP">Usuário:</label>
        </div><!--forleftcad-->
        <input type="text" placeholder="Coloque seu nome de usúario..." id="usuariologaP" class="txtInput" />
    	<div class="d_aviso_erro" id="erro_usuariologaP" style="margin-top:36px; margin-left:170px;"><div class="d_ponta-erro"></div><p></p></div><!--d_aviso_erro-->
    </div><!--contcadinicial-->        
    <div class="contcadinicial">        
        <div class="forleftcad">
        <label for="senhalogaP">Senha:</label>
        </div><!--forleftcad-->
        <input type="password" placeholder="Coloque sua senha..." onKeyUp="return SemEspaco(this);" id="senhalogaP" class="txtInput" />
    	<div class="d_aviso_erro" id="erro_senhalogaP" style="margin-top:36px; margin-left:170px;"><div class="d_ponta-erro"></div><p></p></div><!--d_aviso_erro-->
    </div><!--contcadinicial-->    
    <div class="contsexocadinicial" style="border:0;">    
    <button type="submit" id="logarlogaP">Entrar</button>
    </div><!--contsexocadinicial-->    
    </form>
</div><!--d_cont_login_plano-->
<div id="d_botao_login_cadastro">    
    <h2 id="muda_txt_cadLoga2">Já é um usúario do sistema Gerabar ?</h2>
    <p><a href="javascript:void(0);" id="a_loginCad_plano" class="cad_plano">Clique aqui e acesse sua conta</a>.</p>    
</div><!--d_botao_login_cadastro-->
</div><!--.cAling-->
</div><!--loginCadastroPlano-->
<?php include('_include/footer_inicio.php'); ?>
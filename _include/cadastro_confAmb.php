<?php if(isset($_POST['inclui'])){ if(isset($_SESSION)==false){session_start(); }
		include('../_classes/DB.class.php');
		function getUrl(){return 'http://localhost/myforadmin/';}
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
        include('../_classes/Cadastros.class.php');
		include('../_classes/Empresas.class.php');
		$comp='../';
		$btProx=($_POST['inclui']=="confAmb")?false:true;        
        $dadosUsuario=Cadastros::selDadosUsuario($idDaSessao);
        $user_nome_usuario=$dadosUsuario['dados']['nome_usuario'];
        $user_pgs_amb=$dadosUsuario['dados']['pgs_amb'];
		}else{
		$comp='';		
			if(isset($_GET['cad']) AND $_GET['cad']=="ambiente-funcionario"){
			$btProx=false;
			}else{
			$btProx=(isset($_GET['passos']) AND $_GET['passos']=='2')?true:false;
			}
		}
		$idEmpresa = Empresas::selectEmpresa($idDaSessao);		
		$idEmpre=$idEmpresa['dados'][0];		
		if($btProx==true){
		include($comp.'_include/cadastro_imglogo.php');
		}
		include($comp.'_classes/remove_caracteres.php');
		$nomeEmpre = removeAcentos($idEmpresa['dados'][2],'-'); 
        $PriSangria=$idEmpresa['dados'][18];
		$novoNome ='';		
		 for($j=0;$j<=strlen($nomeEmpre);$j++){
			if(substr($nomeEmpre,$j,1)=='-'){
				$novoNome.='';	
				}else{
				$novoNome.=substr($nomeEmpre,$j,1);
				}
			}
		$novoNome= substr($novoNome,0,7);
?>
<div id="confAmb">
	<h1>Ambientes e operadores para <?php echo $idEmpresa['dados'][2]; ?> </h1>
    <h2>Adicione logins de trabalho para seu ambiente:</h2>    
    <ul id="ul_amb_login">
    	<li class="li_amb_topLog">
        	<span>nome de acesso</span><span class="s_segundo_amb">ambiente</span><span>senha de acesso</span><span class="s_acao_amb">ação</span>
        </li>
    <?php
        $arTxt=array(
                0=>array('identificar','ativar identificação do operador'),
                1=>array('frente_caixa','frente de caixa'),
                2=>array('abrir_caixa','opções de caixa'),
                3=>array('comanda_bar','comanda bar'),
                4=>array('contas_clientes','contas de clientes'),
                5=>array('estoque','estoque'),
                6=>array('clientes','clientes'),
                7=>array('cadastros','cadastros'),
                8=>array('administracao','administração')
            );                
                echo '<li class="li_amb_login" id="liAmb_0_admin">
        	<div class="d_td_cmd"><span>'.$user_nome_usuario.'</span><span class="s_amb_up">Esse Ambiente</span><span>********</span>
            <span class="s_acao_amb">
            	<a href="javascript:void(0);" class="openExitAmb'; if($user_pgs_amb==""){ echo ' amb_ativo';} echo '" id="ambOpen_admin" title="'; echo ($user_pgs_amb=="")?'Esconder':'Mostrar'; echo ' Páginas"></a>
            </span>
            </div>
                <ul id="ulAmb_admin"'; if($user_pgs_amb==""){ echo ' class="ulAmbAberta" style="display:block;"';} echo '>
                    <li class="li_pgs_amb"><p>selecione as páginas para o ambiente Admin:</p></li>';
                    $varPgsAdmin=explode(',',$user_pgs_amb);
                    $numCheck=0;
                    for($i=0; count($arTxt)>$i; $i++){
                        $nn=$i+1;
                        if($arTxt[$i][0]!="identificar"){
                        echo '
                        <li><label><input type="checkbox" value="'.$arTxt[$i][0].'" id="num_'.$nn.'_admin" class="icheck_admin"';
                        
                        if(in_array($arTxt[$i][0],$varPgsAdmin)){ echo 'checked="checked"'; $numCheck+=1; $display='style="display:block"';}else{ $display='';}
                        
                        echo ' /><p>'.$arTxt[$i][1].'</p></label><span title="Salvo no ambiente" class="salvoAmb" '.$display.'></span></li>';
                    }
                    }
                    echo '
					<li><label class="for_label_amb"><input type="checkbox"'; if($numCheck==8){ echo ' checked="checked"'; } echo ' id="td_icheck_admin" class="i_checkTudo" /><p class="sel_tudo_amb">selecionar todas</p></label>
					<a href="javascript:void(0);" class="a_salvaPgAmb">salvar páginas</a>
					</li>
				</ul>
                </li>';                    
            $dadosAmb=Empresas::selectAmb($idEmpre);
			if($dadosAmb['num']>0){                
				foreach($dadosAmb['dados'] as $AsDadosAmb){
                    $numCheck=0;
					$varPgs=explode(',',$AsDadosAmb['pgs_amb']);
					echo '<li class="li_amb_login" id="liAmb_'.$AsDadosAmb['id'].'">
        	<div class="d_td_cmd"><span>'.$AsDadosAmb['acesso_amb'].'</span><span class="s_amb_up">'.$AsDadosAmb['nome_amb'].'</span><span>********</span>
            <span class="s_acao_amb">
            	<a href="javascript:void(0);" class="openExitAmb" id="ambOpen_'.$AsDadosAmb['id'].'" title="Mostrar Páginas"></a>
                <a href="javascript:void(0);" class="deleteAmb imgDelAmb" title="Excluir Login"></a>
            </span>
            </div>
                <ul id="ulAmb_'.$AsDadosAmb['id'].'">
                    <li class="li_pgs_amb"><p>selecione as páginas para o ambiente '.$AsDadosAmb['nome_amb'].':</p></li>';                    
                    for($i=0; count($arTxt)>$i; $i++){
                        $nn=$i+1;
                        echo '
                        <li><label><input type="checkbox" value="'.$arTxt[$i][0].'" id="num_'.$nn.'_'.$AsDadosAmb['id'].'" class="icheck_'.$AsDadosAmb['id'].'"';
                        if($arTxt[$i][0]=="identificar"){
                        if($AsDadosAmb['identificar']==1){ echo 'checked="checked"'; $numCheck+=1; $display='style="display:block"';}else{ $display='';}
                        }else{
                        if(in_array($arTxt[$i][0],$varPgs)){ echo 'checked="checked"'; $numCheck+=1; $display='style="display:block"';}else{ $display='';}
                        }
                        echo ' /><p>'.$arTxt[$i][1].'</p></label><span title="Salvo no ambiente" class="salvoAmb" '.$display.'></span></li>';
                    }                    
                    echo '
					<li><label class="for_label_amb"><input type="checkbox"'; if($numCheck==9){ echo ' checked="checked"'; } echo ' id="td_icheck_'.$AsDadosAmb['id'].'" class="i_checkTudo" /><p class="sel_tudo_amb">selecionar todas</p></label>
					<a href="javascript:void(0);" class="a_salvaPgAmb">salvar páginas</a>                
					</li>
				</ul>
                </li>';
				}
			}			
		 ?>
        <li class="li_amb_login_text" id="l_ambAcima">
        <form method="post" action="">
        <div class="d_td_cmd">
            <span><p class="p_numAmb" <?php if(strlen($novoNome)<9){ echo 'style=" padding-left:'.(10-strlen($novoNome)).'px;"'; } ?>><?php echo $novoNome; ?>_</p>
            <input type="text" placeholder="ex: caixa..." id="i_acessoAmb" class="amb-tira-espaco" autocomplete="off" />
           <div class="d_aviso_erro" id="erro_i_acessoAmb" style=" margin:33px 0 0 66px;"><div class="d_ponta-erro"></div><p></p></div><!--d_aviso_erro-->
            </span>            
            <span class="s_segundo_amb">
            <input type="text" placeholder="ex: caixa..." id="i_nomeAmb" autocomplete="off" />
            <div class="d_aviso_erro" id="erro_i_nomeAmb" style=" margin:33px 0 0 12px;"><div class="d_ponta-erro"></div><p></p></div><!--d_aviso_erro-->
            </span>            
            <span>
            <div id="d_acertaSenha">
            <input type="password" placeholder="senha do login..." id="i_senhaAmb" class="amb-tira-espaco" autocomplete="off" />
            <a href="javascript:void(0);" class="olho-amb" title="Mostrar Senha"><!--mostrar senha---></a>
            </div>
            <div class="d_aviso_erro" id="erro_i_senhaAmb" style=" margin:33px 0 0 12px;"><div class="d_ponta-erro"></div><p></p></div><!--d_aviso_erro-->
            </span>            
            <span class="s_acao_amb"><button type="submit" id="i_enviaAmb">salvar</button></span>
        </div>
        </form>
        </li>
    </ul>    
	<h2 class="h2_cBorda">Adicionar operadores (funcionários):</h2>
    <ul id="ul_amb_operador">
    	<li class="li_amb_topLog li_amb_respansivo">
        	<span>nome operador</span><span>cógido</span><span>senha de acesso</span><span class="s_acao_amb">ação</span>
        </li>        
        <?php
			include($comp.'_classes/Operadores.class.php');
			$dadosOpe= Operadores::selOperador($idEmpre);
			if($dadosOpe['num']>0){			
                foreach($dadosOpe['dados'] as $AsDadosOpe){
                echo '<li class="li_amb_login li_amb_respansivo" id="liOpe_'.$AsDadosOpe['id'].'">
                        <div class="d_td_cmd"><span>'.$AsDadosOpe['nome_operador'].'</span><span class="s_amb_up">'.$AsDadosOpe['codigo'].'</span>
                        <span>'; echo ($AsDadosOpe['admin']==0)?'********':'mesma de acesso'; echo '</span>
                        <span class="s_acao_amb">
                            <a href="javascript:void(0);" class="deleteOpe imgDelOpe" title="Excluir Operador"></a>
                        </span>
                        </div>
                    </li>';
				}
			}
		 ?>        
        <li class="li_amb_login_text li_amb_respansivo" id="l_opeAcima">
        <form method="post" action="">
        <div class="d_td_cmd">
            <span>
            <input type="text" placeholder="Coloque o nome aqui..." id="i_nomeOpe" autocomplete="off" />
           <div class="d_aviso_erro" id="erro_i_nomeOpe" style=" margin:33px 0 0 12px;"><div class="d_ponta-erro"></div><p></p></div><!--d_aviso_erro-->
            </span>            
            <span>
            <input type="text" placeholder="cógido aqui..." id="i_codOpe" autocomplete="off" onKeyPress="return SomenteNumero(event);" maxlength="5" />
            <div class="d_aviso_erro" id="erro_i_codOpe" style=" margin:33px 0 0 12px;"><div class="d_ponta-erro"></div><p></p></div><!--d_aviso_erro-->
            </span>            
            <span>
            <div id="d_acertaSenhaOp">
            <input type="password" placeholder="senha aqui..." id="i_senhaOpe" class="amb-tira-espaco" autocomplete="off" />
            <a href="javascript:void(0);" class="olho-amb" title="Mostrar Senha"><!--mostrar senha---></a>
            </div>
            <div class="d_aviso_erro" id="erro_i_senhaOpe" style=" margin:33px 0 0 12px;"><div class="d_ponta-erro"></div><p></p></div><!--d_aviso_erro-->
            </span>            
            <span class="s_acao_amb"><button type="submit" id="i_enviaOpe">salvar</button></span>
        </div>
        </form>
        </li>        
    </ul>   
    <?php if($btProx==true){
    echo '
	<div id="cont-alt-master">
    <div id="d_sangria_cx">
        <h3>ATIVAR SANGRIA DE CAIXA:</h3>
        <div class="tudo_txt_ajuda">
            <span class="ico-ajuda"></span>
            <div class="cx_txt_ajuda"><div class="ponta_ajuda"></div><p>A sangria serve para abrir o caixa e ter controle de troco, do limite de dinheiro no caixa e do funcionário que está operando no ambiente.</p></div><!--cx_txt_ajuda-->
        </div><!--tudo_txt_ajuda-->
        <div class="d_toggle"><label'; if($PriSangria==0){ echo ' id="l_toggle_desativado"'; }else{ echo ' id="l_toggle_ativado" class="label_ativo"'; } echo '></label><div class="carregador_toggle"></div></div>
    </div><!--d_sangria_cx-->    
    <div id="ad_cmd_senhaMaster"><a href="javascript:void(0);" class="alt_senha_admim">ALTERAR SENHA MASTER</a></div><!--ad_cmd_senhaMaster-->
    <span>Senha atual é a mesma senha de acesso*</span>
    </div>
	<div id="d_prox">
        <a class="proximo_empresa" id="envia_ambOpe" href="?passos=3">próximo passo</a>
    </div>';
	} ?>
</div><!--fecha confAmb-->
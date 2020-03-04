<?php if(isset($_SESSION)==false){session_start(); }
		if(isset($_POST['tipo'])){$tipo = $_POST['tipo'];}elseif(isset($_GET['delete'])){$tipo = "delete";}else{$tipo = "";}
	if($tipo=="delete"){			
	if(isset($_POST['inclui'])){
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
		$tabela = $_SESSION['Gerabar_table'];
		include('../_classes/Cadastros.class.php');		
		$idEmp=Cadastros::selectIdEmpresa($idDaSessao,$tabela);
		$idEmpresa = $idEmp['dados'][0];		
	}else{
		$idEmpresa = $user_id_empresa;
	}	

	$count = Cadastros::countArray($idEmpresa,'fornecedores');
	if($count>0){
	
	if(isset($_GET['pg']) AND $_GET['pg']!=0){
	$pagina = (int)$_GET['pg'];
	}else{
	$pagina = 1;
	}
		$maximo = 8;
		$inicio = $pagina - 1;
		$inicio = $maximo * $inicio;
		
	$pgs = ceil($count / $maximo);
	$fornecedores = Cadastros::selectArray($idEmpresa,'fornecedores',$inicio,$maximo);
	echo '<div id="cont_form_fornecedores">';
	if($fornecedores['num']>0){
	?>
    
    <div class="info_topo_cad"><h1>excluir fornecedor de venda</h1></div><!--fecha info topo cad-->
    
    <div class="linha_form">
    
    <div id="d_tudo_del">
    <input type="text" id="busca_del" autocomplete="off" />
    <button type="submit" class="fornecedores" id="envia_busca_del"></button>
    <input type="hidden" value="<?php echo $pagina; ?>" id="pagina" />
    <input type="hidden" value="<?php echo $count; ?>" id="quantElemento" />
    <ul id="lista_del">
    <?php
	$num = 1;
	foreach($fornecedores['dados'] as $asFornecedor){
	echo '<li>
			<label>
			<input type="checkbox" class="check-del" id="loop-'.$num.'" value="'.$asFornecedor['id'].'" />
			<span class="s_lista_del">'.$asFornecedor['fornecedores'].'</span>
			</label>
			<span class="s_excluir_del">[<a href="javascript:void(0);" class="'.$asFornecedor['id'].'">excluir</a>]</span>            
		</li>';
		$num+=1;
	}
	?>
    </ul>
    </div><!--#d_tudo_del-->

    </div><!--fecha linha form-->
    
    <div class="linha_form">
            
        <div class="d_alinha_form">
        		<input  id="i_select_tudo" type="checkbox"/>
                <span id="s_select_tudo">[<label for="i_select_tudo">selecionar tudo</label>]</span>
        </div>
        <div class="d_alinha_form">
        	<div id="d_acerta_select">
            	<div id="see_search">
        <?php
			if($pgs > 1 ) {
		
			echo '<div id="select_del">
					<div id="s_num_select">'.$pagina.'</div>
					<div class="s_abre_select" id="sel_pg_del"></div>
					<ul>';
						for($i=1;$i <= $pgs;$i++) {
							echo '<li><a href="'.getUrl().'cadastros.php?cad=fornecedores&delete=true&pg='.$i.'">'.$i.'</a></li>';
						}			
			  echo '</ul>
				</div>';
    	 } ?>
         		</div>
         	</div><!--fecha d_acerta_select-->
		</div>
        
        <div class="d_alinha_form">   
            <input type="submit" style="margin-top:7px;" class="cd_envia_dados" id="delete_array" value="excluir selecionados" />
        </div>
        
    </div><!--fecha linha form-->
    
	<?php 
	}else{
	echo '<h1 class="h1_error">Página não encontrada, por favor, <a href="'.getUrl().'cadastros.php?cad=fornecedores&delete=true">clique aqui</a></h1>';
	}
	
	}else{
	echo '<h1 class="h1_error">Não tem fornecedores cadastrados</h1>';
	}
	}else{ ?>
        	<div class="info_topo_cad"><h1>cadastrar novo fornecedor</h1></div><!--fecha info topo cad-->            
            <form action="" method="post">        
        	<div class="linha_form" id="add_mais_unid">
            	<div class="d_alinha_form">
                	<span id="bt_mais_unid" class="2|55|2|55|13"><a href="javascript:void(0);" class="add_fornecedor" title="Adicionar fornecedor extra"></a></span>
                </div>
                <div class="d_alinha_form contUni">
                    <span><label for="cd_fornecedores_array_0">novo fornecedor:</label></span>
                    
                    <div class="tudo_txt_ajuda" style="margin-left:125px;">
                        <span class="ico-ajuda"></span>
                        <div class="cx_txt_ajuda"><div class="ponta_ajuda"></div><p>Aqui você pode cadastrar cada fornecedor que irá fornecer produtos para sua empresa.</p></div><!--cx_txt_ajuda-->
                	</div><!--tudo_txt_ajuda-->
                    
                    <input type="text" id="cd_fornecedores_array_0" class="for_fornecedor" />
                    <div class="d_aviso_erro" id="erro_cd_fornecedores_array_0"><div class="d_ponta-erro"></div><p></p></div><!--d_aviso_erro-->
                </div>
                
            </div><!--fecha linha form-->
            
            <div class="linha_form">
            
            	<div class="d_alinha_form"><span class="sp_alinha_bts"></span></div>
            
                <div class="d_alinha_form">                    
                    <button type="submit" class="cd_envia_dados" id="envia_array">enviar</button>
                    <input type="hidden" id="pegar_array" value="fornecedores" />
                </div>
                
                <div class="d_alinha_form">
                	<button type="reset" class="cd_limpa_dados">limpar campos</button>
                </div>
                
            </div><!--fecha linha form-->
            
            </form>
         <?php } ?>  
        </div><!--fecha form fornecedores-->
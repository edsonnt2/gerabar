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
	$count = Cadastros::countArray($idEmpresa,'unidade_venda');
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
	$unidade = Cadastros::selectArray($idEmpresa,'unidade_venda',$inicio,$maximo);
	echo '<div id="cont_form_unidades">';
	if($unidade['num']>0){
	?>
    
    <div class="info_topo_cad"><h1>excluir unidade de venda</h1></div><!--fecha info topo cad-->
    
    
    <div class="linha_form">
    
    <div id="d_tudo_del">
    <input type="text" id="busca_del" autocomplete="off" />
    <button type="submit" class="unidades" id="envia_busca_del"></button>
    <input type="hidden" value="<?php echo $pagina; ?>" id="pagina" />
    <input type="hidden" value="<?php echo $count; ?>" id="quantElemento" />
    <ul id="lista_del">
    <?php
	$num = 1;
	foreach($unidade['dados'] as $asUnidade){
	echo '<li>
			<label>
			<input type="checkbox" class="check-del" id="loop-'.$num.'" value="'.$asUnidade['id'].'" />
			<span class="s_lista_del">'.$asUnidade['unidade_venda'].'</span>
			</label>
			<span class="s_excluir_del">[<a href="javascript:void(0);" class="'.$asUnidade['id'].'">excluir</a>]</span>            
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
							echo '<li><a href="'.getUrl().'cadastros.php?cad=unidades&delete=true&pg='.$i.'">'.$i.'</a></li>';
						}
			  echo '</ul>
				</div>';
    	 } ?>    	 
         		</div>           
         	</div><!--fecha d_acerta_select-->
		</div>
        
        <div class="d_alinha_form">   
            <button type="submit" style="margin-top:7px;" class="cd_envia_dados" id="delete_array">excluir selecionados</button>
        </div>
        
    </div><!--fecha linha form-->
    
	<?php 
	}else{
	echo '<h1 class="h1_error">Página não encontrada, por favor, <a href="'.getUrl().'cadastros.php?cad=unidades&delete=true">clique aqui</a></h1>';
	}
	
	}else{
	echo '<h1 class="h1_error">Não tem unidades cadastradas</h1>';
	}
	}else{ ?>
        	<div class="info_topo_cad"><h1>cadastrar nova unidade de venda</h1></div><!--fecha info topo cad-->
            
            <form action="" method="post">
        
        	<div class="linha_form" id="add_mais_unid">
            
            	<div class="d_alinha_form">
                	<span id="bt_mais_unid" class="3|55|3|55|20"><a href="javascript:void(0);" class="add_unidade" title="Adicionar mais unidades"></a></span>
                </div>
                <div class="d_alinha_form contUni">
                    <span><label for="cd_unidades_array_0">nova unidade de venda:</label></span>
                    <div class="tudo_txt_ajuda">
                        <span class="ico-ajuda"></span>
                        <div class="cx_txt_ajuda"><div class="ponta_ajuda"></div><p>Com a unidade de venda, você pode controla o que irá vender separando cada produto com seu tipo de unidade, por exemplo: "CX C/12, CX C/24, UNIDADE, KILO" e etc.</p></div><!--cx_txt_ajuda-->
                	</div><!--tudo_txt_ajuda-->
                    
                    <input type="text" id="cd_unidades_array_0" class="for_unid" autofocus="autofocus" />
                    <div class="d_aviso_erro" id="erro_cd_unidades_array_0"><div class="d_ponta-erro"></div><p></p></div><!--d_aviso_erro-->
                </div>
                
            </div><!--fecha linha form-->
            
            <div class="linha_form">
            
            	<div class="d_alinha_form"><span class="sp_alinha_bts"></span></div>
            
                <div class="d_alinha_form">                    
                    <button type="submit" class="cd_envia_dados" id="envia_array">enviar</button>
                    <input type="hidden" id="pegar_array" value="unidades" />
                </div>
                
                <div class="d_alinha_form">
	                <button type="reset" class="cd_limpa_dados">limpar campos</button>
                </div>
                
            </div><!--fecha linha form-->
            
            </form>
        <?php } ?>
           
        </div><!--fecha form unidades-->
<?php if(isset($_POST['inclui'])){	if(!isset($_SESSION)){session_start();}
	include("../_classes/DB.class.php");
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
	include("../_classes/Cadastros.class.php");
	$idDaSessao = $_SESSION['Gerabar_uid'];
	$table = $_SESSION['Gerabar_table'];
	$idEmpre = Cadastros::selectIdEmpresa($idDaSessao,$table);
	$idEmpresa=($idEmpre['num']>0)?$idEmpre['dados'][0]:0;
}else{
	$idEmpresa = $user_id_empresa;
}
?>
<script type="text/javascript">
$(function(){
	$('input.for-valor').priceFormat({
	prefix: '',
	centsSeparator: ',',
	thousandsSeparator: '.'
	});
	
	$('input#cd_produto_valCompra-margem').priceFormat({
	prefix: '',
	centsSeparator: '',
	thousandsSeparator: '.',
	centsLimit: 0
	});
		
});
</script>
<div id="cont_form_produtos">
        
        	<div class="info_topo_cad"><h1>cadastrar novo produto</h1></div><!--fecha info topo cad-->
            
            <form action="" method="post">
        
        	<div class="linha_form">
            
            	<div class="d_alinha_form">
                    <span><label for="cd_produto_marca">marca:</label></span>
                    
                    <?php						
						$marca = Cadastros::selectArray($idEmpresa,'marcas');
						if($marca['num']>0){
							echo '<div class="d_alinha_submenu">
								<input type="text" id="cd_produto_marca" autocomplete="off" autofocus="autofocus" />
								<div class="bt_submenu"><span class="marca"></span></div>
                    			<ul id="submenu_marca">';
							foreach($marca['dados'] as $AsMarca){
								echo '<li><span class="marca">'.$AsMarca['marcas'].'</span></li>';
							}
							echo '</ul>
							<ul id="busca_cd_produto_marca"></ul>
							
							</div><!--d_alinha_submenu-->';
						}else{
							echo '<input type="text" id="cd_produto_marca" autofocus="autofocus" />';
						}
						 ?>
                       <div class="d_aviso_erro" id="erro_cd_produto_marca"><div class="d_ponta-erro"></div><p></p></div><!--d_aviso_erro-->
                </div>
                
                <div class="d_alinha_form">
                    <span><label for="cd_produto_descricao">descrição:</label></span>
                    <input type="text" id="cd_produto_descricao" />
                    <div class="d_aviso_erro" id="erro_cd_produto_descricao"><div class="d_ponta-erro"></div><p></p></div><!--d_aviso_erro-->
                </div>
                
                <div class="d_alinha_form">
                    <span><label style="cursor:inherit">unidade de venda:</label></span>
                    	<?php						
						$unidade = Cadastros::selectArray($idEmpresa,'unidade_venda');
						if($unidade['num']>0){
							echo '<div class="d_alinha_submenu">
								<input type="text" id="cd_produto_unidade" autocomplete="off" />
								<div class="bt_submenu"><span class="unidade"></span></div>
                    			<ul id="submenu_unidade">';
							foreach($unidade['dados'] as $AsUnidade){
								echo '<li><span class="unidade">'.$AsUnidade['unidade_venda'].'</span></li>';
							}
							echo '</ul>
							<ul id="busca_cd_produto_unidade"></ul>
							
							</div><!--d_alinha_submenu-->';
						}else{
							echo '<input type="text" id="cd_produto_unidade" />';
						}
						 ?>
                    <div class="d_aviso_erro" id="erro_cd_produto_unidade"><div class="d_ponta-erro"></div><p></p></div><!--d_aviso_erro-->
                </div>
                
            </div><!--fecha linha form-->
            
            <div class="linha_form">
            
            	<div class="d_alinha_form">
                    <span><label for="cd_produto_categoria">categoria:</label></span>
                    
                    <?php
						$categoria = Cadastros::selectArray($idEmpresa,'categorias');
						if($categoria['num']>0){
							echo '<div class="d_alinha_submenu">
								<input type="text" id="cd_produto_categoria" autocomplete="off" />
								<div class="bt_submenu"><span class="categoria"></span></div>
                    			<ul id="submenu_categoria">';
							foreach($categoria['dados'] as $AsCategoria){
								echo '<li><span class="categoria">'.$AsCategoria['categorias'].'</span></li>';
							}
							echo '</ul>
							<ul id="busca_cd_produto_categoria"></ul>
							
							</div><!--d_alinha_submenu-->';
						}else{
							echo '<input type="text" id="cd_produto_categoria" />';
						}
						 ?>
                     <div class="d_aviso_erro" id="erro_cd_produto_categoria"><div class="d_ponta-erro"></div><p></p></div><!--d_aviso_erro-->
                </div>
                
                <div class="d_alinha_form">
                    <span><label for="cd_produto_fornecedor">fornecedor:</label></span>
                    
                    <?php
						$fornecedor = Cadastros::selectArray($idEmpresa,'fornecedores');
						if($fornecedor['num']>0){
							echo '<div class="d_alinha_submenu">
								<input type="text" id="cd_produto_fornecedor" autocomplete="off" />
								<div class="bt_submenu"><span class="fornecedor"></span></div>
                    			<ul id="submenu_fornecedor">';
							foreach($fornecedor['dados'] as $AsFornecedor){
								echo '<li><span class="fornecedor">'.$AsFornecedor['fornecedores'].'</span></li>';
							}
							echo '</ul>
							<ul id="busca_cd_produto_fornecedor"></ul>
							
							</div><!--d_alinha_submenu-->';
						}else{
							echo '<input type="text" id="cd_produto_fornecedor" />';
						}
					?>
                    <div class="d_aviso_erro" id="erro_cd_produto_fornecedor"><div class="d_ponta-erro"></div><p></p></div><!--d_aviso_erro-->
                </div>
                
                <div class="d_alinha_form">
                    <span><label for="cd_produto_qtd">quantidade:</label></span>
                    <input type="text" id="cd_produto_qtd" onKeyPress="return SomenteNumero(event);" maxlength="11" />
                    <div class="d_aviso_erro" id="erro_cd_produto_qtd"><div class="d_ponta-erro"></div><p></p></div><!--d_aviso_erro-->
                </div>
                
                <div class="d_alinha_form">
                    <span><label for="cd_produto_codInterno">código interno:</label></span>
                    <input type="text" id="cd_produto_codInterno" onKeyUp="return SemEspaco(this);" maxlength="20" />
                    <div class="d_aviso_erro" id="erro_cd_produto_codInterno"><div class="d_ponta-erro"></div><p></p></div><!--d_aviso_erro-->
                </div>
           
            </div><!--fecha linha form-->
            
            <div class="info_topo_cad" style="margin-top:20px;"></div><!--fecha info topo cad-->
            
            <div class="linha_form">
            
            	<div class="d_alinha_form">
                    <span><label for="cd_produto_valCompra">valor compra:</label></span>
                    <input type="text" id="cd_produto_valCompra" class="carrega_valor for-valor" value="0,00" onfocus="if(this.value=='0,00')this.value='';" autocomplete="off" />
                    <input type="hidden" id="salva_cd_produto_valCompra" value="" />
                    <div class="d_aviso_erro" id="erro_cd_produto_valCompra"><div class="d_ponta-erro"></div><p></p></div><!--d_aviso_erro-->
                </div>
            
            	<div class="d_alinha_form">
                    <span><label for="cd_produto_valCompra-margem">margem:</label></span>
                    <div class="d_ajusta_porcento">
                    <input type="text" id="cd_produto_valCompra-margem" class="carrega_margem" value="100" maxlength="3" autocomplete="off" />
                    <div id="s_porcento">%</div>
                    </div>
                    <div class="d_aviso_erro" id="erro_cd_produto_valCompra-margem"><div class="d_ponta-erro"></div><p></p></div><!--d_aviso_erro-->
                </div>
                
                <div class="d_alinha_form">
                    <span><label for="cd_produto_valCompra_valVarejo">valor de venda:</label></span>
                    <input type="text" id="cd_produto_valCompra_valVarejo" class="for-valor" value="0,00" onfocus="if(this.value=='0,00')this.value='';" autocomplete="off" />
                    <div class="d_aviso_erro" id="erro_cd_produto_valCompra_valVarejo"><div class="d_ponta-erro"></div><p></p></div><!--d_aviso_erro-->
                </div>
            
            </div><!--fecha linha form-->
            
            <div class="linha_form">
            
                <div class="d_alinha_form">
                	<button type="submit" class="cd_envia_dados" id="envia_produtos">cadastrar</button>
                </div>
                
                <div class="d_alinha_form">                    
                    <button type="reset" class="cd_limpa_dados">limpar campos</button>
                </div>
                
            </div><!--fecha linha form-->
            
            </form>
        
        </div><!--fecha form produtos-->
<?php include("_include/header.php"); ?>
 	
    <div id="cont_cadastros">
    	
        <div id="topo_cadastros">
        
        	<h1 id="h_cadastros">cadastro de <?php if(isset($_GET['cad'])){ $cad=strtolower($_GET['cad']); echo $_GET['cad'];}else{ echo 'clientes'; $cad='';}?></h1>

        </div><!--topo_cadastros-->
        
        <ul id="menu_cadastro" class="pgCadastro">
        	<li <?php if($cad=='' OR $cad=='clientes'){ echo 'class="cadastro_ativo"';} ?> ><a href="<?php echo getUrl(); ?>cadastros.php?cad=clientes" class="clientes">cadastrar clientes</a></li>
            <li class="li_linha_menuCadTres"></li><!--li_linha_menuCadTres-->            
        	<li <?php if($cad=='produtos'){ echo 'class="cadastro_ativo"';} ?>><a href="<?php echo getUrl(); ?>cadastros.php?cad=produtos" class="produtos">cadastrar produtos</a></li>      
            
            <li class="li_linha_menuCadDois"></li><!--li_linha_menuCadDois-->
            
            <li <?php if($cad=='mesa'){ echo 'class="cadastro_ativo"';} ?>><a href="<?php echo getUrl(); ?>cadastros.php?cad=mesa" class="mesa">comandas de mesa</a></li>                 
            
            <li class="li_linha_menuCadUm"></li><!--li_linha_menuCadUm-->
            
            <li><a href="javascript:void(0);" class="submenu" id="abre_entrada"><span class="<?php if($cad=='entrada'){ echo 'fecha';}else{ echo 'abre';} ?>">valores entrada</span></a>
            	<ul id="abre_entrada_cadastro" <?php if($cad=='entrada'){ echo 'class="submenu_cadastro"';} ?>>
                	<li <?php if($cad=='entrada' AND !isset($_GET['delete'])){ echo 'class="cadastro_ativo"';} ?>><a href="<?php echo getUrl(); ?>cadastros.php?cad=entrada" class="entrada"><span class="cad">cadastrar entrada</span></a></li>
                    <li <?php if($cad=='entrada' AND isset($_GET['delete'])){ echo 'class="cadastro_ativo"';} ?>><a href="<?php echo getUrl(); ?>cadastros.php?cad=entrada&delete=true" class="entrada"><span class="delete">excluir entrada</span></a></li>
                </ul>
            </li>
            
            <li class="li_linha_menuCadDois"></li><!--li_linha_menuCadDois-->
            
            <li><a href="javascript:void(0);" class="submenu" id="abre_unidades"><span class="<?php if($cad=='unidades'){ echo 'fecha';}else{ echo 'abre';} ?>">unidades</span></a>
            	<ul id="abre_unidades_cadastro" <?php if($cad=='unidades'){ echo 'class="submenu_cadastro"';} ?>>
                	<li <?php if($cad=='unidades' AND !isset($_GET['delete'])){ echo 'class="cadastro_ativo"';} ?>><a href="<?php echo getUrl(); ?>cadastros.php?cad=unidades" class="unidades"><span class="cad">cadastrar unidades</span></a></li>
                    <li <?php if($cad=='unidades' AND isset($_GET['delete'])){ echo 'class="cadastro_ativo"';} ?>><a href="<?php echo getUrl(); ?>cadastros.php?cad=unidades&delete=true" class="unidades"><span class="delete">excluir unidades</span></a></li>
                </ul>
            </li>
            
            <li class="li_linha_menuCadTres"></li><!--li_linha_menuCadTres-->
            
            <li><a href="javascript:void(0);" class="submenu" id="abre_marcas"><span class="<?php if($cad=='marcas'){ echo 'fecha';}else{ echo 'abre';} ?>">marcas</span></a>
            	<ul id="abre_marcas_cadastro"<?php if($cad=='marcas'){ echo 'class="submenu_cadastro"';} ?>>
                	<li <?php if($cad=='marcas' AND !isset($_GET['delete'])){ echo 'class="cadastro_ativo"';} ?>><a href="<?php echo getUrl(); ?>cadastros.php?cad=marcas" class="marcas"><span class="cad">cadastrar marcas</span></a></li>
                    <li <?php if($cad=='marcas' AND isset($_GET['delete'])){ echo 'class="cadastro_ativo"';} ?>><a href="<?php echo getUrl(); ?>cadastros.php?cad=marcas&delete=true" class="marcas"><span class="delete">excluir marcas</span></a></li>
                </ul>
            </li>
            
            
            <li><a href="javascript:void(0);" class="submenu" id="abre_categorias"><span class="<?php if($cad=='categorias'){ echo 'fecha';}else{ echo 'abre';} ?>">categorias</span></a>
            	<ul id="abre_categorias_cadastro" <?php if($cad=='categorias'){ echo 'class="submenu_cadastro"';} ?>>
                	<li <?php if($cad=='categorias' AND !isset($_GET['delete'])){ echo 'class="cadastro_ativo"';} ?>><a href="<?php echo getUrl(); ?>cadastros.php?cad=categorias" class="categorias"><span class="cad">cadastrar categorias</span></a></li>
                    <li <?php if($cad=='categorias' AND isset($_GET['delete'])){ echo 'class="cadastro_ativo"';} ?>><a href="<?php echo getUrl(); ?>cadastros.php?cad=categorias&delete=true" class="categorias"><span class="delete">excluir categorias</span></a></li>
                </ul>
            </li>
            
            <li><a href="javascript:void(0);" class="submenu" id="abre_fornecedores"><span class="<?php if($cad=='fornecedores'){ echo 'fecha';}else{ echo 'abre';} ?>">fornecedores</span></a>
            	<ul id="abre_fornecedores_cadastro" <?php if($cad=='fornecedores'){ echo 'class="submenu_cadastro"';} ?>>
                	<li <?php if($cad=='fornecedores' AND !isset($_GET['delete'])){ echo 'class="cadastro_ativo"';} ?>><a href="<?php echo getUrl(); ?>cadastros.php?cad=fornecedores" class="fornecedores"><span class="cad">cadastrar fornecedor</span></a></li>
                    <li <?php if($cad=='fornecedores' AND isset($_GET['delete'])){ echo 'class="cadastro_ativo"';} ?>><a href="cadastros.php?cad=fornecedores&delete=true" class="fornecedores"><span class="delete">excluir fornecedor</span></a></li>
                </ul>
            </li>
           
        </ul><!--fecha menu cadastro-->
        <div id="contConfCad">
        <div id="loadingOne"></div>
        <div id="troca_cadastros" class="sel_aba_prod">
        <?php
        if(!isset($table) || $table!="ambientes"){
		 include('_classes/Cadastros.class.php');
        }
		if(!isset($_GET['cad']) OR $cad=='clientes'){		
	        include('_include/cadastro_clientes.php');
		 }elseif($cad=='produtos'){
			 include('_include/cadastro_produtos.php');
		 }elseif($cad=='mesa'){
			include('_include/cadastro_mesa.php');
		 }elseif($cad=='entrada'){
			include('_include/cadastro_entrada.php');
		 }elseif($cad=='unidades'){
			 include('_include/cadastro_unidades.php');
		 }elseif($cad=='marcas'){
			 include('_include/cadastro_marcas.php');
		 }elseif($cad=='categorias'){
			 include('_include/cadastro_categorias.php');
		 }elseif($cad=='fornecedores'){
			 include('_include/cadastro_fornecedores.php');
		 }else{
		 	echo '<div id="divErroPg"><h1 class="h1_error">Opção de página não encontrada !</h1></div>';
		 }
		 ?>
        </div><!--fecha troca cadastros-->
    </div><!--cont_cadastros-->
	</div><!--contConfCad-->
</div><!--.cAlign-->

<?php include('_include/footer.php');
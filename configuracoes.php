<?php include("_include/header.php"); ?>
 	
    <div id="cont_cadastros">    	
        <div id="topo_cadastros">
        	<h1 id="h_cadastros">página de configurações gerais</h1>
        </div><!--topo_cadastros-->        
        <?php
			if(isset($_GET['cad'])){
				$cad=strtolower($_GET['cad']);
			}else{
				$cad='';
			}
		?>        
        <ul id="menu_cadastro" class="configura">        	
            <li <?php if($cad=='' OR $cad=='ambiente-funcionario'){ echo 'class="cadastro_ativo"';} ?>><a href="<?php echo getUrl(); ?>configuracoes.php?cad=ambiente-funcionario" class="ambiente-funcionario">Cadastrar amb. e func.</a></li>
            <li <?php if($cad=='plano_contratado'){ echo 'class="cadastro_ativo"';} ?>><a href="<?php echo getUrl(); ?>configuracoes.php?cad=plano_contratado" class="plano_contratado">Plano Contratado</a></li>
            <li class="li_linha_menuCadConf"></li><!--li_linha_menuCadConf-->
            <li <?php if($cad=='logotipo'){ echo 'class="cadastro_ativo"';} ?>><a href="<?php echo getUrl(); ?>configuracoes.php?cad=logotipo" class="logotipo">Salvar Logotipo</a></li>
            <li <?php if($cad=='preferencias'){ echo 'class="cadastro_ativo"';} ?>><a href="<?php echo getUrl(); ?>configuracoes.php?cad=preferencias" class="preferencias">Preferências</a></li>
            <li <?php if($cad=='usuario'){ echo 'class="cadastro_ativo"';} ?>><a href="<?php echo getUrl(); ?>configuracoes.php?cad=usuario" class="usuario">Dados de Usúario</a></li>
            <li <?php if($cad=='empresa'){ echo 'class="cadastro_ativo"';} ?> ><a href="<?php echo getUrl(); ?>configuracoes.php?cad=empresa" class="empresa">Dados da Empresa</a></li>
            
        </ul><!--fecha menu cadastro-->
        <div id="contConfCad">
        <div id="loadingOne"></div>
        <div id="troca_cadastros" class="sel_aba_prod">
        <?php
		 include('_classes/Cadastros.class.php');
		 if(!isset($_GET['cad']) OR $cad=='ambiente-funcionario'){
			 include('_include/cadastro_confAmb.php');
		 }elseif($cad=='plano_contratado'){
			include('_include/cadastro_plano_contratado.php');
		 }elseif($cad=='empresa'){
	        include('_include/cadastro_empresa.php');
		 }elseif($cad=='logotipo'){
			include('_include/cadastro_imglogo.php');
		 }elseif($cad=='preferencias'){
			include('_include/cadastro_preferencias.php');
		 }elseif($cad=='usuario'){
			include('_include/cadastro_usuario.php');
		 }else{
		 	echo '<div id="divErroPg"><h1 class="h1_error">Opção de página não encontrada !</h1></div>';
		 }
		 ?>
         
         
        </div><!--fecha troca cadastros-->
        </div><!--contConfigura-->
    </div><!--cont_cadastros-->

</div><!--.cAlign-->

<?php include('_include/footer.php');
<?php include("_include/header.php");
$cad=(isset($_GET['cad']))?strtolower($_GET['cad']):"";
 ?>
    <div id="cont_cadastros">
        <div id="topo_cadastros">        
        	<h1 id="h_cadastros">controle de comanda bar</h1>
        </div><!--topo_cadastros-->        
        <ul id="menu_comanda" class="aba-caixa-bar">
        	<li <?php if($cad=="" || $cad=="lancar-comanda"){ echo 'class="cadastro_ativo"';} ?>><a href="<?php echo getUrl(); ?>comanda-bar.php?cad=lancar-comanda" class="lancar-comanda">lançar comanda</a></li>
            <li <?php if($cad=='consulta-comanda'){ echo 'class="cadastro_ativo"';} ?>><a href="<?php echo getUrl(); ?>comanda-bar.php?cad=consulta-comanda" class="consulta-comanda">consulta comanda</a></li>
            
            <li <?php if($cad=="comanda-mesa"){ echo 'class="cadastro_ativo"';} ?>><a href="<?php echo getUrl(); ?>comanda-bar.php?cad=comanda-mesa" class="comanda-mesa">comanda por mesa</a></li>
            <li <?php if($cad=='consulta-mesa'){ echo 'class="cadastro_ativo"';} ?>><a href="<?php echo getUrl(); ?>comanda-bar.php?cad=consulta-mesa" class="consulta-mesa">consulta por mesa</a></li>
            <li id="liMais">
            	<a href="javascript:void(0);" id="aLiMais" class="180">mais</a>
                <ul></ul>            
            </li>
        </ul><!--fecha menu cadastro-->
        <div id="troca_cadastros" class="sel_aba_prod">
       		<?php 			
			if($cad=="comanda-mesa"){
				if(isset($_GET['idMesa']) AND $_GET['idMesa']<>""){
				include('_include/lancar-comanda.php');
				}else{
				include('_include/comanda-mesa.php');
				}
			}elseif($cad=="consulta-mesa"){
			include('_include/consulta-mesa.php');
			}elseif($cad=="consulta-comanda"){
			include('_include/consulta-comanda.php');
			}elseif($cad=="" || $cad=="lancar-comanda"){
			include('_include/lancar-comanda.php');
			}else{
			echo '<h2 style=" text-transform:uppercase; float:left; margin:40px 20px;">opção de bar não encontrada !</h2>';	
		 	} ?>
        </div><!--fecha troca cadastros-->
        <div id="loadingOne"></div>
    </div><!--cont_cadastros-->
</div><!--.cAlign-->
<?php include('_include/footer.php');
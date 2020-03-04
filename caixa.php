<?php include("_include/header.php"); ?> 	
    <div id="cont_cadastros">
        <div id="topo_cadastros">        
        	<h1 id="h_cadastros"><?php $cad=(isset($_GET['cad']))?strtolower($_GET['cad']):""; if($cad=="opcao-mesa"){ echo 'Opções de mesa'; }elseif($cad=="comanda-cliente"){ echo 'comanda de cliente'; }elseif($cad=="cadastro-clientes"){ echo 'cadastrar novo cliente';}elseif($cad=="comandas-abertas"){echo 'Comandas em aberto';}elseif($cad=="mesas-fechadas"){echo 'Mesas fechadas';}else{echo 'comanda de cliente';} ?></h1>            
        </div><!--topo_cadastros-->
        <ul id="menu_caixa_bar" class="aba-caixa-bar">
            <li <?php if($cad=='' OR $cad=='comanda-cliente'){ echo 'class="cadastro_ativo"';} ?> ><a href="<?php echo getUrl(); ?>caixa.php?cad=comanda-cliente" class="comanda-cliente">comanda cliente</a></li>
            <li <?php if($cad=='cadastro-clientes'){ echo 'class="cadastro_ativo"';} ?> id="linkAbaCliente" ><a href="<?php echo getUrl(); ?>caixa.php?cad=cadastro-clientes" class="cadastro-clientes">cadastrar clientes</a></li>
            <li <?php if($cad=='opcao-mesa'){ echo 'class="cadastro_ativo"';} ?> ><a href="<?php echo getUrl(); ?>caixa.php?cad=opcao-mesa" class="opcao-mesa">opção de mesa</a></li>
            <li id="liMais">
            	<a href="javascript:void(0);" id="aLiMais" class="180">mais</a>
                <ul></ul>
            </li>
        </ul><!--fecha menu cadastro-->
        <div id="troca_cadastros" class="sel_aba_prod">
        <?php
		if(!isset($_GET['cad']) OR $cad=='comanda-cliente'){
		include("_include/comanda-cliente.php");
		 }elseif($cad=='opcao-mesa'){
			include('_include/opcao-mesa.php');
		 }elseif($cad=='cadastro-clientes'){
			include('_include/cadastro-clientes.php');
		 }else{
			echo '<h2 style=" text-transform:uppercase; float:left; margin:40px 20px;">opção de caixa não encontrada !</h2>';
		 }
		 ?>
        </div><!--fecha troca cadastros-->
        <div id="loadingOne"></div>
    </div><!--cont_cadastros-->
</div><!--.cAlign-->
<?php include('_include/footer.php');
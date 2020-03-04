<?php 
include("_include/header.php");
$cc=(isset($_GET['cad']))?strtolower($_GET['cad']):"novas-contas"; 
?>
 
    <div id="cont_cadastros">
        <div id="topo_cadastros">        
        	<h1 id="h_cadastros">contas de clientes</h1>
        </div><!--topo_cadastros-->
        
        <ul id="menu_caixa_bar" class="aba-caixa-bar" style="margin-bottom:20px;">        
        	<li id="liAbaNoCli" <?php if($cc=='novas-contas'){ echo 'class="cadastro_ativo"';} ?> ><a href="<?php echo getUrl(); ?>contas-clientes.php?cad=novas-contas" class="novas-contas">contas de clientes</a></li>
            <li id="liClienteConta" <?php if($cc=='cadastro-clientes-contas'){ echo 'class="cadastro_ativo" style=" display:block;"';} ?> ><a href="<?php echo getUrl(); ?>contas-clientes.php?cad=cadastro-clientes-contas" class="cadastro-clientes-contas">cadastrar clientes</a></li>
	        <li id="liAbaCtCli" <?php if($cc=='contas-abertas'){ echo 'class="cadastro_ativo"';} ?> ><a href="<?php echo getUrl(); ?>contas-clientes.php?cad=contas-abertas" class="contas-abertas">contas de clientes abertas</a></li>
            <li id="liMais">
            	<a href="javascript:void(0);" id="aLiMais" class="220">mais</a>
                <ul style="width:220px;"></ul>            
            </li>
        </ul><!--fecha menu cadastro-->
        
        <div id="troca_cadastros" class="sel_aba_prod">
        <?php		 
		if($cc=='novas-contas'){
		include("_include/novas-contas.php");		
		}elseif($cc=='contas-abertas'){			
			if(isset($_GET['cliente']) AND isset($_GET['cod'])){
			include("_include/contas-produtos.php");
			}else{
			include("_include/contas-abertas.php");
			}
		}elseif($cc=='cadastro-clientes-contas'){
		include('_include/cadastro-clientes.php');
		}else{
		echo '<h2 style=" text-transform:uppercase; float:left; margin:40px 20px;">opção de conta não encontrada !</h2>';	
		}
		 ?>
        </div><!--fecha troca cadastros-->
        <div id="loadingOne"></div>

    </div><!--fecha cont_cadastros-->

</div><!--.cAlign-->

<?php include('_include/footer.php');
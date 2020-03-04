<?php include("_include/header.php"); ?>
 
    <div id="cont_cadastros">
    	
        <div id="topo_cadastros">        
        	<h1 id="h_cadastros">clientes</h1>
            <?php if(in_array(1,$liberarPg) || in_array("cadastros",$liberarPg)){ ?>
            <span id="s_link_dere"><a href="<?php echo getUrl(); ?>cadastros.php">cadastrar cliente</a></span>
            <?php } ?>
        </div><!--topo_cadastros-->
        
        <div class="info_topo_cad" style="margin:15px 0 0 0;"><h1>alterar ou excluir clientes</h1></div><!--fecha info topo cad-->
        
        <?php		
            if(!isset($table) || $table!="ambientes"){
			include('_classes/Cadastros.class.php');
            }
			$count = Cadastros::countArray($user_id_empresa,'clientes');
		if($count>0){
		
		if(isset($_GET['pg']) AND $_GET['pg']!=0){
		$pagina = (int)$_GET['pg'];
		}else{
		$pagina = 1;
		}
		$maximo = 12;
		$inicio = $pagina - 1;
		$inicio = $maximo * $inicio;
		$menos = $pagina - 1;
		$mais = $pagina + 1;			
		$pgs = ceil($count / $maximo);
		$clientes = Cadastros::selectArray($user_id_empresa,'clientes',$inicio,$maximo);
		if($clientes['num']>0){
		 ?>
         
        <input type="hidden" value="<?php echo $pagina; ?>" id="pagina" />
        <input type="hidden" value="<?php echo $count; ?>" id="quantElemento" />
        <input type="hidden" value="clientes" id="qualPg" />
        
        <div id="cont_clientes">
        	
            <div id="linha_topo_clientes">
            	<div class="alinha_clientes_0"></div>
                <div class="alinha_clientes_1"><h2>código</h2></div>
                <div class="alinha_clientes_2"><h2>nome do cliente</h2></div>
                <div class="alinha_clientes_3"><h2>contatos</h2></div>
                <div class="alinha_clientes_4"><h2>comanda</h2></div>
                <div class="alinha_clientes_5"><h2>ação</h2></div>
            </div><!--linha_topo_clientes-->
            
            <div id="linha_clientes_busca" class="key_input">
	            <form method="post" action="">
            	<div class="alinha_clientes_0"></div>
                <div class="alinha_clientes_1"><input type="text" id="filtra_clientes_cod" onKeyPress="return SomenteNumero(event);" maxlength="11" autocomplete="off" /></div>
                <div class="alinha_clientes_2"><input type="text" id="filtra_clientes_nome" autocomplete="off" /></div>
                <div class="alinha_clientes_3"><input type="text" id="filtra_clientes_contato" autocomplete="off" /></div>
             	<div class="alinha_clientes_4"><input type="text" id="filtra_clientes_comanda" onKeyPress="return SomenteNumero(event);" autocomplete="off" /></div>
                <div class="alinha_clientes_5"><button type="submit" id="filtra_clientes_bus">filtrar</button></div>
                </form>
            </div><!--fecha linha_clientes-->
            
		<ul id="ul_linha_clientes" class="sel-input">
       		
		<?php 
        $num=0;        
        foreach($clientes['dados'] as $asClientes){
		$num+=1;
		echo '<li class="'.$asClientes['id'].'">
            	<div class="alinha_clientes_0"><input type="checkbox" id="lop-'.$num.'" value="'.$asClientes['id'].'" /></div>
                <div class="alinha_clientes_1"><p>'.$asClientes['id'].'</p></div>
                <div class="alinha_clientes_2"><p>'.limitiCaract($asClientes['nome'],50).'</p></div>
                <div class="alinha_clientes_3"><p class="p_fone p_tel">'.$asClientes['telefone'].'</p></div>
				<div class="alinha_clientes_4">';
				if($asClientes['comanda']<>""){
				echo '<p class="num_cmd_cliente"><a href="'.getUrl().'caixa.php?cad=comanda-cliente&fecharcomanda='.$asClientes['comanda'].'">'.$asClientes['comanda'].'</a></p>';
				}else{
				echo '<p>sem comanda</p>';
				}
				echo '</div>
                <div class="alinha_clientes_5">
					<p>
						<span>[ <a href="javascript:void(0);" class="editaEstCli">editar</a> ]</span> 
						<span>[ <a href="javascript:void(0);" class="deletarClientes">excluir</a> ]</span>
					</p>
				</div>
            </li>';
			}
			?>
        </ul><!-- fecha linha clientes-->
        </div><!--fecha clientes-->
        <div id="editeTudo">
            <label>
                <input id="todos-check" type="checkbox" />
                <span id="selTudo">Selecionar todos</span>
            </label>		
            <span class="spanLink">[ <a id="editarTudo" href="javascript:void(0);">Editar todos selecionados</a> ]</span>
		    <span class="spanLink">[ <a id="apagaTudo" href="javascript:void(0);">Apagar todos selecionados</a> ]</span>
		</div>
        
        <?php
		if($pgs>1){
        ?>
		<div id="pgTudo">
			<div class="bt_pg" id="d_pri" <?php if($menos==0){ echo 'style="display:none;"';} ?>><a href="<?php echo getUrl(); ?>clientes.php?pg=1" class="1">Primeiro</a></div>
			<div class="bt_pg" id="d_ante" <?php if($menos<=1){ echo 'style="display:none;"';} ?>><a href="<?php echo getUrl(); ?>clientes.php?pg=<?php echo $menos; ?>" class="<?php echo $menos; ?>">Anterior</a></div>
			
    		<span id="select_produto">
            <span id="select_pg"><?php echo $pagina; ?></span>
            <span class="select_abre_bt" id="select_bt"></span>
            <ul>
            <?php
            	for($i=1;$i <= $pgs;$i++) {
					echo '<li><a href="'.getUrl().'clientes.php?pg='.$i.'">'.$i.'</a></li>';
				}
            ?>
            </ul>
    	    </span>
	        <div class="bt_pg" id="d_pro" <?php if($mais>=$pgs){ echo 'style=" display:none;"';} ?>><a href="<?php echo getUrl(); ?>clientes.php?pg=<?php echo $mais; ?>" class="<?php echo $mais; ?>">Próxima</a></div>
	        <div class="bt_pg" id="d_ult" <?php if($mais>$pgs){ echo 'style=" display:none;"';} ?>><a href="<?php echo getUrl(); ?>clientes.php?pg=<?php echo $pgs; ?>" class="<?php echo $pgs; ?>">Último</a></div>
	    </div>
        <?php
		}
		}else{
			echo '<h2 class="h2ProdCliente">Página de cliente não existe !</h2>';
		}
	}else{
		echo '<h2 class="h2ProdCliente">Ainda não tem nenhum cliente cadastrado no sistema !</h2>';
	}
		
	?>

    </div><!--fecha cont_cadastros-->

</div><!--.cAlign-->

<?php include('_include/footer.php');
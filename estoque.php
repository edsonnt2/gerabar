<?php include("_include/header.php"); ?>
 
    <div id="cont_cadastros">

        <div id="topo_cadastros">        
        	<h1 id="h_cadastros">estoque</h1>        	
            <?php if(in_array(1,$liberarPg) || in_array("estoque",$liberarPg)){ ?>
            <span id="s_link_dere"><a href="<?php echo getUrl(); ?>cadastros.php?cad=produtos">cadastrar produto</a></span>            
            <?php } ?>
        </div><!--topo_cadastros-->
        
        <div class="info_topo_cad" style=" margin:15px 0 0 0;"><h1>alterar ou excluir produtos</h1></div><!--fecha info topo cad-->
        
        <?php		
            if(!isset($table) || $table!="ambientes"){
			include('_classes/Cadastros.class.php');
            }
			$count = Cadastros::countArray($user_id_empresa,'produtos');
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
			$produtos = Cadastros::selectArray($user_id_empresa,'produtos',$inicio,$maximo);
			
			if($produtos['num']>0){
		 ?>
         
        <input type="hidden" value="<?php echo $pagina; ?>" id="pagina" />
        <input type="hidden" value="<?php echo $count; ?>" id="quantElemento" />
        <input type="hidden" value="estoque" id="qualPg" />
        
        <div id="cont_estoque">
           <div id="linha_topo_estoque">
            	<div class="alinha_estoque_0"><div class="ali_borda"></div></div>
                <div class="alinha_estoque_1"><div class="ali_borda"><h2><span class="s_cod_esconde">cód. interno</span><span class="s_cod_mostra">código</span></h2></div></div>
                <div class="alinha_estoque_2"><div class="ali_borda"><h2>nome do produto</h2></div></div>
                <div class="alinha_estoque_3"><div class="ali_borda"><h2>categoria</h2></div></div>
                <div class="alinha_estoque_4"><div class="ali_borda"><h2>quant.</h2></div></div>
                <div class="alinha_estoque_5"><div class="ali_borda"><h2>valor de venda</h2></div></div>
                <div class="alinha_estoque_6"><div class="ali_borda"><h2>ação</h2></div></div>
            </div><!--linha_topo_estoque-->
            
            <div id="linha_estoque_busca" class="key_input">
            	<form method="post" action="">
            	<div class="alinha_estoque_0"><div class="ali_borda"></div></div>
                <div class="alinha_estoque_1"><div class="ali_borda"><input type="text" id="filtra_estoque_cod" onKeyUp="return SemEspaco(this);" maxlength="20" autocomplete="off" /></div></div>
                <div class="alinha_estoque_2"><div class="ali_borda"><input type="text" id="filtra_estoque_nome" autocomplete="off" /></div></div>
                <div class="alinha_estoque_3"><div class="ali_borda"><input type="text" id="filtra_estoque_cat" autocomplete="off" /></div></div>
                <div class="alinha_estoque_4"><div class="ali_borda"><input type="text" id="filtra_estoque_quant" onKeyPress="return SomenteNumero(event);" maxlength="11" autocomplete="off" /></div></div>
                <div class="alinha_estoque_5"><div class="ali_borda"><input type="text" id="filtra_estoque_val" class="for-val" onblur="if(this.value=='0,00')this.value='';" autocomplete="off" /></div></div>
                <div class="alinha_estoque_6"><div class="ali_borda"><button type="submit" id="filtra_estoque_bus">filtrar</button></div></div>
                </form>
            </div><!--fecha linha_estoque-->
            
		<ul id="ul_linha_estoque" class="sel-input">
        	<?php 
			$num=0;
			
			foreach($produtos['dados'] as $asProdutos){
				$num+=1;
				echo '<li class="'.$asProdutos['id'].'">
            	<div class="alinha_estoque_0"><div class="ali_borda"><input type="checkbox" id="lop-'.$num.'" value="'.$asProdutos['id'].'" /></div></div>
                <div class="alinha_estoque_1"><div class="ali_borda"><p>'.$asProdutos['codigo_interno'].'</p></div></div>
                <div class="alinha_estoque_2"><div class="ali_borda"><p>'.limitiCaract($asProdutos['marca'].' '.$asProdutos['descricao'].' ('.$asProdutos['unidade_venda'].')',52).'</p></div></div>
				<div class="alinha_estoque_3"><div class="ali_borda"><p>'.limitiCaract($asProdutos['categoria'],44).'</p></div></div>
                <div class="alinha_estoque_4"><div class="ali_borda"><p>'.$asProdutos['quantidade'].'</p></div></div>
                <div class="alinha_estoque_5"><div class="ali_borda"><p>r$ '.number_format($asProdutos['valor_varejo'],2,',','.').'</p></div></div>
                <div class="alinha_estoque_6"><div class="ali_borda"><p><span>[ <a href="javascript:void(0);" class="editaEstCli">editar</a> ]</span> <span>[ <a href="javascript:void(0);" class="deletarEstoque">excluir</a> ]</span></p></div></div>
            	</li>';
			}
			?>
            
        </ul><!-- fecha linha estoque-->
		
        </div><!--fecha estoque-->
        
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
			<div class="bt_pg" id="d_pri" <?php if($menos==0){ echo 'style="display:none;"';} ?>><a href="<?php echo getUrl(); ?>estoque.php?pg=1" class="1">Primeiro</a></div>
			<div class="bt_pg" id="d_ante" <?php if($menos<=1){ echo 'style="display:none;"';} ?>><a href="<?php echo getUrl(); ?>estoque.php?pg=<?php echo $menos; ?>" class="<?php echo $menos; ?>">Anterior</a></div>
			
    		<span id="select_produto">
            <span id="select_pg"><?php echo $pagina; ?></span>
            <span class="select_abre_bt" id="select_bt"></span>
            <ul>
            <?php
            	for($i=1;$i <= $pgs;$i++) {
					echo '<li><a href="'.getUrl().'estoque.php?pg='.$i.'">'.$i.'</a></li>';
				}
            ?>
            </ul>
    	    </span>
	        <div class="bt_pg" id="d_pro" <?php if($mais>=$pgs){ echo 'style=" display:none;"';} ?>><a href="<?php echo getUrl(); ?>estoque.php?pg=<?php echo $mais; ?>" class="<?php echo $mais; ?>">Próxima</a></div>
	        <div class="bt_pg" id="d_ult" <?php if($mais>$pgs){ echo 'style=" display:none;"';} ?>><a href="<?php echo getUrl(); ?>estoque.php?pg=<?php echo $pgs; ?>" class="<?php echo $pgs; ?>">Último</a></div>
	    </div>
        <?php
		}
		}else{
			echo '<h2 class="h2ProdCliente" >Página de protudo não existe !</h2>';
		}
	}else{
		echo '<h2 class="h2ProdCliente" >Ainda não tem nenhum produto cadastrado no sistema !</h2>';
	}
		
		?>

    </div><!--fecha cont_cadastros-->

</div><!--.cAlign-->

<?php include('_include/footer.php');
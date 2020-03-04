<?php if(isset($_POST['inclui'])){ function getUrl(){ return 'http://localhost/myforadmin/';} } ?>
<div id="cont_form_busca_cliente_comanda">			
            <div id="tudo_cmd_tudo_mesa" <?php if(isset($_GET['idMesa'])){ echo 'style="display:none;"';} ?>>
        	<div class="info_topo_cad"><h1>abrir ou fechar comanda mesa</h1></div><!--fecha info topo cad-->            
            <span id="s_openNext_mesa"><a href="<?php echo getUrl(); ?>caixa.php?cad=opcao-mesa&tdMesa=true">mostrar todas as mesas</a></span>            
            <div id="cont-sel-mesas" class="selMesaCaixa">            
			<form action="" method="post">            
        	<div class="linha_form">
            	<div class="d_alinha_form" style=" margin:0 0 5px 2px;">
                    <span><label for="bc_cmd_mesa">buscar por mesa:</label></span>
                    <input type="text" id="bc_cmd_mesa" onKeyPress="return SomenteNumero(event);" autocomplete="off" />
                    <div class="d_aviso_erro" id="erro_bc_cmd_mesa"><div class="d_ponta-erro"></div><p></p></div><!--d_aviso_erro-->
                </div>                
                <div class="d_alinha_form">
	                <span><label>&nbsp;</label></span>
                    <button type="submit" class="cd_envia_dados" id="envia_bc_cmd_mesa" title="ATALHO (ENTER)">buscar</button>
                    <input type="hidden" value="opcao-mesa" class="abaMesa2" id="pgAbaMesa" />
                </div>
            </div><!--fecha linha form-->            
            </form>
                <ul id="ul-mesas-abertas" class="list-mesas-ul"></ul>
                <div class="linha_form">
                <div class="d_alinha_form">
                    <a class="volta_mesas styleVolMesa" href="<?php echo getUrl(); ?>caixa.php?cad=opcao-mesa">voltar</a>
                </div>
                </div><!--fecha linha form-->                
            </div><!--#cont-sel-mesas-->            
            </div><!--fecha tudo_cmd_tudo_mesa-->
            <div id="tudo_cmd_mesa_caixa">            
            <div id="cont_mesa_paga">            
            <div class="info_topo_cad"><h1>busque por mesa para fazer pagamento</h1></div><!--fecha info topo cad-->            
            <form action="" method="post">        
        	<div class="linha_form">
            	<div class="d_alinha_form">
                    <span><label for="cd_consulta_cmd">buscar por mesa:</label></span>
                    <input type="text" id="cd_consulta_cmd" class="caixa_consulta_cmd" <?php if(isset($_GET['idMesa'])){ echo 'value="'.$_GET['idMesa'].'"';} ?>  onKeyPress="return SomenteNumero(event);" autocomplete="off" />
                    <div class="d_aviso_erro" id="erro_consulta_cmd"><div class="d_ponta-erro"></div><p></p></div><!--d_aviso_erro-->
                </div>                
                <div class="d_alinha_form">
	                <span><label>&nbsp;</label></span>
                    <button type="submit" class="cd_envia_dados" id="envia_cmd_consulta" title="ATALHO (ENTER)">buscar</button>
                </div>                
            </div><!--fecha linha form-->            
            </form>            
            </div><!--fecha cont_mesa_paga-->            
            <div id="cont_consulta_cmd" class="busca_comanda_mesa">
            <?php 
			if(isset($_GET['idMesa'])){
			$busca_cmd_bar='busca_comanda_mesa';
			$arraCmd=array($_GET['idMesa']);
			$inclu='';
			$id_empresa=$user_id_empresa;
            if($table=="usuarios"){
			include("_classes/Cadastros.class.php");
            }
			include("_include/lista-comanda.php"); 
			}
			?>  
            </div><!--cont_consulta_cmd-->            
            <div class="voltarTelaCx" id="voltarPagarCx" <?php if(isset($_GET['idMesa'])){ echo 'style="display:block;"';} ?> >
                <span class="volta_mesas" <?php if(isset($_GET['idMesa'])) echo 'style="margin-left:10px;"'; ?>><a href="javascript:void(0);">voltar</a></span>
                <span id="pagarTelaCx" <?php if(!isset($mostrabotao)){ echo 'style="display:none;"';} ?>><a href="javascript:void(0);" title="ATALHO (F2)">pagar mesa (F2)</a></span>
                <span id="descontarCx" <?php if(!isset($mostrabotao)){ echo 'style="display:none;"';} ?>><a href="javascript:void(0);" class="mesa|descontar" title="ATALHO (F3)">descontar (F3)</a></span>
                <span id="juntarPagaCx" <?php if(!isset($mostrabotao)){ echo 'style="display:none;"';} ?>><a href="javascript:void(0);">juntar mesa</a></span>
            </div><!--voltarTelaCx-->            
      </div><!--fecha tudo_cmd_mesa_caixa-->        
</div><!--fecha form cont_form_busca_cliente_comanda-->
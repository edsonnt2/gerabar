<div id="cont_form_busca_cliente_comanda">        
        	<div id="tudo_busc_cliente_caixa" <?php if(isset($_GET['fecharcomanda'])){ echo 'style="display:none;"';} ?>>            
        	<div class="info_topo_cad"><h1>ABRIR OU FECHAR COMANDA</h1></div><!--fecha info topo cad-->            
            <form action="" method="post">        
        	<div class="linha_form">
            	<div class="d_alinha_form" style=" margin-bottom:20px;">
                    <span><label for="cd_cliente_busca_cliente">buscar por cliente:</label></span>
                    <input type="text" id="cd_cliente_busca_cliente" autofocus="autofocus" placeholder="Busque por nome, cpf, rg, e-mail ou telefone..." autocomplete="off" />
                    <div class="d_aviso_erro" id="erro_cd_cliente_busca_cliente"><div class="d_ponta-erro"></div><p></p></div><!--d_aviso_erro-->
                </div>                
                <div class="d_alinha_form">
	                <span><label>&nbsp;</label></span>
                    <button type="submit" class="cd_envia_dados" id="envia_busc_cliente" title="ATALHO (ENTER)">buscar</button>
                </div>                
            </div><!--fecha linha form-->
            </form>
                <div id="cont_res_busc_cliente">
                    <div id="topo_resc_busc_cliente">
                        <div id="tp_nome_busc">nome completo</div>
                        <div id="tp_cpf_busc">cpf</div>
                        <div id="tp_rg_busc">rg</div>
                        <div id="tp_telefone_busc">telefone</div>
                        <div id="tp_acao_busc">ação</div>
                    </div><!--topo_resc_busc_cliente-->                    
                    <ul id="ul_resc_busc_cliente">
                    	<li id="carrega_busc_cliente"></li>
                    </ul><!--ul_consulta_cmd-->                    
             	</div><!--fecha cont_res_busc_cliente-->                
                <div id="sem_cliente_bus_cx"><h2>Cliente não cadastrado !</h2><p class="aba-caixa-bar">por favor, <a href="caixa.php?cad=cadastro-clientes" class="cadastro-clientes" id="abaLink" title="Novo Cliente">clique aqui</a> para cadastrar um novo cliente.</p></div>                
                <div class="voltarTelaCx" id="voltarBuscaTelaCx">
                    	<span id="voltarBuscaCx"><a href="javascript:void(0);">voltar</a></span>
                    </div><!--voltarTelaCx-->            
            </div><!--fecha tudo_busc_cliente_caixa-->
            <div id="tudo_cmd_cliente_caixa">                
            <div id="cont_fmt_cmd">            
            <div class="info_topo_cad"><h1>FAZER PAGAMENTO</h1></div><!--fecha info topo cad-->            
            <form action="" method="post">        
        	<div class="linha_form">
            	<div class="d_alinha_form">
                    <span><label for="cd_consulta_cmd">buscar por comanda:</label></span>
                    <div class="d_alinha_subbusca subCmdBar">
                    <input type="text" id="cd_consulta_cmd" class="caixa_consulta_cmd" <?php if(isset($_GET['fecharcomanda'])){ echo 'value="'.$_GET['fecharcomanda'].'"';} ?> onKeyPress="return SomenteNumero(event);" autocomplete="off" />
                    <div class="bt_subbusca" id="bt_consultaBusca" title="ATALHO (F1)"><span class="cd_consulta_cmd"></span></div>
                    </div><!--d_alinha_subbusca-->
                    <div class="d_aviso_erro" id="erro_consulta_cmd"><div class="d_ponta-erro"></div><p></p></div><!--d_aviso_erro-->
                </div>                
                <div class="d_alinha_form">
	                <span><label>&nbsp;</label></span>
                    <button type="submit" class="cd_envia_dados" id="envia_cmd_consulta" title="ATALHO (ENTER)">buscar</button>
                </div>                
            </div><!--fecha linha form-->            
            </form>            
            </div>
            <div id="cont_consulta_cmd" class="busca_comanda_bar">            
            <?php 
			if(isset($_GET['fecharcomanda'])){
			$busca_cmd_bar='busca_comanda_bar';
			$arraCmd=array($_GET['fecharcomanda']);
			$inclu='';
			$id_empresa=$user_id_empresa;
			$caixa=true;
            if($table=="usuarios"){
			include("_classes/Cadastros.class.php");
            }
			include("_include/lista-comanda.php"); 
			}
			?>
            </div><!--cont_consulta_cmd-->            
            <div class="voltarTelaCx" id="voltarPagarCx" <?php if(isset($_GET['fecharcomanda'])){ echo 'style="display:block;"';} ?> >
                <span id="voltarPagaCx" <?php if(!isset($mostrabotao)){ echo 'style="margin-left:55px;"';}else{ if(isset($_GET['fecharcomanda'])) echo 'style="margin-left:10px;"'; } ?>><a href="javascript:void(0);">voltar</a></span>
                <span id="pagarTelaCx" <?php if(!isset($mostrabotao)){ echo 'style="display:none;"';} ?>><a href="javascript:void(0);" title="ATALHO (F2)">pagar comanda (F2)</a></span>
                <span id="descontarCx" <?php if(!isset($mostrabotao)){ echo 'style="display:none;"';} ?>><a href="javascript:void(0);" class="comanda|descontar" title="ATALHO (F3)">descontar (F3)</a></span>
                <span id="juntarPagaCx" <?php if(!isset($mostrabotao)){ echo 'style="display:none;"';} ?>><a href="javascript:void(0);">juntar comanda</a></span>
                <span id="transferirConta" <?php if(!isset($mostrabotao)){ echo 'style="display:none;"';} ?>><a href="javascript:void(0);">transferir para conta</a></span>
            </div><!--voltarTelaCx-->            
            </div><!--fecha tudo_cmd_cliente_caixa-->        
        </div><!--fecha form cont_form_busca_cliente_comanda-->
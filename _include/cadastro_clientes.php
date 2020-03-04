<script type="text/javascript">
$(function(){
		$("#cd_cliente_data").mask("99/99/9999");
		$("#cliente_0_11").mask("999.999.999-99");
		$("#cliente_0_12").mask("99.999.999-9");
		$("#cliente_0_13").mask("99.999.999/9999-99");
		$(".for_tel").mask("(99) 99999-999?9");
	});
</script>
<div id="cont_form_cliente">        
        	<div class="info_topo_cad"><h1>dados pessoais</h1></div><!--fecha info topo cad-->            
            <form action="" method="post">        
        	<div class="linha_form">            
            	<div class="d_alinha_form">
                    <span><label for="cd_cliente_nome" class="obrigatorio">nome completo:</label></span>
                    <input type="text" id="cd_cliente_nome" autocomplete="off" autofocus="autofocus" />
                    <div class="d_aviso_erro" id="erro_cd_cliente_nome"><div class="d_ponta-erro"></div><p></p></div><!--d_aviso_erro-->
                </div>                
                <div class="d_alinha_form">
                    <span><label for="cd_cliente_data" class="obrigatorio">data nascimento:</label></span>
                    <input type="text" id="cd_cliente_data" placeholder="XX/XX/XXXX" autocomplete="off" />
                    <div class="d_aviso_erro" id="erro_cd_cliente_data"><div class="d_ponta-erro"></div><p></p></div><!--d_aviso_erro-->
                </div>                
                <div class="d_alinha_form">
                    <span><label for="cd_cliente_sexo" class="obrigatorio">sexo:</label></span>
                    <select id="cd_cliente_sexo">
                    	<option value="">SELECIONE</option>
                        <option value="H">HOMEM</option>
                        <option value="M">MULHER</option>
                    </select>
                    <div class="d_aviso_erro" id="erro_cd_cliente_sexo"><div class="d_ponta-erro"></div><p></p></div><!--d_aviso_erro-->
                </div>                
            </div><!--fecha linha form-->            
            <div class="div_tipo_pessoa" id="0_num">        
            	<div class="form_tipo_pessoa">
                	<h2>tipo pessoa:</h2>
                	<ul id="ul_qual_pessoa_0">
                    	<li style="border:0;"><span>Física</span></li>
                        <li style="display:none;" class="ult_pessoa"><span>Jurídica</span></li>
                        <span class="muda_pessoa muda_0"></span>
                    </ul>
                </div>                
                	<div id="0-pessoa_fisica" class="pessoa_ativo">					
					<div class="linha_form">        
						<div class="d_alinha_form">
							<span><label for="cliente_0_11">cpf:</label></span>
							<input type="text" id="cliente_0_11" class="i_cliente_cpf" placeholder="XXX.XXX.XXX-XX" autocomplete="off" />
							<div class="d_aviso_erro" id="erro_cliente_0_11"><div class="d_ponta-erro"></div><p></p></div><!--d_aviso_erro-->
						</div><!--fecha d_alinha_form-->						
						<div class="d_alinha_form">
							<span><label for="cliente_0_12">rg:</label></span>
							<input type="text" id="cliente_0_12" class="i_cliente_rg" placeholder="XX.XXX.XXX-X" autocomplete="off" />
							<div class="d_aviso_erro" id="erro_cliente_0_12"><div class="d_ponta-erro"></div><p></p></div><!--d_aviso_erro-->
						</div><!--fecha d_alinha_form-->											
					</div><!--fecha linha_form-->				
                </div><!--fecha pessoa física-->                
                <div id="0-pessoa_juridica" style="display:none;">				
					<div class="linha_form">        
						<div class="d_alinha_form">
							<span><label for="cliente_0_13">cnpj:</label></span>
							<input type="text" id="cliente_0_13" class="i_cliente_cnpj" placeholder="XX.XXX.XXX/XXXX-XX" autocomplete="off" />
							<div class="d_aviso_erro" id="erro_cliente_0_13"><div class="d_ponta-erro"></div><p></p></div><!--d_aviso_erro-->
						</div><!--fecha d_alinha_form-->						
						<div class="d_alinha_form">
							<span><label for="cliente_0_14">inscrição estadual:</label></span>
							<input type="text" id="cliente_0_14" class="i_cliente_estadual" autocomplete="off" />
							<div class="d_aviso_erro" id="erro_cliente_0_14"><div class="d_ponta-erro"></div><p></p></div><!--d_aviso_erro-->
						</div><!--fecha d_alinha_form-->											
					</div><!--fecha linha_form-->                
            	</div><!--fecha pessoa jurídica-->                
            </div><!-- fecha div tipo pessoa-->            
            <div class="info_topo_cad"><h1>contatos</h1></div><!--fecha info topo cad-->        
        	<div class="linha_form">            
            	<div class="d_alinha_form">
                    <span><label for="cd_cliente_tel">telefone:</label></span>
                    <input type="text" id="cd_cliente_tel" class="for_tel" placeholder="(XX) XXXXX-XXXX" autocomplete="off" />
                </div>                
                <div class="d_alinha_form">
                    <span><label for="cd_cliente_email">email:</label></span>
                    <input type="text" id="cd_cliente_email" placeholder="ex: nome@email.com" autocomplete="off" />
                    <div class="d_aviso_erro" id="erro_cd_cliente_email"><div class="d_ponta-erro"></div><p></p></div><!--d_aviso_erro-->
                </div>                
            </div><!--fecha linha form-->            
            <div class="linha_form">            
                <div class="d_alinha_form">
                	<button type="submit" class="cd_envia_dados" id="envia_clientes" title="ATALHO (ENTER)">cadastrar</button>
                </div>                
                <div class="d_alinha_form">                    
                	<button type="reset" class="cd_limpa_dados">limpar campos</button>
                </div>                
            </div><!--fecha linha form-->            
            </form>        
        </div><!--fecha form cliente-->
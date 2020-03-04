		<script type="text/javascript">
			$(function(){
				$(".for_data_filtro").mask("99/99/9999");
				
				//CALENDARIO ABERTO/FECHADO
				$( ".for_data_filtro" ).datepicker({
					showOn: "button",
					buttonImage: "_img/calendario.png",
					buttonImageOnly: true,
					buttonText: "Calendário",
					dateFormat: 'dd/mm/yy',
					dayNames: ['Domingo','Segunda','Terça','Quarta','Quinta','Sexta','Sábado'],
					dayNamesMin: ['Dom','Seg','Ter','Qua','Qui','Sex','Sáb','Dom'],
					dayNamesShort: ['D','S','T','Q','Q','S','S','D'],
					monthNames: ['Janeiro','Fevereiro','Março','Abril','Maio','Junho','Julho','Agosto','Setembro','Outubro','Novembro','Dezembro'],
					monthNamesShort: ['Jan','Fev','Mar','Abr','Mai','Jun','Jul','Ago','Set','Out','Nov','Dez'],
					nextText: 'Próximo',
					prevText: 'Anterior'
				});				
			});
			</script>
            <div class="d_tudo_filtro"<?php if($pgOndefiltra=="comandas-abertas"){ echo ' style="margin-bottom:10px;"';} ?> >
            	<div class="form_tudo_filtro" id="d_f_data">
                	<h2>FILTRAR POR:</h2>
                	<ul>
                    	<?php
						if($qualAtivo=="data"){
						echo '
						<li class="li_ativo_filtro"><span id="_data_inicio">Data</span></li>
                        <li class="li_hide"><span id="_busca_filtro">Busca</span></li>
                        <li class="li_hide"><span id="f_tudo">Mostrar tudo</span></li>';
						}elseif($qualAtivo=="busca"){
						echo '
                        <li class="li_ativo_filtro"><span id="_busca_filtro">Busca</span></li>
                        <li class="li_hide"><span id="f_tudo">Mostrar tudo</span></li>
						<li class="li_hide"><span id="_data_inicio">Data</span></li>';
						}else{
						echo '
                        <li class="li_ativo_filtro"><span id="f_tudo">Mostrar tudo</span></li>
						<li class="li_hide"><span id="_data_inicio">Data</span></li>
						<li class="li_hide"><span id="_busca_filtro">Busca</span></li>';
						}
						 ?>                    	
                        <span class="muda_filtro" id="f_data"></span>
                    </ul>
                </div>
                <?php if($pgOndefiltra!="mesas-abertas" && $pgOndefiltra!="caixas-abertos" && $pgOndefiltra!="caixas-fechados" && $pgOndefiltra!="vendas-abertas" && $pgOndefiltra!="vendas-fechadas" && $pgOndefiltra!="mesas-fechadas" && $pgOndefiltra!="contas-fechadas" && $pgOndefiltra!="contas-abertas"){ ?>
                <div class="form_tudo_filtro" id="d_f_entrada">
                	<h2 id="h_entrada" class="<?php echo $qualEntrada; ?>">POR ENTRADA:</h2>
                	<ul>
                    	<?php
						if($qualEntrada=="todas"){
						echo '
						<li class="li_ativo_filtro"><span id="entrada_todas">Todas</span></li>
                        <li class="li_hide"><span id="entrada_pagas">Pagas</span></li>
                        <li class="li_hide"><span id="entrada_free">Free</span></li>';
						}elseif($qualEntrada=="pagas"){
						echo '
                        <li class="li_ativo_filtro"><span id="entrada_pagas">Pagas</span></li>
                        <li class="li_hide"><span id="entrada_free">Free</span></li>
						<li class="li_hide"><span id="entrada_todas">Todas</span></li>';
						}else{
						echo '
                        <li class="li_ativo_filtro"><span id="entrada_free">Free</span></li>
						<li class="li_hide"><span id="entrada_todas">Todas</span></li>
						<li class="li_hide"><span id="entrada_pagas">Pagas</span></li>';
						}
						 ?>
                        <span class="muda_filtro" id="f_entrada"></span>
                    </ul>
                </div>                
                
                <?php } if($pgOndefiltra!="mesas-abertas" && $pgOndefiltra!="caixas-abertos" && $pgOndefiltra!="caixas-fechados" && $pgOndefiltra!="vendas-abertas" && $pgOndefiltra!="vendas-fechadas" && $pgOndefiltra!="mesas-fechadas"){ ?>
                
                <div class="form_tudo_filtro" id="d_f_sexo">
                	<h2 id="h_sexo" class="<?php echo $qualSexo; ?>">POR SEXO:</h2>
                	<ul>
                    	<?php
						if($qualSexo=="todas"){
						echo '
						<li class="li_ativo_filtro"><span id="sexo_todas">Selecione</span></li>
                        <li class="li_hide"><span id="sexo_h">Homem</span></li>
                        <li class="li_hide"><span id="sexo_m">Mulher</span></li>';
						}elseif($qualSexo=="h"){
						echo '
                        <li class="li_ativo_filtro"><span id="sexo_h">Homem</span></li>
                        <li class="li_hide"><span id="sexo_m">Mulher</span></li>
						<li class="li_hide"><span id="sexo_todas">Todas</span></li>';
						}else{
						echo '
                        <li class="li_ativo_filtro"><span id="sexo_m">Mulher</span></li>
						<li class="li_hide"><span id="sexo_todas">Todas</span></li>
						<li class="li_hide"><span id="sexo_h">Homem</span></li>';
						}
						 ?>
                        <span class="muda_filtro" id="f_sexo"></span>
                    </ul>
                </div>
                <?php } ?>
                <form method="post" action="">                
                <div class="linha_form">                
                <div id="d_filtro_i_data_inicio" class="fecha_tudo_filtro" <?php if($qualAtivo<>"data"){ echo 'style="display:none;"';} ?>>
        
						<div class="d_alinha_form">
                        	<input type="hidden" id="qualCad" class="<?php echo $qualAtivo; ?>" value="<?php echo $pgOndefiltra; ?>" />
                        	<input type="hidden" id="DBdataInicio" value="<?php echo $DBdataInicial; ?>" />
                            <input type="hidden" id="DBdataFinal" value="<?php echo $DBdataFinal; ?>" />
							<span><label for="i_data_inicio">de data:</label></span>
							<input type="text" id="i_data_inicio" class="for_data_filtro" value="<?php if($dataInicial<>false){echo $dataInicial;}else{ echo $DBdataInicial;} ?>" placeholder="__/__/____" name="dataInicial" autocomplete="off" />
							<div class="d_aviso_erro" id="erro_i_data_inicio"><div class="d_ponta-erro"></div><p></p></div><!--d_aviso_erro-->
						</div><!--fecha d_alinha_form-->
						
						<div class="d_alinha_form">
							<span><label for="i_data_final">até data:</label></span>
							<input type="text" id="i_data_final" class="for_data_filtro" value="<?php if($dataFinal<>false){echo $dataFinal;}else{ echo $DBdataFinal;} ?>" name="dataFinal" placeholder="__/__/____" autocomplete="off" />
							<div class="d_aviso_erro" id="erro_i_data_final"><div class="d_ponta-erro"></div><p></p></div><!--d_aviso_erro-->
						</div><!--fecha d_alinha_form-->
						
                </div><!--d_filtro_f_data-->
                
                <div id="d_filtro_i_busca_filtro" class="fecha_tudo_filtro" <?php if($qualAtivo<>"busca"){ echo 'style="display:none;"';} ?>>
                
						<div class="d_alinha_form">
							<span><label for="i_busca_filtro">busca:</label></span>
							<input type="text" id="i_busca_filtro" placeholder="Busque por nome, cpf, rg, e-mail, telefone e etc..." value="<?php if(isset($_GET['busca'])){echo $_GET['busca'];} ?>" autocomplete="off" />
							<div class="d_aviso_erro" id="erro_i_busca_filtro"><div class="d_ponta-erro"></div><p></p></div><!--d_aviso_erro-->
						</div><!--fecha d_alinha_form-->
                </div><!--d_filtro_f_busca-->                
                <div class="d_alinha_form fecha_tudo_filtro" id="d_daBusca" <?php if($qualAtivo=="tudo"){ echo 'style="display:none;"';} ?>>
	                <span><label>&nbsp;</label></span>
                    <button type="submit" class="cd_envia_dados" id="envia_filtro_openExit">filtrar</button>
                </div>
                <div class="d_alinha_p">
	                <p id="p_countCmd" style=" <?php if($qualAtivo=="busca"){ echo 'display:none;'; }elseif($qualAtivo=="tudo"){ echo 'margin-top:7px;';}else{ echo 'margin-top:29px;';} ?>"><?php 
                        
                        $qualTa=explode('-',$pgOndefiltra);
                        if($qualTa[0]=="mesas"){
                        $txtFiltra='mesa';
                        }elseif($qualTa[0]=="contas"){
                        $txtFiltra='conta';
                        }elseif($qualTa[0]=="vendas"){
                        $txtFiltra='venda';
                        }elseif($qualTa[0]=="caixas"){
                        $txtFiltra='caixa';
                        }else{
                        $txtFiltra='comanda';
                        }
                        
                        echo $countTudoAbreFecha; echo ($countTudoAbreFecha>1)?' '.$txtFiltra.'s encontradas':' '.$txtFiltra.' encontrada'; 
                        ?> </p>
                </div>
                
            </div><!--fecha linha form-->            
            </form>                
            </div><!--fecha d_tudo_filtro-->
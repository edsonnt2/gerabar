<?php include('_include/header_inicio.php'); ?>


<div class="cAlign">
<div id="form-H" style="float:left;">
<h1 style="margin-left:20px;">Finalize seu contrato</h1>
</div>
</div><!--.cAlign-->

</div><!--#topo-->


<div class="cAlign">
    
 
<div id="d_td_checkout"> 
    
    <div id="d_topo_checkout"><h2>CHECKOUT <span id="confi_check">- CONFIRMAÇÃO</span></h2></div><!--d_topo_checkout-->
    
    <div id="tudo_pagamento_check">
        
    <h2 class="h2_checkout">Plano a Contratar</h2>
    <div id="d_plano_checkout">
        <select id="s_plano">
            <option value="0"<?php if($planoContrata==1){ echo ' selected';} ?>>Plano Grátis - R$ 0,00</option>
            <option value="1"<?php if($planoContrata==2){ echo ' selected';} ?>>Plano Premium Anual - R$ 79,90</option>
            <option value="2"<?php if($planoContrata==3){ echo ' selected';} ?>>Plano Premium Mensal - R$ 14,90</option>
        </select>        
    </div><!--d_plano_checkout-->    
      
    <div id="tudo_plano_free"<?php if($planoContrata==1){ echo ' style="display:block;"';} ?> >
        <span class="botaoPagar"><a href="javascript:void(0);" id="concluirFree">CONCLUIR CONTRATO</a></span>
    </div><!--tudo_plano_free-->
        
    <div id="tudo_plano_premium"<?php if($planoContrata==1){ echo ' style="display:none;"';} ?> >
    
    <h2 class="h2_checkout">Informe seu Endereço</h2>    

    <div id="d_tudo_endereco">

        <div class="linha_form">

            <div class="d_alinha_form">
                <span><label for="pcd_cep">CEP:</label></span>
                <input type="text" id="pcd_cep" class="de_cep" value="" placeholder="XXXXX-XXX" onBlur="return BuscaCep(this.value,'pcd_cep','pcd_endereco','pcd_numero','pcd_bairro','pcd_cidade','pcd_estado');" />
                <div class="d_aviso_erro" id="erro_pcd_cep"><div class="d_ponta-erro"></div><p></p></div><!--d_aviso_erro-->
            </div>

            <div class="d_alinha_form">
                <span><label for="pcd_endereco">ENDEREÇO:</label></span>
                <input type="text" id="pcd_endereco" class="de_endereco" value="" />
                <div class="d_aviso_erro" id="erro_pcd_endereco"><div class="d_ponta-erro"></div><p></p></div><!--d_aviso_erro-->
            </div>

        </div><!--fecha linha form-->

        <div class="linha_form">

            <div class="d_alinha_form">
                <span><label for="pcd_numero">Nº:</label></span>
                <input type="text" id="pcd_numero" class="de_numero" onKeyPress="return SomenteNumero(event);" maxlength="10" />
                <div class="d_aviso_erro" id="erro_pcd_numero"><div class="d_ponta-erro"></div><p></p></div><!--d_aviso_erro-->
            </div>

            <div class="d_alinha_form">
                <span><label for="pcd_comple" class="naoObrigatorio">COMPLEMENTO:</label></span>
                <input type="text" id="pcd_comple" class="de_comple" value="" />
            </div>

            </div><!--fecha linha form-->

        <div class="linha_form">

            <div class="d_alinha_form">
                <span><label for="pcd_bairro">BAIRRO:</label></span>
                <input type="text" id="pcd_bairro" class="de_bairro" value="" />
                <div class="d_aviso_erro" id="erro_pcd_bairro"><div class="d_ponta-erro"></div><p></p></div><!--d_aviso_erro-->
            </div>

            <div class="d_alinha_form">
                <span><label for="pcd_cidade">CIDADE:</label></span>
                <input type="text" id="pcd_cidade" class="de_cidade" value="" />
                <div class="d_aviso_erro" id="erro_pcd_cidade"><div class="d_ponta-erro"></div><p></p></div><!--d_aviso_erro-->
            </div>

            <div class="d_alinha_form">
                <span><label for="pcd_estado">ESTADO:</label></span>

                <select id="pcd_estado" class="de_estado">
                    <option value="">UF</option>
                    <?php                $esta=array('','AC','AL','AM','AP','BA','CE','DF','ES','GO','MA','MG','MS','MT','PA','PB','PE','PI','PR','RJ','RN','RO','RR','RS','SC','SE','SP','TO');
                       for($m=1;$m<=27;$m++){
                       echo'<option value="',$esta[$m],'">',$esta[$m],'</option>';
                       }
                    ?>
                </select>
                <div class="d_aviso_erro" id="erro_pcd_estado"><div class="d_ponta-erro"></div><p></p></div><!--d_aviso_erro-->
            </div>

        </div><!--fecha linha form-->

    </div><!--d_tudo_entrega-->
    
    <div id="d_final_checkout">
    
    <h2 class="h2_checkout" id="link_teste">teste Forma de Pagamento</h2>
        
        <ul id="u_forma_checkout">
            <li><a href="javascript:void(0);" id="pg-cartao">CARTÃO DE CRÉDITO</a></li>
            <li id="li_boleto_hide"<?php if($planoContrata==3){ echo ' style="display: block;"'; } ?> ><a href="javascript:void(0);" id="pg-boleto">BOLETO BANCÁRIO</a></li>
        </ul><!--u_forma_checkout-->
        
            <?php            
             if($planoContrata==1){ 
                 $subTotal='0';
            }elseif($planoContrata==2){
                 $subTotal='79.9';
            }elseif($planoContrata==3){
                 $subTotal='14.9';
             }else{
                 $subTotal='0';
             } ?>
        
        <h1 id="h_valor_total">VALOR TOTAL DA COMPRA: <?php echo '<span class="'.$subTotal.'">R$ '.number_format($subTotal,2,',','.').'</span>'; ?></h1>
        
        <div id="d_cartao_checkout" class="fechaPaga">
            
            <div class="d_amb_pagseguro">
            <h2>Você está em um ambiente seguro:</h2>
            <img src="<?php echo getUrl(); ?>_img/pagseguro.png" />
            </div>
            
            <form method="post" action="">
                
                <div class="linha_form">

                    <div class="d_alinha_form">
                    <span><label for="pg_nome">NOME DO TITULAR:</label></span>
                    <input type="text" id="pg_nome" placeholder="(Como impresso no cartão)" />
                    <div class="d_aviso_erro" id="erro_pg_nome"><div class="d_ponta-erro"></div><p></p></div><!--d_aviso_erro-->
                    </div>

                    <div class="d_alinha_form">
                    <span><label for="pg_diaNasc">DATA DE NASCIMENTO DO TITULAR:</label></span>

                    <select id="pg_diaNasc">
                    <option value="">DIA:</option>
                    <?php
                    $data=date('d/m/Y',strtotime($user_nascimento));

                    if($data=='01/01/1111'){
                    $diaNasc='';
                    $mesNasc='';
                    $anoNasc='';
                    }else{
                    $dataEx=explode('/',$data);
                    $diaNasc=$dataEx[0];
                    $mesNasc=$dataEx[1];
                    $anoNasc=$dataEx[2];				
                    }

                    for($d=1;$d<=31;$d++){
                        if($d<10){$dia = '0'.$d;}else{$dia = $d;}
                        echo '<option value="'.$dia.'"'; if((int)$diaNasc==$d){ echo ' selected="selected"';} echo '>'.$dia.'</option>';
                    }
                    ?>
                    </select>

                    <select id="pg_mesNasc">
                    <option value="">MÉS:</option>
                    <?php
                    $mes = array('','Janeiro','Fevereiro','Março','Abril','Maio','Junho','Julho','Agosto','Setembro','Outubro','Novembro','Dezembro');
                    for($m=1;$m<=12;$m++){
                    if($m<10){$mm = '0'.$m;}else{$mm = $m;}
                    echo '<option value="'.$mm.'"'; if((int)$mesNasc==$m){ echo ' selected="selected"';} echo '>'.$mes[$m].'</option>';
                    }
                     ?>
                    </select>

                    <select id="pg_anoNasc">
                    <option value="">ANO:</option>
                    <?php
                    for($ano=date('Y');$ano>=(date('Y')-100);$ano--){
                    echo '<option value="'.$ano.'"'; if($anoNasc==$ano){ echo ' selected="selected"';} echo '>'.$ano.'</option>';
                    }
                    ?>            
                    </select>
                    <div class="d_aviso_erro" id="erro_pg_nascimento"><div class="d_ponta-erro"></div><p></p></div><!--d_aviso_erro-->

                    </div>
                    
                </div><!--fecha linha form-->
                    

                <div class="linha_form">

                    <div class="d_alinha_form">
                    <span><label for="pg_cpf">CPF DO TITULAR:</label></span>
                    <input type="text" id="pg_cpf" class="f_cpf" placeholder="XXX.XXX.XXX-XX" />
                    <div class="d_aviso_erro" id="erro_pg_cpf"><div class="d_ponta-erro"></div><p></p></div><!--d_aviso_erro-->
                    </div>
                    
                    <div class="d_alinha_form">
                    <span><label for="pg_tel">TELEFONE DO TITULAR:</label></span>
                    <input type="text" id="pg_tel" class="f_tel" placeholder="(XX) XXXX-XXXX" />
                    <div class="d_aviso_erro" id="erro_pg_tel"><div class="d_ponta-erro"></div><p></p></div><!--d_aviso_erro-->
                    </div>

                </div><!--fecha linha form-->

                <div class="linha_form">

                    <div class="d_alinha_form">
                    <span><label for="pg_numCartao">NÚMERO DO CARTÃO:</label></span>
                    <input type="text" id="pg_numCartao" onKeyPress="return SomenteNumero(event);" maxlength="16" />
                    <div class="d_aviso_erro" id="erro_pg_numCartao"><div class="d_ponta-erro"></div><p></p></div><!--d_aviso_erro-->
                    </div>

                    <div class="d_alinha_form">

                    <ul id="ul_bandeira_card">
                    <li id="carrega_band"></li>
                    <li id="li_visa"><img src="<?php echo getUrl(); ?>_img/ico_visa.png" /></li>
                    <li id="li_mastercard"><img src="<?php echo getUrl(); ?>_img/mastercard1.png" /></li>
                    <li id="li_elo"><img src="<?php echo getUrl(); ?>_img/ico_elo.gif" /></li>
                    <li id="li_amex"><img src="<?php echo getUrl(); ?>_img/ico_american.png" /></li>
                    <li id="li_diners"><img src="<?php echo getUrl(); ?>_img/ico_diners.png" /></li>
                    <li id="li_hipercard"><img src="<?php echo getUrl(); ?>_img/ico_hipercard.png" /></li>
                    </ul>
                    <div class="d_aviso_erro" id="erro_ul_bandeira_card"><div class="d_ponta-erro"></div><p></p></div><!--d_aviso_erro-->
                    </div>

                </div><!--fecha linha form-->
                

                <div class="linha_form">

                    <div class="d_alinha_form">
                    <span><label for="pg_mesVal">DATA DE VALIDADE:</label></span>

                    <select id="pg_mesVal">
                    <option value="">MÊS:</option>
                    <?php
                    for($i=1; $i<13; $i++){
                    if($i<10){
                    $mes = '0'.$i;
                    }else{
                    $mes = $i;
                    }
                    echo '<option value="'.$mes.'">'.$mes.'</option>';
                    }
                    ?>
                    </select>

                    <select id="pg_anoVal">
                    <option value="">ANO:</option>
                    <?php
                    $anofim = date('Y')+10;
                    for($ano=date('Y'); $ano<=$anofim; $ano++){
                    echo '<option value="'.$ano.'">'.$ano.'</option>';
                    }
                    ?>
                    </select>
                    <div class="d_aviso_erro" id="erro_validade"><div class="d_ponta-erro"></div><p></p></div><!--d_aviso_erro-->

                    </div>

                    <div class="d_alinha_form">
                    <span><label for="pg_cvvCartao">CÓDIGO DE SEGURANÇA:</label></span>
                        
                    <div class="d_codCartao">
                    <input type="text" id="pg_cvvCartao" onKeyPress="return SomenteNumero(event);" maxlength="3" />
                    <span id="s_cod_cartao"><!--codigo do cartão--></span>
                        <div id="d_ajuda_cod_cartao">
                        <span id="s_ponta_cartao"></span>
                        <p>O código de segurança é um número de 3 dígitos que se encontra no verso do seu cartão de crédito.</p>                            
                        </div>
                    </div><!--d_codCartao-->
                        
                    <div class="d_aviso_erro" id="erro_pg_cvvCartao" style="margin-top: 34px;"><div class="d_ponta-erro"></div><p></p></div><!--d_aviso_erro-->
                    </div>    

                </div><!--fecha linha form-->
                

                <div class="linha_form">

                    <div class="d_alinha_form">
                    <span><label>PARCELAMENTO:</label></span>
                    <div id="pg_parcela">1x de <span>R$ <?php echo number_format($subTotal,2,',','.'); ?></span></div>                    
                    </div>

                </div><!--fecha linha form-->

                <div class="linha_form">

                    <div class="d_alinha_form">
                    <button type="submit" class="cd_envia_dados" id="envia_pagarConta">CONTRATAR</button>
                    <input type="hidden" id="tokenPagSeguro" value="" />
                    <input type="hidden" id="IdDaSessao" value="" />
                    </div>
                    
                </div><!--fecha linha form-->
                
            </form>
            
        </div><!--d_cartao_checkout-->
        
        
        <div id="d_boleto_checkout" class="fechaPaga">
            
            <form method="post" action="">
            
            <div class="linha_form">

                <div class="d_alinha_form">
                <span><label for="cpf_boleto">CPF:</label></span>
                <input type="text" id="cpf_boleto" class="f_cpf" placeholder="XXX.XXX.XXX-XX" />
                <div class="d_aviso_erro" id="erro_cpf_boleto"><div class="d_ponta-erro"></div><p></p></div><!--d_aviso_erro-->
                </div>

                <div class="d_alinha_form">
                <span><label for="tel_boleto">TELEFONE:</label></span>
                <input type="text" id="tel_boleto" class="f_tel" placeholder="(XX) XXXX-XXXX" />
                <div class="d_aviso_erro" id="erro_tel_boleto"><div class="d_ponta-erro"></div><p></p></div><!--d_aviso_erro-->
                </div>

            </div><!--fecha linha form-->

            <div class="caixaPaga">

                <p>* Por favor verifique se o bloqueador de janelas pop-op está desativado para permitir a abertura da janela do seu banco.</p>
                <p>* Esse boleto poderá ser pago em qualquer banco conveniado, casas lotéricas ou pelo seu Internet Banking.</p>
                <p>* A confirmação do pagamento se dá de forma automática em até 2 dias úteis.</p>
                <p>* Boleto gerado e homologado pelo pagSeguro.</p>

            </div><!--caixaPaga-->
                
            <div class="linha_form">
                <div class="d_alinha_form">
                <button type="submit" class="cd_envia_dados" id="gerarBoleto">GERAR BOLETO</button>
                </div>
            </div><!--fecha linha form-->
                
            </form>
            
            <?php
            /*
            <h1 class="h_indisponivel">Pagamento com boleto indisponível no momento !</h1>
            <p class="nomeGrande">Clique no botão abaixo para gerar o boleto bancário</p>
            
            <span class="botaoPagar"><a href="javascript:void(0);" id="gerarBoleto">GERAR BOLETO</a></span>
            */
            ?>
        </div><!--d_cartao_checkout-->
        
    </div><!--d_final_checkout-->
        
    </div><!--tudo_plano_premium-->
        
    </div><!--tudo_pagamento_check-->
    
    
    <div id="tudo_confirma_check">
        
        <h2 class="h2_checkout">Plano à Contratar</h2>
        
        <div class="d_conf_dentro">
            <h2 id="valorPlanoContrato"></h2>            
        </div>
        
        <h2 class="h2_checkout">Endereço Informado</h2>
        
        <div class="d_conf_dentro">
            <p class="pTop"></p>
            <p class="pBottom"></p>
        </div>
        
        
        <h2 class="h2_checkout">Forma de Pagamento</h2>        
        
        <div class="d_conf_dentro" id="cont_confirm_cartao">
            
            <div>            
            <span class="s_conf1">Nome do Titular:</span>
            <span class="s_conf2" id="d_nome_t"></span>
            </div>
            <div>
            <span class="s_conf1">Data de Nascimento do Titular:</span>
            <span class="s_conf2" id="d_data_nasc_t"></span>
            </div>
            <div>
            <span class="s_conf1">Telefone do Titular:</span>
            <span class="s_conf2" id="d_tel_t"></span>
            </div>
            <div>
            <span class="s_conf1">CPF do Titular:</span>
            <span class="s_conf2" id="d_cpf_t"></span>
            </div>
            <div>
            <span class="s_conf1">Número do Cartão:</span>
            <span class="s_conf2" id="d_num_t"></span>
            <span class="s_conf2" id="d_band_t"></span>
            </div>
            <div>
            <span class="s_conf1">Data de Validade:</span>
            <span class="s_conf2" id="d_data_val_t"></span>
            </div>
            <div>
            <span class="s_conf1">Código de Seguraça:</span>
            <span class="s_conf2" id="d_cvv_t"></span>
            </div>
            <div>
            <span class="s_conf1">Parcelamento:</span>
            <span class="s_conf2" id="d_parc_t"></span>
            </div>
            
        </div>
        
        <a href="javascript:void(0);" id="voltar_cartao">VOLTAR</a>
        <a href="javascript:void(0);" id="finalizar_compra">FINALIZAR CONTRATO</a>
    </div><!--tudo_confirma_check-->
    
    <div id="d_tudo_compra_feita"></div><!--d_tudo_compra_feita-->
    
	
</div><!--d_td_checkout-->

</div><!--.cAling-->

<script type="text/javascript" src="https://stc.pagseguro.uol.com.br/pagseguro/api/v2/checkout/pagseguro.directpayment.js"></script>

<?php include('_include/footer_inicio.php'); ?>
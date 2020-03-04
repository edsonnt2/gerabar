<?php
$disabled='';
if($abrirFecharCx=="reabrir_caixa"){
    $txtTopo='RE';
    $txtTopo1='FAZER SANGRIA DO CAIXA';
    $reabrir=AbrirFecharCaixa::reabrirCaixa($id_empresa,$fechada_por);    
    if($reabrir['num']>0){
        $style=' style="text-transform: none; line-height: 18px; padding-bottom: 5px;"';
        $txt2='Caixa fechado com <span>R$ '.number_format($reabrir['dados']['pago_dinheiro'],2,',','.').'</span> mais <span>R$ '.number_format($reabrir['dados']['troco'],2,',','.').'</span> de troco em dinheiro e <span>R$ '.number_format($reabrir['dados']['pago_cartao'],2,',','.').'</span> no cartão.';
        $valTroco=number_format($reabrir['dados']['troco'],2,',','.');
        $valLimite=number_format($reabrir['dados']['limite_caixa'],2,',','.');
        $disabled=' disabled="disabled"';
    }else{
        $txt2='REABRIR CAIXA PARA '.$noneOpera;
    }
    $idReabrir='i_reabrir_caixa';
    }else{
        $txtTopo1='ABRIR CAIXA';
        $txt2='ABRIR CAIXA PARA '.$noneOpera;
        $idReabrir='i_abrir_caixa';
    }
?>
    <script type="text/javascript">
$(function(){		
	$('.for_cx').priceFormat({
	prefix: '',
	centsSeparator: ',',
	thousandsSeparator: '.'
	});
});
</script>
    
<div id="abrirCaixa-dentro">
    <div id="abrirCaixa-topo"><span><?php echo $txtTopo1; ?></span></div><!--tranferi-centro-->
    <div id="abrirCaixa-cima">
        
        <h2 id="add_nome_caixa"<?php echo $style; ?>><?php echo $txt2; ?></h2>
            <form method="post" action="">
                
            <div class="linha_form">
                <div class="d_alinha_form" style="margin-left:10px;">
                    <span><label for="i_troco_cx"><?php if($abrirFecharCx=="a_abrir_caixa") echo 'Coloque '; ?>Valor de Troco:</label></span>
                    <input type="text" id="i_troco_cx" class="for_cx"<?php echo $disabled; ?> value="<?php echo $valTroco; ?>" onfocus="if(this.value=='0,00')this.value='';" autocomplete="off" />
                    <div class="d_aviso_erro" id="erro_i_troco_cx"><div class="d_ponta-erro"></div><p></p></div><!--d_aviso_erro-->
                </div>

                <div class="d_alinha_form" style="margin-left:10px;">
                    <span><label for="i_limiti_cx"><?php if($abrirFecharCx=="a_abrir_caixa") echo 'Coloque '; ?>Limite do Caixa:</label></span>
                    <input type="text" id="i_limiti_cx" class="for_cx" value="<?php echo $valLimite; ?>" onfocus="if(this.value=='0,00')this.value='';" autocomplete="off" />
                    <div class="d_aviso_erro" id="erro_i_limiti_cx"><div class="d_ponta-erro"></div><p></p></div><!--d_aviso_erro-->
                </div>
                
            </div><!--fecha linha form-->
                
            <div class="linha_form">    
                <div class="d_alinha_form" style="margin-left:10px;">
                	<button type="submit" class="cd_envia_dados" id="<?php echo $idReabrir; ?>" ><?php echo $txtTopo; ?>ABRIR CAIXA</button>
                </div>
            </div><!--fecha linha form-->
            
            </form>
    </div><!--abrirCaixa-cima-->
    <div
     id="abrirCaixa-baixo">
        <span id="voltar-abrirCaixa"><a href="javascript:void(0);">VOLTAR</a></span>            
    </div><!--abrirCaixa-baixo-->
</div><!--abrirCaixa-dentro-->
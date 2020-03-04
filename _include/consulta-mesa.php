<div id="cont_form_comanda">
    <div class="info_topo_cad"><h1>consulta de mesa</h1></div><!--fecha info topo cad-->
    <form action="" method="post">
    <div class="linha_form">
        <div class="d_alinha_form">
            <span style="margin-bottom:5px;"><label for="cd_consulta_cmd">busque por mesa:</label></span>
            <input type="text" id="cd_consulta_cmd" onKeyPress="return SomenteNumero(event);" autocomplete="off" />
            <div class="d_aviso_erro" id="erro_consulta_cmd"><div class="d_ponta-erro"></div><p></p></div><!--d_aviso_erro-->
        </div>
        <div class="d_alinha_form">
        <span style="margin-bottom:5px;"><label>&nbsp;</label></span>
            <button type="submit" class="cd_envia_dados formConsu" id="envia_cmd_consulta" title="ATALHO (ENTER)">consultar</button>
        </div>
    </div><!--fecha linha form-->
    </form>
<div id="cont_consulta_cmd" class="busca_comanda_mesa"></div><!--cont_consulta_cmd-->
</div><!--fecha form comanda-->
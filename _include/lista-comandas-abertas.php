<div id="cont_cmd_abertaFechada">

<div id="topo_cmd_abertaFechada">
    <?php
    
    if($pgOndefiltra=="mesas-abertas"){
        echo '<div id="tp_nome_cmd" class="abre_com_mesa">comanda mesa</div>';
    }elseif($pgOndefiltra=="vendas-abertas"){
        echo '<div id="tp_nome_cmd" class="abre_com_mesa">operador</div>';
    }else{
        echo '<div id="tp_nome_cmd">nome completo</div>
    <div id="tp_comanda_cmd">comanda</div>';
    }
    
    ?>
    <div id="tp_valor_cmd" class="<?php echo $pgOndefiltra; ?>">valor total</div>
    <div id="tp_data_cmd">aberta em</div>
    <div id="tp_acao_cmd">ação</div>
</div><!--topo_resc_busc_cliente-->
<ul id="ul_cmd_abertaFechada">
    <?php
    
    if($pgOndefiltra=="mesas-abertas"){
    $campoDesc="idCMC";
    $txtDesc="cmd_mesa";
    $tblDesc="mesa";
    $funcGarcon="garcon";    
    $dataAberto="cadastro";
    $monstraEsconde="comanda";
        
    }elseif($pgOndefiltra=="vendas-abertas"){
    $campoDesc="garcon";
    $txtDesc="funcionario";
    $tblDesc="frente_caixa";
    $dataAberto="cadastro";
    $funcGarcon="funcionario";
    $monstraEsconde="venda";
    include($acres."_classes/Operadores.class.php");
    }else{
    $campoDesc="idCMC";
    $txtDesc="comanda";
    $tblDesc="comanda";
    $dataAberto="ultima_compra";
    $funcGarcon="garcon";
    $monstraEsconde="comanda";
    $valTotal=DB::getConn()->prepare("SELECT SUM(quantidade*valor) AS total FROM comandas WHERE comanda=? AND id_empresa=? AND idfechado=0");		
    }

    $valTotalDescontar=DB::getConn()->prepare("SELECT SUM(valor) AS total FROM descontar WHERE id_empresa=? AND ".$campoDesc."=? AND qualTBL=? AND idfechado=0");	

    foreach($cmdAbertas['dados'] as $AsCmdAberta){
        
        $valTotalDescontar->execute(array($idEmpresa,$AsCmdAberta[$txtDesc],$tblDesc));
        if($valTotalDescontar->rowCount()>0){
        $valorTotalDesc=$valTotalDescontar->fetch(PDO::FETCH_ASSOC);
        $valorTotalDesconto=$valorTotalDesc['total'];
        }else{
        $valorTotalDesconto=0;
        }
        
        if($pgOndefiltra=="vendas-abertas" || $pgOndefiltra=="mesas-abertas"){
        $valTopo=$AsCmdAberta['total'];
        $valorDaEntrada=0;
        }else{
        
        $valTotal->execute(array($AsCmdAberta['comanda'],$idEmpresa));
        if($valTotal->rowCount()>0){
        $valorTotal = $valTotal->fetch(PDO::FETCH_ASSOC);

        $valorTotalCmd = $valorTotal['total'];
        }else{
        $valorTotalCmd=0;
        }
        $valorDaEntrada=($AsCmdAberta['opc_entrada']=="")?'0.00':$AsCmdAberta['opc_entrada'];
        if($AsCmdAberta['vale_pedagio']=="sim"){$valorTotalCmd=$valorTotalCmd-$AsCmdAberta['valor_pedagio'];}
        if($AsCmdAberta['consuma']==0){
            $valorTotalCmd=$valorTotalCmd+$valorDaEntrada;
        }
        if($valorTotalCmd<$valorDaEntrada){
        $valorTotalCmd = $valorDaEntrada;
        }							
        $valTopo=($AsCmdAberta['pagar_entrada']==1)?$valorTotalCmd-$valorDaEntrada:$valorTotalCmd;
        }
        $valTopo-=$valorTotalDesconto;
        
    echo '<li>';
    if($pgOndefiltra=="vendas-abertas"){
    if($AsCmdAberta['funcionario']=='a'){
        $operador='Administrador';
    }elseif($AsCmdAberta['funcionario']=='isento'){
        $operador='Universal';
    }else{
    $selOpera=Operadores::selUmOperador($idEmpresa,$AsCmdAberta['funcionario']);
    $operador=($selOpera['num']>0)?$selOpera['dados']['nome_operador']:'(OPERADOR APAGADO)';
    }    
    $buscCmd=FrenteCaixa::selectFrente($idEmpresa,$AsCmdAberta['funcionario']);
    echo '<div id="li_nome_cmd" class="abre_com_mesa">'.limitiCaract($operador,47,false,false).'</div>';
    }elseif($pgOndefiltra=="mesas-abertas"){
        
    $buscCmd=Mesas::selMesaPagar($idEmpresa,$AsCmdAberta['cmd_mesa']);    
    $cmdMesa=($AsCmdAberta['cmd_mesa']<10)?'0'.$AsCmdAberta['cmd_mesa']:$AsCmdAberta['cmd_mesa'];
    echo '<div id="li_nome_cmd" class="abre_com_mesa">MESA <span>'.$cmdMesa.'</span></div>';
    }else{
    $buscCmd=Comandas::trazesCmdBar($idEmpresa,$AsCmdAberta['comanda']);
    echo '<span style=" display:none;" class="consumo-'.$AsCmdAberta['id'].'">'; echo ($AsCmdAberta['consuma']==1)?'1':'0'; echo'</span>
    <div class="li_nome_cmd">'.limitiCaract($AsCmdAberta['nome'],47,false,false).'</div>
    <div class="li_comanda_cmd"><a href="'.getUrl().'caixa.php?cad=comanda-cliente&fecharcomanda='.$AsCmdAberta['comanda'].'">'.$AsCmdAberta['comanda'].'</a></div>';
    }
    echo '<div class="li_valor_cmd">R$ <span class="sp_cmd_val-'.$AsCmdAberta['id'].'">'.number_format($valTopo,2,',','.').'</span></div>
    <div class="li_data_cmd"><span class="s_data_toda">'.date('d/m/Y H:i:s',strtotime($AsCmdAberta[$dataAberto])).'</span><span class="s_data_respansiva">'.date('d/m/Y',strtotime($AsCmdAberta[$dataAberto])).'</span></div>
    <div class="li_acao_cmd"><a href="javascript:void(0);" class="'.$AsCmdAberta['id'].'">mostrar <span class="s_'; 
                    if($monstraEsconde=="comanda"){ echo 'cmd';}elseif($monstraEsconde=="venda"){ echo 'venda';}else{'conta';}
                    echo '_mostrar">'.$monstraEsconde.'</span></a></div>
    
        <ul class="ul_mostra_comanda" id="cmdVer-'.$AsCmdAberta['id'].'">';
            $valTotalProd=0;
        
            if((isset($AsCmdAberta['opc_entrada']) AND $AsCmdAberta['opc_entrada']<>"") || $buscCmd['num']>0){
            echo '<li class="topo_mostra_comanda">
                <div class="tp_produto_comanda">produto</div>
                <div class="tp_garcon_comanda">garçon</div>
                <div class="tp_valUnitario_comanda">valor unit.</div>
                <div class="tp_quant_comanda">qtd</div>
                <div class="tp_valTotal_comanda">valor total</div>
                <div class="tp_dataHora_comanda">data e hora</div>
                <div class="tp_acao_comanda">ação</div>
            </li>';
            }
            foreach($buscCmd['dados'] as $asCmdBar){
                $valTotalCmd=$asCmdBar['quantidade']*$asCmdBar['valor'];
                $valTotalProd=$valTotalProd+$valTotalCmd;
                
                if($pgOndefiltra=="vendas-abertas"){
                    $nomeDoProd=($asCmdBar['id_produto']==0)?$asCmdBar['nome_produto'].' (diversos)':$asCmdBar['nome_produto'];
                }else{
                    $nomeDoProd=($asCmdBar['id_produto']==0)?$asCmdBar['descricao'].' '.$asCmdBar['marca']:$asCmdBar['marca'].' '.$asCmdBar['descricao'];
                }
                
                
            echo '<li id="liCmd-'.$asCmdBar['id'].'" class="'.$asCmdBar['id_produto'].'">
                <div class="li_tp_produto_comanda">'.limitiCaract($nomeDoProd,40).'</div>
                <div class="li_tp_garcon_comanda d_mostra_garcon"><span class="s_li_abreFecha_respansivo">garçon:&nbsp;</span> <span class="pega_mostra_garcon">'.$asCmdBar[$funcGarcon].'</span>
                    <div class="mostra_garcon loading-garcon">
                    <div class="ponta-info-func"></div>
                    <div class="cont-garcon"></div>
                    </div>
                </div>
                <div class="li_tp_valUnitario_comanda"><span class="s_li_abreFecha_respansivo">valor unit.:&nbsp;</span> R$ '.number_format($asCmdBar['valor'],2,',','.').'</div>
                <div class="li_tp_quant_comanda"><span class="s_li_abreFecha_respansivo">quant.:&nbsp;</span> <span class="numQuantDel">'.$asCmdBar['quantidade'].'</span></div>
                <div class="li_tp_valTotal_comanda"><span class="s_li_abreFecha_respansivo">valor total:&nbsp;</span> R$ <span id="pegaCmdVal-'.$asCmdBar['id'].'" class="'.$valTotalCmd.'">'.number_format($valTotalCmd,2,',','.').'</span></div>
                <div class="li_tp_dataHora_comanda">'.date('d/m/Y H:i:s',strtotime($asCmdBar['cadastro'])).'</div>
                <div class="li_tp_acao_comanda"><a href="javascript:void(0);" id="'.$asCmdBar['id'].'-'.$AsCmdAberta['id'].'-cmdId" class="cmd_delete" title="Excluir produto da comanda"></a></div>
            </li>';
            }
        
            if($pgOndefiltra=="vendas-abertas"){
            $funcDesconto=$AsCmdAberta['funcionario'];
            }elseif($pgOndefiltra=="mesas-abertas"){
            $funcDesconto=false;
            }else{
            $funcDesconto=false;
            if($AsCmdAberta['opc_entrada']<>""){
            echo '<li>
                <div class="li_tp_produto_comanda">';
                echo ($AsCmdAberta['consuma']==1)?'CONSUMAÇÃO DE R$ ':'ENTRADA NO VALOR DE R$ ';
                echo number_format($valorDaEntrada,2,',','.'); echo ($AsCmdAberta['pagar_entrada']==1)?' (pago)':''; echo '</div>
                <div class="li_tp_garcon_comanda d_mostra_garcon"><span class="s_li_abreFecha_respansivo">garçon:&nbsp;</span> <span class="pega_mostra_garcon">'.$AsCmdAberta['cmd_aberta_por'].'</span>
                    <div class="mostra_garcon loading-garcon">
                    <div class="ponta-info-func"></div>
                    <div class="cont-garcon"></div>
                    </div>
                </div>
                <div class="li_tp_valUnitario_comanda"><span class="s_li_abreFecha_respansivo">valor unit.:&nbsp;</span> R$ '; echo ($AsCmdAberta['pagar_entrada']==1)?'-':''; echo number_format($valorDaEntrada,2,',','.').'</div>
                <div class="li_tp_quant_comanda"><span class="s_li_abreFecha_respansivo">quant.:&nbsp;</span> 1</div>
                <div class="li_tp_valTotal_comanda"><span class="s_li_abreFecha_respansivo">valor total:&nbsp;</span> R$ '; echo ($AsCmdAberta['pagar_entrada']==1)?'-':''; echo number_format($valorDaEntrada,2,',','.').'</div>
                <div class="li_tp_dataHora_comanda">'.date('d/m/Y H:i:s',strtotime($AsCmdAberta['ultima_compra'])).'</div>
                <div class="li_tp_acao_comanda"></div>
            </li>';
            }

        if($AsCmdAberta['vale_pedagio']=="sim"){
            echo '<li>
            <div class="li_tp_produto_comanda">VALE CONSUMAÇÃO</div>
            <div class="li_tp_garcon_comanda d_mostra_garcon"><span class="s_li_abreFecha_respansivo">garçon:&nbsp;</span> <span class="pega_mostra_garcon">'.$AsCmdAberta['cmd_aberta_por'].'</span>
                <div class="mostra_garcon loading-garcon">
                <div class="ponta-info-func"></div>
                <div class="cont-garcon"></div>
                </div>
            </div>								
            <div class="li_tp_valUnitario_comanda"><span class="s_li_abreFecha_respansivo">valor unit.:&nbsp;</span> R$ -'.number_format($AsCmdAberta['valor_pedagio'],2,',','.').'</div>
            <div class="li_tp_quant_comanda"><span class="s_li_abreFecha_respansivo">quant.:&nbsp;</span> 1</div>
            <div class="li_tp_valTotal_comanda"><span class="s_li_abreFecha_respansivo">valor total:&nbsp;</span> R$ -'.number_format($AsCmdAberta['valor_pedagio'],2,',','.').'</div>
            <div class="li_tp_dataHora_comanda">'.date('d/m/Y H:i:s',strtotime($AsCmdAberta['ultima_compra'])).'</div>
            <div class="li_tp_acao_comanda"></div>
            </li>';
            $valTotalProd=$valTotalProd-$AsCmdAberta['valor_pedagio'];
        }
            }
        
        $descontar=Cadastros::trazerDescontar($idEmpresa,$AsCmdAberta[$txtDesc],$tblDesc,0,$funcDesconto);
        if($descontar['num']>0){
            foreach($descontar['dados'] as $asDescontar){
            echo '<li id="liCmdDesc-'.$asDescontar['id'].'" class="0">
            <div class="li_tp_produto_comanda">VALOR DESCONTADO</div>
            <div class="li_tp_garcon_comanda d_mostra_garcon"><span class="s_li_abreFecha_respansivo">garçon:&nbsp;</span> <span class="pega_mostra_garcon">'.$asDescontar['garcon'].'</span>
                <div class="mostra_garcon loading-garcon">
                <div class="ponta-info-func"></div>
                <div class="cont-garcon"></div>
                </div>
            </div>								
            <div class="li_tp_valUnitario_comanda"><span class="s_li_abreFecha_respansivo">valor unit.:&nbsp;</span> R$ -'.number_format($asDescontar['valor'],2,',','.').'</div>
            <div class="li_tp_quant_comanda"><span class="s_li_abreFecha_respansivo">quant.:&nbsp;</span> <span class="numQuantDel">1</span></div>								
            <div class="li_tp_valTotal_comanda"><span class="s_li_abreFecha_respansivo">valor total:&nbsp;</span> R$ <span id="pegaCmdValDesc-'.$asDescontar['id'].'" class="-'.$asDescontar['valor'].'">-'.number_format($asDescontar['valor'],2,',','.').'</span></div>								
            <div class="li_tp_dataHora_comanda">'.date('d/m/Y H:i:s',strtotime($asDescontar['cadastro'])).'</div>
            <div class="li_tp_acao_comanda"><a href="javascript:void(0);" id="'.$asDescontar['id'].'-'.$AsCmdAberta['id'].'-descontarId" class="cmd_delete" title="Excluir produto da comanda"></a></div>
            </li>';
            }
        }

            echo '<li class="li_valFinal_comanda" id="totalCada-'.$AsCmdAberta['id'].'">';
            if(isset($AsCmdAberta['consuma']) AND $AsCmdAberta['consuma']==1){
                $valTotalProd-=$valorTotalDesconto;
                if($valTotalProd<$valorDaEntrada){
                    $valResta = $valorDaEntrada-$valTotalProd;
                    if($AsCmdAberta['pagar_entrada']==1){
                    $novo=0;
                    echo '<div class="'.$valorDaEntrada.'">RESTA CONSUMIR R$ <span id="resto_val" class="'.$valResta.'">'.number_format($valResta,2,',','.').'</span> DA CONSUMAÇÃO<span id="valTotalComanda-'.$AsCmdAberta['id'].'" class="'.$valTotalProd.'" style="display:none;">'.number_format($novo,2,',','.').'</span></div>';
                    }else{ 
                    $novo=$valorDaEntrada;
                    echo '<div class="'.$novo.'">resta R$ <span id="resto_val" class="'.$valResta.'">'.number_format($valResta,2,',','.').'</span> DA CONSUMAÇÃO DE R$ <span id="valTotalComanda-'.$AsCmdAberta['id'].'" class="'.$valTotalProd.'">'.number_format($novo,2,',','.').'</span></div>';
                    }										
                }else{										
                    if($AsCmdAberta['pagar_entrada']==1){ $valTotalProd=$valTotalProd-$valorDaEntrada; $novo=0;}else{$novo=$valorDaEntrada;}
                    echo '<div class="'.$novo.'">valor total da comanda R$ <span id="valTotalComanda-'.$AsCmdAberta['id'].'" class="'.$valTotalProd.'">'.number_format($valTotalProd,2,',','.').'</span></div>';
                }
            }else{
                $valTotalProd=$valTotalProd+$valorDaEntrada;
                if($valTotalProd<$valorDaEntrada){
                $valTotalProd=$valorDaEntrada;
                }
                if(isset($AsCmdAberta['pagar_entrada']) AND $AsCmdAberta['pagar_entrada']==1){ $valTotalProd=$valTotalProd-$valorDaEntrada;}

                $valTotalProd-=$valorTotalDesconto;									
            echo '<div class="'.$valorDaEntrada.'">valor total '; echo ($monstraEsconde=="venda")?'do venda':'da comanda'; echo ' R$ <span id="valTotalComanda-'.$AsCmdAberta['id'].'" class="'.$valTotalProd.'">'.number_format($valTotalProd,2,',','.').'</span></div>';
            }
        echo '</li></ul><!--ul_mostra_comanda-->
    </li>';
} ?>
</ul><!--ul_cmd_abertaFechada-->
<?php
if($pgs>1){
?>
<div id="pgTudo" style="margin-top:30px;">
    <div id="d_pri" <?php if($menos==0){ echo 'style="display:none;"';} ?>><a href="<?php echo getUrl(); ?>administracao.php?cad=comandas-abertas<?php echo $linkData; ?>&pg=1" class="1">Primeiro</a></div>
    <div id="d_ante" <?php if($menos<=1){ echo 'style="display:none;"';} ?>><a href="<?php echo getUrl(); ?>administracao.php?cad=comandas-abertas<?php echo $linkData; ?>&pg=<?php echo $menos; ?>" class="<?php echo $menos; ?>">Anterior</a></div>
    <span id="select_produto" class="naofaz">
    <span id="select_pg"><?php echo $pagina; ?></span>
    <span class="select_abre_bt" id="select_bt"></span>
    <ul>
    <?php
        for($i=1;$i <= $pgs;$i++) {
            echo '<li><a href="'.getUrl().'administracao.php?cad=comandas-abertas'.$linkData.'&pg='.$i.'">'.$i.'</a></li>';
        }
    ?>
    </ul>
    </span>
    <div id="d_pro" <?php if($mais>=$pgs){ echo 'style=" display:none;"';} ?>><a href="<?php echo getUrl(); ?>administracao.php?cad=comandas-abertas<?php echo $linkData; ?>&pg=<?php echo $mais; ?>" class="<?php echo $mais; ?>">Próxima</a></div>
    <div id="d_ult" <?php if($mais>$pgs){ echo 'style=" display:none;"';} ?>><a href="<?php echo getUrl(); ?>administracao.php?cad=comandas-abertas<?php echo $linkData; ?>&pg=<?php echo $pgs; ?>" class="<?php echo $pgs; ?>">Último</a></div>
</div>
<?php } ?>
</div><!--fecha cont_cmd_abertaFechada-->
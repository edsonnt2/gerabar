<?php if(isset($_POST['inclui'])){ if(isset($_SESSION)==false){session_start(); }
		include('../_classes/DB.class.php');		
		function getUrl(){return 'http://localhost/myforadmin/';}
		
		if(!isset($_SESSION['Gerabar_uid']) || is_null($_SESSION['Gerabar_uid']) || empty($_SESSION['Gerabar_uid'])){
		include('../_classes/Login.class.php');
		$objLogin=new Login;
			if(!$objLogin->logado()){
			?>
			<script type="text/javascript">
            	$(function(){ red:window.location.href="<?php echo getUrl(); ?>"; });
            </script>
			<?php
			exit();
			}
		}
		$idDaSessao = $_SESSION['Gerabar_uid'];
        $planoAtivo=$_SESSION['Gerabar_plano'];
        include("../_classes/Empresas.class.php");
		}
?>

<div id="cont_plano_contratado">
    
    <h1 id="h1TopoUsuario">PLANO CONTRATADO</h1>    
    <?php
    
    $dadosAss=Empresas::selectPlano($idDaSessao);
    $getAss=$dadosAss['dados'];
    
     if($dadosAss['num']==0){
         echo '<div id="d_plano_gratis">
        <h2>Plano Grátis Contratado</h2>
        <span class="s_botao_conf_plano"><a href="'.getUrl().'planos.php">CONTRATE UM PLANO PREMIUM</a></span>
    </div><!--plano_gratis-->';
     }else{
         
         if($getAss['plano']==1){
             $txtPlano="Anual";
             $valPlano="79,90";
         }else{
             $txtPlano="Mensal";
             $valPlano="14,90";
         }
         $status_ass=$getAss['status_assinatura'];
         
        if($status_ass==1){
        $statusAss="AGUARDANDO PAGAMENTO";
        $btNovoContrato=true;
        }elseif($status_ass=="INITIATED"){
        $statusAss="PENDENTE";
        }elseif($status_ass=="PENDING" || $status_ass==2){
             $statusAss="EM ANÁLISE";
             $btNovoContrato=true;
        }elseif($status_ass=="ACTIVE"){
             $statusAss="ATIVO";
             $btNovoContrato=true;
        }elseif($status_ass=="PAYMENT_METHOD_CHANGE"){
             $statusAss="PENDENTE";
        }elseif($status_ass=="SUSPENDED"){
             $statusAss="SUSPENSO";
        }elseif($status_ass=="CANCELLED" || $status_ass=="CANCELLED_BY_RECEIVER" || $status_ass=="CANCELLED_BY_SENDER" || $status_ass==7 || $status_ass==6){
             $statusAss="CANCELADO";
        }elseif($status_ass=="EXPIRED"){
             $statusAss="EXPIRADO";
        }else{
        $statusAss="EM ANÁLISE";
        }
         
    ?>
    <div id="d_plano_premium">
        <?php
         echo '
            <h2>Plano Premium '.$txtPlano.'</h2>

            <p>VALOR PLANO: <span>R$ '.$valPlano.'</span></p>

            <p>STATUS: <span id="s_alt_status_plano">'.$statusAss.'</span></p>

            <p>MÉTODO PAGAMENTO: <span>'; echo ($getAss["metodo_pagamento"]==1)?'CARTÃO DE CRÉDITO':'BOLETO'; echo '</span></p>';

            if($statusAss=="ATIVO"){
            ?>
            <span id="s_cancela_contrato"><a href="javascript:void(0);" id="a_cancelar_contrato">CANCELAR CONTRATO</a></span>
            <?php }elseif($getAss["metodo_pagamento"]==2 && $status_ass==1){            
            echo '<span id="s_cancela_contrato"><a href="'.$getAss["link_pagamento"].'" target="_blank">IMPRIMIR BOLETO</a></span>';        
             } ?>
        
            <span class="s_botao_conf_plano" <?php echo (isset($btNovoContrato))?'style="display: none;"':''; ?>><a href="<?php echo getUrl(); ?>planos.php">RENOVE SEU PLANO PREMIUM</a></span>
        </div><!--plano_premium-->
    <?php
     }
        /*
        
        VALOR PLANO: 25,00 OU 15,00
        
        STATUS PLANO: PLANO ATIVO OU SUSPENSO
        
        TIPO DE PAGAMENTO: CARTÃO DE CRÉDITO OU BOLETO
        
        CARTÃO DE CRÉDITO: DATA DO DÉBITO
        
        CARTÃO DE CRÉDITO: DATA DO PRÓXIMO DÉBITO
        
        CARTÃO DE CRÉDITO: BOTÃO PARA CANCELAR PLANO
        
            CARTÃO DE CRÉDTIO: BOTÃO REFAZER O CONTRATO CASO CANCELADO
        
            BOLETO: PRÓXIMO BOLETO
        
            BOLETO: BOLETO GERADO - LINK BOLETO
        
        */
        ?>
    
    
</div><!--cont_plano_contratado-->
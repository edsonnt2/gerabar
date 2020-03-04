<?php if(isset($_POST['inclui'])){ if(isset($_SESSION)==false){session_start(); }
include('../_classes/DB.class.php');
function getUrl(){ return 'http://localhost/myforadmin/';}
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
$table = $_SESSION['Gerabar_table'];
include('../_classes/Cadastros.class.php'); 
include('../_classes/Empresas.class.php');
$idEmpre = Cadastros::selectIdEmpresa($idDaSessao,$table);
$user_id_empresa=($idEmpre['num']>0)?$idEmpre['dados'][0]:0;
include('../_classes/AbrirFecharCaixa.class.php'); 
}else{
    if(isset($_POST['voltaInclui'])){
    include('../_classes/AbrirFecharCaixa.class.php'); 
    }
}
?>
<script type="text/javascript">
	$(function(){
	var timeComandasOut=true,pairaRecente;
	$('.cima_zerar').hover(function(){
		var abrirRecente=($(this).attr('id')=="zeraCmdRecente")?'limpaRecente':'zerarRelatorio';
		pairaRecente = setTimeout(function(){		
		$('#'+abrirRecente).slideDown(100);
		timeComandasOut=false;
		},300);
	},function(){
		if(timeComandasOut){
		clearTimeout(pairaRecente);
		}else{
		var abrirRecente=($(this).attr('id')=="zeraCmdRecente")?'limpaRecente':'zerarRelatorio';
		$('#'+abrirRecente).slideUp(100);	
		timeComandasOut=true;
		}
	});
	});
</script>
<div class="admin_left">
        
    	<div id="ad_cmd_aberta" class="div_form_admin">
        <div class="top_admin_sexo">RELATÓRIO ABERTOS</div>
        <a href="<?php echo getUrl(); ?>administracao.php?cad=caixas-abertos" id="pegarPgRel" class="caixas" title="Caixas abertos">
        	<h1>CAIXAS ABERTOS</h1>
            <p class="ad_p1"><?php $numCaixa=AbrirFecharCaixa::dadosCaixa($user_id_empresa); echo $numCaixa['num']; ?></p>
            <h2>VALOR TOTAL ATUAL</h2>
            <p class="ad_p2"><span>R$</span> 
			<?php $valCaixa=AbrirFecharCaixa::valorCaixa($user_id_empresa);
                echo number_format($valCaixa['totalPago']+$valCaixa['totalTroco'],2,',','.'); ?>
			</p>
        </a>
        </div><!--ad_cmd_aberta-->
        
        <div class="div_form_admin admin_caixas">
        	<h1>VALOR TOTAL SEM TROCO</h1>
            <p class="ad_p2"><span>R$</span> 
			<?php echo number_format($valCaixa['totalPago'],2,',','.'); ?>
        </div><!--ad_cmd_aberta-->
    
        <div id="d_adm_aberta" class="div_form_admin">
        <a href="<?php echo getUrl(); ?>administracao.php?cad=caixas-abertos" title="Caixas Abertos">
        	VER CAIXAS ABERTOS
        </a>
        </div><!--ad_cmd_aberta-->
        
        <div id="d_adm_fechada" class="div_form_admin">
        <a href="<?php echo getUrl(); ?>administracao.php?cad=caixas-fechados" title="Caixas Fechados">
        	VER CAIXAS FECHADOS
        </a>
        </div><!--ad_cmd_aberta-->
        
        </div><!--admin_left-->
        
        <div class="admin_right">        
        <div id="ad_cmd_fechadaRecente" class="div_form_admin">
        <div class="top_admin_sexo">RELATÓRIO FECHADOS</div>
        <a href="javascript:void(0);" class="cima_zerar" id="zeraCmdRecente" title="Caixas Fechados Recentemente">
        	<h1>CAIXAS FECHADOS RECENT.</h1>
            <p class="ad_p1" id="count_cmd"><?php $numCaixa1=AbrirFecharCaixa::dadosCaixa($user_id_empresa,1,false,false,false,false,true); echo $numCaixa1['num']; ?></p>
            <h2>VALOR TOTAL ATUAL</h2>
            <p class="ad_p2" id="valo_cmd"><span>R$</span> 
            <?php $valCaixa1=AbrirFecharCaixa::valorCaixa($user_id_empresa,1,false,true);
                echo number_format($valCaixa1['totalPago']+$valCaixa1['totalTroco'],2,',','.'); ?>
			</p>
            <span id="limpaRecente">zerar fechadas recentes</span>
        </a>
        </div><!--ad_cmd_fechadaRecente-->
        
        <div class="div_form_admin admin_caixas">
        	<h1>VALOR TOTAL SEM TROCO</h1>
            <p class="ad_p2 valHM"><span>R$</span> 
            <?php echo number_format($valCaixa1['totalPago'],2,',','.'); ?>
            </p>
        </div><!--ad_cmd_aberta-->
        
        <div id="ad_cmd_todasFechadas" class="div_form_admin" style="margin-bottom: 0;">
        <a href="<?php echo getUrl(); ?>administracao.php?cad=caixas-fechados" title="Caixas Fechados">
        	<h1>TODOS CAIXAS FECHADOS</h1>
            <p class="ad_p1" id="addCountFecha"><?php $numCaixa2=AbrirFecharCaixa::dadosCaixa($user_id_empresa,1); echo $numCaixa2['num']; ?></p>
            <h2>VALOR TOTAL ATUAL</h2>
            <p class="ad_p2" id="addValFecha"><span>R$</span> 
            <?php $valCaixa2=AbrirFecharCaixa::valorCaixa($user_id_empresa,1);
             echo number_format($valCaixa2['totalPago']+$valCaixa2['totalTroco'],2,',','.'); ?>
			</p>
        </a>
        </div><!--ad_cmd_todasFechadas-->
        <div class="div_form_admin admin_caixas">
        	<h1>VALOR TOTAL SEM TROCO</h1>
            <p class="ad_p2"><span>R$</span> 
            <?php echo number_format($valCaixa2['totalPago'],2,',','.'); ?>
            </p>
        </div><!--ad_cmd_aberta-->
        
        </div><!--admin_right-->
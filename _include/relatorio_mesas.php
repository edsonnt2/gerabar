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
$acre='../';
}else{
    if(!isset($_POST['voltaInclui'])){
    $acre='';
    }
}	
include($acre.'_classes/Mesas.class.php'); 
?><script type="text/javascript">
	$(function(){
	var timeComandasOut=true,pairaRecente;
	$('.cima_zerar').hover(function(){
		pairaRecente = setTimeout(function(){		
		$('#limpaRecente').slideDown(100);
		timeComandasOut=false;
		},300);
	},function(){
		if(timeComandasOut){
		clearTimeout(pairaRecente);
		}else{
		$('#limpaRecente').slideUp(100);	
		timeComandasOut=true;
		}
	});
	});
</script>

	<div class="admin_left">
        
    	<div id="ad_cmd_aberta" class="div_form_admin">
        <div class="top_admin_sexo">RELATÓRIO ABERTAS</div>
        <a href="<?php echo getUrl(); ?>administracao.php?cad=mesas-abertas" id="pegarPgRel" class="mesas" title="Mesas Abertas">
        	<h1>MESAS ABERTAS</h1>
            <p class="ad_p1"><?php $MeAberta=Mesas::selMesaAberta($user_id_empresa); echo $MeAberta['num']; ?></p>
            <h2>VALOR TOTAL ATUAL</h2>
            <p class="ad_p2"><span>R$</span> 
			<?php echo number_format((Mesas::valMesaAberta($user_id_empresa)-Cadastros::valorTotalDescontar($user_id_empresa,'mesa')),2,',','.'); ?>
            </p>
        </a>
        </div><!--ad_cmd_aberta-->
        
        <div id="d_adm_aberta" class="div_form_admin d_acerta_top">
        <a href="<?php echo getUrl(); ?>administracao.php?cad=mesas-abertas" title="Mesas Abertas">
        	VER MESAS ABERTAS
        </a>
        </div><!--ad_cmd_aberta-->
        
        <div id="d_adm_fechada" class="div_form_admin">
        <a href="<?php echo getUrl(); ?>administracao.php?cad=mesas-fechadas" title="Mesas Fechadas">
        	VER MESAS FECHADAS
        </a>
        </div><!--ad_cmd_aberta-->
        
        
        </div><!--admin_left-->
        
        <div class="admin_right">        
        <div id="ad_cmd_fechadaRecente" class="div_form_admin">
        <div class="top_admin_sexo">RELATÓRIO FECHADAS</div>
        <a href="javascript:void(0);" class="cima_zerar" id="zeraCmdRecente" title="Comandas Fechadas Recentemente">
        	<h1>MESAS FECHADAS RECENT.</h1>
            <p class="ad_p1" id="count_cmd"><?php $fechaRec= Mesas::countMesasFechadas($user_id_empresa,false,false,true); echo $fechaRec['count'];?></p>
            <h2>VALOR TOTAL ATUAL</h2>
            <p class="ad_p2" id="valo_cmd"><span>R$</span> 
       		<?php echo number_format($fechaRec['total'],2,',','.'); ?>
            </p>
            <span id="limpaRecente">zerar fechadas recentes</span>
        </a>
        </div><!--ad_cmd_fechadaRecente-->        

        <div id="ad_cmd_todasFechadas" class="div_form_admin" style="margin-top:15px;">
        <a href="<?php echo getUrl(); ?>administracao.php?cad=mesas-fechadas" title="Mesas Fechadas">
        	<h1>TODAS MESAS FECHADAS</h1>
            <p class="ad_p1" id="addCountFecha"><?php $fechaTotal= Mesas::countMesasFechadas($user_id_empresa); echo $fechaTotal['count'];?></p>
            <h2>VALOR TOTAL ATUAL</h2>
            <p class="ad_p2" id="addValFecha"><span>R$</span> 
			<?php echo number_format($fechaTotal['total'],2,',','.'); ?>
            </p>
        </a>
        </div><!--ad_cmd_todasFechadas-->
        
        </div><!--admin_right-->
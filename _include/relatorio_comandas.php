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

include($acre.'_classes/Comandas.class.php'); 
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
        <div class="top_admin_sexo">RELATÓRIO ABERTAS</div>
        <a href="<?php echo getUrl(); ?>administracao.php?cad=comandas-abertas" id="pegarPgRel" class="comandas" title="Comandas Abertas">
        	<h1>COMANDAS ABERTAS</h1>
            <p class="ad_p1"><?php echo Comandas::countCmdAberta($user_id_empresa); ?></p>
            <h2>VALOR TOTAL ATUAL</h2>
            <p class="ad_p2"><span>R$</span> 
			<?php echo number_format((Comandas::valorTotalCmd($user_id_empresa)-Cadastros::valorTotalDescontar($user_id_empresa,'comanda')),2,',','.'); ?>
			</p>
        </a>
        </div><!--ad_cmd_aberta-->
        
        <div class="div_form_admin admin_sexo">            
        	<h1>COMANDAS ABERTAS HOMEM</h1>
            <p class="ad_p1"><?php echo Comandas::countCmdAberta($user_id_empresa,"H"); ?></p>
            <h2>VALOR TOTAL ATUAL</h2>
            <p class="ad_p2"><span>R$</span> 
			<?php echo number_format((Comandas::valorTotalCmd($user_id_empresa,'H')-Cadastros::valorTotalDescontar($user_id_empresa,'comanda','H')),2,',','.'); ?>
            <div class="sep_admin_sexo"></div>
            <h1>COMANDAS ABERTAS MULHER</h1>
            <p class="ad_p1"><?php echo Comandas::countCmdAberta($user_id_empresa,"M"); ?></p>
            <h2>VALOR TOTAL ATUAL</h2>
            <p class="ad_p2"><span>R$</span> 
			<?php echo number_format((Comandas::valorTotalCmd($user_id_empresa,'M')-Cadastros::valorTotalDescontar($user_id_empresa,'comanda','M')),2,',','.'); ?>
			</p>
        </div><!--ad_cmd_aberta-->
    
        <div id="d_adm_aberta" class="div_form_admin">
        <a href="<?php echo getUrl(); ?>administracao.php?cad=comandas-abertas" title="Comandas Abertas">
        	VER COMANDAS ABERTAS
        </a>
        </div><!--ad_cmd_aberta-->
        
        <div id="d_adm_fechada" class="div_form_admin">
        <a href="<?php echo getUrl(); ?>administracao.php?cad=comandas-fechadas" title="Comandas Fechadas">
        	VER COMANDAS FECHADAS
        </a>
        </div><!--ad_cmd_aberta-->
        
        </div><!--admin_left-->
        
        <div class="admin_right">        
        <div id="ad_cmd_fechadaRecente" class="div_form_admin">
        <div class="top_admin_sexo">RELATÓRIO FECHADAS</div>
        <a href="javascript:void(0);" class="cima_zerar" id="zeraCmdRecente" title="Comandas Fechadas Recentemente">
        	<h1>COMANDAS FECHADAS RECENT.</h1>
            <p class="ad_p1" id="count_cmd"><?php $fechaRec= Comandas::countCmdFechadas($user_id_empresa,true); echo $fechaRec['count'];?></p>
            <h2>VALOR TOTAL ATUAL</h2>
            <p class="ad_p2" id="valo_cmd"><span>R$</span> 
            <?php echo number_format($fechaRec['total'],2,',','.'); ?>
			</p>
            <span id="limpaRecente">zerar fechadas recentes</span>
        </a>
        </div><!--ad_cmd_fechadaRecente-->
        
        <div class="div_form_admin admin_sexo" id="admin_sexo_fecha">
        	<a href="javascript:void(0);" class="cima_zerar" id="zeraRelat" title="Zerar Fechadas por Gênero">
        	<h1>COMANDAS FECHADAS HOMEM</h1>
            <p class="ad_p1 numHM"><?php $fechaTotalH= Comandas::countCmdFechadas($user_id_empresa,false,"H",true); echo $fechaTotalH['count'];?></p>
            <h2>VALOR TOTAL ATUAL</h2>
            <p class="ad_p2 valHM"><span>R$</span> 
            <?php echo number_format($fechaTotalH['total'],2,',','.'); ?>
            </p>
            <div class="sep_admin_sexo"></div>
            <h1>COMANDAS FECHADAS MULHER</h1>
            <p class="ad_p1 numHM"><?php $fechaTotalM= Comandas::countCmdFechadas($user_id_empresa,false,"M",true); echo $fechaTotalM['count'];?></p>
            <h2>VALOR TOTAL ATUAL</h2>
            <p class="ad_p2 valHM"><span>R$</span> 
            <?php echo number_format($fechaTotalM['total'],2,',','.'); ?>
            </p>
            <span id="zerarRelatorio">zerar fechadas por gênero</span>
        	</a>
        </div><!--ad_cmd_aberta-->
        
        <div id="ad_cmd_todasFechadas" class="div_form_admin">
        <a href="<?php echo getUrl(); ?>administracao.php?cad=comandas-fechadas" title="Comandas Fechadas">
        	<h1>TODAS COMANDAS FECHADAS</h1>
            <p class="ad_p1" id="addCountFecha"><?php $fechaTotal= Comandas::countCmdFechadas($user_id_empresa); echo $fechaTotal['count'];?></p>
            <h2>VALOR TOTAL ATUAL</h2>
            <p class="ad_p2" id="addValFecha"><span>R$</span> 
            <?php echo number_format($fechaTotal['total'],2,',','.'); ?>
			</p>
        </a>
        </div><!--ad_cmd_todasFechadas-->
        
        </div><!--admin_right-->
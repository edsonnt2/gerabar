<?php if(isset($_POST['inclui'])){ if(isset($_SESSION)==false){session_start();}
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
$tabela = $_SESSION['Gerabar_table'];
$planoAtivo=$_SESSION['Gerabar_plano'];                                  
include('../_classes/Cadastros.class.php');
$idEmp = Cadastros::selectIdEmpresa($idDaSessao,$tabela);
$idEmpresa = $idEmp['dados'][0];
$inc='../';
}else{
$idEmpresa = $user_id_empresa;
$inc='';
}
include($inc.'_classes/Mesas.class.php');
?>
<div id="cont-sel-mesas" class="selMesaBar">
	<span id="s_abrir_new_mesa"><a href="<?php echo getUrl(); ?>comanda-bar.php?cad=comanda-mesa&newMesa=true">abrir comanda de mesa</a></span>
    <?php
	$mesasAberta=Mesas::selMesaAberta($idEmpresa);
	echo '<div class="info_topo_cad"'; if($mesasAberta['num']==0){ echo ' style="display:none;"';} echo '><h1>comandas de mesas abertas</h1></div><!--fecha info topo cad-->';
	?>
	<form action="" method="post">
        	<div class="linha_form">
            	<div class="d_alinha_form" style=" margin:0 0 5px 2px;">
                    <span><label for="bc_cmd_mesa">buscar por mesa:</label></span>
                    <input type="text" id="bc_cmd_mesa" onKeyPress="return SomenteNumero(event);" autocomplete="off" />
                    <div class="d_aviso_erro" id="erro_bc_cmd_mesa"><div class="d_ponta-erro"></div><p></p></div><!--d_aviso_erro-->
                </div>
                <div class="d_alinha_form">
	                <span><label>&nbsp;</label></span>
                    <button type="submit" class="cd_envia_dados" id="envia_bc_cmd_mesa" title="ATALHO (ENTER)">buscar</button>
                    <input type="hidden" value="comanda-mesa" class="abaMesa1" id="pgAbaMesa" />
                </div>
            </div><!--fecha linha form-->
            </form>
	<?php
	echo '<ul id="ul-mesas-abertas" class="list-mesas-ul">';
        $limiteMesa=($planoAtivo==1)?$mesasAberta['num']:3;
        $nm=1;
    	foreach($mesasAberta['dados'] as $AsMesa){
            if($nm<=$limiteMesa){
		$me=($AsMesa['cmd_mesa']<10)?'0'.$AsMesa['cmd_mesa']:$AsMesa['cmd_mesa'];
        echo '<li class="openMesa"><a href="'.getUrl().'comanda-bar.php?cad=comanda-mesa&idMesa='.$AsMesa['cmd_mesa'].'">mesa '.$me.'</a></li>';
            }
            $nm++;
		}
    echo '</ul>';
	?>
    <div class="d_alinha_form" style="display:none;">
        <a class="volta_mesas styleVolMesa" href="<?php echo getUrl(); ?>comanda-bar.php?cad=comanda-mesa">voltar</a>
    </div>
</div><!--#cont-sel-mesas-->
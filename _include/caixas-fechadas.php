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
		include('../_classes/Cadastros.class.php');
		include('../_classes/formata_texto.php');
		$idEmpresa = Cadastros::selectIdEmpresa($idDaSessao,$tabela);
		$user_id_empresa = $idEmpresa['dados'][0];
		$acres="../";
        include("../_classes/AbrirFecharCaixa.class.php");
        $status=(int)$_POST['cxStatus'];
		}else{
		$acres="";
        $status=(isset($_GET['cad']) && $_GET['cad']=="caixas-abertos")?0:1;
        if($table=="usuarios"){
		include('_classes/Cadastros.class.php');
        }
		}		
            
			$trasData=AbrirFecharCaixa::DataCaixaFechado($user_id_empresa,$status);
			$DBdataFinal=date('d/m/Y',strtotime($trasData['dados'][0]));
			$valData=explode('/',$DBdataFinal);
			$DBdataInicial = date('d/m/Y',mktime(0,0,0,$valData[1],$valData[0]-30,$valData[2]));
			$dataInicial=false;
			$dataFinal=false;
			$qualAtivo="data";
			$linkData="";
			if(isset($_GET["tudo"])){
			$linkData="&tudo=true";
			$qualAtivo="tudo";
			}elseif(isset($_GET["busca"])){
			$qualAtivo="busca";
			}elseif(isset($_GET['dataInicial']) AND isset($_GET['dataFinal'])){
			$dataInicial=$_GET['dataInicial'];
			$dataFinal=$_GET['dataFinal'];
			$linkData="&dataInicial=".$dataInicial."&dataFinal=".$dataFinal;
			}else{
			$dataInicial=$DBdataInicial;
			$dataFinal=$DBdataFinal;
			$linkData="&dataInicial=".$dataInicial."&dataFinal=".$dataFinal;
			}
            $count=AbrirFecharCaixa::dadosCaixa($user_id_empresa,$status,$dataInicial,$dataFinal);
        if($count['num']>0){
    ?>
<div class="d_volta_admin"><a href="<?php echo getUrl(); ?>administracao.php?relatorio=caixa-aberto-fechado">Voltar para início de Administração</a></div>
    <div id="tudo_cmd_aberta">    
     <div class="info_topo_cad"><h1>Caixas <?php echo ($status==0)?'Abertos':'fechados'; ?></h1></div><!--fecha info topo cad-->    
     <?php 
	$pgOndefiltra=($status==0)?'caixas-abertos':'caixas-fechados';
	$countTudoAbreFecha=$count['num'];
	include($acres.'_include/filtro.php'); 
	
      echo '<div id="tudoCarregaCmd">';
        if($qualAtivo=="busca"){
			$pgs = 0;
			if($_GET["busca"]==""){
			$numCmd=0;
			}else{
            $cmdFechadas=AbrirFecharCaixa::buscarCaixas($_GET["busca"],$user_id_empresa,$status);
			$numCmd=$cmdFechadas['num'];
			}
        }else{
        $pagina = (isset($_GET['pg']) AND $_GET['pg']!=0)?(int)$_GET['pg']:1;
        $maximo = 30;
        $inicio = $pagina - 1;
        $inicio = $maximo * $inicio;
        $menos = $pagina - 1;
        $mais = $pagina + 1;
        $pgs = ceil($countTudoAbreFecha/$maximo);
        $cmdFechadas=AbrirFecharCaixa::dadosCaixa($user_id_empresa,$status,$dataInicial,$dataFinal,$inicio,$maximo);
        $numCmd=$cmdFechadas['num'];
        }
        if($numCmd>0){
		$qualCad=$pgOndefiltra;
		$qualvai=$qualAtivo;
		$id_empresa=$user_id_empresa;
		include($acres.'_include/lista-comandas-fechadas.php');	
		 }else{
		        if($qualAtivo=="busca"){
					if($_GET["busca"]<>""){
					echo '<div class="tudo_cmd_vazio">
						<h1>Nada foi encontrado em sua busca !</h1>
					</div>';
					}
				}else{
				echo '<div class="tudo_cmd_vazio">
					<h1>Página não encontrada !</h1>
				</div>';
				}
         } ?>
    	</div><!--fecha tudoCarregaCmd-->
    </div><!--tudo_cmd_aberta-->
    <?php } ?>
    <div class="tudo_cmd_vazio" <?php if($count['num']>0){ echo 'style=" display:none;" ';} ?>>
    <h1>sem caixas <?php echo ($status==1)?"fechados":"abertos"; ?> !</h1>
    </div>
<div class="d_volta_admin"><a href="<?php echo getUrl(); ?>administracao.php?relatorio=caixa-aberto-fechado" id="qualPgEsta" class="caixa-aberto-fechado">Voltar para início de Administração</a></div>
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
$tabela = $_SESSION['Gerabar_table'];
include('../_classes/Cadastros.class.php');
$idEmp = Cadastros::selectIdEmpresa($idDaSessao,$tabela);
$user_id_empresa = $idEmp['dados'][0];
$acre="../";
}else{
$acre="";
if(!isset($table) || $table!="ambientes"){
include('_classes/Cadastros.class.php');
}
}
include($acre."_classes/Clientes.class.php");
include($acre."_classes/remove_caracteres.php");
$trasDados=Clientes::listaConta($user_id_empresa);
?> 
        
        <div id="d_mostrar_contas">
        
        <div class="info_topo_cad" style="margin:15px 0 0 0;"><h1>crédito de clientes</h1></div><!--fecha info topo cad-->
        
        <?php
		$trasData=Clientes::DataContaAbertoFechado($user_id_empresa,"conta_clientes");
		$DBdataFinal=date('d/m/Y',strtotime($trasData['dados'][0]));
		$valData=explode('/',$DBdataFinal);
		$DBdataInicial = date('d/m/Y',mktime(0,0,0,$valData[1],$valData[0]-90,$valData[2]));
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
		if(isset($_GET["sexo"])){				
		$linkData="&sexo=".$_GET["sexo"].$linkData;
		$qualSexo=$_GET["sexo"];
		$qSex=$_GET["sexo"];
		}else{
		$qualSexo="todas";
		$qSex=false;
		}	
		$count=Clientes::listaConta($user_id_empresa,false,false,$dataInicial,$dataFinal,$qSex);
		
		if($count['num']>0){		
		$pgOndefiltra='contas-abertas';
		$countTudoAbreFecha=$count['num'];
		include($acre.'_include/filtro.php'); 
		?>
            
       <div id="tudoCarregaCmd">     
       
	   <?php
	   
	   		// Cria uma função que retorna o timestamp de uma data no formato DD/MM/AAAA
			function geraTimestamp($data) {
			$partes = explode('/', $data);
			return mktime(0, 0, 0, $partes[1], $partes[0], $partes[2]);
			}
            if($qualAtivo=="busca"){
			$pgs = 0;
			if($_GET["busca"]==""){
			$numCmd=0;
			}else{
			$trasDadosForm=Clientes::buscaListaConta($_GET["busca"],$user_id_empresa,$qSex);
			$numCmd=$trasDadosForm['num'];
			}
            }else{
            $pagina = (isset($_GET['pg']) AND $_GET['pg']!=0)?(int)$_GET['pg']:1;
            $maximo = 25;
            $inicio = $pagina - 1;
            $inicio = $maximo * $inicio;
            $menos = $pagina - 1;
            $mais = $pagina + 1;
            $pgs = ceil($count['num']/$maximo);            
			$trasDadosForm = Clientes::listaConta($user_id_empresa,$inicio,$maximo,$dataInicial,$dataFinal,$qSex);			
			$numCmd=$trasDadosForm['num'];
            }
            if($numCmd>0){        
			include($acre.'_include/lista-conta.php');			
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
			
			}
		?>
        
        </div><!--fecha tudoCarregaCmd-->
        <?php } ?>
        
        </div><!--d_mostrar_contas-->
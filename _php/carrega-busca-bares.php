<?php	
if(!isset($_SESSION)){session_start();}
include("../_classes/DB.class.php");
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
include("../_classes/Cadastros.class.php");
include("../_classes/Clientes.class.php");
include("../_classes/formata_texto.php");
include("../_classes/remove_caracteres.php");
$idDaSessao = $_SESSION['Gerabar_uid'];
$table = $_SESSION['Gerabar_table'];
$planoAtivo=$_SESSION['Gerabar_plano'];

$idEmpre = Cadastros::selectIdEmpresa($idDaSessao,$table);
$id_empresa=($idEmpre['num']>0)?$idEmpre['dados'][0]:0;
extract($_POST);
if(isset($_GET["newMesa"])){
extract($_GET);
function like($needle,$haystack){
	$regex = '/'.str_replace('%','.*?',$needle).'/';
	return preg_match($regex,$haystack)>0;
}
include("../_classes/Empresas.class.php");
$trasMesas=Empresas::selectEmpresa(0,$id_empresa);
if($trasMesas['num']>0){	
	if($trasMesas['dados'][16]<>0){	
		$linkMesa=(isset($mesaCaixa))?'caixa.php?cad=opcao-mesa&idMesa=':'comanda-bar.php?cad=comanda-mesa&idMesa=';
        $limiteMesa=($planoAtivo==1)?$trasMesas['dados'][16]:3;
		for($n=1;$n<=$limiteMesa;$n++){
		$num=($n<10)?'0'.$n:$n;
		
			if(isset($serchMesa)){				
				if(like('%'.$serchMesa.'%',$num)){
				$contMesa=true;
				if(isset($paraSerch)==false){$paraSerch=true;}
				}else{
				$contMesa=false;
				}
			}else{				
			$contMesa=true;
			}
					
			if($contMesa==true){	
				if(Cadastros::versetem($id_empresa,$n,'cmd_mesa','cmd_mesa')==false){
				if(isset($abaMesaQ)==false || $abaMesaQ=="abaMesa2"){
				echo '<li><a href="'.getUrl().$linkMesa.$n.'">mesa '.$num.'</a></li>';
				}
				}else{				
					if(isset($abaMesaQ) AND $abaMesaQ=="abaMesa1"){
						if(isset($temBusc)==false){$temBusc=true;}
					}					
				echo '<li class="openMesa"><a href="'.getUrl().$linkMesa.$n.'">mesa '.$num.'</a></li>';
				}
			}
		}
				
		if(isset($serchMesa) AND isset($paraSerch)==false){
		echo '<li class="openMesa">não foi encontrado nada !</li>';
		}else{			
			if(isset($abaMesaQ) AND $abaMesaQ=="abaMesa1"){
				if(isset($temBusc)==false){
					echo '<li class="openMesa">não foi encontrado nada !</li>';
				}
			}
		}
	}
}

}elseif(isset($_GET["buscaCliente"])){	
$buscando= Cadastros::buscaArray($_GET["selTabela"],$_GET["buscaCliente"],$id_empresa,18);
if($buscando['num']>0){
	$num=0;
	foreach($buscando['dados'] as $asBusca){
		echo '<li class="s_acrescenta_conta"'; if($num==0){ $num++; echo ' id="ativo_conta_nome"';} echo '>
			<a href="'.getUrl().'contas-clientes.php?cad=contas-abertas&cliente='.removeAcentos($asBusca['nome'],'-').'&cod='.$asBusca['id'].'" class="'.$asBusca['id'].'|'.$asBusca['nome'].'">
				<span>'.$asBusca['nome'].'</span>
				<span class="s_border_conta">Cód. '.$asBusca['id'].'</span>
			</a>
			</li>';
	}
}else{
echo '<li class="nadaCliente"><span>cliente não encotrado !<br /> <a href="'.getUrl().'contas-clientes.php?cad=cadastro-clientes-contas" class="cadClienteConta">clique aqui</a> para cadastrar um novo cliente.</span></li>';
}

}elseif(isset($_GET["carConta"])){
	extract($_GET);
	$total=0;
	$colocaIdConta=0;
	echo '<li class="li-inner" style="display:none;"><span class="temAgrupado">'.Clientes::countAgrupaConta($idCliente,$id_empresa).'</span></li>';	
	include("../_include/lista-produtos-conta.php");
	echo '<li class="li-inner" style="display:none;"><input type="hidden" class="inp_val_total" id="'.$total.'-val" value="'.number_format($total,2,',','.').'" /></li>';
	
}elseif(isset($setContaCliente)){
	$nomeProduto=trim($nomeProduto);
	$codFunc=trim($codFunc);
    $valorCompra=trim($valorCompra);
	$valor=trim($valor);
	$quantidade=(int)$quantidade;
	
	if($nomeProduto==""){
		echo "Coloque o nome ou código interno do produto !|i_nome_prod_contas";
		}elseif($codFunc==""){
		echo "Coloque seu código de funcionário !|i_cod_func";
		}elseif(Cadastros::versetem($id_empresa,$codFunc,'codigo','operadores')==false){
		echo "Funcionário não encontrado !|i_cod_func";
		}elseif($idProduto==0 AND ($valor=="0.00" || $valor=="")){
		echo "Coloque um valor para esse produto !|i_val_diverso";
		}elseif($quantidade=="" || $quantidade==0){
		echo "Quantidade em branco ou igual a 0 !|novaQuantProd";
		}elseif($idCliente<>"" AND $idProduto<>"" AND $quantidade<>"" AND $valor<>""){
        if(Cadastros::plano_cadastro_ativo($planoAtivo,$id_empresa,"conta_clientes",20,(int)$idCliente)==true){
        
		$idCerto=Clientes::insertContaCliente((int)$idCliente,$id_empresa,(int)$idProduto,$quantidade,$valorCompra,$valor,strip_tags($nomeProduto),$codFunc);
		if($idCerto!=false){
		echo $idCerto['id']."||".date('d/m/Y H:i:s',strtotime($idCerto['data']))."|".$idCerto['id_conta'];
		}else{
		echo "Ocorreu um erro ou alterar o status da empresa, por favor, tente mais tarde !|erro";
		}	
            
        }else{
            echo "Limite de cadastros para o Plano Grátis atingido. Contrate um Plano Premium e continue cadastrando !|erro";
		}	
        
        
	}else{
		echo "Ocorreu um erro ou alterar o status da empresa, por favor, tente mais tarde !|erro";
	}
	
}else{
echo "<h2>Ocorreu algum erro inesperado, por favor, tente novamente mais tarde !</h2>";
}
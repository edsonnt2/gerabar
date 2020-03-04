<?php
if(!isset($_SESSION)){session_start();}

if(isset($_FILES['uploadfoto'])){
include('funcoes.php');
$imagem = $_FILES['uploadfoto'];
$nome1 = sha1(date('y-m-d H:i:s')).'1.jpg';
$nome2 = sha1(date('y-m-d H:i:s')).'2.jpg';

$ext = array('image/jpeg','image/pjpeg','image/jpg','image/gif','image/png');

if(in_array($imagem['type'],$ext)){				
	upload($imagem,$nome1,'../_uploads/_negocios',328,128);	
	upload($imagem,$nome2,'../_uploads/_negocios',200);	
	if(!file_exists('../_uploads/_negocios/'.$nome1)){
		echo "Ocorreu um erro ao fazer upload da imagem ! 1|erro";
	}elseif(file_exists('../_uploads/_negocios/'.$nome2)){
		include("../_classes/DB.class.php");
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
		include("../_classes/Empresas.class.php");
		$idEmpresa = Empresas::selectEmpresa($_SESSION['Gerabar_uid']);
		$dadosImg=Empresas::selectImgEmpresa($idEmpresa['dados'][0]);
		if($dadosImg['num']>0){
			if(Empresas::updateImgEmpresa($idEmpresa['dados'][0],$nome1,$nome2)){
				if(file_exists('../_uploads/_negocios/'.$dadosImg['dados']['nome_img_1'])){
				unlink('../_uploads/_negocios/'.$dadosImg['dados']['nome_img_1']);
				}				
				if(file_exists('../_uploads/_negocios/'.$dadosImg['dados']['nome_img_2'])){
				unlink('../_uploads/_negocios/'.$dadosImg['dados']['nome_img_2']);
				}				
			echo $nome1."|";
			}else{
			echo "Ocorreu um erro ao fazer o upload, por favor, tente mais tarde !|erro";
			}
		}else{
		if(Empresas::insertImgEmpresa($idEmpresa['dados'][0],$nome1,$nome2)){
		echo $nome1."|";
		}else{
			echo "Ocorreu um erro ao fazer o upload, por favor, tente mais tarde !|erro";
		}		
		}
		
	}else{
		echo "Ocorreu um erro ao fazer upload da imagem, por favor, tente mais tarde !|erro";
	}
	
	}else{
		echo "Imagem muito grande ou tipo não suportado ! (Coloque uma imagem com tamanho entre 1000 à 2000)|erro";
	}
}else{
	echo "Ocorreu um erro inesperado, por favor, tente novamente mais tarde !|erro";
}
<?php
session_start();
include("../_classes/DB.class.php");
include("../_classes/Login.class.php");
function getUrl(){ return 'http://localhost/myforadmin/';}
$objLogin=new Login;
extract($_POST);
if(isset($senhaOpe) AND isset($codigoOpe)){	
	if(!isset($_SESSION)){session_start();}
		if(!$objLogin->logado()){
		?>
			<script type="text/javascript">
            	$(function(){ red:window.location.href="<?php echo getUrl(); ?>"; });
            </script>
			<?php
		exit();
		}
	include("../_classes/Cadastros.class.php");
	$idDaSessao = $_SESSION['Gerabar_uid'];
	$table = $_SESSION['Gerabar_table'];
	$idEmpre = Cadastros::selectIdEmpresa($idDaSessao,$table);
	$id_empresa=($idEmpre['num']>0)?$idEmpre['dados'][0]:0;
	if($codigoOpe==""){
	echo "Código do operador está em branco !|cd_codigoOpe";
	}elseif($objLogin->logarOperador($codigoOpe,$senhaOpe,$id_empresa)){
		echo "logar|";
	}else{
		if($objLogin->erro){
			echo "Senha ou código do operador incorreto !|cd_senhaOpe";
		}else{
			echo "Erro no sistema !|erro";
		}
	}
}elseif(isset($lembrar)){
	$lembra=($lembrar=="sim")?true:false;
    $erEmailLoga=($ondeLogar=="logarlogaP")?'usuariologaP':'emailloga';
	if($emailUsuario==""){
        
	echo "Nome de usuário ou e-mail em branco !|".$erEmailLoga."|1";
	}elseif($objLogin->logar(strip_tags($emailUsuario),strip_tags($senha),$lembra)){
        
        if($ondeLogar=="logarlogaP"){
             if(isset($_SESSION['Gerabar_plano']) AND $_SESSION['Gerabar_plano']==1){
                echo getUrl()."configuracoes.php?cad=plano_contratado||";
                }else{
                echo (isset($_SESSION['salvar_plano']))?getUrl()."checkout.php||":getUrl()."planos.php||";
             }
            
        }else{
		echo getUrl()."||";
        }
	}else{
		if($objLogin->erro){
			echo "Senha ou usuário incorreto !|".$erEmailLoga."|1";
		}else{
			echo "Erro no sistema !|erro|";
		}
	}
}elseif(isset($nome)){
    $nome=trim($nome);
	$nomeUsuario=trim($nomeUsuario);
	$email=trim($email);
	$mes=trim($mes);
	$dia=trim($dia);
	$ano=trim($ano);
	$senha=trim($senha);
    $sepnome=explode(' ',$nome);
    $sobrenome='';
        for($i=0;count($sepnome)>$i;$i++){
            if($i==0){
            $nomePri=$sepnome[$i];
            }elseif($i==1){
            $sobrenome=$sepnome[$i];
            }else{
            $sobrenome.=' '.$sepnome[$i];    
            }
        }
	include("../_classes/Cadastros.class.php");
	if(trim($nome)=="" || strlen($nome)<6){
	echo "Nome em branco ou pequeno de mais !|nomecad";
	}elseif($sobrenome==""){
    echo "Por favor, coloque seu nome completo !|nomecad";    
    }elseif($nomeUsuario=="" || strlen($nomeUsuario)<2){
	echo "Nome de Usuário em branco ou pequeno de mais !|nomeUsuariocad";
	}elseif(Cadastros::versetem(0,$nomeUsuario,'nome_usuario')==true){
	echo "Nome de Usuário já está cadastrado em nosso sistema !|nomeUsuariocad";
	}elseif($email=="" || !preg_match("/^[a-z0-9_\.\-]+@[a-z0-9_\.\-]*[a-z0-9_\-]+\.[a-z]{2,4}$/i",$email)){
	echo "E-mail em branco ou inválido !|emailcad";
	}elseif(Cadastros::versetem(0,$email,'email')==true){
	echo "Este e-mail já está cadastrado em nosso sistema !|emailcad";
	}elseif(checkdate($mes,$dia,$ano)==false){
	echo "Data de nascimento está incorreta !|diacad";
	}elseif((date('Y')-'100')>$ano){
	echo "Data está incorreta !|diacad";
	}elseif((date('Y')-'18')<$ano){
	echo "A idade miníma para se cadastrar é de 18 anos !|diacad";
	}elseif(empty($genero)==true){
	echo "Selecione um gênero !|radio";
	}elseif($senha=="" || strlen($senha)<6){
	echo "Senha em branco ou pequena de mais !|senhacad";
	}elseif(!preg_match("/^(?=.*\d)(?=.*[a-z])(?!.*\s).*$/",$senha)){
	echo "Senha em branco ou pequena de mais !|senhacad";
	}else{
		if($genero<>"F" && $genero<>"M"){
		echo "Gênero inválido !|radio";
		exit();
		}
		$nasc = $ano.'-'.$mes.'-'.$dia;
		$chave = sha1(uniqid( mt_rand(),true)); 
       $nome=$nomePri; if(Cadastros::insertCadastro(strip_tags($nomeUsuario),strip_tags($email),strip_tags($senha),strip_tags($nome),strip_tags($sobrenome),strip_tags($nasc),strip_tags($genero),$chave,1,0)){
			if($objLogin->logar(strip_tags($nomeUsuario),strip_tags($senha))){
                
                if($ondeCadastra=="cadastroplano"){
                    echo (isset($_SESSION['salvar_plano']))?getUrl()."checkout.php|":getUrl()."planos.php|";
                }else{
				echo getUrl()."|";
                }
				$msgCima='Obrigado por se inscrever no Gerabar, agora precisamos validar sua conta verificando seu e-mail.';
				$novoCadastro=true;
				include('envia_verifica.php');
			}else{
				echo "Ocorreu um erro ao fazer o login, por favor, tente mais tarde !|erro";
			}			
		}else{
			echo "Ocorreu um erro ao fazer o cadastro, por favor, tente mais tarde !|erro";
		}
	}

}elseif(isset($sair) AND $sair=="logOut"){
$objLogin->sair();
}else{
echo "Ocorreu algum erro inesperado, por favor, tente novamente mais tarde !|erro";
}
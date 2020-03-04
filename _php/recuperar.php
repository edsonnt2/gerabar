<?php
include("../_classes/DB.class.php");
include("../_classes/Recuperar.class.php");
function getUrl(){ return 'http://localhost/myforadmin/';}
extract($_POST);
if(isset($recemail)){	
	$recemail=trim($recemail);
	$dadosMail=Recuperar::dadosEmail(strip_tags($recemail));
	if($dadosMail['num']==0){
		echo "E-mail não cadastrado em nosso sistema !|recuperaEmail";
	}else{		
		$dados=$dadosMail['dados'];			
		$link = getUrl().'recuperar_senha.php?utilizador='.$recemail.'&confirmacao=';
		
		$dadosRecu=Recuperar::dadosRecupera(strip_tags($recemail));	
		if($dadosRecu['num']>0){
			$chave = $dadosRecu['dados']['chave'];	
			$salvoChave=true;
		}else{
			$chave = sha1(uniqid( mt_rand(),true));		
			$salvoChave=(Recuperar::salvarChave(strip_tags($recemail),strip_tags($chave)))?true:false;		
		}
		
		if($salvoChave==true){
		$link.=strip_tags($chave);
		
		$msgHTML='<table cellpadding="0" cellspacing="0" border="0" width="100%" bgcolor="#fff" align="center">
	<tr>
    	<td>
        	<table cellpadding="0" cellspacing="0" border="0" width="100%" align="center" bgcolor="#fff" style="width:100%; line-height:22px !important; color:#333 !important;">
            	<tr>
                	<td colspan="4" bgcolor="#555"">
                    <div style="padding:10px 0 2px 0;"><img src="'.getUrl().'_img/gerabar_logo.png" width="200px"  alt="Gerabar" /></div>					
                    </td>
                </tr>
				<tr><td colspan="4">&nbsp;</td></tr>
                <tr>
                	<td colspan="4">
                    	<span><font size="2" face="Arial, Helvetica, sans-serif">Olá '.$dados['nome'].' '.$dados['sobrenome'].',</font></span>
                    </td>
                </tr>                
                <tr>
                	<td colspan="4">
						<span><font size="2" face="Arial, Helvetica, sans-serif">Para recuperar sua senha no <a href="'.getUrl().'" target="_blank">Gerabar.com.br</a> clique no link abaixo:</font></span>
                    </td>
                </tr>
				<tr><td colspan="4">&nbsp;</td></tr>
				<tr>
                	<td colspan="4">
						<span><font size="2" face="Arial, Helvetica, sans-serif" color="#0055BB"><a href="'.$link.'" target="_blank">'.$link.'</a></font></span>
                    </td>
                </tr>
				<tr><td colspan="4">&nbsp;</td></tr>				
				<tr>
                	<td colspan="4">
						<span><font size="2" face="Arial, Helvetica, sans-serif" color="#0055BB">OBS: Não responda esse e-mail, pois não receberá retorno.</font></span>
                    </td>
                </tr>
                <tr><td colspan="4">&nbsp;</td></tr>
                <tr><td colspan="4">&nbsp;</td></tr>
                <tr>
                	<td colspan="2">
                        <span><font size="5" face="Arial, Helvetica, sans-serif" color="#444"><b><a href="'.getUrl().'" style=" text-decoration:none !important; color:#444 !important;">Gerabar Gerenciador Online</a></b></font></span>
                    </td>
                </tr>
                <tr><td colspan="4">&nbsp;</td></tr>
				<tr><td colspan="4">&nbsp;</td></tr>
            </table>            
        </td>
    </tr>
</table>';		
		$msgTXT='Olá '.$dados['nome'].' '.$dados['sobrenome'].'. Para recuperar sua senha no Gerabar copie e cole em seu navegador o link a seguir: '.$link.'. Para mais informações acesse gerabar.com.br. Att. Equipe Gerabar.';
		include('../_classes/Mail.class.php');
		$mail= new Mail;
		$subtitulo = 'Recuperação de Senha';
		if($mail->sendMail($recemail,$dados['nome'].' '.$dados['sobrenome'],$subtitulo,$msgHTML,$msgTXT)){
		echo "|";
		}else{
		echo "Ocorreu um erro ao enviar e-mail de recuperação de senha, por favor, tente novamente !|erro|";
		}
		}else{
		echo "Ocorreu um erro ao enviar e-mail de recuperação de senha, por favor, tente novamente !|erro|";
		}
	}
	
}elseif(isset($novaSenha)){	
$novaSenha=trim($novaSenha);
$repSenha=trim($repSenha);
$email=trim($email);
if($novaSenha==""){
echo "Por favor, coloque sua nova senha !|novasenha";
}elseif(strlen($novaSenha)<6){
echo "Sua nova senha tem que ter no mínimo 6 caracteres !|novasenha";
}elseif($repSenha==""){
echo "Por Favor, repita sua nova senha !|repnovasenha";
}elseif($novaSenha!=$repSenha){
echo "As duas senhas não correspondem uma com a outra !|repnovasenha";
}else{
	if(Recuperar::altSenhas(strip_tags($email),strip_tags($novaSenha),strip_tags($confirmaConta))){	
	echo "|";
	//Recuperar::deleteChave(strip_tags($email),strip_tags($confirmaConta));
	}else{
	echo "Ocorreu um erro inesperado em nosso sistema, por favor, entre em contato com o administrador do Gerabar !|erro";
	}
}

}else{
echo "Ocorreu algum erro inesperado, por favor, tente novamente mais tarde !|erro";
}
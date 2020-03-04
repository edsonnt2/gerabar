<?php
extract($_POST);
function getUrl(){ return 'http://localhost/myforadmin/';}
if(isset($email_cont)){

	$email = trim($email_cont);
	$assunto = trim($assunto_cont);
	$descricao = trim($descricao_cont);
	$arquivo = $_FILES['anexo_cont']; 
	$tamanho = 4194304; 
	$tipos = array('application/msword','application/vnd.openxmlformats-officedocument.wordprocessingml.document','application/vnd.ms-excel','application/pdf','image/pjpeg','image/jpeg','image/x-png','image/png'); 
	 
	if(!filter_var($email, FILTER_VALIDATE_EMAIL)){ 
	echo json_encode(array("msg"=>"Este e-mail é inválido !","diverro"=>"i_email_cont"));
	}elseif($assunto==""){ 
	echo json_encode(array("msg"=>"Assunto está em branco !","diverro"=>"i_assunto_cont"));
	}elseif($descricao==""){ 
	echo json_encode(array("msg"=>"Descrição está em branco !","diverro"=>"i_descricao_cont"));
	}else{
		 if(is_uploaded_file($arquivo['tmp_name'])){
			 if(!in_array($arquivo['type'], $tipos)){ 
			 echo json_encode(array("msg"=>"Tipo de arquivo não permetido !","diverro"=>"label_ane2"));
			 exit();
			 }elseif($arquivo['size']>$tamanho){ 
			 echo json_encode(array("msg"=>"O limite do tamanho do arquivo é de 4MB !","diverro"=>"label_ane2"));
			 exit();	
			 }else{ 
				$anexo=$arquivo;
			 }
		 }else{
			$anexo=false;	
		 }
		
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
                    	<span><font size="2" face="Arial, Helvetica, sans-serif"><strong>'.nl2br($assunto).',</strong></font></span>
                    </td>
                </tr>
				<tr><td colspan="4">&nbsp;</td></tr>				
				<tr>
                	<td colspan="4">
						<span><font size="2" face="Arial, Helvetica, sans-serif">'.nl2br($descricao).'</font></span>
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
		$msgTXT='('.$assunto.'). '.$descricao;
		include('../_classes/Mail.class.php');		
		$mail= new Mail;		
		if($mail->sendMail($email,'Contato (Solicitação)',$assunto,$msgHTML,$msgTXT,true,$anexo)){
		 echo json_encode(array("msg"=>"","diverro"=>""));
		}else{
    	echo json_encode(array("msg"=>"Ocorreu um erro ao enviar solicitação, por favor, tente novamente !","diverro"=>"erro"));
		}
	}
}
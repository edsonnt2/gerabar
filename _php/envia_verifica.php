<?php
$link = getUrl().'verificar_email.php?utilizador='.$email.'&confirmacao='.$chave;

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
                    	<span><font size="2" face="Arial, Helvetica, sans-serif">Olá '.$nome.' '.$sobrenome.',</font></span>
                    </td>
                </tr>
                <tr>
                	<td colspan="4">
						<span><font size="2" face="Arial, Helvetica, sans-serif">'.$msgCima.'</font></span>
                    </td>
                </tr>
				<tr><td colspan="4">&nbsp;</td></tr>
                <tr>
                	<td colspan="4">
						<span><font size="2" face="Arial, Helvetica, sans-serif">Para verificar seu e-mail no <a href="'.getUrl().'" target="_blank">Gerabar.com.br</a> clique no link abaixo:</font></span>
                    </td>
                </tr>
				<tr><td colspan="4">&nbsp;</td></tr>
				<tr>
                	<td colspan="4">
						<font size="2" face="Arial, Helvetica, sans-serif" color="#0055BB"><a href="'.$link.'" target="_blank" style=" color:#0055BB;"><span style=" color:#0055BB;">'.$link.'</span></a></font>
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
                        <font size="5" face="Arial, Helvetica, sans-serif" color="#444"><b><a href="'.getUrl().'" style=" text-decoration:none; color:#444;"><span style="text-decoration:none; color#444;">Gerabar Gerenciador Online</span></a></b></font>
                    </td>
                </tr>
                <tr><td colspan="4">&nbsp;</td></tr>
				<tr><td colspan="4">&nbsp;</td></tr>
            </table>            
        </td>
    </tr>
</table>';		
		$msgTXT='Olá '.$nome.' '.$sobrenome.'. Para verificar seu e-mail no Gerabar copie e cole em seu navegador o link a seguir: '.$link.'. Para mais informações acesse gerabar.com.br. Att. Equipe Gerabar.';
		include('../_classes/Mail.class.php');
		$mail= new Mail;
		$subtitulo = 'Verificação de e-mail';		
		$mail->sendMail($email,$nome.' '.$sobrenome,$subtitulo,$msgHTML,$msgTXT);
		
		if(isset($novoCadastro)){
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
                    	<span><font size="2" face="Arial, Helvetica, sans-serif">Usuário novo cadastrado !</font></span>
                    </td>
                </tr>
				<tr>
                	<td colspan="4">
						<span><font size="2" face="Arial, Helvetica, sans-serif">Nome: '.$nome.' '.$sobrenome.', legal :)</font></span>
                    </td>
                </tr>
                <tr>
                	<td colspan="4">
						<span><font size="2" face="Arial, Helvetica, sans-serif">E-mail: '.$email.'</font></span>
                    </td>
                </tr>
                <tr><td colspan="4">&nbsp;</td></tr>
                <tr>
                	<td colspan="2">
                        <font size="5" face="Arial, Helvetica, sans-serif" color="#444"><b><a href="'.getUrl().'" style=" text-decoration:none; color:#444;"><span style="text-decoration:none; color#444;">Gerabar Gerenciador Online</span></a></b></font>
                    </td>
                </tr>
                <tr><td colspan="4">&nbsp;</td></tr>
				<tr><td colspan="4">&nbsp;</td></tr>
            </table>            
        </td>
    </tr>
</table>';
		$msgTXT='Usuário novo cadastrado ! Nome: '.$nome.' '.$sobrenome.', legal :)';
		$subtitulo = 'Usuário novo cadastrado';		
		$mail->sendMail('contato@gerabar.com.br','',$subtitulo,$msgHTML,$msgTXT);
		}
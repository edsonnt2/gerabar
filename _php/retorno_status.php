<?php
//header("access-control-allow-origin: https://sandbox.pagseguro.uol.com.br");

function getUrl(){ return 'http://localhost/myforadmin/';}

if(isset($_POST['notificationType'])){
    
    if($_POST['notificationType']=="preApproval" || $_POST['notificationType']=="transaction"){
        include('../_classes/PagSeguro.class.php');
		$pagSet = new PagSeguro;
        
        $retornoBoleto=($_POST['notificationType']=="transaction")?true:false;
        
		$pagRet=$pagSet->retornoPagamento($_POST['notificationCode'],$retornoBoleto);
        
        
            
            include("../_classes/DB.class.php");
            include('../_classes/Cadastros.class.php');
            
            if($retornoBoleto==true){
            $status_ass=$pagRet->status;
			$codigo_ass=$pagRet->code;
            $email_ass=$pagRet->sender->email;
            $nome_completo=$pagRet->sender->name;
            }else{
			$status_ass=$pagRet["status"];
			$codigo_ass=$pagRet["code"];
            $email_ass=$pagRet["sender"]["email"];
            $nome_completo=$pagRet["sender"]["name"];
            }
            
            if($retornoBoleto==true && $status_ass==1){
			$enviaComBoleto=$pagRet->paymentLink;
			}	
            
            if($status_ass==3 || $status_ass==4){
                $status_ass="ACTIVE";
            }
            
            $planoAss=Cadastros::altAssinaturas($status_ass,$codigo_ass);
            
            if($planoAss!=false){
            $atualizarPedido=true;                
             $_SESSION['Gerabar_plano']=($status_ass=="ACTIVE")?1:0;
            } 
		
	}
    
	
	if(isset($atualizarPedido)){
        
        $assunto=($planoAss==1)?"Plano Premium Anual":"Plano Premium Mensal";
        
        if($status_ass==1){
            $descricao="Estamos aguardando o pagamento do boleto para dar continuidade ao seu contrato ! </br> Caso teve algum problema, por favor, entre em contato nossa equipe.";
        }elseif($status_ass=="INITIATED"){
            $descricao="Nosso sistema identificou uma tentativa de assinatura que ficou pendente. </br> Caso teve algum problema, por favor, entre em contato nossa equipe.";
        }elseif($status_ass=="PENDING" || $status_ass==2){
            $descricao="Seu contrato para o ".$assunto." está em análise.";
        }elseif($status_ass=="ACTIVE"){
            $descricao="Seu contrato para o ".$assunto." foi aprovado. </br> Acesse sua conta e aproveite o seu plano ao máximo.";
        }elseif($status_ass=="PAYMENT_METHOD_CHANGE"){
            $descricao="Identificamos que ouve um problema com seu cartão, por favor, </br> substitua seu cartão ou altere o meio de pagamento.";
        }elseif($status_ass=="SUSPENDED"){
            $descricao="Devido a problemas em nosso sistema, resolvemos suspender seu ".$assunto.". </br> Desculpe-nos pelo transtorno.";
        }elseif($status_ass=="CANCELLED"){
            $descricao="Nossa empresa de recorrência (PagSeguro) cancelou seu ".$assunto.", por favor, </br> entre em contato com nossa equipe.";
        }elseif($status_ass=="CANCELLED_BY_RECEIVER" || $status_ass==7 || $status_ass==6){
            $descricao="Seu ".$assunto." foi cancelado pelo nosso sistema. </br> Sentiremos sua falta. ";
        }elseif($status_ass=="CANCELLED_BY_SENDER"){
            $descricao="Nosso sistema identificou que o seu ".$assunto." foi cancelado. </br> Sentiremos sua falta.";
        }elseif($status_ass=="EXPIRED"){
            $descricao="Nosso sistema identifiou que o seu ".$assunto." expirou.";
        }else{
        $descricao="Seu contrato para o ".$assunto." está em análise.";
        }
        
        if(isset($enviaComBoleto)){
            $boletoEnvio='<tr>
                <td colspan="4">
                    <span><font size="2" face="Arial, Helvetica, sans-serif">Caso ainda não tenha imprimido seu boleto <a href="'.$enviaComBoleto.'" style="color:#0055BB !important;">clique aqui</a> para imprimir.</font></span>
                </td>
            </tr>';
        }else{
            $boletoEnvio="";
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
                    	<span><font size="2" face="Arial, Helvetica, sans-serif"><strong>Olá '.$nome_completo.',</strong></font></span>
                    </td>
                </tr>
				<tr><td colspan="4">&nbsp;</td></tr>				
                <tr>
                	<td colspan="4">
                    	<span><font size="2" face="Arial, Helvetica, sans-serif">'.$descricao.'</font></span>
                    </td>
                </tr>
                '.$boletoEnvio.'
				<tr><td colspan="4">&nbsp;</td></tr>
				<tr>
                	<td colspan="4">
						<span><font size="2" face="Arial, Helvetica, sans-serif">Obrigado por usar o serviço Gerabar.</font></span>
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
        
		$msgTXT='('.$assunto.'). '.$descricao.' Obrigado por usar o serviço Gerabar.';
		include('../_classes/Mail.class.php');		
		$mail= new Mail;
		if($mail->sendMail($email_ass,$nome_completo,"Gerabar | ".$assunto,$msgHTML,$msgTXT)){
		 echo "200 OK";
		}else{
    	echo "500 ERROR";
		}
}       
	
}
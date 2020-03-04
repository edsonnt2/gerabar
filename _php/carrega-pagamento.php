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

if(isset($_GET["concluirFree"])){
    
    echo '<div class="caixaTran"><h3>PLANO GRÁTIS CONTRATO</h3>
    <p>Seu contrato foi aprovato.</p>
    <p>Obrigado por usar o serviço Gerabar, <a href="'.getUrl().'">clique aqui</a> para ir para a página inicial.</p>
    </div>';
    unset($_SESSION['salvar_plano']);
    exit();
}

extract($_POST);
if(isset($pagSeguro)){
        include('../_classes/Cadastros.class.php');
        include("../_classes/PagSeguro.class.php");
        $classPag = new PagSeguro();
    
        if($pagSeguro=='carregaId'){
		$idSessaoPag = $classPag->iniciaPagamentoAction();
		if($idSessaoPag){
		echo $idSessaoPag;
		}
	   }elseif(isset($cancelarPlano)){
            
            $idDaSessao = $_SESSION['Gerabar_uid'];
            $dadosUsuario=Cadastros::selDadosUsuario($idDaSessao);
            if($dadosUsuario['num']>0){
            $chave=$dadosUsuario['dados']['cod_assinatura'];
            }else{
                echo 'Ocorreu um erro inesperado ao cancelar seu contrato, por favor, tente novamente !|erro';
                exit();
            }
            $dadosCancel= $classPag->cancelarPagamento($chave);
            if(isset($dadosCancel['error'])){
                echo $dadosCancel['errors'].'|erro';
            }else{
                $status_ass=$pagSet["status"];
                
                
                
                if($planoAss=Cadastros::altAssinaturas("CANCELLED_BY_RECEIVER",$chave)){
                $_SESSION['Gerabar_plano']=0;
                    echo '|';
                }else{
                echo 'Ocorreu um erro inesperado ao cancelar seu contrato, por favor, tente novamente !|erro';
                }
                
                
            }

        }elseif($pagSeguro=="salvaDados"){
            
        if($plano=="0" || $valorTotal=="0"){            
        echo 'Ocorrou um erro ao finalizar contrato. O plano selecionado não confere !|erro';
        exit();
        }
        
        function formato_valor($variavel,$padrao=false){
            if($padrao==true){
            $valForm=str_replace('.','',$variavel);
            $variavel=str_replace(',','.',$valForm);
            }
            $sep=explode('.',$variavel);
            if(!isset($sep[1])){
            $fimVal='00';
            }else{
            $fimVal=(strlen($sep[1])==1)?$sep[1].'0':$sep[1];
            }
            return $sep[0].'.'.$fimVal;
        }

        $cep=trim($cep);
        $endereco=trim($endereco);
        $numero=trim($numero);
        $bairro=trim($bairro);
        $cidade=trim($cidade);
        $estado=trim($estado);
        $plano=(int)$plano;
        $valTotal=trim($valorTotal);
        if($cep==""){
        echo 'Cep está em branco !|pcd_cep';
        }elseif($endereco==""){
        echo 'Endereço está em branco !|pcd_endereco';		
        }elseif($numero==""){
        echo 'Número está em branco !|pcd_numero';
        }elseif($bairro==""){
        echo 'Bairro está em branco !|pcd_bairro';
        }elseif($cidade==""){
        echo 'Cidade está em branco !|pcd_cidade';
        }elseif($estado==""){
        echo 'Estado está em branco !|pcd_estado';
        }elseif($plano!="1" && $plano!="2"){
        echo 'Plano selecionado não confere, por favor, tente novamente !|erro';
        }elseif($valTotal!="14.9" && $valTotal!="79.9"){
        echo 'Plano selecionado não confere, por favor, tente novamente !|erro';
        }elseif($plano=="1" && $valTotal!="79.9"){
        echo 'Plano selecionado não confere, por favor, tente novamente !|erro';
        }elseif($plano=="2" && $valTotal!="14.9"){
        echo 'Plano selecionado não confere, por favor, tente novamente !|erro';
        }else{
            /*
            include("../_classes/Validar.class.php");
            $cpfSepara=explode('-',$cpfTitular);
            $cpfPri=str_replace('.','',$cpfSepara[0]);
            $cpfSeg=$cpfSepara[1];            
            if(Validar::validar_cpf($cpfPri,$cpfSeg)==true){
                echo 'CPF informado é inválido !|pg_cpf';
                exit();
            }
            */
            
            $dadosPagamento=array();
            $cpfSalvar=$cpfTitular;
            $telSalvar=$telTitular;
            $cpfTitular=str_replace('.','',$cpfTitular);
            $cpfTitular=str_replace('-','',$cpfTitular);
            $cepEditado=str_replace('-','',$cep);

            //$valParcela=formato_valor($valTotal);	

            $telT = explode(' ',$telTitular);
            $coAreaTitular=preg_replace("/[^0-9]/","",$telT[0]);
            $telTitular=preg_replace("/[^0-9]/","",$telT[1]);
            
            if($method=="creditCard"){
            include("../_classes/formata_texto.php");
            $dadosPagamento['plano']=$plano; //gerado via javascript
            $dadosPagamento['tokenDoCard']=$tokenPaga; //gerado via javascript
            $dadosPagamento['NomeTitular']=converter($nomeTitular,1); //nome do titular
            $dadosPagamento['codigoHash']=$identificador; //gerado via javascript		
            $dadosPagamento['dataNascimentoTitular']=$dataDia.'/'.$dataMes.'/'.$dataAno; //PADRÃO 31/12/1999                
            }
                
            $dadosPagamento['cpfTitular']=$cpfTitular;
            $dadosPagamento['codigoDeAreaTitular']=$coAreaTitular;
            $dadosPagamento['telefoneTitual']=$telTitular;
            $dadosPagamento['nomeRua']=$endereco;
            $dadosPagamento['numeroCasa']=$numero;
            $dadosPagamento['bairro']=$bairro;
            $dadosPagamento['cep']=$cepEditado;
            $dadosPagamento['complementoEnd']=$complemento;
            $dadosPagamento['cidade']=$cidade;
            $dadosPagamento['estado']=$estado;    
            
            
            $idDaSessao = $_SESSION['Gerabar_uid'];    
            $dadosUsuario=Cadastros::selDadosUsuario($idDaSessao);	
            if($dadosUsuario['num']>0){        
            $nomeUsu=$dadosUsuario['dados']['nome'].' '.$dadosUsuario['dados']['sobrenome'];	
            $emailUsu=$dadosUsuario['dados']['email'];
            }else{
                echo 'Ocorreu um erro inesperado ao finalizar contrato, por favor, tente novamente !|erro';
                exit();
            }
            $dadosPagamento['nomeUsuario']=$nomeUsu; //nome do usuário deve conter nome e sobrenome
            $dadosPagamento['emailUsuario']=$emailUsu; //,
            
            $dadosPag = $classPag->efetuaPagamento($dadosPagamento,$method);
            
            if(isset($dadosPag['error'])){
                $error= explode(':',$dadosPag['errors']);
                
                if($method=="creditCard"){
                    $erroCpf="pg_cpf";
                    $erroTel="pg_tel";
                }else{
                    $erroCpf="cpf_boleto";
                    $erroTel="tel_boleto";
                }
                
                    if($error[0]=="senderPhone invalid value"){
                        echo 'Telefone informado é inválido !|'.$erroTel;
                    }elseif($error[0]=="cpf is invalid" || $error[0]==1114){
                        echo 'CPF informado é inválido !|'.$erroCpf;
                    }elseif($error[0]=="sender email invalid domain"){
                echo 'Seu e-mail cadastrado é inválido, por favor, coloque um e-mail válido indo em "configurações" e tente contratar seu plano novamente !|erro';
                    }else{
                        echo $dadosPag['errors'].'|erro';
                    }
                }else{
                
                $dadosSalvar=array();
                
                if($method=="creditCard"){
                    $dadosSalvar['codCartao']=$dadosPag;
                    $linkBoleto="";
                    $metodo=1;
                }else{                    
                    $dadosSalvar['codBoleto']=$dadosPag['code'];
                    $dadosSalvar['linkBoleto']=$dadosPag['paymentLink'];
                    $linkBoleto=$dadosPag['paymentLink'];
                    $dadosSalvar['codBarraBoleto']=$dadosPag['barcode'];
                    $dadosSalvar['dataVencimento']=$dadosPag['dueDate'];                    
                    $metodo=2;
                }
                
                $table = $_SESSION['Gerabar_table'];
                $idEmpre = Cadastros::selectIdEmpresa($idDaSessao,$table);
                $id_empresa=($idEmpre['num']>0)?$idEmpre['dados'][0]:0;
                if(Cadastros::salEndereco(strip_tags($cep),strip_tags($endereco),strip_tags($numero),strip_tags($complemento),strip_tags($bairro),strip_tags($cidade),strip_tags($estado),$plano,$dadosSalvar,$idDaSessao,$id_empresa,$metodo,$cpfSalvar,$telSalvar)){
                    
                    if($method=='boleto'){
                    $txtBoleto='<p>Caso seu boleto não tenho sido aberto, <a href="'.$dadosPag['paymentLink'].'" target="_blank">clique aqui</a> para abrir e imprimir.</p>';
                    $txt1='AGUARDANDO PAGAMENTO';
                    $txt2='Estamos aguardando o pagamento do boleto.';
                    }else{
                    $txtBoleto='';
                    $txt1='EM ANÁLISE';
                    $txt2='Seu contrato está em análise.';
                    }
                    
                    echo '
                    <div class="caixaTran"><h3>ADESÃO '.$txt1.'</h3>
                    <p>'.$txt2.'</p>
                    '.$txtBoleto.'
                    <p>Obrigado por usar o serviço Gerabar, <a href="'.getUrl().'">clique aqui</a> para ir para a página inicial.</p>
                    </div>||'.$linkBoleto;
                    unset($_SESSION['salvar_plano']);
                }else{
                    echo 'Ocorreu um erro inesperado ao finalizar contrato, por favor, tente novamente !|erro';
                }

            } //fecha confirma Pagamento


        } // fecha validade formulario

    }else{
        echo 'Ocorreu um erro inesperado ao finalizar contrato, por favor, tente novamente !|erro';
    }

}else{
    echo 'Ocorreu um erro inesperado ao finalizar contrato, por favor, tente novamente !|erro';
}




    
/*$boletoEmail='<tr>
	<td colspan="4">
		<span><font size="4" face="Arial, Helvetica, sans-serif"><b>Caso ainda não tenha imprimido seu boleto <a href="'.$link_paga.'" style="color:#0055BB;">clique aqui</a> para imprimir.</b></font></span>
	</td>
</tr>';*/
			/*		
	$msgHTML='<table cellpadding="0" cellspacing="0" border="0" width="100%" bgcolor="#fafafa" align="center">
	<tr>
    	<td>
        	<table cellpadding="0" cellspacing="10" border="0" width="750px" align="center" bgcolor="#fff" style="width:750px; font-size:14px !important; font-family:Arial, Helvetica, sans-serif !important; line-height:30px !important; color:#333 !important;">
            	<tr>
                	<td colspan="4" background="'.getUrl().'/_imgs/fundo1.jpg">
                    <div align="center" style="padding:10px 0 2px 0;"><img src="'.getUrl().'/_imgs/logo-moda-royale.png" width="300px" /></div>
                    </td>
                </tr>                
                <tr>
                	<td colspan="4">
                    	<span><font size="4" face="Arial, Helvetica, sans-serif">Olá '.$nomeUsu.',</font></span>
                    </td>
                </tr>                
                <tr>
                	<td colspan="4">
	                    <span><font size="4" face="Arial, Helvetica, sans-serif">Sua compra no valor de R$ '.number_format($valorCompra,2,',','.').' está em processo.</br>
                    	Status atual: '.$status.'</br>
                        O número do seu pedido é: '.$pedido.'</font></span>
                    </td>
                </tr>
                '.$boletoEmail.'
                <tr><td colspan="4">&nbsp;</td></tr>
                <tr><td colspan="4">&nbsp;</td></tr>
                <tr>
                	<td colspan="4">
                    	<span><font size="4" face="Arial, Helvetica, sans-serif"><b>Para acesso Moda Royale e visualizar seu pedido <a href="'.getUrl().'/meus_pedidos" style="color:#0055BB;">clique aqui</a>.</br>
						Ou entre em contato conosno pelo Telefone/Whatsapp: (19) 98162-5456</b></font></span>
                    </td>
                </tr>
                <tr>
                	<td colspan="2">
                        <span><font size="6" face="Arial, Helvetica, sans-serif" color="#DEA90C"><b><a href="'.getUrl().'" style=" color:#DEA90C; text-decoration:none !important;">Moda Royale</a></b></font></span>
                    </td>
                </tr>
                <tr><td colspan="4">&nbsp;</td></tr>
				<tr><td colspan="4">&nbsp;</td></tr>
            </table>            
        </td>
    </tr>
</table>';
			
			$msgTXT='Olá '.$nomeUsu.', seu pedido de número '.$pedido.' está com o status "'.$status.'". Para mais informações acesse modaroyale.com.br. Att. Equepe Moda Royale.';
			
			include('../_classes/Mail.class.php');
			$mail= new Mail;
			
			$mail->sendMail($emailUsu,$nomeUsu,'Recebemos seu Pedido',$msgHTML,$msgTXT);
			*/
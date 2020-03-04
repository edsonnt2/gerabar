<?php
	/*
	SANDBOX
	 //EMAIL: edson_nt2@hotmail.com
	 //TOKEN: C1B269A6E53E41CDABD38F7773DD6B33
	 //EMAIL USUARIO: edson@sandbox.pagseguro.com.br
	 
	PRODUÇÃO
	 //EMAIL: edson_nt2@hotmail.com
	 //TOKEN: 2D6A86420D584C668890386A02C67479
	 */

    require_once "vendor/autoload.php";


    require "vendor/carloswgama/php-pagseguro/examples/_autoload.class.php";    
    use CWG\PagSeguro\PagSeguroAssinaturas;

	class PagSeguro{
        
		private $preEmail="edson_kollombo@hotmail.com";
		private $preToken="4117f42e-5d67-4372-b36c-a19e6d0e0f82f9d90fe041f18b194abc0ab46281510517be-9d73-463c-afba-676c22aa444e";
		private $preProducao="";
        private $sandbox=false;
        
        public function createPlano($codReferencia,$plano,$periodo,$valorPlano){
			$emailPagseguro = $this->preEmail;
			$token = $this->preToken; //token teste SANDBOX
            $producao=$this->preProducao;
            
            /*
            if($codReferencia=="001"){
            $plano='Premium Anual';
            $periodo='YEARLY';
            $valorPlano='79.90';
            }else{
            $plano='Premium Mensal';
            $periodo='MONTHLY'; //MONTHLY | YEARLY
            $valorPlano='14.90';                
            } 
            */
            
            $descricaoPlano='Plano '.$plano.' para uso completo do sistema Gerabar';            
          include('vendor/pagseguro/pagseguro-php-sdk/public/DirectPreApproval/createPlan.php');
            
		}
        
        public function iniciaPagamentoAction() { //gera o código de sessão obrigatório para gerar identificador (hash)
            
			$emailPagseguro = $this->preEmail;
			$token = $this->preToken; //token teste SANDBOX
            $producao=($this->sandbox==true)?'sandbox':'production';
            include('vendor/pagseguro/pagseguro-php-sdk/public/Configuration/dynamicConfiguration.php');
            
            
		}
        
        public function efetuaPagamento($dados,$method) {
			//$method  creditCard  || boleto
            
            if($method=="creditCard"){

            //$emailPagseguro = $this->preEmail;
            //$token = $this->preToken; //token teste SANDBOX
            //$producao=$this->preProducao;        
            $codAnual='C8AC25434B4B26E884019FACA31B6660';
            $codMensal='6E52CFD58989980664B40FA7F3165845';

            if($dados['plano']=='1'){
            $codPlano= $codAnual;
            $codReferencia= '001';    
            }else{
            $codPlano= $codMensal;
            $codReferencia= '002';
            }
                
                $pagseguro = new PagSeguroAssinaturas($this->preEmail, $this->preToken, $this->sandbox);

                //Nome do comprador / Nome do comprador igual a como esta no CARTÂO
                $pagseguro->setNomeCliente($dados['nomeUsuario'],$dados['NomeTitular']);
                //Email do comprovador
                $pagseguro->setEmailCliente($dados['emailUsuario']); //colocar isso edson@sandbox.pagseguro.com.br
                //Informa o telefone DD e número
                $pagseguro->setTelefone($dados['codigoDeAreaTitular'], $dados['telefoneTitual']);
                //Informa o CPF
                $pagseguro->setCPF($dados['cpfTitular']);
                //Informa o endereço RUA, NUMERO, COMPLEMENTO, BAIRRO, CIDADE, ESTADO, CEP
                $pagseguro->setEnderecoCliente($dados['nomeRua'], $dados['numeroCasa'], $dados['complementoEnd'], $dados['bairro'], $dados['cidade'], $dados['estado'], $dados['cep']);
                //Informa o ano de nascimento
                $pagseguro->setNascimentoCliente($dados['dataNascimentoTitular']);
                //Infora o Hash  gerado na etapa anterior (assinando.php), é obrigatório para comunicação com checkoutr transparente
                $pagseguro->setHashCliente($dados['codigoHash']);
                //Informa o Token do Cartão de Crédito gerado na etapa anterior (assinando.php)
                $pagseguro->setTokenCartao($dados['tokenDoCard']);
                //Código usado pelo vendedor para identificar qual é a compra
                $pagseguro->setReferencia($codReferencia);
                //Plano usado (Esse código é criado durante a criação do plano)
                $pagseguro->setPlanoCode($codPlano);
                //No ambiente de testes funciona normalmente sem o IP, no ambiente "real", mesmo na documentação falando que é opcional, precisei passar o IP ($_SERVER['HTTP_CLIENT_IP'];) do cliente para finalizar corretamente a assinatura
                // https://comunidade.pagseguro.uol.com.br/hc/pt-br/community/posts/360001810594-Pagamento-Recorrente-Cancelado- (o erro e a solução encontrada)                
                $pagseguro->setIPCliente($_SERVER['REMOTE_ADDR']);

                try{
                    return  $pagseguro->assinaPlano();
                } catch (Exception $e) {
                    $err['error']=true;
                    $err['errors']=$e->getMessage();
                    return $err;
                }

            }else{
                
            //$data['reference']=$dados["codReferencia"]; //codigo do boleto no sistema
            $data['firstDueDate']=date('Y-m-d', strtotime('+5 days')); // data vencimento primeiro boleto
            $data['numberOfPayments']=1;
            $data['periodicity']='monthly';
            $data['amount']="13.90";
            $data['instructions']='Não cobrar juros após o vencimento';
            $data['description']='Adesão do Plano Premium Mensal no gerenciador Gerabar';
                
                $dadosCustomer['document']['type']='CPF'; // cpf assinante
                $dadosCustomer['document']['value']=$dados['cpfTitular']; // numero cpf
                
                $dadosCustomer['phone']['areaCode']=$dados['codigoDeAreaTitular']; // DDD do telefone
                $dadosCustomer['phone']['number']=$dados['telefoneTitual']; // Numero do telefone sem DDD
                
                $dadosCustomer['name']=$dados['nomeUsuario']; // Nome do cliente á contratar a adesão
                $dadosCustomer['email']=$dados['emailUsuario']; // e-mail da pessoa a contratar a adesão
                

                $dadosCustomer['address']['postalCode']=$dados['cep']; 
                $dadosCustomer['address']['street']=$dados['nomeRua'];
                $dadosCustomer['address']['number']=$dados['numeroCasa'];
                $dadosCustomer['address']['complement']=$dados['complementoEnd'];

                $dadosCustomer['address']['district']=$dados['bairro'];
                $dadosCustomer['address']['city']=$dados['cidade'];
                $dadosCustomer['address']['state']=$dados['estado'];
       
            $data['customer']=$dadosCustomer;
            
            /*TESTE CREDENCIAL*/
            
            $dadoCred['email'] = $this->preEmail;
            $dadoCred['token'] = $this->preToken;
            $credenciais= '?'.http_build_query($dadoCred);            
            $headers = array('Content-Type: application/json;charset=ISO-8859-1',
                            'Accept: application/json;charset=ISO-8859-1');            
            
                $curl = curl_init("https://ws.pagseguro.uol.com.br/recurring-payment/boletos".$credenciais);
                curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "POST");
                curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
                @curl_setopt($curl, CURLOPT_SAFE_UPLOAD, false);
                if (!empty($data))
                    curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($data));
                curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
                $curl_response = curl_exec($curl);
                $response = curl_getinfo($curl);
                $response['body'] = json_decode($curl_response, true);
                curl_close($curl);
                
                if ($response['http_code'] == 201) {
                    return $response['body']['boletos'][0];
                } else {
                    //print_r($response['body']['errors']);
                    $err['error']=true;
                    $err['errors']=$response['body']['errors'][0]['code'];
                    return $err;
                }
                
            }	

		}
        
        public function cancelarPagamento($assinaturaCode){
            $pagseguro = new PagSeguroAssinaturas($this->preEmail, $this->preToken, $this->sandbox);
            try {
                return $pagseguro->cancelarAssinatura($assinaturaCode);
            } catch (Exception $e) {
                $err['error']=true;
                $err['errors']=$e->getMessage();
                return $err;
            }
        }
        
		public function retornoPagamento($notificationCode,$boleto=false) { //gera o código de sessão obrigatório para gerar identificador (hash)            
            if($boleto==false){
            $pagseguro = new PagSeguroAssinaturas($this->preEmail, $this->preToken, $this->sandbox);
            //Caso seja uma notificação de uma assinatura (preApproval)
            return $pagseguro->consultarNotificacao($notificationCode);
            die;
            }else{
            $emailPagseguro = $this->preEmail;
			$token = $this->preToken; //token teste SANDBOX
			$url = 'https://ws.pagseguro.uol.com.br/v3/transactions/notifications/'.$notificationCode.'?email='.$emailPagseguro.'&token='.$token;
			$headers = array('Content-Type: application/x-www-form-urlencoded; charset=ISO-8859-1');	
			$curl = curl_init();			
			curl_setopt($curl, CURLOPT_URL,$url);
			curl_setopt( $curl,CURLOPT_HTTPHEADER, $headers );
			curl_setopt( $curl,CURLOPT_RETURNTRANSFER, true );
			curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);			
			curl_setopt($curl, CURLOPT_HEADER, false);
			$xml = curl_exec($curl);	
			curl_close($curl);
	
			$xml= simplexml_load_string($xml);
			return $xml;
            }
		}

}
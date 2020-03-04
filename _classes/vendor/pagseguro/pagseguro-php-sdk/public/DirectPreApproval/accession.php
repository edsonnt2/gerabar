<?php
//require_once "../../vendor/autoload.php";

\PagSeguro\Library::initialize();
\PagSeguro\Library::cmsVersion()->setName("Nome")->setRelease("1.0.0");
\PagSeguro\Library::moduleVersion()->setName("Nome")->setRelease("1.0.0");
/**
 *  Para usa o ambiente de testes (sandbox) descomentar a linha abaixo
 */
if($producao=="sandbox"){
\PagSeguro\Configuration\Configure::setEnvironment('sandbox');
}
//\PagSeguro\Configuration\Configure::setLog(true, '/var/www/git/pagseguro/pagseguro-php-sdk/Log.log');

$preApproval = new \PagSeguro\Domains\Requests\DirectPreApproval\Accession();
$preApproval->setPlan($codPlano);
$preApproval->setReference($codReferencia);
$preApproval->setSender()->setName($nomeUso);//assinante
$preApproval->setSender()->setEmail('edson@sandbox.pagseguro.com.br');//assinante $emailUso
$preApproval->setSender()->setHash($codigoHash);//hash assinante
//$preApproval->setSender()->setIp('ip');//assinante
$preApproval->setSender()->setAddress()->withParameters($endereco,$numero,$bairro,$cep,$cidade,$estado,'BRA');//assinante
$document = new \PagSeguro\Domains\DirectPreApproval\Document();
$document->withParameters('CPF', $cpfTitular); //assinante
$preApproval->setSender()->setDocuments($document);
$preApproval->setSender()->setPhone()->withParameters($coAreaTitular,$telTitular); //assinante
$preApproval->setPaymentMethod()->setCreditCard()->setToken($tokenPaga); //token do cartão de crédito gerado via javascript
$preApproval->setPaymentMethod()->setCreditCard()->setHolder()->setName($nomeTitular); //nome do titular do cartão de crédito
$preApproval->setPaymentMethod()->setCreditCard()->setHolder()->setBirthDate($nascimento); //data de nascimento do titular do cartão de crédito
//$document = new \PagSeguro\Domains\DirectPreApproval\Document();
//$document->withParameters('CPF', $cpfTitular); //cpf do titular do cartão de crédito
$preApproval->setPaymentMethod()->setCreditCard()->setHolder()->setDocuments($document);
$preApproval->setPaymentMethod()->setCreditCard()->setHolder()->setPhone()->withParameters($coAreaTitular,$telTitular); //telefone do titular do cartão de crédito
$preApproval->setPaymentMethod()->setCreditCard()->setHolder()->setBillingAddress()->withParameters($endereco,$numero,$bairro,$cep,$cidade,$estado,'BRA'); //endereço do titular do cartão de crédito
try {
    $response = $preApproval->register(
	    new \PagSeguro\Domains\AccountCredentials($emailPagseguro,$token) // credencias do vendedor no pagseguro
    );
    
    $retornoPlano= $response;
    
} catch (Exception $e) {    
    //$retornoPlano='erro_cartao';
    die($e->getMessage());    
}


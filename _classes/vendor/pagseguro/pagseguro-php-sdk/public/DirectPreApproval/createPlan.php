<?php
//require_once "../../../../../vendor/autoload.php";

\PagSeguro\Library::initialize();
\PagSeguro\Library::cmsVersion()->setName("Nome")->setRelease("1.0.0");
\PagSeguro\Library::moduleVersion()->setName("Nome")->setRelease("1.0.0");
/**
 *  Para usa o ambiente de testes (sandbox) descomentar a linha abaixo
 */

/*
$codReferencia="001";
if($codReferencia=="001"){
$plano='Premium Anual';
$periodo='YEARLY';
$valorPlano='79.90';
}else{
$plano='Premium Mensal';
$periodo='MONTHLY'; //MONTHLY | YEARLY
$valorPlano='14.90';                
}
$descricaoPlano='Plano '.$plano.' para uso completo do sistema Gerabar';
$emailPagseguro="edson_kollombo@hotmail.com";
$token="4117f42e-5d67-4372-b36c-a19e6d0e0f82f9d90fe041f18b194abc0ab46281510517be-9d73-463c-afba-676c22aa444e";


http://localhost/myforadmin/_classes/vendor/pagseguro/pagseguro-php-sdk/public/DirectPreApproval/createPlan.php

if($producao=="sandbox"){
\PagSeguro\Configuration\Configure::setEnvironment('sandbox');
}
*/
    
$plan = new \PagSeguro\Domains\Requests\DirectPreApproval\Plan();
//$plan->setRedirectURL('http://meusite.com');
$plan->setReference($codReferencia);
$plan->setPreApproval()->setName($plano);
$plan->setPreApproval()->setCharge('AUTO');
$plan->setPreApproval()->setPeriod($periodo); 
$plan->setPreApproval()->setAmountPerPayment($valorPlano);
//$plan->setPreApproval()->setTrialPeriodDuration(28);
$plan->setPreApproval()->setDetails($descricaoPlano);
//$plan->setPreApproval()->setFinalDate('2018-09-03');
$plan->setPreApproval()->setCancelURL("http://localhost/myforadmin/"); //plano_cancelado.php
//$plan->setReviewURL('http://meusite.com./review');
//$plan->setMaxUses(100);
$plan->setReceiver()->withParameters($emailPagseguro);

try {
    $response = $plan->register(
	    new \PagSeguro\Domains\AccountCredentials($emailPagseguro,$token) // credencias do vendedor no pagseguro
    );
    return $response->code;
} catch (Exception $e) {
    die($e->getMessage());
}

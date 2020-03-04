<?php
//require_once "../../../../../vendor/autoload.php";
$preEmail="edson_nt2@hotmail.com";
$preToken="C1B269A6E53E41CDABD38F7773DD6B33"; //sandbox

\PagSeguro\Library::initialize();
\PagSeguro\Library::cmsVersion()->setName("Nome")->setRelease("1.0.0");
\PagSeguro\Library::moduleVersion()->setName("Nome")->setRelease("1.0.0");

//desativar em produção
\PagSeguro\Configuration\Configure::setEnvironment('sandbox');

try {
    if (\PagSeguro\Helpers\Xhr::hasPost()) {
        $response = \PagSeguro\Services\PreApproval\Notification::check(
            //\PagSeguro\Configuration\Configure::getAccountCredentials()
            new \PagSeguro\Domains\AccountCredentials($preEmail,$preToken) // credencias do vendedor no pagseguro
        );
    } else {
        throw new \InvalidArgumentException($_POST);
    }

    //\PagSeguro\Parsers\PreApproval\Search\Response::setStatus($response->status);
    echo "<pre>";
    $pagSet=$response;
} catch (Exception $e) {
    die($e->getMessage());
}

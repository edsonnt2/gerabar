<?php
header("access-control-allow-origin: https://sandbox.pagseguro.uol.com.br");
//=============================================//
//           Cancelando assinatura		       //
//=============================================//
require "../_autoload.class.php";
use CWG\PagSeguro\PagSeguroAssinaturas;

$email = "edson_nt2@hotmail.com";
$token = "C1B269A6E53E41CDABD38F7773DD6B33";
$sandbox = true;

$pagseguro = new PagSeguroAssinaturas($email, $token, $sandbox);

// $_POST['notificationType'] = 'preApproval';
// $_POST['notificationCode'] = '144F13-CC5C135C13CE-FBB4906F9375-850AB5';

//Caso seja uma notificação de uma assinatura (preApproval)
if ($_POST['notificationType'] == 'preApproval') {
    $codigo = $_POST['notificationCode']; //Recebe o código da notificação e busca as informações de como está a assinatura
    $response = $pagseguro->consultarNotificacao($codigo);
    print_r($response);
    die;
}


<?php
function render($title,$layout,$view,$scripts=[],$data = []) {

    /* Can include user session */


    $templatePath = $_ENV['APP_VIEWS_TEMPLATES_PATH'];
    $pagePath = $_ENV['APP_VIEWS_PAGES_PATH'];

    require_once("{$templatePath}/includes/{$layout}/head.php");
    require_once("{$templatePath}/includes/{$layout}/header.php");
    require_once("{$pagePath}/$view");
    require_once("{$templatePath}/includes/{$layout}/footer.php");
    require_once("{$templatePath}/includes/{$layout}/scripts.php");
}

function request() {
    if ( $_POST != [] ) {
        return (object)$_POST;
    }

    return json_decode( file_get_contents("php://input") );
}

function response($res) {
    ob_start();
    header('Access-Control-Allow-Origin: *');
    header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS, PATCH');
    header("Access-Control-Allow-Headers: *");
    header('Content-Type: application/json; charset=utf-8');
    http_response_code($res['http_code']);
    echo json_encode($res['response']);
    ob_end_flush();
    exit();
}

function isLogged() {
    $isLogged = true;
    $loginTime = $_ENV['APP_USER_LOGIN_TIME'];

    $exist = isExistSession($name = 'user_login_timeout');
    if ( !$exist ) {
        return $isLogged = false;
    }

    $isExpired = isExpiredSession($sessionName='user_login_timeout', $loginTime);
    if ( $exist && $isExpired ) {
        return $isLogged = false;
    }

    return $isLogged;
}

function onlyNumbers(string $value): string
{
    return preg_replace('/\D/', '', $value);
}
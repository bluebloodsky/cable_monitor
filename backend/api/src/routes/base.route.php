<?php
use Slim\Http\Response;
use Slim\Http\Request;

$app->get('/', function (Request $req, Response $resp, $args) {
    return $resp->withJson(['ret'=>'success']);
});

$app->get('/phpinfo', function (Request $req, Response $resp, $args) {
   return phpinfo();
});

$app->post('/error', function (Request $req, Response $resp, $args) {
    throw new CmuException("this is an veryveryveryvery veryveryveryvery veryveryveryvery looooooooooooooooooooooong error test.......");
});

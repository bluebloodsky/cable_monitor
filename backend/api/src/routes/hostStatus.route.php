<?php
use Slim\Http\Response;
use Slim\Http\Request;

$app->group('/host_status', function () {
	$this->get('' , function (Request $req, Response $resp, $args){
        $sysInfo = new HostStatusInfo();
        return $resp->withJson($sysInfo->All());
    });
});

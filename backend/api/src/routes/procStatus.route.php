<?php
use Slim\Http\Response;
use Slim\Http\Request;


$app->group('/proc_status', function () {
    $this->get('' , function (Request $req, Response $resp, $args){
        $proInfo = gGetAllProcInfoArray();
        return $resp->withJson($proInfo);
    });
	$this->get('/{proc_name}' , function (Request $req, Response $resp, $args){
        $procName = $args['proc_name'];
        $proInfo = gGetProcInfoArray($procName);
        return $resp->withJson($proInfo);
    });
    $this->post('/restart/{proc_name}', function (Request $req, Response $resp, $args){
		$params = $req->getQueryParams();
        $procName = $args['proc_name'];
        //Omit the runstatus
        gRestartProc($procName);
        return $resp;
    });
});

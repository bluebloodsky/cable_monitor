<?php
use Slim\Http\Response;
use Slim\Http\Request;

$encryptMiddleware = function (Request $req, Response $resp, $next ) {
    /** @var Response $resp */
    $resp = $next($req, $resp);
    if(!$resp->isSuccessful())
        return;

};

$app->group('/mms_cfg', function (){
    $this->get('', function (Request $req, Response $resp, $args) {
        $cfg = new MmsConfig();
        $RET = $cfg->GetCfgData();
        return $resp->withJson($RET);
    });
    $this->post('', function (Request $req, Response $resp, $args) {
        //$params = $req->getQueryParams();
        $postParams = $req->getParsedBody();
        if(!$postParams)
            throw new CmuException("no data post, check Content-Type or data");

        $cfg = new MmsConfig();
        unset($postParams['command']);
        $cfg->SetCfgData($postParams);

        return $resp;
    });
});

$app->group('/ntp_cfg', function (){
    $this->get('', function (Request $req, Response $resp, $args) {
        $RET = NtpConfig::GetNtpInfo();
        return $resp->withJson($RET);
    });
    $this->post('', function (Request $req, Response $resp, $args) {
        $postParams = $req->getParsedBody();
        unset($postParams['command']);
        NtpConfig::SetNtpInfo($postParams);

        return $resp;
    });
});

$app->group('/log_cfg', function (){
    $this->get('', function (Request $req, Response $resp, $args) {
        $cfg = new LogConfig();
        $RET = $cfg->GetCfgData();
        return $resp->withJson($RET);
    });
    $this->post('', function (Request $req, Response $resp, $args) {
        $postParams = $req->getParsedBody();
        $cfg = new LogConfig();
        unset($postParams['command']);
        $cfg->SetCfgData($postParams);

        return $resp;
    });
});



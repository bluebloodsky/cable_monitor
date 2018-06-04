<?php
use Slim\Http\Response;
use Slim\Http\Request;


$app->group('/sys_time', function () {
    $this->get('', function (Request $req, Response $resp, $args) {

        $RET = TimeSet::GetSysTime();
        return $resp->withJson($RET);
    });
    $this->post('', function (Request $req, Response $resp, $args) {
        $req_val = json_decode($req->getBody(),true);
        $epoch = $req_val['epoch'];
        if (!$epoch)
            return $resp;

        TimeSet::SetSysTime($epoch);
        return $resp;
    });
});

$app->group('/net_set', function () {
    $this->get('', function (Request $req, Response $resp, $args) {
        $RET = NetSet::GetNetPara();
        return $resp->withJson($RET);
    });
    $this->post('', function (Request $req, Response $resp, $args) {
        $req_val = json_decode($req->getBody(),true);
        if(!NetSet::CheckNetParaValidation($req_val))
        	throw new CmuException("Invalid argument post!");

        NetSet::SetNetPara($req_val);
        return $resp;
    });
});

$app->group('/ied_reset', function () {
    $this->post('', function (Request $req, Response $resp, $args) {
        IedSet::SetIedReset();

        return $resp;
    });
});

$app->group('/ied_license', function() {
    $this->get('', function (Request $req, Response $resp, $args) {
        $RET = LiceneseRegister::IsAlreadyRegisted();
        $hash = LiceneseRegister::GetHashString();
        return $resp->withJson(['is_registered'=>$RET, 'ied_hash'=>$hash]);
    });

    $this->post('', function (Request $req, Response $resp, $args) {
        $params = json_decode($req->getBody(), true);
        if (!array_has($params, 'ied_license'))
            throw new CmuException("不合理的上送格式! 缺少ied_license域. ");

        LiceneseRegister::SetHashString($params['ied_license']);

        return $resp;
    });
});

<?php
use Slim\Http\Response;
use Slim\Http\Request;

//获取基本属性
$app->group('/map_params', function(){
    $this->get('', function (Request $req, Response $resp, $args) {
        $RET = InfoCollection::GetMapParams();
       // var_dump($RET);
        //$resp->write($RET);
        return $resp->withJson($RET);
    });
});

$app->group('/sen_types', function () {
    $this->get('', function (Request $req, Response $resp, $args) {
        $RET = InfoCollection::GetAllSensorTypes();
        return $resp->withJson($RET);
    });
});

$app->group('/ln_classes', function () {
    $this->get('', function (Request $req, Response $resp, $args) {
        $RET = InfoCollection::GetAllLnClasses();
        return $resp->withJson($RET);
    });
    $this->post('',function (Request $req , Response $resp , $args){
        $ln_class = json_decode($req->getBody() , true);
        InfoCollection::AddLnClass($ln_class);
        return $resp;
    });
});

$app->group('/attr_tmpls', function () {
    $this->get('', function (Request $req, Response $resp, $args) {
        $RET = InfoCollection::GetAllAttrTemplates();
        return $resp->withJson($RET);
    });

});
$app->group('/commu_proc_attrs', function () {
    $this->get('', function (Request $req, Response $resp, $args) {
        $RET = ProcAttrsExtra::GetAllProcAttrs();
        return $resp->withJson($RET);
    });
    $this->post('', function (Request $req, Response $resp, $args) {
        //$procAttrs = json_decode($req->getBody());
        $procAttrs = $req->getParsedBody();
        ProcAttrsExtra::SetProcAttrs($procAttrs);
        return $resp;
    });

});

$app->get('/debug_templs', function (Request $req, Response $resp, $args) {
    // Omit the params
    //$params = $req->getQueryParams();
    $RET = DebugTemplsExtra::GetAllData();
    return $resp->withJson($RET);
});


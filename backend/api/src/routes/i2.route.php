<?php
use Slim\Http\Response;
use Slim\Http\Request;

$app->group('/i2_sensors', function() {
    $this->get('', function(Request $req, Response $resp, $args) {
        $m = new I2SensorModel();
        $RET = $m->GetAll($req->getQueryParams());
        return $resp->withJson($RET);
    });
    $this->post('/{sensor_id}', function (Request $req, Response $resp, $args) {
        $sensorId = $args['sensor_id'];
        $params = json_decode($req->getBody() , true);
        $m = new I2SensorModel();
        $m->UpdateInfoById($sensorId, $params);
        return $resp;
    });
    $this->post('', function (Request $req, Response $resp, $args) {
        $params = json_decode($req->getBody() , true);
        $m = new I2SensorModel();
        $m->AddInfo($params);
        return $resp;
    });
    $this->delete('/{sensor_ids}', function (Request $req, Response $resp, $args) {
        $sensorIds = $args['sensor_ids'];
        $m = new I2SensorModel();
        $m->DeleteInfoById(preg_split("/,/", $sensorIds));
        return $resp;
    });

    $this->post('/{sensor_id}/debug_order', function (Request $req, Response $resp, $args) {
        $params = json_decode($req->getBody() , true);
        $sensorId = $args['sensor_id'];
        $m = new I2SensorModel();
        $m->PostSensorDebugOrder($sensorId,$params);
        return $resp;
    });

});

$app->group('/i2_params', function(){
    $this->get('', function (Request $req, Response $resp, $args) {
        $params = $req->getQueryParams();
        $groupId = $params['group_id'];
        $m = new I2ParamsModel();
        if($groupId == null){
          $RET = $m->GetAllInfos();
          return $resp->withJson($RET);
        }
        else{
          $RET = $m->GetParamsByGroupId($groupId);
          return $resp->withJson($RET);
        }
    });

    $this->post('/{i2_param_id}', function (Request $req, Response $resp, $args) {
        $i2ParamId = $args['i2_param_id'];
        $params = json_decode($req->getBody() , true);
        $m = new I2ParamsModel();
        $m->UpdateInfoById($i2ParamId, $params);
        return $resp;
    });

    $this->post('', function (Request $req, Response $resp, $args) {
        $params = json_decode($req->getBody() , true);
        $m = new I2ParamsModel();
        $m->AddInfo($params);
        return $resp;
    });

    $this->delete('/{i2_param_ids}', function (Request $req, Response $resp, $args) {
        $i2ParamIds = $args['i2_param_ids'];
        $m = new I2ParamsModel();
        $m->DeleteInfoById(preg_split("/,/", $i2ParamIds));
        return $resp;
    });

});

$app->group('/cac_infos', function() {
    $this->get('', function (Request $req, Response $resp, $args) {
        $m = new I2CacModel();
        $RET = $m->GetAllInfos();
        return $resp->withJson($RET);
    });
    $this->post('', function (Request $req, Response $resp, $args) {
        $params = json_decode($req->getBody() , true);
        $m = new I2CacModel();
        if(count($params) == 0)
            throw new CmuException("Empty cac data post....");

        $m->DeleteAll();
        $m->AddInfo($params);
        return $resp;
    });
});

$app->group('/cag_infos', function() {
    $this->get('', function (Request $req, Response $resp, $args) {
        $m = new I2CagModel();
        $RET = $m->GetAllInfos();
        return $resp->withJson($RET);
    });
    $this->post('', function (Request $req, Response $resp, $args) {
        $params = json_decode($req->getBody() , true);
        $m = new I2CagModel();
        $m->AddInfo($params);
        return $resp;
    });
    $this->post('/{cag_id}', function (Request $req, Response $resp, $args) {
        $cagId = $args['cag_id'];
        $params = json_decode($req->getBody() , true);
        $m = new I2CagModel();
        $m->UpdateInfoById($cagId, $params);
        return $resp;
    });
    $this->delete('/{cag_ids}', function (Request $req, Response $resp, $args) {
        $cagIds = $args['cag_ids'];
        $m = new I2CagModel();
        $m->DeleteInfoById(preg_split("/,/", $cagIds));
        return $resp;
    });
});

$app->get('/i2_groups', function (Request $req, Response $resp, $args) {
    $params = $req->getQueryParams();
    $fields = [] ;
    if(array_has($params , "fields"))
    {
        $fields = preg_split('/,/', array_get($params, 'fields', ''));
    }
    $m = new I2GroupModel($fields);
    $RET = $m->GetAllInfos();
    return $resp->withJson($RET);
});

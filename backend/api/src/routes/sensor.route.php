<?php
use Slim\Http\Response;
use Slim\Http\Request;

$app->group('/sensors', function () {
	$this->get('' , function (Request $req, Response $resp, $args) {
		$params = $req->getQueryParams();
		$groupby = array_has($params, "groupby") ? $params["groupby"] : '';
        $fields = array_has($params, "fields") ? $params["fields"] : '';
		//$fields = $params["fields"];
		if($fields){
		    $fields = preg_split("/,/" , $fields);
		}else{
			$fields = ['sen_id', 'sen_type', 'ln_class', 'ln_inst' , 'desc_cn'];
		}
		$RET = SensorModel::GetSensorsDataGroupBy($groupby, $fields,$params);
		return $resp->withJson($RET);

	});

	$this->get('/sen_basic_status' , function (Request $req, Response $resp, $args) {
		$RET = SensorBasicStatus::GetCurrentSensorStatus();
        return $resp->withJson($RET);
	});

    $this->get('/all' , function (Request $req, Response $resp, $args) {
		$RET = SensorModel::GetSensorsDataAll();
        return $resp->withJson($RET);
	});

	//***desc: 获取某一设备某一报警原因历史数据
	$this->get('/{id}/sen_basic_status' , function (Request $req, Response $resp, $args) {
		$params = $req->getQueryParams();
		$sen_id = $args['id'];

		$RET = SensorBasicStatus::GetSensorStatusById($sen_id, $params);
        return $resp->withJson($RET);
	});

	$this->get('/{id}/sen_datas' , function (Request $req, Response $resp, $args) {
		$params = $req->getQueryParams();
		$sen_id = $args['id'];
        $RET = SensorData::GetSensorDataById($sen_id, $params);
        return $resp->withJson($RET);
	});

    $this->get('/{id}/sen_csv' , function (Request $req, Response $resp, $args) {
		$params = $req->getQueryParams();
		global  $gTokenHeaderPrefix;
        unset($params[$gTokenHeaderPrefix]);

		$sen_id = $args['id'];
		return SensorData::GetCsvById($sen_id, $params, $resp);
	});

	$this->get('/sen_update' , function (Request $req, Response $resp, $args) {
        $params = $req->getQueryParams();
        $RET = SensorData::GetUpdateSensorInfo($params);
        return $resp->withJson($RET);
    });

    $this->get('/alm_untreat' , function (Request $req, Response $resp, $args) {
        $RET = SensorBasicStatus::GetAlmUntreated();
        return $resp->withJson($RET);
    });

    $this->post('/treat_alm' , function (Request $req, Response $resp, $args) {
        $params = json_decode($req->getBody() , true);
        SensorBasicStatus::SetAlmTreated($params["list_id"]);
        return $resp;
    });

    $this->post('/{sensor_id}/debug_orders' , function (Request $req, Response $resp, $args) {
        $params = json_decode($req->getBody() , true);
        $sensorId = $args['sensor_id'];
        SensorModel::PostSensorDebugOrder($sensorId,$params);
        return $resp;

        /*
        ***type:post
        ***url: api/sensors/$sen_id$/debug_orders
        ***request:
        {
            sen_id:	<int>,
            cmd:	<int>,
            param:	<str>,
        }
        */
        // 不知道这个要怎么实现
    });

	$this->post('' , function (Request $req, Response $resp ) {
        $sensor = json_decode($req->getBody() , true);
        $ret = SensorModel::OnAddSensor($sensor);
		return $resp->withJson($ret);
	});
	$this->post('/{id}' , function (Request $req, Response $resp, $args) {
		$sensor = json_decode($req->getBody() , true);
		$sen_id = $args['id'];
		SensorModel::OnUpdateSensor($sen_id, $sensor);
		return $resp;
    });

	$this->delete('/{ids}' , function (Request $req, Response $resp, $args) {
		$sen_ids = $args['ids'];
		SensorModel::OnDeleteSensor($sen_ids);
		return $resp;
    });

});

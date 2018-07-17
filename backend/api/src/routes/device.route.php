<?php
$app->group('/tunnels', function () {
    $this->get('', function ($req, $resp, $args) {
        global $db;
        $RET = $db->select("tbl_tunnel","*");
        return $resp->withJson($RET);
    });
    $this->post('', function ($req, $resp, $args) {
        global $db;
        $db->pdo->beginTransaction();
        $db->delete("tbl_tunnel",[]);
        $db->insert("tbl_tunnel",json_decode($req->getBody() , true));
        $db->pdo->commit();
        return $resp->withJson([]);
    });
});

$app->group('/wires', function () {
    $this->get('', function ($req, $resp, $args) {
        global $db;
        $RET = $db->select("tbl_wire","*");
        return $resp->withJson($RET);
    });
    $this->post('', function ($req, $resp, $args) {
        global $db;
        $db->pdo->beginTransaction();
        $db->delete("tbl_wire",[]);
        $db->insert("tbl_wire",json_decode($req->getBody() , true));
        $db->pdo->commit();
        return $resp->withJson([]);
    });
});

$app->group('/sections', function () {
    $this->get('', function ($req, $resp, $args) {
        global $db;
        $RET = $db->select("tbl_section","*");
        return $resp->withJson($RET);
    });
    $this->post('', function ($req, $resp, $args) {
        global $db;
        $db->pdo->beginTransaction();
        $db->delete("tbl_section",[]);
        $db->insert("tbl_section",json_decode($req->getBody() , true));
        $db->pdo->commit();
        return $resp->withJson([]);
    });
});

$app->group('/monitor-devices', function () {
    $this->get('', function ($req, $resp, $args) {
        global $db;
        $RET = $db->select("tbl_monitor_device","*");
        return $resp->withJson($RET);
    });
    $this->post('', function ($req, $resp, $args) {
        global $db;
        $db->pdo->beginTransaction();
        $db->delete("tbl_monitor_device",[]);
        $db->insert("tbl_monitor_device",json_decode($req->getBody() , true));
        $db->pdo->commit();
        return $resp->withJson([]);
    });
});

$app->get('/device-cfg' , function ($req, $resp, $args) {
    global $db;
    $wires = $db->select("tbl_wire","*");
    $tunnels = $db->select("tbl_tunnel","*");
    $monitor_types = $db->select("tbl_monitor_type","*");
    $sections = $db->select("tbl_section","*");
    $monitor_params = $db->select("tbl_monitor_param","*");
    $monitor_devices =  $db->select("tbl_monitor_device","*");
      
    return $resp->withJson([
    	"wires" => $wires ,
    	"tunnels" => $tunnels ,
    	"monitor_types" => $monitor_types,
    	"sections" => $sections ,
        "monitor_params" => $monitor_params,
        "monitor_devices" => $monitor_devices
    ]);
});
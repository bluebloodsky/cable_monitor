<?php
$app->group('/tunnels', function () {
    $this->get('', function ($req, $resp, $args) {
        global $db;
        $RET = $db->select("tbl_tunnel","*");
        return $resp->withJson($RET);
    });
});

$app->group('/wires', function () {
    $this->get('', function ($req, $resp, $args) {
        global $db;
        $RET = $db->select("tbl_wire","*");
        return $resp->withJson($RET);
    });
});

$app->group('/sections', function () {
    $this->get('', function ($req, $resp, $args) {
        global $db;
        $RET = $db->select("tbl_section","*");
        return $resp->withJson($RET);
    });
});

$app->group('/monitor-devices', function () {
    $this->get('', function ($req, $resp, $args) {
        global $db;
        $RET = $db->select("tbl_monitor_device","*");
        return $resp->withJson($RET);
    });
});

$app->get('/device-tree' , function ($req, $resp, $args) {
    global $db;
    $wires = $db->select("tbl_wire","*");
    $tunnels = $db->select("tbl_tunnel","*");
    $monitor_types = $db->select("tbl_monitor_type","*");
    $sections = $db->select("tbl_section","*");
    return $resp->withJson([
    	"wires" => $wires ,
    	"tunnels" => $tunnels ,
    	"monitor_types" => $monitor_types,
    	"sections" => $sections 
    ]);
});
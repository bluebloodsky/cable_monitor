<?php
$app->group('/monitor-types', function () {
    $this->get('', function ($req, $resp, $args) {
        global $db;
        $RET = $db->select("tbl_monitor_type","*");
        return $resp->withJson($RET);
    });
    $this->post('', function ($req, $resp, $args) {
        global $db;
        $db->pdo->beginTransaction();
        $db->delete("tbl_monitor_type",[]);
        $db->insert("tbl_monitor_type",json_decode($req->getBody() , true));
        $db->pdo->commit();
        return $resp->withJson([]);
    });
});

$app->group('/monitor-params', function () {
    $this->get('', function ($req, $resp, $args) {
        global $db;
        $RET = $db->select("tbl_monitor_param","*");
        return $resp->withJson($RET);
    });
     $this->post('', function ($req, $resp, $args) {
        global $db;
        $db->pdo->beginTransaction();
        $db->delete("tbl_monitor_param",[]);
        $db->insert("tbl_monitor_param",json_decode($req->getBody() , true));
        $db->pdo->commit();
        return $resp->withJson([]);
    });
});
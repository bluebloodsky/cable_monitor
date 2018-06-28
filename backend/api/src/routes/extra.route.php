<?php
$app->group('/monitor-types', function () {
    $this->get('', function ($req, $resp, $args) {
        global $db;
        $RET = $db->select("tbl_monitor_type","*");
        return $resp->withJson($RET);
    });
});

$app->group('/monitor-params', function () {
    $this->get('', function ($req, $resp, $args) {
        global $db;
        $RET = $db->select("tbl_monitor_param","*");
        return $resp->withJson($RET);
    });
});
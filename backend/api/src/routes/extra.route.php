<?php
$app->group('/monitor-types', function () {
    $this->get('', function ($req, $resp, $args) {
        global $db;
        $RET = $db->select("tbl_monitor_type","*");
        return $resp->withJson($RET);
    });
    $this->get('/his-data' , function($req, $resp, $args) {
        global $db;
        $f_data = $db->select("floathisdata","*");
        $b_data = $db->select("boolhisdata","*");
        return $resp->withJson(array_merge($f_data , $b_data));
    });
});
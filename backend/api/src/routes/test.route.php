<?php
$app->group('/test', function () {
    $this->get('/real-data', function ($req, $resp, $args) {
        global $db;
        $f_data = $db->select("floatrealdata","*");
        $b_data = $db->select("boolrealdata","*");
        return $resp->withJson(array_merge($f_data , $b_data));
    });
    $this->get('/his-data' , function($req, $resp, $args) {
        global $db;
        $f_data = $db->select("floathisdata","*");
        $b_data = $db->select("boolhisdata","*");
        return $resp->withJson(array_merge($f_data , $b_data));
    });
});
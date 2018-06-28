<?php
$app->group('/test', function () {
    $this->get('/real-data', function ($req, $resp, $args) {
        global $db;
        $f_data = $db->select("floatrealdata",[
            "[>]tbl_rel_dev_data"=>"measId" ,
            "[>]tbl_monitor_param"=>["tbl_rel_dev_data.param_name"=>"name"] 
        ],[
            "val" , "tm(data_time)" , "tbl_rel_dev_data.device_name" , "tbl_rel_dev_data.param_name"
        ],[
            "tbl_monitor_param.data_type" => 'FLOAT'
        ]);
        $b_data = $db->select("boolrealdata",[
            "[>]tbl_rel_dev_data"=>"measId" ,
            "[>]tbl_monitor_param"=>["tbl_rel_dev_data.param_name"=>"name"] 
        ],[
            "val" , "tm(data_time)" , "tbl_rel_dev_data.device_name" , "tbl_rel_dev_data.param_name"
        ],[
            "tbl_monitor_param.data_type" => 'BOOL'
        ]);
        $data  = array_merge($f_data , $b_data);

        return $resp->withJson($data);
    });
    $this->get('/his-data' , function($req, $resp, $args) {
        global $db;
        $f_data = $db->select("floathisdata","*");
        $b_data = $db->select("boolhisdata","*");
        return $resp->withJson(array_merge($f_data , $b_data));
    });
});
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
        $params = $req->getQueryParams();
        $hisWhere = [];
        if(array_has($params,'device_name'))
        {
            $hisWhere["AND"]["device_name"] = $params["device_name"];
        }
        if(array_has($params,'time_min'))
        {
            $hisWhere["AND"]["tm[>=]"] = Str2Time($params["time_min"]);
        }
        if(array_has($params,'time_max'))
        {
            $hisWhere["AND"]["tm[<=]"] = Str2Time($params["time_max"]);
        }
        $hisWhere["ORDER"] = "tm";

        $join = [
            "[>]tbl_rel_dev_data"=>"measId" ,
            "[>]tbl_monitor_param"=>["tbl_rel_dev_data.param_name"=>"name"] 
        ];
        $fields = [
            "val" , "tm(data_time)" , "tbl_rel_dev_data.device_name" , "tbl_rel_dev_data.param_name"
        ];
        global $db;
        $hisWhere["AND"]["tbl_monitor_param.data_type"] = "FLOAT";
        $f_data = $db->select("floathisdata", $join,$fields ,$hisWhere);
        $hisWhere["AND"]["tbl_monitor_param.data_type"] = "BOOL";
        $b_data = $db->select("boolhisdata", $join,$fields ,$hisWhere);
        return $resp->withJson(array_merge($f_data , $b_data));
    });
});
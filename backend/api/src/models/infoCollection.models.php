<?php

/*
$g_cfgI2Db = new medoo([
    'database_type' => 'sqlite',
    'database_file' => 'E:\isoms_web\api\config\cfg_i2.sqlite3'
]);
*/

class InfoCollection
{
    static public function GetAllSensorTypes()
    {
        $cfg_db = GetCfgDb();
        $q = $cfg_db->select('sen_type_model', ['sen_type']);
        $resp = array_values($q);
        return [$resp];
    }

    static public function GetMapParams()
    {
        $cfg_db = GetCfgDb();
        //i2基本配置数据
        $i2_db = GetI2DataDb();
        $resp = [];

        //从数据库读取所有设备型号
        $q = $cfg_db->select('sen_type_model', ['sen_type']);
        foreach ($q as $row) {
            $resp["map_sen_type"][] = ['value'=>$row['sen_type'], 'label'=>$row['sen_type']];
        }

        //从数据库读取所有监测类型
        $q = $cfg_db->select('ln_class_model', ['ln_class' , 'desc_cn']);

        foreach ($q as $row) {
            $resp["map_ln_class"][] = ['value'=>$row['ln_class'], 'label'=>$row['desc_cn']];
        }

        //从数据库读取所有通信类型
        $q = $cfg_db->select('commu_type_model', ['commu_type' , 'commu_type_cn']);
        foreach ($q as $row) {
            $resp["map_commu_type"][] = ['value'=>intval($row['commu_type']), 'label'=> $row['commu_type_cn']];
        }

        $q = $i2_db->select("phase_tbl",["phase_id" , "phase_name"],[  "ORDER" => "phase_id"]);
        foreach ($q as $row) {
            $resp["map_phase"][] = ['value'=>intval($row['phase_id']), 'label'=>$row['phase_name']];
        }

        //从数据库中读取设备属性模版
        $q = $cfg_db->select('sen_attr_model', ['ln_class','sen_type','attr','desc_cn','attr_def_val']);
        $map_sen_attr = [] ;
        foreach ($q as $row) {
            $location = -1 ;
            for($i = 0 , $arrlength=count($map_sen_attr); $i < $arrlength ; $i++){
                if($map_sen_attr[$i]["ln_class"] == $row["ln_class"] && $map_sen_attr[$i]["sen_type"] == $row["sen_type"]){
                    $location = $i ;
                    break;
                }
            }            
            if($location == -1){
                $item["ln_class"] = $row["ln_class"] ;
                $item["sen_type"] = $row["sen_type"] ;
                unset($row["ln_class"]);
                unset($row["sen_type"]);
                $item["attrs"] = [] ;
                array_push($item["attrs"],$row);
                //array_push($item["attrs"], ["attr" =>$row["attr"] , "desc_cn" =>$row["desc_cn"] ,  "attr_def_val" =>$row["attr_def_val"] ]);
                array_push($map_sen_attr, $item);
            }
            else{
                unset($row["ln_class"]);
                unset($row["sen_type"]);
                $map_sen_attr[$location]["attrs"][] = $row;
            }
        }
        $resp["map_sen_attr"] = $map_sen_attr;


        //从数据库中读取设备指令模版
        $q = $cfg_db->select('sen_debug_model', ['ln_class','sen_type','cmd','desc_cn','comment','def_data'] );
        gCastIntValue(['cmd'], $q);

        $map_sen_debug = [] ;
        foreach ($q as $row) {
            $location = -1 ;
            for($i = 0 , $arrlength=count($map_sen_debug); $i < $arrlength ; $i++){
                if($map_sen_debug[$i]["ln_class"] == $row["ln_class"] && $map_sen_debug[$i]["sen_type"] == $row["sen_type"]){
                    $location = $i ;
                    break;
                }
            }
            if($location == -1){
                $item["ln_class"] = $row["ln_class"] ;
                $item["sen_type"] = $row["sen_type"] ;
                unset($row["ln_class"]);
                unset($row["sen_type"]);
                $item["attrs"] = [] ;
                array_push($item["attrs"], $row);
                array_push($map_sen_debug, $item);
            }
            else{
                unset($row["ln_class"]);
                unset($row["sen_type"]);
                array_push($map_sen_debug[$location]["attrs"], $row);
            }
        }
        $resp["map_sen_debug"] = $map_sen_debug;

        $q = $cfg_db->select('cdc_type_model', ['cdc_type_id','cdc_type_name','desc_cn']);
        gCastIntValue(['cdc_type_id'], $q);
        $resp["map_cdc_type"] = $q;

        $q = $i2_db->select("i2_group_tbl", ["group_id" , "ln_name" , "group_name" , "group_code" ],[  "ORDER" => "group_id"]);
        gCastIntValue(['group_id'], $q);
        $resp["map_i2_group"] = $q;

        $q = $i2_db->select("i2_debug_model",["cmd(value)","desc_cn(label)"]);
        gCastIntValue(['value'], $q);
        $resp["map_i2_debug"] = $q;
        /*
        foreach ($q as $row) {
            $resp["map_i2_debug"][] = ['value'=>intval($row['cmd']), 'label'=>$row['desc_cn']];
        }
        */

        $q = $i2_db->select("data_type_tbl",["data_type_id","data_type_name"]);
        gCastIntValue(['data_type_id'], $q);
        $resp["map_i2_data_type"] = $q;
        //
        return $resp;
    }
    static public function GetAllAttrTemplates()
    {
        $cfg_db = GetCfgDb();
        $q = $cfg_db->select('sen_attr_model', ['ln_class','sen_type','attr','desc_cn','attr_def_val']);
        $resp = array_values($q);
        return $resp;
    }
    static public function GetAllLnClasses()
    {
        $cfg_db = GetCfgDb();
        $q = $cfg_db->select('ln_class_model', ['ln_class', 'desc_cn']);
        return $q;
    }
    static public function AddLnClass($ln_class)
    {
        $cfg_db = GetCfgDb();
        $ln_class = array_filter($ln_class , function($key){
            return in_array($key , ['ln_class', 'desc_cn']);
        },ARRAY_FILTER_USE_KEY);
        $new_id = $cfg_db->insert('ln_class_model',$ln_class);
    }
    /*
    static public function GetAllLnClasses()
    {
        $cfg_db = GetCfgDb();
        $q = $cfg_db->select('sen_attr_model', ['ln_class', 'sen_type', 'attr', 'attr_desc_cn', 'attr_def_val']);
        $resp = [];
        foreach ($q as $row) {
            $lnclass = $row['ln_class'];

            $resp[$lnclass] = ['ln_class'=>$lnclass, 'sen_type'=>$row['sen_type']];
            $resp[$lnclass]['items'][] =
                ['attr'=>$row['attr'], 'desc_cn'=>$row['attr_desc_cn'], 'def_val'=>$row['attr_def_val']];
        }
        return array_values($resp);
    }
    */
}

class ProcAttrsExtra
{
    static public function GetAllProcAttrs()
    {
        $cfg_db = GetCfgDb();
        $q = $cfg_db->select('sys_cfg_tbl', ['key', 'value', 'desc_cn']);
        $resp = [];
        foreach ($q as $row) {
            array_push($resp, ['key' => $row['key'], 'desc_cn' => $row['desc_cn'], 'value' => $row['value']]);
        }
        return $resp;
    }

    static public function SetProcAttrs($attrs)
    {
        $cfg_db = GetCfgDb();
        $cfg_db->pdo->beginTransaction();
        foreach($attrs as $key=>$value)
        {
            $cfg_db->update('sys_cfg_tbl',
                            ['value' => $value],
                            ['key' => $key]
                        );
        }

        $cfg_db->pdo->commit();
    }

}


/*
class IpExtra
{
    static public function GetIpInfo()
    {

        $m = php_uname('m');
        if(!ereg('^arm', $m))
        {
            //echo '<p>the ip modify operation is only available on arm system.</p>';
            return;
        }

        exec("db -v|grep '^lan_'", $out);
        $v = [];
        foreach($out as $line)
        {
            preg_match('/^lan_(\w+)(\d+)=(.+)$/', $line, $regs);
            $v[$regs[2]][$regs[1]] = $regs[3];
        }

    }
}
*/

class DebugTemplsExtra
{
    public static function GetAllData()
    {
        $cfg_db = GetCfgDb();
        $cols = ['ln_class', 'type', 'cmd', 'desc_cn', 'comment', 'def_data'];
        $q = $cfg_db->select('debug_tmpl_tbl', $cols);
        $ret = [];
        foreach($q as $row)
        {
            $lnclass =$row['ln_class'];
            unset($row['ln_class']);
            $type =$row['type'];
            unset($row['type']);
            $unionKey = "$lnclass#$type";
            if(!array_key_exists($unionKey, $ret))
            {
               $ret[$unionKey] = ['ln_class'=>$lnclass, 'type'=>$type, 'items'=>[]];
            }
            $ret[$unionKey][items][] = $row;
        }

        return array_values($ret);
    }
}

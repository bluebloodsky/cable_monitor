<?php

/*
$g_cfgI2Db = new medoo([
    'database_type' => 'sqlite',
    'database_file' => 'E:\isoms_web\api\config\cfg_i2.sqlite3'
]);
*/

class DoAttrModel
{
    static public function GetDoAttrsByLnclass($ln_class)
    {
        $where = [];
        if($ln_class)
        {
            $where = ['ln_class' => $ln_class];
        }

        $cols =['do_id', 'ln_class', 'do_name', 'desc_cn', 'unit', 'ratio', 'import_level', 'do_order', 'short_addr', 'cdc_type_id', 'precision'];
        $cols = array_map(function($item){
            return "do_map_model.$item";
        },$cols);
        array_push($cols , "cdc_type_model.desc_cn(cdc_type_desc)");
        $cfg_db = GetCfgDb();
        $q = $cfg_db->select('do_map_model', [
            '[>]cdc_type_model' => 'cdc_type_id'
        ],
            $cols,
            $where
            );
        return $q;
    }

    static public function GetDoAttrs($params)
    {
        $join = [];
        $where_clause = [];
        $cols =['do_id', 'ln_class', 'do_name', 'desc_cn', 'unit', 'ratio', 'import_level', 'do_order', 'short_addr', 'cdc_type_id', 'precision'];
        if(array_has($params , "fields"))
        {
            $fields = preg_split("/,/", $params["fields"]);
            $fields = array_map(function($item){
                return "do_map_model.$item";
            },$fields);
            unset($params["fields"]);
        }
        else{
            $fields = array_map(function($item){
                return "do_map_model.$item";
            },$cols);
            array_push($fields , "cdc_type_model.desc_cn(cdc_type_desc)") ;
            $join['[>]cdc_type_model'] = 'cdc_type_id' ;
        }
        if(array_has($params , "cdc_type_name")){
            $join['[>]cdc_type_model'] = 'cdc_type_id' ;
            $where_clause = ['cdc_type_model.cdc_type_name' => $params["cdc_type_name"]];
            unset($params["cdc_type_name"]);
        }
        $params = array_filter($params , function($key) use($cols){
                return in_array($key , $cols);
            },ARRAY_FILTER_USE_KEY);
        $where["AND"] = array_merge($where_clause , $params);
        if(count($where["AND"]) == 0)
            $where = [];
        $cfg_db = GetCfgDb();
        if(count($join) == 0)
        {
            $q = $cfg_db->select('do_map_model',
                $fields,
                $where
            );
        }
        else
        {
            $q = $cfg_db->select('do_map_model',
                $join ,
                $fields,
                $where
            );
        }

        gCastIntValue(['do_id', 'cdc_type_id', 'do_order', 'short_addr', 'import_level', 'precision', 'ratio'], $q);
        return $q;
    }

    static public function AddDoAttr($doAttrs)
    {
        $newDoAttr = array_filter($doAttrs , function($key){
            return in_array($key , ['ln_class','do_name','desc_cn','cdc_type_id','do_order',
                'short_addr','import_level','unit','precision','ratio']);
        },ARRAY_FILTER_USE_KEY);
        $cfg_db = GetCfgDb();
        $do_id = $cfg_db->insert('do_map_model',
            $newDoAttr);
    }

    static public function UpdateDoAttr($do_id, $doAttrs)
    {
        $newDoAttr = array_filter($doAttrs , function($key){
            return in_array($key , ['ln_class','do_name','desc_cn','cdc_type_id','do_order',
                'short_addr','import_level','unit','precision','ratio']);
        },ARRAY_FILTER_USE_KEY);

        $cfg_db = GetCfgDb();
        $num = $cfg_db->update('do_map_model',
            $newDoAttr,
            [
                'do_id' => $do_id
            ]);
        if($num != 1)
            throw new CmuException("update sen_cfg_tbl return value $num != 1");

    }

    static public function DeleteDoAttr($do_ids)
    {
        $cfgDb = GetCfgDb();
        $arr_ids = preg_split("/,/", $do_ids);
        $num = $cfgDb->delete('do_map_model', ['do_id' => $arr_ids]);
        if ($num < 1)
            throw new CmuException("delete do_map_model return value $num < 1");

    }
}


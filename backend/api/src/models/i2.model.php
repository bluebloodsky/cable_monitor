<?php

class I2BaseModel
{
    protected $table;
    protected $keyIdCol;
    protected $cols;
    protected $i2Db;
    protected $intIdCols;

    public function __construct($table, $cols, $keyIdCol, $intIdCols=[])
    {
        $this->table = $table;
        $this->cols = $cols;
        $this->keyIdCol = $keyIdCol;
        $this->intIdCols = $intIdCols;

        $this->i2Db = GetI2DataDb();
    }

    public function GetAllInfos()
    {
        $q = $this->i2Db->select($this->table, $this->cols);
        gCastIntValue($this->intIdCols, $q);
        return $q;
    }

    public function GetOneInfo($id)
    {
        $where = [ $this->keyIdCol => $id, 'ORDER' => $this->keyIdCol.' ASC'];
        $q = $this->i2Db->get($this->table, $this->cols, $where);
        gCastIntValue($this->intIdCols, $q);
        return $q;
    }

    public function UpdateInfoById($id, $info)
    {
        $info = array_filter($info , function($key){
            return in_array($key , $this->cols);
        },ARRAY_FILTER_USE_KEY);

        $where = [ $this->keyIdCol => $id];
        $RET = $this->i2Db->update($this->table, $info, $where);
        if($RET!=1)
            throw new CmuException("update info failed, retvalue $RET!=1");
    }

    public function AddInfo($info)
    {
        $info = array_filter($info , function($key){
            return in_array($key , $this->cols);
        },ARRAY_FILTER_USE_KEY);

        $RET = $this->i2Db->insert($this->table, $info);
    }
    public function DeleteInfoById($ids)
    {
        $where = [ $this->keyIdCol => $ids];
        $RET = $this->i2Db->delete($this->table, $where);
        if($RET < 1)
            throw new CmuException("delete info failed, retvalue $RET < 1");
    }
    public function DeleteAll()
    {
        $RET = $this->i2Db->delete($this->table,[]);
    }
}

class I2SensorModel extends I2BaseModel
{
    public function __construct()
    {
       parent::__construct('i2_sensor_tbl',
           ['sensor_id', 'sensor_code', 'ln_inst', 'desc_cn', 'group_id', 'equipment_id', 'dataupload_period', 'next_dataupload_time' ,'phase'],
           'sensor_id'
           );
    }
    public function GetAll($params)
    {
        if(array_has($params , "fields")){
            $l_cols =  preg_split("/,/", $params["fields"]);
        }
        else{
            $ext_columns = ["i2_group_tbl.group_name" , "phase_tbl.phase_name"];
            $l_cols = array_merge ($this->cols , $ext_columns);
        }
        return $this->i2Db->select($this->table,["[>]i2_group_tbl]" =>"group_id" ,
            "[>]phase_tbl]" =>["phase"=>"phase_id"]
            ] ,$l_cols);
    }
    /*
     * ######################################################################
    ***desc:    下发I2调试指令
    ***type:   post
    ***url:    api/i2_sensors/$sensor_id$/debug_order
    ***arg:
        $sensor_id$ : <int> I2 sensor的id
    ***request:
    {
        sensor_id:	<int>,
        cmd:	<int>,
        param:	<str>,
    }
      ######################################################################
     */
    public function PostSensorDebugOrder($sensorId , $params)
    {
        $cmd = $params["cmd"];
        $str = "sen_id:$sensorId;cmd:$cmd";
        set_time_limit(0);
        $host = "127.0.0.1";
        $port = 6565;
        $socket = socket_create(AF_INET, SOCK_STREAM, SOL_TCP) or die("Could not create  socket\n");
        $connection = socket_connect($socket, $host, $port) or die("Could not connet server\n");
        socket_write($socket, $str) or die("Write failed\n");
        while ($buff = socket_read($socket, 1024, PHP_BINARY_READ)) {
            $RET = $buff;
            break;
        }
        socket_close($socket);
    }
};

class I2ParamsModel extends I2BaseModel
{
    public function __construct()
    {
        parent::__construct('i2_paramgroup_tbl',
            ['i2_paramgroup_id','group_id', 'param_code', 'param_name', 'param_alm_name', 'rate', 'data_type'],
            'i2_paramgroup_id',
            ['i2_paramgroup_id','group_id', 'data_type']
                );
    }
    public function GetParamsByGroupId($groupId)
    {
        $where = ['group_id' =>$groupId,
                    'ORDER' => $this->keyIdCol.' ASC'];
        $l_cols = array_merge($this->cols , ['data_type_tbl.data_type_name']);
        return $this->i2Db->select($this->table,
            ['[>]data_type_tbl' => ['data_type'=>'data_type_id']], $l_cols, $where);
    }
}

class I2CacModel extends I2BaseModel
{
    public function __construct()
    {
        parent::__construct('i2_cac_tbl',
            ['cac_id', 'cac_ip', 'heartbeat_period', 'next_heartbeat_time'],
            'cac_id' ,
            ['heartbeat_period']
            );
    }
}

class I2CagModel extends I2BaseModel
{
    public function __construct()
    {
        parent::__construct('i2_cag_tbl',
            ['cag_id', 'cag_ip', 'cag_port', 'cag_service_locate', 'cag_namespace', 'timeout_time'],
            'cag_id',
            ['cag_id', 'cag_port', 'timeout_time']
            );
    }
}

class I2GroupModel extends I2BaseModel
{
    public function __construct($fields)
    {
        $cols = $fields;
        if(count($fields) == 0)
        {
            $cols = ['group_id', 'ln_name', 'group_name', 'group_code'];
        }

        parent::__construct('i2_group_tbl', $cols,
            'group_id',
                    ['group_id']
        );
    }
}
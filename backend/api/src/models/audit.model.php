<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 18-4-12
 * Time: 上午10:16
 */

class AuditModel {
    static private $user;
    public function __construct($user)
    {
    }

    static public function SetUser($user) {
        AuditModel::$user = $user;
    }
    static public function Insert($desc, $isSuccessful) {

        $db = GetIedDataDb();
        $result = $isSuccessful ? '成功' : '失败';
        $time = strftime('%Y-%m-%d %T');
        $rec = ['audit_time'=>$time, 'operate_desc'=>$desc, 'operate_result'=>$result, 'operator'=>AuditModel::$user ];
        $db->insert('audit_log', $rec);
    }
    static public function GetAllLog() {

        $db = GetIedDataDb();
        $q = $db->select('audit_log', ['id', 'audit_time', 'operator', 'operate_desc', 'operate_result']);
        return $q;
    }

    static public function Remove($id) {
        $db = GetIedDataDb();

        $q = $db->select('audit_log', ['audit_time', 'operator', 'operate_desc'], ['id'=>$id]);
        if(count($q)!=1)
            throw new CmuException("删除日志失败!");
        $rec = $q[0];
        $str = "删除日志(".$rec['audit_time']."#".$rec['operate_desc']."), id号$id";

        $q = $db->delete('audit_log', ['id'=>$id]);
        AuditModel::Insert($str, ($q==1)?'成功':'失败');
    }
}
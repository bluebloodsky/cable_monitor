<?php

/**
 * Created by PhpStorm.
 * User: lmh
 * Date: 2017/3/24
 * Time: 9:41
 */
class UserModel
{
    static public function GetAllUsers()
    {

        $db = GetCfgDb();
        $ret = $db->select("user_info_tbl", ['user_name', 'user_level', 'user_desc']);
        return $ret;
    }

    static public function Chpasswd($currentUserName, $currentUserPasswd, $editUserName, $editUserNewPasswd)
    {
        $db = GetCfgDb();
        $RET = $db->count('user_info_tbl',
            ["AND" => ['user_name' => $currentUserName, 'password' => $currentUserPasswd]]);
        if ($RET == 0)
            throw new AuthException("用户${currentUserName}密码验证失败!");

        $RET = $db->update('user_info_tbl', ['password' => $editUserNewPasswd], ['user_name' => $editUserName]);
        if ($RET != 1)
            throw new Exception("修改用户${editUserName}密码失败!");

    }

    public static function ValidatePasswd($editUserNewPasswd)
    {
        if ((strlen($editUserNewPasswd) < 8) ||
        (!preg_match("", $editUserNewPasswd)) ||
        (!preg_match("#[A-Z]+#", $editUserNewPasswd)) ||
        (!preg_match("#[a-z]+#", $editUserNewPasswd)) ||
        (!preg_match("/[-~!@#$%^&\*(),\.<>;_=:]+/", $editUserNewPasswd))
        )
            {
                throw new Exception("密码不符合要求:至少8位,包含大小写特殊字符");
            }
    }

    static public function AddUser($info)
    {
        $db = GetCfgDb();
        $userName = $info["user_name"];
        $passwd = $info["user_passwd"];
        $userLevel = $info["user_level"];
        $userDesc = $info["user_desc"];

        $RET = $db->count("user_info_tbl", ["user_name" => $userName]);
        if ($RET > 0)
            throw new AuthException('该用户已存在!');

        $RET = $db->insert("user_info_tbl",
            ["user_name" => $userName, "password" => $passwd, "user_level" => $userLevel, "user_desc" => $userDesc]);
        if (!$RET)
            throw new Exception('添加用户失败!');

    }

    static public function DeleteUser($userName)
    {
        $db = GetCfgDb();
        $RET = $db->delete("user_info_tbl", ["user_name" => $userName]);
        if (!$RET)
            throw new Exception('删除用户失败!');

    }

}
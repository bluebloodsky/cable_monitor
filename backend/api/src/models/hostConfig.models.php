<?php
/**
 * Created by PhpStorm.
 * User: libgcc
 * Date: 2017/8/14
 * Time: 10:48
 */


class IedSet
{
    static public function SetIedReset()
    {
        $RET = 0;
        exec('/sbin/reboot', $o, $RET);
        if($RET!=0)
            throw new CmuException("重启系统出错!");

    }
}

class TimeSet
{
    static public function GetSysTime()
    {

        $time = time();
        return ['epoch'=>$time];
    }
    static public function SetSysTime($epoch)
    {
        $RET = 0;
        date_default_timezone_set("Asia/Shanghai");
        $str  = "date +%s -s @$epoch";
        exec($str, $o, $RET);
        if($RET!=0)
            throw new CmuException("错误的时间格式!");
        exec("hwclock -w", $o, $RET);
        if($RET!=0)
            throw new CmuException("设置时间出错!");
    }
}

class NetSet
{
    static public function GetNetPara()
    {
        $para=array();
        $idx=-1;
        global $gNetCfgFilePath;
        $path=$gNetCfgFilePath;
        if(file_exists($path))
        {
            $file = fopen($path, "r") or exit("Unable to open network config file!");
            while(!feof($file))
            {
                $row= trim(fgets($file));
                if((!empty($row))&&(strpos($row,"#")!==0))
                {
                    $arr=explode(" ",$row);
                    $arr=array_filter($arr);
                    $cnt=count($arr);
                    if($cnt<=0)
                    {
                        continue;
                    }
                    if(strtolower($arr[$cnt-1]) =="static")
                    {
                        $idx++;
                        $para[$idx]=array();
                        $para[$idx]["eth"]=$arr[1];
                    }
                    if(strtolower($arr[0])=="address"||strtolower($arr[0])=="netmask"||strtolower($arr[0])=="gateway")
                    {
                        $para[$idx][$arr[0]]=$arr[1];
                    }
                }
            }
            fclose($file);
        }
        else
        {
            error_log("network config file not find!");
            throw new CmuException("network config file not find!");
        }
        return $para;
    }

    static public function CheckNetParaValidation($para)
    {
		$maskBin = decbin(ip2long($para["netmask"]));

		return filter_var($para["address"], FILTER_VALIDATE_IP) &&
				filter_var($para["gateway"], FILTER_VALIDATE_IP) &&
				   strlen($maskBin) == 32 && preg_match('/0/', $maskBin) && !preg_match('/01/', $maskBin);
    }

    static public function SetNetPara($para)
    {
        global $gNetCfgFilePath;
        $path=$gNetCfgFilePath;
        $rows=array();
        $find=false;
        $have=false;
        $new_str="";
        if(file_exists($path))
        {
            $file = fopen($path, "r") or exit("Unable to open network config file!");
            while(!feof($file))
            {
                $row= trim(fgets($file));
                if(strstr($row,"static"))
                {
                    $find=(strstr($row,$para["eth"])!=false);
                    if(strstr($row,$para["eth"]))
                    {
                        $have=true;
                    }
                }
                if($find)
                {
                    $arr=explode(' ',$row);
                    if(count($arr)>0)
                    {
                        $key=strtolower($arr[0]);
                        if($key=="address"||$key=="netmask"||$key=="gateway")
                        {
                            if($para[$key]!=null&&trim($para[$key])!="")
                            {
                                $row=$key." ".$para[$key];  //新行
                            }
                        }
                    }
                }
                $rows[]=$row;
            }

            fclose($file);  //关闭文件

            if(!$have)  //不存在则添加
            {
                $rows[]="auto ".$para["eth"];
                $rows[]="iface ".$para["eth"]." inet static";
                $rows[]="address ".$para["address"];
                $rows[]="netmask ".$para["netmask"];
                $rows[]="gateway ".$para["gateway"];
            }
            for($i=0;$i<count($rows);$i++)
            {
                $new_str.=$rows[$i];
                $new_str.="\n";
            }
            $size=file_put_contents($path,$new_str);  //写入新数据
        }
        else
        {
            error_log("network config file not find!");
            throw new CmuException("network config file not find!");
        }
    }

}

class LiceneseRegister
{
    static public function IsAlreadyRegisted() {
        global $gMmsHome;
        $procName = trim(`$gMmsHome/monitor.sh showied`);
        if(!$procName)
            return false;
        $RET = 0;
        $O = null;
        exec("pidof $procName", $O, $RET);
        return $RET==0;
    }
    static public function GetHashString()
    {
        global $gMmsBinHome;
        $hash_exe = $gMmsBinHome.'license_hash';
        $hash =  exec($hash_exe);

        error_log("hash exe: $hash_exe, hash: $hash");
        return $hash;
    }

    static public function SetHashString($key)
    {
        global $gMmsEtcHome;
        global $gMmsBinHome;
        $hash_exe = $gMmsBinHome.'license_hash';
        $key_file = $gMmsEtcHome.trim(`$hash_exe dstfile`);
        error_log("key_file: $key_file, key: $key");

        $fp = fopen($key_file, 'w');
        fwrite($fp, "$key\n");
        fclose($fp);
    }
}

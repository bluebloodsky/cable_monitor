<?php
/**
 * Mms settings
 */

$gMmsHome = getenv("COLLECTOR_IED_PATH");
if(!$gMmsHome)
{
    error_log('env "COLLECTOR_IED_PATH" cannot be found!');
    exit ;
}

$gNandHome = getenv("IED_NAND_PATH");
if(!$gNandHome)
{
    error_log('env "IED_NAND_PATH" cannot be found!');
    exit ;
}

$gTokenKey = getenv("IED_WEB_TOKEN");
if(!$gTokenKey)
 $gTokenKey = "cmu.secret";

$gTokenHeader = 'Token-Authorization-X';
$gTokenHeaderPrefix = 'CMU-TOKEN';

#$gMmsEtcHome = $gMmsHome."/etc/";
$gMmsEtcHome = "/etc/cmu/";
$gMmsBinHome = $gMmsHome."/bin/";
$gMmsIcdHome = $gMmsHome."/icd/";
$gMmsDocHome = $gMmsHome."/doc/";
$gMmsUpdateHome = $gMmsHome."/update/";
$gMmsToolHome= $gNandHome."/software/";   //add 常用工具目录
$gMmsHelpHome= $gNandHome."/help/";   //add 帮助文档目录
$gNetCfgFilePath= "/etc/network/interfaces";
$gMmsTmpHome = $gNandHome."/tmp";

if(!file_exists($gMmsTmpHome) && !mkdir($gMmsTmpHome))
{
    throw new Exception('Cannot make tmp dir....');
}

$gMmsConfigFileMap = array('mmscfg' => "mms_config.xml",
                           'logcfg' => "log_config.xml");

$gI2LogFileName = $gNandHome . DS . "log/soap_proxy.INFO";

ini_set("error_reprorting", "E_ALL");
ini_set("log_errors", "On");
ini_set("error_log", "$gNandHome/log/php_error.log");   //此路径自行配置
date_default_timezone_set('Asia/Shanghai');

function GetCfgDb()
{
    global $gMmsEtcHome;
    $g_cfgMonitorDb = new medoo([
        'database_type' => 'sqlite',
        'database_file' => $gMmsEtcHome . DS .'cfg.sqlite3'
    ]);

    error_log("datafile: ".$gMmsEtcHome . DS .'cfg.sqlite3');
    return $g_cfgMonitorDb;
}
function GetIedDataDb()
{
    global $gNandHome;
    $g_iedDataDb = new medoo([
        'database_type' => 'sqlite',
        'database_file' => "$gNandHome/db/ied_data.sqlite3"
    ]);
    return $g_iedDataDb;
}
function GetI2DataDb()
{
    global $gMmsEtcHome;
    $g_i2Db = new medoo([
        'database_type' => 'sqlite',
        'database_file' =>  $gMmsEtcHome . DS .'cfg_i2.sqlite3'
    ]);
    return $g_i2Db;
}
// public function
function gGetLogDirAndFileName()
{
    global $gMmsEtcHome;
    $mmsLogCfgFile = $gMmsEtcHome."logcfg.xml";
    $xml = simplexml_load_file($mmsLogCfgFile);
    if(!$xml)
    {
        echo "open file $mmsLogCfgFile failed.\n";
        exit;
    }

    return array('logDir'=>(string)$xml->LogControl->LogDir,
        'logFile'=>(string)$xml->LogControl->LogFileName);
}


class CmuException extends Exception {}
class AuthException extends  Exception {}



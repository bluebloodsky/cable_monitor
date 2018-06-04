<?php
/**
 * Created by PhpStorm.
 * User: libgcc
 * Date: 2016/12/23
 * Time: 13:56
 */

class BaseConfig
{
    public $m_cfgFileName = '';

    static function EncryptFile($fileName) {
        global $gMmsEtcHome;
        global $gMmsBinHome;
    }

    public function __construct($cfgFileName)
    {
        $this->m_cfgFileName = $cfgFileName;
    }

    protected function GetCfgFile()
    {
        global $gMmsEtcHome;
        $file =  $gMmsEtcHome.$this->m_cfgFileName;
//        error_log("before read cfg file $file");
        return $file;
    }
    protected function Filter($item)
    {
        return true;
    }
    public function GetCfgData()
    {
        $RET = [];
        $xml = simplexml_load_file($this->GetCfgFile());
        foreach ($xml->children() as $tag1)
        {
            $item1 = $tag1->getName();
            if(!$this->Filter($item1))
                continue;

            foreach ($tag1->children() as $tag2)
            {
                $item2 = $tag2->getName();
                $val2 = $tag2->__toString();
                $RET[$item1."_".$item2] = $val2;
            }
        }

        gCastIntValue(['MmsReport_ReportScanRate',
            'MmsReport_BRCBBufferSize',
            'MmsLog_LogScanRate',
            'MmsLog_LogMaxEntries',
            'MmsLog_SqliteMaxRows',

            'LogControl_LogFileSize',
            'LogControl_LogBufferSize',
            'LogControl_LogCnt',

            'sync_cycle',
            'out_time',
            ], $RET, true);
        return $RET;
    }

    public function SetCfgData($logCfg)
    {
        $logCfgFile = $this->GetCfgFile();
        $xml = simplexml_load_file($logCfgFile);
        foreach ($logCfg as $key=>$val)
        {
            $nameArr = explode('_', $key, 2);
            $xml->$nameArr[0]->$nameArr[1] = $val;
        }

        $RET = $xml->asXML($logCfgFile);
        if(!$RET)
        {
            throw new CmuException("save config failed!");
        }

        global $gMmsBinHome;
        global $gMmsBinHome;
        exec("$gMmsBinHome/sm4 encode $logCfgFile");
        return ['ret'=>'success'];
    }
}

class LogConfig extends BaseConfig
{
    public function __construct()
    {
        parent::__construct("logcfg.xml");
    }
    public function Filter($item)
    {
        return $item == "LogControl";
    }
}
class MmsConfig extends BaseConfig
{
    public function __construct()
    {
        parent::__construct("mms_config.xml");
    }

    public function Filter($item)
    {
        return $item == "SclFile"
                || $item == "MmsReport"
                || $item == "MmsLog"
                || $item == "MmsFile";
    }

    private function GetIedNameAndAP()
    {
        global $gMmsIcdHome;
       $icdFiles = array_diff(scandir($gMmsIcdHome), ['..', '.']);
        $RET = [];
        foreach ($icdFiles as $icdFile)
        {
            if(!preg_match('/\.icd$/', $icdFile))
                continue;

            try
            {
                $d = [];
                $xml = new XMLReader();
                $xml->open($gMmsIcdHome.$icdFile);
                while($xml->read())
                {
                    if($xml->nodeType==XMLReader::ELEMENT && $xml->name=='ConnectedAP')
                    {
                        if($xml->hasAttributes)
                        {
                            $attributes = array();
                            while($xml->moveToNextAttribute())
                            {
                                $attributes[$xml->name] = $xml->value;
                            }
                            $d['iedName'] = $attributes['iedName'];
                            $d['AP'][] = $attributes['apName'];
                        }
                    } else if($xml->nodeType==XMLReader::END_ELEMENT && $xml->name=='Communication') {
                        break;
                    }
                }

                $RET[basename($icdFile)] = $d;
                $xml->close();
            }catch (Exception $e) {
                error_log("read icd file $icdFile failed, skip it.");
            }
        }

        return $RET;
    }

    public function GetCfgData()
    {
        $RET = parent::GetCfgData();
        return ['mms_cfg_info' => $RET, 'icd_cfg_info' => $this->GetIedNameAndAP()];
    }
}
class NtpConfig
{
    static public function GetNtpInfo()
    {
        global $gMmsEtcHome;
        $ntpFile = $gMmsEtcHome."ntp.ini";
        $arr = parse_ini_file($ntpFile);
        unset($arr['rtc_dev']);
        return $arr;
    }

    static private function WriteNtpFile($arr, $fileName)
    {
        $res = [];
        foreach($arr as $key => $val)
        {
            if(is_array($val))
            {
                $res[] = "[$key]";
                foreach($val as $skey => $sval)
                {
                    $res[] = "$skey = $sval";
                    //$res[] = "$skey = ".(is_numeric($sval) ? $sval : '"'.$sval.'"');
                }
            }
            else
                $res[] = "$key = $val";
            //$res[] = "$key = ".(is_numeric($val) ? $val : '"'.$val.'"');
        }
        $dataToSave = implode("\n", $res);

        try
        {
            if($fp = fopen($fileName, 'w'))
            {
                $startTime = microtime(TRUE);
                do
                {            $canWrite = flock($fp, LOCK_EX);
                    // If lock not obtained sleep for 0 - 100 milliseconds, to avoid collision and CPU load
                    if(!$canWrite) usleep(round(rand(0, 100)*1000));
                } while ((!$canWrite)and((microtime(TRUE)-$startTime) < 5));

                //file was locked so now we can store information
                if ($canWrite)
                {
                    fwrite($fp, "[ntp]\n");
                    fwrite($fp, $dataToSave);
                    flock($fp, LOCK_UN);
                }
                fclose($fp);
            }

            exec("$gMmsBinHome/sm4 encode $fileName");
        }
        catch (Exception $e)
        {
            error_log("write file $fileName failed: ".$e->getMessage());
            throw new $e;
        }

    }
    static public function SetNtpInfo($ntpInfo)
    {
        global $gMmsEtcHome;
        $ntpFile = $gMmsEtcHome."ntp.ini";
        $arr = parse_ini_file($ntpFile);
        foreach($ntpInfo as $key=>$val)
        {
            $arr[$key] = $val;
        }

        self::WriteNtpFile($arr, $ntpFile);
    }
}


<?php

function gGetProcInfoArray($procName)
{
    global $gMmsHome;
    $pid  = trim(`cat $gMmsHome/pid/$procName.pid`);
    $procItem = array();
    $procItem['procName'] = $procName;
    $procItem['pid'] = intval($pid);
    $procItem['isRunning'] = false;
    $procItem['runTime'] = '';

    $procDir = "/proc/$pid";
    if( $pid && is_dir($procDir) && ($arr = stat($procDir)))
    {
        $procItem['isRunning'] = true;
        $runTime_t = (time() - $arr['mtime']);
        $procItem['runTime'] = $runTime_t;
    }

    return $procItem;
}
function gGetAllProcInfoArray()
{
    global $gMmsHome;
    $procInfoList = array();
    foreach(array('ied', 'ntp', 'i2') as $arg)
    {
        $procName = trim(`$gMmsHome/monitor.sh show$arg`);
        if(!$procName)
            continue;
        array_push($procInfoList, gGetProcInfoArray($procName));
    }

    return $procInfoList;
}


function gRestartProc($procName)
{
    global $gMmsHome;
    $pid  = trim(`cat $gMmsHome/pid/$procName.pid`);

    exec("kill -9 $pid", $output, $ret);
    if($ret!=0)
    {
        $msg = "kill proce $procName[$pid] failed";
        error_log($msg."ret: $ret");
    }

    do {
        sleep(3);
        $newPid = trim(`cat $gMmsHome/pid/$procName.pid`);
        if( ($newPid!=$pid) && is_dir("/proc/$newPid"))
        {
            sleep(1);   #add a sleep for slow return...
            return;
        }
    }while(1);


}

<?php

class LogContent
{
    static public function GetLogContent($type, $start, $limit)
    {
        if($limit<=0)
            $limit = 200;

        try{
            if($type == "ied")
            {
                $logdirAndFile = gGetLogDirAndFileName();
                $logFileName = $logdirAndFile['logDir']."/".$logdirAndFile['logFile'];
                global $gMmsHome;
                chdir($gMmsHome);
            }
            else    //if($type == "i2")
            {
                global $gI2LogFileName;
                $logFileName = $gI2LogFileName;
            }

            if($start == 0)
            {   //if $start is 0, means the current read, return the last $limit lines
                $lineCount=0;
                /*
                while (!$fp->eof())
                {
                    $fp->next();
                    ++$lineCount;
                }
                */
                $lineCount = rtrim(`cat $logFileName|wc -l`);

                $start = $lineCount>$limit ? ($lineCount-$limit) : 0;
            }

            error_log("On Read logfilename: $logFileName, start: $start");
            $lines = [];
            $fp = new SplFileObject($logFileName);
            $fp->seek($start);     // Seek to line no. 10,000
            while($limit-- && !$fp->eof())
            {
                $lines[] =  rtrim($fp->current());
                $fp->next();
            }
        }catch (Exception $e){
            error_log('Caught exception:'.$e->getMessage());
            throw $e;
        }

        // fix the last line empty bug
        if(strlen(end($lines)) == 0)
            array_pop($lines);
        return ['last_line'=>($start+count($lines)), 'log_content' => $lines];
    }
}


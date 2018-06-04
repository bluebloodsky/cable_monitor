<?php

/**
 * Created by PhpStorm.
 * User: libgcc
 * Date: 2016/12/26
 * Time: 15:26
 */
use \Psr\Http\Message\UploadedFileInterface;
class FileListModel
{
    static public function GetCmuFileList()
    {
        $RET['logFiles'] = self::GetLogFileList();
        $RET['cfgFiles'] = self::GetCfgFileList();
        $RET['icdFiles'] = self::GetIcdFileList();
//		$RET['helpFiles']=self::GetHelpFileList();
        return $RET;
    }

    static public function GetLogFileList()
    {
        global $gMmsHome;
        $logdirAndFile = gGetLogDirAndFileName();
        $logDir = $logdirAndFile['logDir'];
        chdir($gMmsHome);
        return self::GetFilesPrivate("log", "log", $logDir);
    }

    static public function GetCfgFileList()
    {
        global $gMmsEtcHome;
        return self::GetFilesPrivate("cfg", "sqlite3", $gMmsEtcHome);
    }

    static public function GetIcdFileList()
    {
        global $gMmsIcdHome;
        return self::GetFilesPrivate("icd", "icd", $gMmsIcdHome);
    }

    static public function GetToolsFileList()
    {
        global $gMmsToolHome;
        global $gMmsHome;
        chdir($gMmsHome);
        return self::GetFilesPrivate("tool", "", $gMmsToolHome);
    }

    static public function GetHelpFileList()
    {
        global $gMmsHelpHome;
        global $gMmsHome;
        chdir($gMmsHome);
        return self::GetFilesPrivate("help", "*", $gMmsHelpHome);
    }
	
	static private function GetFilesPrivate($type, $suffix, $dir)
    {
        if(!(is_dir($dir)&&chdir($dir)))
        {
            error_log("chdir '$dir' failed...");
            throw new CmuException("chdir $dir failed");
        }
        $dh = dir(".");
        $RET=[];
        while($entry = $dh->read())
        {
            if($entry === "." || $entry === "..")
                continue;
            if(!is_file($entry))
                continue;
            if($suffix && !preg_match("/.$suffix$/", $entry))
                continue;

            $info = stat($entry);
            $RET[] = [
                'name'=> $entry,
                'size'=> $info['size'],
                'uptime'=> $info['mtime'],
                'url' => "file_download?type=$type&filename=$entry"];
        }
        return $RET;
    }

    static public function GetFile($type, $filename, $resp)
    {
        global $gMmsHome, $gMmsEtcHome, $gMmsIcdHome,$gMmsToolHome,$gMmsHelpHome;

        $dir = '';
        if($type == "log")
        {
            chdir($gMmsHome);
            $dir = gGetLogDirAndFileName()['logDir'];
        }
        else if($type == "cfg")
            $dir = $gMmsEtcHome;
        else if($type == "icd")
            $dir = $gMmsIcdHome;
        else if($type=="tool")
            $dir=$gMmsToolHome;
		else if($type=="help")
            $dir=$gMmsHelpHome;		
        return self::GetFilePrivate($dir, $filename, $resp);
    }

    static  public function OnUploadFile(UploadedFileInterface $newfile) {
        // do something with $newfile
        if ($newfile->getError() === UPLOAD_ERR_OK)
        {
            $uploadFileName = $newfile->getClientFilename();
            if(!preg_match("/.icd$/", $uploadFileName))
            {
                throw new CmuException('file should be suffixed by ".icd" !');
            }

            global $gMmsIcdHome;
            $newfile->moveTo($gMmsIcdHome.$uploadFileName);
        }

        return self::GetIcdFileList();
    }

    static private function GetFilePrivate($dir, $filename, $resp)
    {
        if(!chdir($dir))
        {
            echo "chdir '$dir' failed...";
            throw new CmuException("chdir $dir failed");
        }

        if(!is_file($filename))
            throw new CmuException("now such file $filename");

        $info = stat($filename);
        $fp = fopen($filename, 'r');
        if(!$fp)
            throw new CmuException("unable to open file $filename!");

        $stream = new \Slim\Http\Stream($fp); // create a stream instance for the response body
        return $resp->withHeader('Content-Type', 'application/force-download')
            ->withHeader('Content-Type', 'application/octet-stream')
            ->withHeader('Content-Type', 'application/download')
            ->withHeader('Content-Description', 'File Transfer')
            ->withHeader('Content-Transfer-Encoding', 'binary')
            ->withHeader('Content-Disposition', "attachment; filename=$filename")
            ->withBody($stream); // all stream contents will be sent to the response
    }


}

<?php
/**
 * Created by PhpStorm.
 * User: libgcc
 * Date: 2017/11/10
 * Time: 11:22
 */
use \Firebase\JWT\JWT;

class Authentication {
    static function Validate($auth) {

        $userName = $auth['userName'];
        $passwd = $auth['password'];
        $verifyCode = $auth['verifyCode'];
        $codeFileName = $auth['codeId'];
        $license = $auth['license'];

        self::ValidateLicense($license);
        self::ValidateCode($verifyCode, $codeFileName);
        $userLevel = self::ValidateUser($userName, $passwd);
        $token = self::MakeToken($userName, $userLevel);

        return ['token' => $token, 'user' => $userName];
    }

    private static function ValidateLicense($license)
    {
        if(strlen($license) != 10)
            throw new AuthException("验证标识格式不正确!要求10位长度");

        global $gMmsBinHome;
        $hash_exe = $gMmsBinHome.'license_hash';
        $hash =  exec($hash_exe);
        if(substr($hash, 0, 10) !== $license)
            throw new AuthException("验证标错误!");
    }

    static function ValidateUser($userName, $passwd) {
        $db=GetCfgDb();


//        $m = $db->select('user_info_tbl', ["user_name", "password","user_level","user_desc"]);
        $q=$db->select("user_info_tbl",["password","user_level","user_desc"],["user_name"=>$userName]);
//        error_log("$passwd, $q[0]['password']");
        if(!$q || $passwd!=$q[0]["password"])
            throw new AuthException("用户名或密码不正确");

        return $q[0]['user_level'];
    }

    static function ValidateCode($verifyCode, $codeFileName) {
        global $gMmsTmpHome;
        $fileName = $gMmsTmpHome."/$codeFileName";
        if(!is_file($fileName))
            throw new AuthException("未知错误,请重新刷新");

        try {
            $code = file_get_contents($fileName);
        }catch(Exception $exception) {
           throw new AuthException("未知错误,请重新刷新");
        }
        if(strcasecmp($code, $verifyCode) != 0)
            throw new AuthException("验证码不正确!");

        // 验证成功后,删除所有tmp目录下的.code文件
        // 这一操作可能会触发同时段登录的其它客户端的code被删除,但只是引发内部错误重新刷新一次即可
        // 这样简单的操作可以保证tmp目录下没有多余的文件
        foreach (glob("$gMmsTmpHome/*.code") as $codeFile) {
            if(is_file($codeFile))
                unlink($codeFile);
        }

        return true;
    }

    static function MakeToken($userName, $userLevel) {
        global $gTokenKey;

        $now = new DateTime();
//        $exp = new DateTime("now +2 ");
        $jti = base64_encode(random_bytes(16));

        $payload = [
            'jti' => $jti,
            'iat' => $now->getTimeStamp(),
            'exp' => $now->getTimeStamp()+3600*2,   //2 hours

            'user' => $userName,
            'userLevel' => $userLevel
        ];

        return JWT::encode($payload, $gTokenKey, "HS256");
    }

    static function GenerateVerifyCode() {
        $code = '';
        $chars = 'abcdefghijkmnpqrstuvwxyzABCDEFGHIJKMNPQRSTUVWXYZ0123456789';
        for($i = 0 ; $i < 4 ;$i++){
            $code .= $chars[ mt_rand(0, strlen($chars) - 1)];
        }
        $filename = '';
        for($i = 0 ; $i < 10 ;$i++){
            $filename .= $chars[ mt_rand(0, strlen($chars) - 1)];
        }

        // add an .code suffix
        $im = imgCreate("$code.code");
        ob_start();
        imagepng($im);
        $base64code = base64_encode(ob_get_clean());
        imagedestroy($im);

        global $gMmsTmpHome;
        file_put_contents($gMmsTmpHome."/$filename", $code);
        return ['codeId' => $filename, 'imgType' => 'image/png', 'imgData' => $base64code];
    }

    public static function ReAuth($userName, $authentication)
    {
        $db=GetCfgDb();
        $passwd = $authentication['password'];
        $q=$db->select("user_info_tbl",["password","user_level","user_desc"],["user_name"=>$userName]);
        return ['result' => ($q && $passwd==$q[0]["password"])];
    }

}
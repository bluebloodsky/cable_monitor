<?php
$app = new Slim\App();

$db_cfg = require_once API. 'config' . DS . 'db.config.php';
$db = new Medoo($db_cfg);
foreach (glob(API . 'src' . DS . 'libs' . DS . '*.php') as $filename) {
    require_once $filename;
}


foreach (glob(API . 'src' . DS . 'models' . DS . '*.php') as $filename) {
    require_once $filename;
}

foreach(glob(API . 'src' . DS . 'routes' . DS . '*.php') as $router) {
    require_once $router;
}

/*应该根据token获取操作用户信息,现无权限管理，暂时默认 blq/emc*/
$userInfo = ["station" => "blq" ,
            "username" => "blq_admin"];

$asJsonMidd = function ($req, $resp, $next) {
    if($req->isOptions()){
        $resp = $resp->withHeader('Access-Control-Allow-Origin', 'http://localhost:8080');
        $resp = $resp->withHeader('Access-Control-Allow-Credentials' , 'true');
        $resp = $resp->withHeader('Access-Control-Allow-Headers', 'Origin,X-Requested-With,Content-Type,Accept,Token-Authorization-X');
        $resp = $resp->withHeader('Access-Control-Allow-Methods', 'GET,POST,PUT, DELETE');
        return $resp;
    }
    try{
        $resp = $next($req, $resp);
    }catch (Exception $e) {
        $resp = $resp->withJson(['error'=>$e->getMessage()], 500);
        error_log("Exception occured: ".$e->getMessage());
    }
    $resp = $resp->withHeader('Access-Control-Allow-Origin', 'http://localhost:8080');
    $resp = $resp->withHeader('Access-Control-Allow-Credentials' , 'true');
    $resp = $resp->withHeader('Access-Control-Allow-Headers', 'Origin,X-Requested-With,Content-Type,Accept,Token-Authorization-X');
    $resp = $resp->withHeader('Access-Control-Allow-Methods', 'GET,POST,PUT, DELETE');
    return $resp;

};
$app->add($asJsonMidd);

/**
 * Run the application
 */
 $app->run();
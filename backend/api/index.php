<?php
/**
 * Define some constants
 */

use Dflydev\FigCookies\Cookie;
use Dflydev\FigCookies\FigResponseCookies;
use Dflydev\FigCookies\SetCookie;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;

define("DS", DIRECTORY_SEPARATOR);
define("ROOT", realpath(dirname(__DIR__)) . DS);
define("API" , ROOT . "api" . DS);
define("VENDORDIR", ROOT . "vendor" . DS);
define("ROUTEDIR", API . "src" . DS . "routes" . DS);
/**
 * Include autoload file
 */

//use Slim\Middleware\TokenAuthentication;
use Slim\Http\Request;
use Slim\Http\Response;

if (file_exists(VENDORDIR . "autoload.php")) {
    require_once VENDORDIR . "autoload.php";
} else {
    die("<pre>Run 'composer.phar install' in root dir</pre>");
}

/**
 * Include getData file
 */
$app = new Slim\App();

foreach (glob(API . 'config' . DS . '*.php') as $filename) {
    require_once $filename;
}
foreach (glob(API . 'src' . DS . 'models' . DS . '*.php') as $filename) {
    require_once $filename;
}
foreach (glob(API . 'src' . DS . 'libs' . DS . '*.php') as $filename) {
    require_once $filename;
}
foreach(glob(API . 'src' . DS . 'auth' . DS . '*.php') as $auth){
    require_once $auth;
}

foreach(glob(ROUTEDIR . '*.php') as $router) {
    require_once $router;
}

/**
 * Run the application
 */

$container = $app->getContainer();

$container["jwt"] = null;

$activeTimeMiddleware = function (Request $req, Response $resp, callable $next ) use ($container) {
//    global $gTokenHeader, $gTokenHeaderPrefix;
    $jwt = $container["jwt"];
    if(!$jwt)
        return $next($req, $resp);

    $uri = $req->getUri();
    $path =$uri->getPath();
    error_log("in activeTimeMiddleware path:  $path");
    //skip the two auto get action, just monitor the manually operation.
    if($path=='sys_time' or preg_match('/sen_basic_status/', $path))
        return $next($req, $resp);

    $now = time();
//    $lastAccessTime = FigResponseCookies::get($req, 'idleTime')->getValue();
    $lastAccessTime = $req->getCookieParam('idleTime');

    error_log("in activeTimeMiddleware lastAccessTime: $lastAccessTime, now: $now, minus: ".($now-$lastAccessTime));
    if( ($now-$lastAccessTime) >= 300)
    {
        $resp = FigResponseCookies::remove($resp, 'idleTime');
        $resp = $resp->withJson("请求超时!", 408);
    } else {
        $modify = function (SetCookie $cookie) {
            return $cookie->withValue(time());
        };
        $resp = FigResponseCookies::modify($resp, 'idleTime', $modify);
        error_log("int activeTimeMiddleware show this msg if not timeout");

    }

    return $next($req, $resp);

};

$app->add($activeTimeMiddleware);

//   https://github.com/tuupola/slim-jwt-auth
$app->add(new \Slim\Middleware\JwtAuthentication([
    'rules' => [
        new \Slim\Middleware\JwtAuthentication\RequestPathRule([
            'path' => '/',
            'passthrough' => ['/login', '/verify_code', '/phpinfo']
        ]),
        new \Slim\Middleware\JwtAuthentication\RequestMethodRule([
            'passthrough' => ['options']
        ])
    ],

    'header' => $gTokenHeader,
    'regexp' => "/$gTokenHeaderPrefix\s+(.*)$/i",
    'secret' => $gTokenKey,
    'secure' => false,

    'error' => function (Request $request, Response $response, $arguments) {
        $data["status"] = "error";
        $data["message"] = $arguments["message"];
        return $response->withHeader("Content-Type", "application/json")
                    ->withJson(['error' => $arguments['message']], 401);
    },

    "callback" => function ($request, $response, $arguments) use ($container) {
        $container["jwt"] = $arguments["decoded"];
//        $container["lastAccessTime"] = time();

    }


]));

$ExceptionMiddleware = function (Request $req, Response $resp, callable $next) {
    global $gTokenHeader;

    //调试模式跨域访问,需要先做一个options请求
    if($req->isOptions()) {
        $resp = $resp->withHeader('Access-Control-Allow-Origin', '*');
        $resp = $resp->withHeader('Access-Control-Allow-Methods', 'GET,POST,PUT, DELETE');
        $resp = $resp->withHeader('Access-Control-Allow-Headers', "Origin,X-Requested-With,Content-Type,Accept,$gTokenHeader");
        return $resp;
    }

    try{
        $resp = $next($req, $resp);
        //一般post请求成功后,默认返回空,但这对于前端的json解析会有一个小bug,所以后端做一个处理,返回一个空值
        if(($req->isPost()||$req->isDelete()) && $resp->getBody()->getSize()==0 )
        {
            $resp = $resp->withJson('');
        }
    }catch (AuthException $e) {
        $resp = $resp->withJson($e->getMessage(), 401);
        error_log("Auth Exception occured: ".$e->getMessage());
    }catch (CmuException $e) {
        $resp = $resp->withJson($e->getMessage(), 500);
        error_log("Cmu Exception occured: " . $e->getMessage());
    } catch (Exception $e) {
        $resp = $resp->withJson($e->getMessage(), 503);
        error_log("Unkown Exception occured: " . $e->getMessage());
    }

    $resp = $resp->withHeader('Access-Control-Allow-Origin', '*');
    $resp = $resp->withHeader('Access-Control-Allow-Headers', "Origin,X-Requested-With,Content-Type,Accept,$gTokenHeader");
    $resp = $resp->withHeader('Access-Control-Allow-Methods', 'GET,POST,PUT, DELETE');
    return $resp;
};

$app->add($ExceptionMiddleware);



$fileDownloadMiddleware = function (Request $req, Response $resp, callable $next ) {
    global $gTokenHeader, $gTokenHeaderPrefix;
    if($req->isGet())
    {
        $uri = $req->getUri();
        $path =$uri->getPath();
        if($path=='file_download' or preg_match('/sen_csv$/', $path))
        {
            $req = $req->withHeader($gTokenHeader, "$gTokenHeaderPrefix ".$req->getQueryParams()[$gTokenHeaderPrefix]);
        }
//        $headers = $req->getHeaders();
//        error_log("headers: ");
    }

    return $next($req, $resp);
};
$app->add($fileDownloadMiddleware);

$auditMiddleware = function (Request $req, Response $resp, callable $next ) use ($container) {
    /** @var Response $resp */
    $resp = $next($req, $resp);

    //如果没有登陆信息,一般不记录日志,/login,/logout已经自主添加audit日志记录
    $jwt = $container["jwt"];
    if($req->isOptions() || $req->isGet() || !$jwt )
        return $resp;

    $path = $req->getUri()->getPath();
    $user = $container['jwt']->user;

    AuditModel::SetUser($user);
    $params = json_decode($req->getBody(), true);
    $desc = array_has($params, 'command') ? $params['command'] : $req->getMethod()." url $path";

    AuditModel::Insert($desc, $resp->isSuccessful());

    return $resp;

};
$app->add($auditMiddleware);


$app->run();

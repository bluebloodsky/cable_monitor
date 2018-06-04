<?php

use Dflydev\FigCookies\SetCookie;
use Slim\Http\Response;
use Slim\Http\Request;



/**
 * Created by PhpStorm.
 * User: lmh
 * Date: 2017/3/24
 * Time: 9:20
 */
//
const ADMIN_LEVEL = 1;
const AUDIT_LEVEL = 2;
const NORMAL_LEVEL = 0;
use Dflydev\FigCookies\FigResponseCookies;

$cookieMw = function (Request $req, Response $resp, $next) {
    /**  @var Response $resp */
    $resp = $next($req, $resp);
    if (!$resp->isSuccessful())
        return $resp;

    $resp = FigResponseCookies::set($resp, SetCookie::create('idleTime')->withValue(time()));
    return $resp;
};

$auditMiddleware = function (Request $req, Response $resp, $next) {
    $resp = $next($req, $resp);

    $path = $req->getUri()->getPath();
    $desc = $path=='login' ? '登陆' : '注销';

    AuditModel::Insert($desc, $resp->isSuccessful());

    return $resp;

};

$app->get('/verify_code' , function (Request $req, Response $resp, $args) {
//    $license = $req->getParam('license');
    $RET = Authentication::GenerateVerifyCode();
    return $resp->withJson($RET);
});
$app->post('/login' , function (Request $req, Response $resp, $args) {
    $authentication = json_decode($req->getBody(), true);
    $RET = Authentication::Validate($authentication);
    AuditModel::SetUser($RET['user']);
    return $resp->withJson(['token' => $RET['token']]);
})->add($auditMiddleware)->add($cookieMw);

$app->post('/logout' , function (Request $req, Response $resp, $args) {
    return $resp;
})->add($auditMiddleware);

$app->post('/reAuth' , function (Request $req, Response $resp, $args) {
    $currentUserName = $this->jwt->user;
    $authentication = json_decode($req->getBody(), true);
    $RET = Authentication::ReAuth($currentUserName, $authentication);
    return $resp->withJson($RET);
});

$app->group('/users', function () {
    $this->get('' , function (Request $req, Response $resp, $args) {
        $isAdmin = ($this->jwt->userLevel==ADMIN_LEVEL);
        if(!$isAdmin)
            throw new AuthException('仅支持管理员用户请求');
        //$ln_class = $params["ln_class"];
        //$RET = DoAttrModel::GetDoAttrsByLnclass($ln_class);
        $RET = UserModel::GetAllUsers();
        return $resp->withJson($RET);
    });

    $this->post('/passwd' , function (Request $req, Response $resp, $args) {
        $info = json_decode($req->getBody(),true);
        $isAdmin = ($this->jwt->userLevel==ADMIN_LEVEL);
        $currentUserName = $this->jwt->user;
        $editUserName = $info['edituser_name'];
        if(!$isAdmin && $editUserName != $currentUserName)
            throw new AuthException('非法修改请求!');

        $currentUserPasswd = $info['currentuser_passwd'];
        $editUserNewPasswd = $info['edituser_new_passwd'];
//        UserModel::ValidatePasswd($editUserNewPasswd);
        UserModel::Chpasswd($currentUserName, $currentUserPasswd, $editUserName, $editUserNewPasswd);

        return $resp;
    });

    $this->post('' , function (Request $req, Response $resp, $args) {
        $info = json_decode($req->getBody(),true);
//        error_log("userlevel:", $this->jwt->userLevel);
        $isAdmin = ($this->jwt->userLevel==ADMIN_LEVEL);
        if(!$isAdmin)
            throw new AuthException("该操作仅支持管理员用户");

        UserModel::AddUser($info);
        return $resp;
    });

    $this->delete('/{user_name}' , function (Request $req, Response $resp, $args) {
        $isAdmin = ($this->jwt->userLevel==ADMIN_LEVEL);
        if(!$isAdmin)
            throw new AuthException('该操作仅支持管理员用户请求');

        $userName = $args['user_name'];
        UserModel::DeleteUser($userName);
        return $resp;
    });
});

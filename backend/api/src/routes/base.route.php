<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/1/31
 * Time: 12:38
 */
$app->group('/', function () {
    $this->get('', function ($req, $resp, $args) {
        //var_dump($RET);
        return 'aa';
        // return $resp->withJson($RET);
    });

});

<?php
use Slim\Http\Response;
use Slim\Http\Request;

$app->get('/log_content', function (Request $req, Response $resp, $args) {
    $params = $req->getQueryParams();

    if(!array_has($params, 'type'))
        throw new CmuException("need file type !");
    $type =  $params['type'];
    if($type != "i2" && $type != "ied")
        throw new CmuException("bad type value $type");

    $limit = array_has($params, 'limit') ? $params['limit'] : 200;
    $start = array_has($params, 'start') ? $params['start'] : 0;

    $RET = LogContent::GetLogContent($type, $start, $limit);
    return $resp->withJson($RET);
});


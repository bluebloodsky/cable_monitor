<?php
use Slim\Http\Response;
use Slim\Http\Request;

$app->group('/do_attrs', function () {
    $this->get('' , function (Request $req, Response $resp, $args) {
        $params = $req->getQueryParams();
        //$ln_class = $params["ln_class"];
        //$RET = DoAttrModel::GetDoAttrsByLnclass($ln_class);
        $RET = DoAttrModel::GetDoAttrs($params);
        return $resp->withJson($RET);
    });

    $this->post('' , function (Request $req, Response $resp, $args) {
        $doAttrs = json_decode($req->getBody() , true);
        DoAttrModel::AddDoAttr($doAttrs);

        return $resp;
    });

    $this->post('/{do_id}' , function (Request $req, Response $resp, $args) {
        $do_id = $args['do_id'];
        $doAttrs = json_decode($req->getBody(),true);
        DoAttrModel::UpdateDoAttr($do_id, $doAttrs);

        return $resp;
    });

    $this->delete('/{do_ids}' , function (Request $req, Response $resp, $args) {
        $do_ids = $args['do_ids'];
        DoAttrModel::DeleteDoAttr($do_ids);

        return $resp;
    });

});

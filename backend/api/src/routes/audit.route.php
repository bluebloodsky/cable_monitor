<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 18-4-12
 * Time: 上午11:27
 */

use Slim\Http\Request;
use Slim\Http\Response;

$app->group('/audit_log', function() {
    $this->get('', function (Request $req, Response $resp, $args) {
        $RET = AuditModel::GetAllLog();
        return $resp->withJson($RET);
    });

    $this->delete('/{id}', function (Request $req, Response $resp, $args) {
        $auditId = $args['id'];
        AuditModel::SetUser($this->jwt->user);
        AuditModel::Remove($auditId);

        return $resp;
    });
});

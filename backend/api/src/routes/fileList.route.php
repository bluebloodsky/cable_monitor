<?php
use Slim\Http\Response;
use Slim\Http\Request;

$app->get('/cfg_filelist', function (Request $req, Response $resp, $args) {
    // Omit the params
    //$params = $req->getQueryParams();
    $RET = FileListModel::GetCmuFileList();
    return $resp->withJson($RET);
});

$app->get('/tools_filelist', function (Request $req, Response $resp, $args) {
    // Omit the params
    //$params = $req->getQueryParams();
    $RET = FileListModel::GetToolsFileList();
    return $resp->withJson($RET);
});

$app->get('/file_download', function (Request $req, Response $resp, $args) {
    $params = $req->getQueryParams();
    $type = $params['type'];
    $fileName = $params['filename'];
    if(is_null($type)||is_null($fileName))
    {
        throw new CmuException("need argument type and filename");
    }
    return FileListModel::GetFile($type, $fileName, $resp);
});

$app->post('/icd_upload', function (Request $req, Response $resp, $args) {
    $files = $req->getUploadedFiles();
    if (empty($files['newfile']))
    {
        throw new CmuException('Expect a newfile');
    }

    $RET = FileListModel::OnUploadFile($files['newfile']);

    return $resp->withJson($RET);
});

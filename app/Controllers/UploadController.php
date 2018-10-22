<?php

namespace App\Controllers;

use App\Models\UploadModel;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use Slim\Http\Stream;

use \App\Controller;


class UploadController extends Controller {


    public function onUploadfile(Request $request, Response $response, $args){
        header("Access-Control-Allow-Origin: *");

        $uploadedFiles = $request->getUploadedFiles();
        $uploadedFile = $uploadedFiles['uploads'];
        if($uploadedFile->getError() === UPLOAD_ERR_OK){
            $originalName = $uploadedFile->getClientFilename();
            $originalTab = explode(".",$originalName);
            $generatedName = sha1($originalName).".".$originalTab[count($originalTab) -1];
            $uploadedFile->moveTo("./uploads/".$generatedName);
            return $response->withJson(['errorCode'=>true, 'message'=>['formatfile'=>$originalTab[count($originalTab) -1], 'originalName'=>$originalName, 'generatedName'=>$generatedName]]);
        }
        else{
            return $response->withJson(['errorCode'=> false]);
        }
    }

    public function showfile(Request $request, Response $response, $args){
        header("Access-Control-Allow-Origin: *");

        $uploadModel = new UploadModel($this->db);
        $messageFile = $uploadModel->getMessageByGenerateName($args['file']);

        $file = DIR . '/uploads/'.$messageFile['generate_name'];
        $fh = fopen($file, 'rb');

        $stream = new Stream($fh); // create a stream instance for the response body
        return $response->withHeader('Content-Type', 'application/force-download')
            ->withHeader('Content-Type', 'application/octet-stream')
            ->withHeader('Content-Type', 'application/download')
            ->withHeader('Content-Description', 'File Transfer')
            ->withHeader('Content-Transfer-Encoding', 'binary')
            ->withHeader('Content-Disposition', 'attachment; filename="' . $messageFile['original_name'] . '"')
            ->withHeader('Expires', '0')
            ->withHeader('Cache-Control', 'must-revalidate, post-check=0, pre-check=0')
            ->withHeader('Pragma', 'public')
            ->withBody($stream); // all stream contents will be sent to the response
    }


}
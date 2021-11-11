<?php

namespace RouterController;

use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class RouterController
{
  private $db;
  public $data;

  public function showAll(Request $request, Response $response )
  {
    $this->data = new Data();
    $response = $data->showAll();

    return $response;
  }
   
  
  public function addClient(Request $request, Response $response )
  {
    $first_name = $request->getParam('first_name');
    $last_name = $request->getParam('last_name');
    $email_addr = $request->getParam('email_addr');
    $email_arr = explode(",", $email_addr );

    $this->data = new Data();
    $data->addOne($first_name, $last_name, $email_addr, $email_arr);
    echo 'Client added to db';
  }
  public function showOne(Request $request, Response $response )
  {
    $id = $request->getAttribute('id');
    $this->data = new Data();
    $response = $data->showOne( $id );
    return $response;
  }
  public function showFile(Request $request, Response $response, $args)
  {
    $filePath = __DIR__ . '/' . $args['file'];

    if (!file_exists( $filePath )) {
        return $response->withStatus(404, 'File Not Found');
    }
  
    switch (pathinfo( $filePath, PATHINFO_EXTENSION )) {
        case 'css':
            $mimeType = 'text/css';
        break;
        case 'js':
            $mimeType = 'application/javascript';
        break;
        default:
            $mimeType = 'text/html';
    }
  
    $newResponse = $response->withHeader('Content-Type', $mimeType . '; charset=UTF-8');
  
    $newResponse->getBody()->write(file_get_contents( $filePath ));
  
    return $newResponse;
  }
}
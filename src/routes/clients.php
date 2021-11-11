<?php
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;


$app = new \Slim\App;


$app->get('/clients', RouterController::class . ':showAll');

$app->post('/clients/add', RouterController::class . ':addOne');

$app->get('/clients/{id}', RouterController::class . ':showOne');

$app->get('/{file}', function (Request $request, Response $response, $args) {
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
});
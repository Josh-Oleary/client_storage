<?php
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

require __DIR__ . '/../vendor/autoload.php';
require '../src/config/db.php';

$app = new \Slim\App;


require '../src/routes/clients.php';

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

$app->run();
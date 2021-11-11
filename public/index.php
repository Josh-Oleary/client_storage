<?php
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;


require __DIR__ . '/../vendor/autoload.php';
require '../src/config/db.php';

$app = new \Slim\App;

// $container = $app->getContainer();

// $container['view'] = function ($container) {
//     $view = new \Slim\Views\Twig(__DIR__.'../public');
//     $basePath = rtrim(str_ireplace('index.php', '', $container['request']->getUri()->getBasePath()), '/');
//     $view->addExtension(new Slim\Views\TwigExtension($container['router'], $basePath));
//     return $view;
// };


// $app->get('/', function (Request $request, Response $response) {
//   $result = $app->render(__DIR__.'home.twig');
//   return $result;
// };

require '../src/routes/clients.php';



$app->run();
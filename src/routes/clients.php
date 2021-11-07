<?php
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

$app = new \Slim\App;

$app->get('/', function (Request $request, Response $response) {
  $response->getBody()->write("Home Page");
  return $response;
});

$app->get('/clients', function (Request $request, Response $response) {
  $sql = "SELECT * FROM clients";

  try{
    $db = new db();
    $db = $db->connect();

    $stmt = $db->query($sql);
    $clients = $stmt->fetchAll(PDO::FETCH_OBJ);
    $db = null;
    echo json_encode($clients);
  } catch(PDOException $e) {
    echo '{"error": {"text": '.$e->getMessage().'}}';
  }
});

$app->get('/add', function(Request $request, Response $response) {
  echo 'ADD CLIENT';
});

$app->get('/clients/{id}', function(Request $request, Response $response) {
  $id = $request->getAttribute('id');
  $sql = "SELECT * FROM `clients` WHERE `id` = $id";

  try{
    $db = new db();
    $db = $db->connect();

    $stmt = $db->query($sql);
    $clients = $stmt->fetchAll(PDO::FETCH_OBJ);
    $db = null;
    echo json_encode($clients);
  } catch(PDOException $e) {
    echo '{"error": {"text": '.$e->getMessage().'}}';
  }
});
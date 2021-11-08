<?php
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

$app = new \Slim\App;


$app->get('/clients', function (Request $request, Response $response) {
  $sql = "SELECT * FROM clients";

  try{
    $db = new db();
    $db = $db->connect();

    $stmt = $db->query( $sql );
    $clients = $stmt->fetchAll(PDO::FETCH_OBJ);
    $db = null;
    echo json_encode( $clients );
  } catch(PDOException $e) {
    echo '{"error": {"text": '.$e->getMessage().'}}';
  }
});

$app->post('/clients/add', function(Request $request, Response $response) {
  $first_name = $request->getParam('first_name');
  $last_name = $request->getParam('last_name');
  $emails = $request->getParam('email');

  $sql = "INSERT INTO `clients` (first_name, last_name) VALUES (:first_name, :last_name);";
  
  try{
    $db = new db();
    $db = $db->connect();

    $stmt = $db->prepare($sql);

    $stmt->bindParam(':first_name', $first_name);
    $stmt->bindParam(':last_name', $last_name);

    $stmt->execute();

    echo 'Add client success';

  } catch(PDOException $e) {
    echo '{"error": {"text": '.$e->getMessage().'}}';
  }
});

$app->get('/clients/{id}', function(Request $request, Response $response) {
  $id = $request->getAttribute('id');
  $sql = "SELECT * FROM `clients` WHERE `id` = $id";

  try{
    $db = new db();
    $db = $db->connect();

    $stmt = $db->query( $sql );
    $client = $stmt->fetchAll(PDO::FETCH_OBJ);
    $db = null;
    echo json_encode( $client );
  } catch(PDOException $e) {
    echo '{"error": {"text": '.$e->getMessage().'}}';
  }
});
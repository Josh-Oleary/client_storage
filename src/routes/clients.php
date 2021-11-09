<?php
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;


$app = new \Slim\App;


$app->get('/clients', function (Request $request, Response $response ) {
  $sql = "SELECT * FROM clients";

  try{
    $db = new db();
    $db = $db->connect();

    $stmt = $db->query( $sql );
    $clients = $stmt->fetchAll(PDO::FETCH_OBJ);
    $db = null;
    if($clients == []){
        echo 'No clients in db';
    } else {
        echo json_encode( $clients );
    }
  } catch(PDOException $e) {
    echo '{"error": {"text": '.$e->getMessage().'}}';
  }
});

$app->post('/clients/add', function(Request $request, Response $response ) {
    $first_name = $request->getParam('first_name');
    $last_name = $request->getParam('last_name');
    $email_addr = $request->getParam('email_addr');
    $email_arr = explode(",", $email_addr );

    $sql = "INSERT INTO `clients` (first_name, last_name) VALUES (:first_name, :last_name);";

    if($first_name !== '' && $last_name !== '' && $email_addr !== ''){
        try{
            $db = new db();
            $db = $db->connect();

            $stmt = $db->prepare( $sql );


            $stmt->bindParam(':first_name', $first_name );
            $stmt->bindParam(':last_name', $last_name );

            $stmt->execute();

            $prev_id = $db->lastInsertId();

            for($i = 0; $i < count( $email_arr ); $i++){
              $stmt2 = $db->prepare("INSERT INTO `emails` (client_id, email_addr) VALUES (:client_id, :email_addr);");

              $stmt2->bindParam(':client_id', $prev_id );
              $stmt2->bindParam(':email_addr', $email_arr[$i] );

              $stmt2->execute();
            }
            $return_data = (object) ['first_name' => $first_name, 'last_name' => $last_name];
            echo json_encode( $return_data );

          } catch(PDOException $e) {
            echo '{"error": {"text": '.$e->getMessage().'}}';
          }
    } else {
        echo 'Input fields can not be empty, please try again!';
    }

});

$app->get('/clients/{id}', function(Request $request, Response $response ) { 
  $id = $request->getAttribute('id');

  $sql = "SELECT first_name, last_name, email_addr FROM clients, emails WHERE clients.id = $id && emails.client_id = $id;";

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
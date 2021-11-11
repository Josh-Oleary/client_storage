<?php

use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class Data
{
  private $db;

  public function __construct(ContainerInterface $container) 
  {
    $this->db = new db();
  }

  public function showAll()
  {
    $sql = "SELECT * FROM clients";
    $this->db = $db->connect();
  
    $stmt = $db->query( $sql );
    $clients = $stmt->fetchAll(PDO::FETCH_OBJ);
  
    $db = null;

    return json_encode( $clients );
  }

  public function addOne($first_name, $last_name, $email_addr, $email_arr)
  {
    $sql = "INSERT INTO `clients` (first_name, last_name) VALUES (:first_name, :last_name);";

    if($first_name !== '' && $last_name !== '' && $email_addr !== ''){
       
    $this->db = $db->connect();

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
      return json_encode( $return_data );

    }
  }

  public function showOne( $id )
  {
    $sql = "SELECT first_name, last_name, email_addr FROM clients, emails WHERE clients.id = $id && emails.client_id = $id;";
  
    $this->db = $db->connect();

    $stmt = $db->query( $sql );
    $client = $stmt->fetchAll(PDO::FETCH_OBJ);

    $db = null;
    return json_encode( $client );
  }
}

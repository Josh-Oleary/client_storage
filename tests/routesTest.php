<?php
require __DIR__ . '/../vendor/autoload.php';



class RoutesTest extends \PHPUnit\Framework\TestCase
{
  protected $client;

  protected function setUp(): void {
    $this->client = new GuzzleHttp\Client([
      'base_uri' => 'http://localhost/'
    ]);
  }

  public function testGet_ValidInput_ClientObject(): object {
    $response = $this->client->get('slimAPI/public/clients');

    $this->assertEquals(200, $response->getStatusCode());
    $this->assertIsObject($response);
    $data = json_decode($response->getBody(), true);

    $this->assertNotEmpty( $data , $message = 'Return Empty');

    return $response;
  }

  public function testPost_AddClients() {
    $data = (array) ['first_name' => 'Josh', 'last_name' => 'Oleary', 'email_addr' => 'test@mail.com'];
    
    $request = $this->client->post('slimAPI/public/clients/add', $data);

    $this->assertEquals(200, $request->getStatusCode());

  }

  public function testGet_ClientById(): object {
    $response = $this->client->get('slimAPI/public/clients/1');

    $this->assertEquals(200, $response->getStatusCode());
    $this->assertIsObject($response);
    $data = json_decode($response->getBody(), true);
    $this->assertNotEmpty($data, $message = 'Invalid User');

    return $response;
  }
}
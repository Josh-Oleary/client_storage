# client_storage
API built with slimPHP and MariaDB

#Run Application
Download zip file and run `composer install` in the command line. I used MAMP for this project, you can use something similar or start up an apache server on port 80
Database server should be set to port 3306

You can use Postman for quick testing of routes


#Routes

public/clients
  - this endpoint will return all clients in the db

public/clients/{id}
  - this endpoing will return a specific client whose id matchs the {id} variable,
  - this endpoint also returns all email addresses associated with this client
 
 public/add
  - this endoint requires 3 paramets in multipart/form-data format
    first_name | last_name | email
  - user can add as many email addresses as they would like, addresses contain no spaces, only a ',' in between addresses
 
 public/home.twig
  - this endpoint will render a basic UI for adding clients to db

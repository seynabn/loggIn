<?php 
// vendor= importerar .env innehållet.
require_once("vendor/autoload.php");
require_once("models/UserDatabase.php");
class Database

{
  public $pdo; // PDO är PHP Data Object - en klass som finns i PHP för att kommunicera med databaser
  // I $pdo finns nu funktioner (dvs metoder!) som kan användas för att kommunicera med databasen

  private $usersDatabase;
  function getUsersDatabase()
  {
    return $this->usersDatabase;
  }


  // Note to Stefan STATIC så inte initieras varje gång

  // SKILJ PÅ CONFIGURATION OCH KOD

  function __construct()
  {
    $dotenv = \Dotenv\Dotenv::createImmutable(__DIR__."/../");
    $dotenv->load();
  


    $host = $_ENV['DATABASE_HOST'];
    $db = $_ENV['DATABASE_NAME'];
    $user = $_ENV['DATABASE_USER'];
    $pass = $_ENV['DATABASE_PASS'];
    $port = $_ENV['DATABASE_PORT'];

    $dsn = "mysql:host=$host:$port;dbname=$db"; // connection string
    $this->pdo = new PDO($dsn, $user, $pass);

    $this->usersDatabase = new UserDatabase($this->pdo);
    $this->usersDatabase->setupUsers();
    $this->usersDatabase->seedUsers();

  
  }
  
};
?>

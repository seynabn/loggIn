<?php
require_once('vendor/autoload.php');
require_once("models/Database.php");

 
class UserDatabase {
    private $pdo;
    private $auth;
 
    function getAuth(){
      return $this->auth;
    }
    function __construct($pdo) {
        $this->pdo = $pdo;
        $this->auth = new \Delight\Auth\Auth($pdo);
    }
 
    function setupUsers(){
    }
    
    // när progranmmet startar så kan vi se till att de kommer in en användare.
    // kommer att lägga till en användare i databasen.
        function seedUsers(){
        if($this->pdo->query("select * from users where email='seynab.nur@hotmail.com'")->rowCount() == 0){
            $userId = $this->auth->admin()->createUser("seynab.nur@hotmail.com", "Hejsan123.", "seynab.nur@hotmail.com");    
        }
    }
    function addUserDetails($id, $streetaddress, $name, $postalCode, $city){
            $query = $this->pdo->prepare("INSERT INTO UserDetails (id, streetaddress, name, postalCode, city) VALUES (:id, :streetaddress, :name, :postalCode, :city)");
            $query->execute(["id"=>$id, "streetaddress"=>$streetaddress, 
                    "name"=>$name, "postalCode"=>$postalCode, "city"=>$city]);
        }

 
}
<?php
ob_start();
require_once('lib/PageTemplate.php');
require_once("vendor/autoload.php");
require_once("models/Database.php");



# trick to execute 1st time, but not 2nd so you don't have an inf loop
if (!isset($TPL)) {
    $TPL = new PageTemplate();
    $TPL->PageTitle = "Login";
    $TPL->ContentBody = __FILE__;
    include "layout.php";
    exit;
}
$message = "";
$database = new Database();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];
    try {
        $database->getUsersDatabase()->getAuth()->login($email, $password);
        header("Location: /");
    } catch (\Delight\Auth\InvalidEmailException $e) {
        $message = "Fel användarnamn eller lösenord";
    } catch (\Delight\Auth\InvalidPasswordException $e) {
        $message = "Fel användarnamn eller lösenord";
    }
}
?>

<p>
<div class="row">
<?php
echo $message
?>
    <div class="row">
        <div class="col-md-12">
            <div class="newsletter">
                <p>User<strong>&nbsp;LOGIN</strong></p>
                <form method="POST">
                    <input name="email" class="input" type="email" placeholder="Enter Your Email">
                    <br />
                    <br />
                    <input name="password" class="input" type="password" placeholder="Enter Your Password">
                    <br />
                    <br />
                    <button class="newsletter-btn"><i class="fa fa-envelope"></i> Login</button>
                </form>
                <a href="">Lost password?</a>
            </div>
        </div>
    </div>


</div>


</p>
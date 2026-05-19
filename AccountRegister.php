<?php
ob_start(); // för cookies och sessions.
require_once('lib/PageTemplate.php');
require_once("vendor/autoload.php");
require_once("models/Database.php");
require_once("models/UserDatabase.php");
require_once("utils/validator.php");

// $newId == 3
// Lagra 
$database = new Database();
# trick to execute 1st time, but not 2nd so you don't have an inf loop
if (!isset($TPL)) {
    $TPL = new PageTemplate();
    $TPL->PageTitle = "Regsier";
    $TPL->ContentBody = __FILE__;
    include "layout.php";
    exit;
}
$v = new Validator($_POST);

$database = new Database();
$email = "";
$password = "";
$passwordRepeat = "";
$name = "";
$streetaddress = "";
$postalCode = "";
$city = "";

$message = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Dom har tryckt på knappen, validera och registrera
    $email = $_POST['email'];
    $password = $_POST['password'];
    $passwordRepeat = $_POST['passwordRepeat'];
    $name = $_POST['name'];
    $streetaddress = $_POST['street'];
    $postalCode = $_POST['postal'];
    $city = $_POST['city'];

    // todo add 
    $v->field('email')->required()->email();
    $v->field('password')->required()->min_len(8)->max_len(20);
    $v->field('passwordRepeat')->equals($password);

    $v->field('name')->required()->min_len(3)->max_len(50);
    $v->field('street')->required()->min_len(3)->max_len(50);
    $v->field('postal')->required()->max_len(10);
    $v->field('city')->required()->max_len(50);

    //
    if ($v->is_valid()) {
        try {
            $userid = $database->getUsersDatabase()->getAuth()->register($email, $password, $email);
            // insert into user details table with $userid and other details
            $database->getUsersDatabase()->addUserDetails($userid, $name, $streetaddress, $postalCode, $city);
            header("Location: /AccountLogin.php");
            exit;
        } catch (\Delight\Auth\UserAlreadyExistsException $e) {
            $message = "User already exists";
        } catch (\Delight\Auth\InvalidEmailException $e) {
            $message = "Invalid email";
        } catch (\Delight\Auth\TooManyRequestsException $e) {
            $message = "Too many requests, please try again later";
        }
    }
}

?>






?>
<p>
<div class="row">

    <div class="row">
        <div class="col-md-12">
            <div class="newsletter">
                <p>User<strong>&nbsp;REGISTER</strong></p>
                <form method="POST">
                    <input value="<?php echo $email; ?>" class="input" type="text" placeholder="Enter Your Email"
                        name="email">
                    <?php echo $v->get_error_message('email'); ?>
                    <br />
                    <br />
                    <input value="<?php echo $password; ?>" class="input" type="password"
                        placeholder="Enter Your Password" name="password">
                    <?php echo $v->get_error_message('password'); ?>
                    <br />
                    <br />
                    <input value="<?php echo $passwordRepeat; ?>" class="input" type="password"
                        placeholder="Repeat Password" name="passwordRepeat">
                    <?php echo $v->get_error_message('passwordRepeat'); ?>
                    <br />
                    <br />
                    <input value="<?php echo $name; ?>" class="input" type="text" placeholder="Name" name="name">
                    <?php echo $v->get_error_message('name'); ?>
                    <br />
                    <br />
                    <input value="<?php echo $streetaddress; ?>" class="input" type="text" placeholder="Street address"
                        name="street">
                    <?php echo $v->get_error_message('street'); ?>
                    <br />
                    <br />
                    <input value="<?php echo $postalCode; ?>" class="input" type="text" placeholder="Postal code"
                        name="postal">
                    <?php echo $v->get_error_message('postal'); ?>
                    <br />
                    <br />
                    <input value="<?php echo $city; ?>" class="input" type="text" placeholder="City " name="city">
                    <?php echo $v->get_error_message('city'); ?>
                    <br />
                    <br />
                    <button type="submit" class="newsletter-btn"><i class="fa fa-envelope"></i> Register</button>
                </form>
            </div>
        </div>
    </div>


</div>


</p>
<?php
require_once("../Database/connect.db.php");

session_set_cookie_params(0, '/', 'localhost', true, true);
session_start();


if (empty($_POST["Username"])) {
    $_SESSION["Error"] = "Username is required.";
    header('Location: ../Register.php');
    exit();
    //die("Username is required.");
}
if (empty($_POST["password"])) {
    $_SESSION["Error"] = "Password is required.";
    header('Location: ../Register.php');
    exit();
    //die("Password is required.");
}
$username = $_POST["Username"];
if (!preg_match ("/^[a-zA-Z0-9_-]+$/", $username)){
    $_SESSION["Error"] = "Username can only contain letters, numbers, underscores (_) and hyphes (-)!";
    header('Location: ../Register.php');
    exit();
    //die("Username can only contain letters, numbers, underscores (_) and hyphes (-)! ");
}
$email = $_POST['email'];
$pattern = '/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/';
if (!preg_match($pattern, $email )){
    $_SESSION["Error"] = "Please provide a valid email address.";
    header('Location: ../Register.php');
    exit();
    //die("Please provide a valid email address.");
}
if (strlen($username) > 30){
    $_SESSION["Error"] = "Username must not have more than 30 characters.";
    header('Location: ../Register.php');
    exit();
    //die("Username must not have more than 30 characters");
}
if (strlen($email) > 50){
    $_SESSION["Error"] = "Email must not have more than 50 characters.";
    header('Location: ../Register.php');
    exit();
    //die("Email must not have more than 50 characters");
}
if (strlen($_POST["password"]) < 8){
    $_SESSION["Error"] = "Password must not have less than 8 characters.";
    header('Location: ../Register.php');
    exit();
}
if (strlen($_POST["password"]) >64){
    $_SESSION["Error"] = "Password lenght should not exceed 64 characters.";
    header('Location: ../Register.php');
    exit();
}

$db = database_connect();
$statement1 = $db->prepare('SELECT * FROM USER WHERE UserName = ? OR Email = ?');
$statement1->execute(array($_POST['Username'], $_POST['email']));
if($statement1->fetch() !== false){
    $_SESSION["Error"] = "Username or email already in use.";
    header('Location: ../Register.php');
    exit();
    //die("Username or email already in use.");
}
else{
    $options = ['cost' => 11];
    //session_set_cookie_params(0, '/', 'localhost', true, true);
    //session_start();
    $secure_password = password_hash($_POST["password"], PASSWORD_DEFAULT, $options);
    $statement2 = $db->prepare('INSERT INTO USER (UserName, Email, Password) VALUES (?, ?, ?)');
    $statement2->execute(array($_POST["Username"], $_POST["email"] , $secure_password));
    $_SESSION["Username"] = $_POST["Username"];
    header('Location: ../mainPage.php');
}




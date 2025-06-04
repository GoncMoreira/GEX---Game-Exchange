<?php
require_once("../Database/connect.db.php");

session_set_cookie_params(0, '/', 'localhost', true, true);
session_start();


if (empty($_POST["email"])) {
    $_SESSION["Error"] = "Email is required.";
    header('Location: ../Login.php');
    exit();
}
if (empty($_POST["password"])) {
    $_SESSION["Error"] = "Password is required.";
    header('Location: ../Login.php');
    exit();
}

$email = $_POST['email'];
$pattern = '/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/';
if (!preg_match($pattern, $email )){
    $_SESSION["Error"] = "Please provide a valid email address.";
    header('Location: ../Login.php');
    exit();
}


$db =  database_connect();

$statement1 = $db->prepare('SELECT * FROM USER WHERE Email = ? ');
$statement1->execute(array($_POST['email']));
$acc = $statement1->fetch();

if($acc !== false){
    if ($acc['Blocked']===0){
        $raw_password = $_POST['password'];
        if (password_verify($raw_password, $acc["Password"])){
            $_SESSION['Username'] = $acc["UserName"];
            header('Location: ../mainPage.php');
            exit();
        }
        else {
            $_SESSION["Error"] = "Wrong password for this account.";
            header('Location: ../Login.php');
            exit();
        }
    }
    else{
        $_SESSION["Error"] = "This account has been blocked by an admin.";
        header('Location: ../Login.php');
        exit();
    }
}
else{
    $statement1 = $db->prepare('SELECT * FROM USER WHERE Email = ?');
    $statement1->execute(array($_POST['email']));
    $acc2 = $statement1->fetch();
    
    if ($acc2 === false) {
        $_SESSION["Error"] = "This account does not exist.";
        header('Location: ../Login.php');
        exit();
    }
    else {
        $_SESSION["Error"] = "Wrong password for this account.";
        header('Location: ../Login.php');
        exit();
    }
}

<?php

require_once('../Database/connect.db.php');

session_set_cookie_params(0, '/', 'localhost', true, true);
session_start();


if (empty($_POST["address"])) {
    $_SESSION["Error"] = "Address is required.";
    header('Location: ../buy_item.php');
    exit();
}


if (empty($_POST["email"])) {
    $_SESSION["Error"] = "Email confirmation is required.";
    header('Location: ../buy_item.php');
    exit();
}


if (empty($_POST["password"])) {
    $_SESSION["Error"] = "Please insert your password.";
    header('Location: ../buy_item.php');
    exit();
}


$address = $_POST["address"];
if (!preg_match("/^[a-zA-Z0-9-\s]+$/", $address)){    
    $_SESSION["Error"] = "Address can only contain letters, spaces, numbers and hyphes (-)!";
    header('Location: ../buy_item.php');
    exit();
}
$email = $_POST['email'];
$pattern = '/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/';
if (!preg_match($pattern, $email )){
    $_SESSION["Error"] = "Please provide a valid email address.";
    header('Location: ../buy_item.php');
    exit();
}


$db = database_connect();
$stmt = $db->prepare('SELECT * FROM USER AS U WHERE U.UserName == ?');
$stmt->execute(array($_SESSION['Username']));
$user = $stmt->fetch();

if ($_POST["email"] != $user['Email']) {
    $_SESSION["Error"] = "Emails do not match.";
    header('Location: ../buy_item.php');
    exit();
}
if ( !password_verify($_POST["password"], $user['Password'])) {
    $_SESSION["Error"] = "Wrong password.";
    header('Location: ../buy_item.php');
    exit();
}

$stmt = $db->prepare('SELECT PRODUCTId FROM SHOPPINGCART AS S WHERE S.UserName == ?');
$stmt->execute(array($_SESSION['Username']));
$items = $stmt->fetchAll();

$users = array();
$index = 0;

foreach($items as $item){
    $stmt = $db->prepare('SELECT * FROM PRODUCT AS P WHERE P.PRODUCTId == ?');
    $stmt->execute(array($item['PRODUCTId']));
    $new_user = $stmt->fetchAll()[0]['UserName'];
    if(!in_array($new_user,$users)){
        $users[$index] = $new_user;
        $index++;
    }
    
}
$users = array_unique($users);
//print_r($users);

//introduzir valores no transactions
$stmt = $db->prepare('SELECT count(*) FROM TRANSACTIONS');
$stmt->execute();
$id = $stmt->fetch()[0] + 1;

foreach($items as $item){
    $stmt = $db->prepare('INSERT INTO TRANSACTIONS (TRANSACTIONSId, PRODUCTId, Username, Address) VALUES (?, ?, ?, ?)');
    $stmt->execute(array($id, $item['PRODUCTId'], $_SESSION['Username'], $_POST["address"]));
    //colocar sold a 1
    $stmt = $db->prepare('UPDATE PRODUCT SET sold = 1 WHERE PRODUCTId = ?');
    $stmt->bindParam(1, $item['PRODUCTId']);
    $stmt->execute();
    $stmt = $db->prepare('DELETE FROM SHOPPINGCART AS S WHERE S.PRODUCTId = ?');
    $stmt->execute(array($item['PRODUCTId']));
}



header('Location: ../ShippingForm.php?id=' . $id);

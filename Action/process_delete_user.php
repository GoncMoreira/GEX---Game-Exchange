<?php

    require_once('../Database/connect.db.php');

    $db =  database_connect();

    session_set_cookie_params(0, '/', 'localhost', true, true);
    session_start();

    $deleted_user = $_POST['UserName'];
    $logged_in_user = $_SESSION['Username'];

    $stmt = $db->prepare('DELETE FROM PRODUCT WHERE UserName = ?');
    $stmt->bindParam(1, $deleted_user);
    $stmt->execute();

    $stmt = $db->prepare('DELETE FROM USER WHERE UserName = ?');
    $stmt->bindParam(1, $deleted_user);
    if ($deleted_user===$logged_in_user){
        session_destroy();
    }
    if ($stmt->execute()) {
        header('Location: ../mainPage.php');
    }
?>
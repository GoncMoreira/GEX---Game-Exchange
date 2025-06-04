<?php

    session_set_cookie_params(0, '/', 'localhost', true, true);
    session_start();

    require_once('../Database/connect.db.php');

    $db = database_connect();

    $receiver_name = $_POST["ReceiverUserName"];
    $stmt = $db->prepare('SELECT UserName FROM USER WHERE UserName = ?');
    $stmt->execute(array($receiver_name));
    $new_id = $stmt->fetch(PDO::FETCH_COLUMN, 0);

    if ($new_id === $receiver_name){
        header('Location: ../chat.php?UserName='.$receiver_name);
    }
    else{
        $_SESSION["Error"] = "User not found";
        header('Location: ../Messages.php');
    }
?>
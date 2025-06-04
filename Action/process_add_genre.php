<?php

    session_set_cookie_params(0, '/', 'localhost', true, true);
    session_start();

    require_once('../Database/connect.db.php');

    $db = database_connect();

    $new_name = $_POST["GENREName"];

    $stmt = $db->prepare('SELECT * FROM GENRE WHERE GENREName = ?');
    $stmt->execute(array($new_name));

    if (sizeof($stmt->fetchAll())>0){
        $_SESSION["Error"] = "Genre already exists";
        header('Location: ../adminPage.php');
        exit();
    }
    else{
        $stmt = $db->prepare('INSERT INTO GENRE (GENREName) VALUES (?)');
        $stmt->execute(array($new_name));
    }

    header('Location: ../mainPage.php')
?>
<?php

    require_once('../Database/connect.db.php');

    $db =  database_connect();

    session_set_cookie_params(0, '/', 'localhost', true, true);
    session_start();

    $selected_user = $_POST['UserName'];

    $stmt = $db->prepare('SELECT Admin FROM USER WHERE UserName = ?');
    $stmt->execute(array($selected_user));
    $admin = $stmt->fetch()[0];

    $stmt = $db->prepare('UPDATE USER SET Admin=? WHERE UserName = ?');
    if ($admin===0){
        if ($stmt->execute(array(1, $selected_user))) {
            header('Location: ../mainPage.php');
        }
    } 
    else if ($admin===1){
        if ($stmt->execute(array(0, $selected_user))) {
            header('Location: ../mainPage.php');
        }
    }
?>
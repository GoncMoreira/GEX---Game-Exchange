<?php

    require_once('../Database/connect.db.php');

    $db =  database_connect();

    session_set_cookie_params(0, '/', 'localhost', true, true);
    session_start();

    $selected_user = $_POST['UserName'];

    $stmt = $db->prepare('SELECT Blocked FROM USER WHERE UserName = ?');
    $stmt->execute(array($selected_user));
    $blocked = $stmt->fetch()[0];

    $stmt = $db->prepare('UPDATE USER SET Blocked=? WHERE UserName = ?');
    if ($blocked===0){
        if ($stmt->execute(array(1, $selected_user))) {
            $stmt = $db->prepare('DELETE FROM PRODUCT WHERE PRODUCTId IN ( SELECT PRODUCTId FROM PRODUCT JOIN USER ON PRODUCT.UserName = USER.UserName WHERE USER.UserName = ? )');
            $stmt->execute(array($selected_user));
            header('Location: ../mainPage.php');
        }
    } 
    else if ($blocked===1){
        if ($stmt->execute(array(0, $selected_user))) {
            header('Location: ../mainPage.php');
        }
    }
?>
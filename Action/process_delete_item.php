<?php

require_once('../Database/connect.db.php');

session_set_cookie_params(0, '/', 'localhost', true, true);
session_start();

    
    $db = database_connect();

    $target_id = $_POST["ProductId"];

    $stmt = $db->prepare('DELETE FROM PRODUCT WHERE PRODUCTId = ?');
    $stmt->execute(array($target_id));

    $stmt = $db->prepare('DELETE FROM PRODUCT_IMAGE WHERE PRODUCTId = ?');
    $stmt->execute(array($target_id));

    header('Location: ../mainPage.php')
?>
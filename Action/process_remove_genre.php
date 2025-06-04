<?php

    session_set_cookie_params(0, '/', 'localhost', true, true);
    session_start();

    require_once('../Database/connect.db.php');

    $db = database_connect();

    $genre_name = $_POST["GENREName"];

    $stmt = $db->prepare('DELETE FROM GENRE WHERE GENREName = ?');
    $stmt->execute(array($genre_name));

    $stmt = $db->prepare('DELETE FROM PRODUCT_GENRE WHERE GENREName = ? ');
    $stmt->execute(array($genre_name));

    header('Location: ../mainPage.php')
?>
<?php

    session_start();

    require_once('../Database/connect.db.php');

    $db = database_connect();

    $receiver_name = $_POST["ReceiverUserName"];
    $message = $_POST["MessageText"];

    $datetime = new DateTime('now', new DateTimeZone('+0100'));
    $current_time = $datetime->format('Y-m-d H:i:s');

    $stmt = $db->prepare('SELECT MAX(MESSAGEId) FROM MESSAGES');
    $stmt->execute();
    $new_id = $stmt->fetch()[0] + 1;


    $stmt = $db->prepare('INSERT INTO MESSAGES (MESSAGEId, SenderUserName, ReceiverUserName, TimeSent, MessageText) VALUES (?,?,?,?,?)');
    $stmt->execute(array($new_id, $_SESSION['Username'], $receiver_name, $current_time, $message));

    header('Location: ../chat.php?UserName='.$receiver_name);
?>
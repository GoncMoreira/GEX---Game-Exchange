<?php 
declare(strict_types=1);

require_once('Database/connect.db.php');
require_once('Database/games.db.php');
require_once('Interface/generic.int.php');
require_once('Interface/messages.int.php');

session_set_cookie_params(0, '/', 'localhost', true, true);
session_start();


$db = database_connect();
$userDetails = [];
//fetch messages of each conversation and group them by user, select time of last message and username
$stmt = $db->prepare('SELECT ReceiverUserName, MAX(TimeSent) AS LM FROM MESSAGES WHERE SenderUserName = ? GROUP BY ReceiverUserName');
$stmt->execute(array($_SESSION['Username']));
$senderMessages = $stmt->fetchAll();

$stmt = $db->prepare('SELECT SenderUserName, MAX(TimeSent) AS LM FROM MESSAGES WHERE ReceiverUserName = ? GROUP BY SenderUserName');
$stmt->execute(array($_SESSION['Username']));
$receiverMessages = $stmt->fetchAll();

foreach ($senderMessages as $message) {
    $userDetails[$message['ReceiverUserName']] = $message['LM'];
}
foreach ($receiverMessages as $message) {
    $userDetails[$message['SenderUserName']] = $message['LM'];
}

if ($userDetails !== NULL){
    arsort($userDetails);
    $users = array_keys($userDetails);
    $time_sent = array_values($userDetails);
}
else{
    $users = array();
    $time_sent = array();
}

//echo sizeof($users);
draw_header("Messages Page");
draw_conversations($users, $time_sent);
draw_footer();
?>
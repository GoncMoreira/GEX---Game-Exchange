<?php 
declare(strict_types=1);

require_once('Database/connect.db.php');
require_once('Database/games.db.php');
require_once('Interface/generic.int.php');
require_once('Interface/messages.int.php');

session_start();

$db = database_connect();
$search_un = $_GET['UserName'];

$stmt = $db->prepare('SELECT * FROM MESSAGES WHERE (SenderUserName = ? AND ReceiverUserName = ?) OR (SenderUserName = ? AND ReceiverUserName = ?) ORDER BY TimeSent');
$stmt->execute(array($search_un, $_SESSION['Username'], $_SESSION['Username'], $search_un));
$texts = $stmt->fetchAll();

$stmt = $db->prepare('UPDATE MESSAGES SET SEEN = 1 WHERE SenderUserName = ? AND ReceiverUserName = ?');
$stmt->execute(array($search_un, $_SESSION['Username']));

//echo sizeof($items);
draw_header("Messages Page");
draw_chat($texts, $search_un);
draw_footer();
?>
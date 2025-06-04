<?php 
declare(strict_types=1);

require_once('Database/connect.db.php');
require_once('Database/games.db.php');
require_once('Interface/generic.int.php');
require_once('Interface/sell_item.int.php');

session_start();

$db = database_connect();
$id = $_GET['id'];

$stmt = $db->prepare('SELECT * FROM TRANSACTIONS WHERE TRANSACTIONSId = ?');
$stmt->execute(array($id));
$items = $stmt->fetchAll();


draw_ShippingForm($items);

?>
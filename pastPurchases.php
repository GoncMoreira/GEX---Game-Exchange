<?php

declare(strict_types=1);
require_once('Database/connect.db.php');
require_once('Database/games.db.php');
require_once('Interface/generic.int.php');
require_once('Interface/games.int.php');


session_set_cookie_params(0, '/', 'localhost', true, true);
session_start();

$db = database_connect();
$stmt = $db->prepare('SELECT * FROM USER WHERE UserName = ?');
$stmt->execute(array($_SESSION['Username']));
$user = $stmt->fetchAll();

draw_header("Past Purchases");
draw_purchased_items($user);
draw_footer();
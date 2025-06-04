<?php 
declare(strict_types=1);

require_once('Database/connect.db.php');
require_once('Database/games.db.php');
require_once('Interface/generic.int.php');
require_once('Interface/admin.int.php');

session_set_cookie_params(0, '/', 'localhost', true, true);
session_start();

$db =  database_connect();
draw_header("Admin Page");

$stmt = $db->prepare('SELECT * FROM USER WHERE Blocked == 1');
$stmt->execute();
$users = $stmt->fetchAll();
draw_blocked_users($users);

$stmt = $db->prepare('SELECT * FROM DEVICE');
$stmt->execute();
$devices = $stmt->fetchAll();
$stmt = $db->prepare('SELECT * FROM GENRE');
$stmt->execute();
$genres = $stmt->fetchAll();
draw_admin_add_category($devices, $genres);

draw_footer();
?>
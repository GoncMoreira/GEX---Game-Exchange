<?php 
declare(strict_types=1);

require_once('Database/connect.db.php');
require_once('Database/games.db.php');
require_once('Interface/generic.int.php');
require_once('Interface/games.int.php');

session_set_cookie_params(0, '/', 'localhost', true, true);
session_start();

$db = database_connect();
$items_sold = get_items_being_sold_by_user($db, $_SESSION['Username']);

draw_header("Items being sold page");
draw_games_being_sold($items_sold);
draw_footer();

?>

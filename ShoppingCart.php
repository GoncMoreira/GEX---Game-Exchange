<?php 
declare(strict_types=1);

require_once('Database/connect.db.php');
require_once('Database/games.db.php');
require_once('Interface/generic.int.php');
require_once('Interface/games.int.php');

session_set_cookie_params(0, '/', 'localhost', true, true);
session_start();

$db = database_connect();

$items = get_all_items_shopping_cart($db, $_SESSION['Username']);
draw_header("ShoppingCart Page");
draw_ShoppingCart($items);
draw_footer();
?>
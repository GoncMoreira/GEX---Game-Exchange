<?php 
declare(strict_types=1);

require_once('Database/connect.db.php');
require_once('Database/games.db.php');
require_once('Interface/generic.int.php');
require_once('Interface/games.int.php');

session_set_cookie_params(0, '/', 'localhost', true, true);
session_start();

$db =  database_connect();
$items;
$genres = get_all_genres($db);
$devices = get_all_devices($db);
draw_header("Main Page");
if (isset($_SESSION['Username'])){
        $items = get_all_items_except_current_user($db, $_SESSION['Username']);
}
else {
        $items = get_all_items($db);
       
}


draw_all_games($items);
draw_side_menu( $genres, $devices);
draw_footer();
?>

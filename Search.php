<?php 
declare(strict_types=1);

require_once('Database/connect.db.php');
require_once('Database/games.db.php');
require_once('Interface/generic.int.php');
require_once('Interface/games.int.php');
session_set_cookie_params(0, '/', 'localhost', true, true);
session_start();

$db = database_connect();

$search_value = $_GET['search'];
$search_value = preg_replace("/[^a-zA-Z0-9-.\s]/", '', $search_value);

$matching_items;
$genres = get_all_genres($db);
$devices = get_all_devices($db);
if (isset($_SESSION['Username'])){
    $matching_items = search_items_by_name_user_restriction($db, $search_value, $_SESSION['Username']);
}
else {$matching_items = search_items_by_name($db, $search_value);}

draw_header("Search Page");
draw_search_items($matching_items);
draw_side_menu( $genres, $devices);
draw_footer();
?>

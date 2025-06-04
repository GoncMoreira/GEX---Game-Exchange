<?php
declare(strict_types=1);

require_once('Database/connect.db.php');
require_once('Database/games.db.php');
require_once('Interface/generic.int.php');
require_once('Interface/games.int.php');
session_set_cookie_params(0, '/', 'localhost', true, true);
session_start();


$db =  database_connect();
draw_header("FilterResults Page");

$genres = [];
$price = 1000000;
$devices = [];
$developers = [];
if (isset($_GET['genres'])){
    $genres = $_GET['genres'];
    
}

if(isset($_GET['devices'])){
    $devices = $_GET['devices'];
}
if(isset($_GET['developers'])){
    $developers = $_GET['developers'];
}
if(isset( $_GET['price'])){
    $price = intval($_GET['price']);
}


$items = search_filter($db, $genres, $devices, $price, $developers);
 if (empty($items)){ ?>
 <main id = "empty_filter_page">
    <span id="no_found_items_filter"> No items found! </span>
 </main>
<?php }
 else {
    $items_non_duplicates = [];
    $items_ids_no_duplicates = [];
    foreach($items as $item){
        if (in_array($item['PRODUCTId'], $items_ids_no_duplicates)){
            //is duplicate
        }
        else {
            // not duplicate
            $items_ids_no_duplicates[] = $item['PRODUCTId'];
            $items_non_duplicates[] = $item;
            
        }
    }

    if (isset($_SESSION['Username'])){
        draw_set_of_items_except_current_user($items_non_duplicates, $_SESSION['Username']);
    }
    else {draw_all_games($items_non_duplicates);}
    }
    
$genres_ = get_all_genres($db);
$devices_ = get_all_devices($db);
draw_side_menu( $genres_, $devices_);

draw_footer();
?>
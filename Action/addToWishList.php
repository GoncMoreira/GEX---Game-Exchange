<?php
require_once('../Database/connect.db.php');
require_once('../Database/games.db.php');
session_set_cookie_params(0, '/', 'localhost', true, true);
session_start();


$db =  database_connect();

if(isset($_POST['btnValue'])) 
    { 
        $btnValue = $_POST['btnValue']; 
        addToUserWishList($db,$btnValue, $_SESSION['Username']);
    }

?>
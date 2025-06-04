<?php
// removefromCart.php
require_once('../Database/connect.db.php');
require_once('../Database/games.db.php');
// Start the session
session_set_cookie_params(0, '/', 'localhost', true, true);
session_start();


$db =  database_connect();

if(isset($_POST['btnValue'])) 
    { 
        // Getting the value of button 
        // in $btnValue variable 
        $btnValue = $_POST['btnValue']; 
        //echo $btnValue;
        removefromUserWishList($db,$btnValue, $_SESSION['Username']);
         // Sending Response 
        //echo "Success"; 
    } 

?>
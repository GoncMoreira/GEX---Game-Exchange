<?php

declare(strict_types=1);
require_once('Database/connect.db.php');
require_once('Database/games.db.php');
require_once('Interface/generic.int.php');
require_once('Interface/games.int.php');
require_once('Interface/admin.int.php');

session_set_cookie_params(0, '/', 'localhost', true, true);
session_start();

   $db = database_connect();
   $search_id = $_GET['id'];
   $items = get_item_by_id($db, $search_id);
   $userlogin;
   if(isset($_SESSION['Username'])){
      $stmt = $db->prepare('SELECT * FROM USER WHERE USER.UserName = ? ');
      $stmt->execute(array($_SESSION['Username']));
      $userlogin = $stmt->fetchAll()[0];
   }
   
   draw_header('Item Page');
   
   if($items[0]['sold'] == 1){
      draw_purchased_item($items);
      draw_footer();
   }
   else{
      draw_item($items);
      if(isset($_SESSION['Username'])) if ($userlogin['Admin']===1) draw_admin_remove_item($items);
      draw_footer();
   }
   
?>

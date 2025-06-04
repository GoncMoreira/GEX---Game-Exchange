<?php

declare(strict_types=1);
require_once('Database/connect.db.php');
require_once('Interface/generic.int.php');
require_once('Interface/profile.int.php');
require_once('Interface/admin.int.php');

session_set_cookie_params(0, '/', 'localhost', true, true);
session_start();

   $db = database_connect();
   $search_un = $_GET['Username'];
   $stmt = $db->prepare('SELECT * FROM USER WHERE USER.UserName = ? ');
   $stmt->execute(array($search_un));
   $user = $stmt->fetchAll()[0];

   $stmt = $db->prepare('SELECT * FROM USER WHERE USER.UserName = ? ');
   $stmt->execute(array($_SESSION['Username']));
   $userlogin = $stmt->fetchAll()[0];

   draw_header('Profile Page');
   if ($search_un===$_SESSION['Username']){
      
      draw_own_profile($user);
      if ($userlogin['Admin']===1) draw_admin_page_button();
   }
   else if ($user !== null){
      
      draw_profile($user);
      if ($userlogin['Admin']===1){
         ?> <aside id= "admin_panel">
         <?php
         if ($user['Admin']===0 && $user['Blocked']===0) draw_admin_promote_user($user);
         else if ($user['Admin']===1) draw_admin_demote_user($user);
         if ($user['Blocked']===0) draw_admin_block_user($user);
         else if ($user['Blocked']===1) draw_admin_unblock_user($user);
         draw_admin_delete_user($user);
         ?> </aside> 
      <?php
      } 
   }
   draw_footer();
?>
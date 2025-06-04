<?php

  declare(strict_types=1);
  require_once(__DIR__.'/../Database/connect.db.php');
  

  function get_items_being_sold_by_user(PDO $db, string $username): array{
    $stmt = $db->prepare('SELECT *
                    FROM PRODUCT JOIN USER USING (UserName) WHERE USER.UserName = ?');
    $stmt->execute(array($username));
    $items = $stmt->fetchAll();
    return $items;
  }

  function search_items_by_name(PDO $db, string $name) : array{
    
    $stmt = $db->prepare('SELECT *
                    FROM PRODUCT JOIN USER USING (UserName) WHERE PRODUCT.ProductName LIKE "%'.$name.'%"');
    $stmt->execute();
    $items = $stmt->fetchAll();
    return $items;
  }

  function search_items_by_name_user_restriction(PDO $db, string $name, string $user_name) : array{
    
    $stmt = $db->prepare('SELECT *
                    FROM PRODUCT JOIN USER USING (UserName) WHERE PRODUCT.UserName != ? AND PRODUCT.ProductName LIKE "%'.$name.'%"');
    $stmt->execute(array($user_name));
    $items = $stmt->fetchAll();
    return $items;
  }

  function get_all_items(PDO $db) : array{
    $stmt = $db->prepare('SELECT * FROM PRODUCT JOIN USER USING (UserName)');
    $stmt->execute();
    $items = $stmt->fetchAll();
    return $items; 
  }

  function get_item_by_id(PDO $db, string $id) : array{
    $stmt = $db->prepare('SELECT * FROM PRODUCT JOIN DEVICE USING (DEVICEId) JOIN PRODUCT_GENRE USING (PRODUCTId) JOIN GENRE USING (GENREName) WHERE PRODUCT.PRODUCTId = ?');
    $stmt->execute(array($id));
    $items = $stmt->fetchAll();
    return $items; 
  }

  
  function get_all_items_except_current_user(PDO $db, string $user_name): array{
    $stmt = $db->prepare('SELECT * FROM PRODUCT WHERE PRODUCT.UserName != ? ');
    $stmt->execute(array($user_name));
    $items = $stmt->fetchAll();
    return $items; 
  }

  // SHOPPING CART
  function get_all_items_shopping_cart(PDO $db, string $user_name) : array{
    $stmt = $db->prepare('SELECT * FROM SHOPPINGCART JOIN PRODUCT USING (PRODUCTId) WHERE SHOPPINGCART.UserName = ? ');
    $stmt->execute(array($user_name));
    $items = $stmt->fetchAll();
    return $items; 
  }

  // PUT IN SHOPPING CART

  function check_item_in_user_shopping_cart(PDO $db, string $product_id, string $user_name): array{
    $stmt = $db->prepare('SELECT * FROM SHOPPINGCART WHERE SHOPPINGCART.PRODUCTId = ? AND SHOPPINGCART.UserName = ? ');
    $stmt->execute(array($product_id, $user_name));
    $items = $stmt->fetchAll();
    return $items; 
  }
   // Function to add the product to the cart
  function addToUserShoppinCart(PDO $db, string $product_id, string $user_name){
    $product_in_cart =  check_item_in_user_shopping_cart( $db, $product_id, $user_name);
    if (!empty($product_in_cart)){
      return;
    }
    else {
      $stmt = $db->prepare('INSERT INTO SHOPPINGCART VALUES (?, ?)');
      $stmt->execute(array( $product_id, $user_name));
    }
  }

  // REMOVE FROM SHOPPING CART
  function removefromUserShoppinCart(PDO $db, string $product_id, string $user_name){
    $product_in_cart =  check_item_in_user_shopping_cart( $db, $product_id, $user_name);
    if (!empty($product_in_cart)){
      $stmt = $db->prepare('DELETE FROM SHOPPINGCART WHERE  SHOPPINGCART.PRODUCTId = ? AND SHOPPINGCART.UserName = ?');
      $stmt->execute(array( $product_id, $user_name));
    }
    else {
      return;
    }
  }


  // WISHLIST

  function get_all_items_wish_list(PDO $db, string $user_name) : array{
    $stmt = $db->prepare('SELECT * FROM WISHLIST JOIN PRODUCT USING (PRODUCTId) WHERE WISHLIST.UserName = ? ');
    $stmt->execute(array($user_name));
    $items = $stmt->fetchAll();
    return $items; 
  }

  // PUT IN WISHLIST

  function check_item_in_user_wishList(PDO $db, string $product_id, string $user_name): array{
    $stmt = $db->prepare('SELECT * FROM WISHLIST WHERE WISHLIST.PRODUCTId = ? AND WISHLIST.UserName = ? ');
    $stmt->execute(array($product_id, $user_name));
    $items = $stmt->fetchAll();
    return $items; 
  }

  function addToUserWishList(PDO $db, string $product_id, string $user_name){
    $product_in_wishList =  check_item_in_user_wishList( $db, $product_id, $user_name);
    if (!empty($product_in_wishList)){
      echo 'Item already in WishList!';
      return;
    }
    else {
      $stmt = $db->prepare('INSERT INTO WISHLIST VALUES (?, ?)');
      $stmt->execute(array( $product_id, $user_name));
      echo 'Item added to WishList!';
    }
  }


   // REMOVE FROM SHOPPING CART
   function removefromUserWishList(PDO $db, string $product_id, string $user_name){
    $product_in_wish_list =  check_item_in_user_wishList( $db, $product_id, $user_name);
    if (!empty($product_in_wish_list)){
      $stmt = $db->prepare('DELETE FROM WISHLIST WHERE  WISHLIST.PRODUCTId = ? AND WISHLIST.UserName = ?');
      $stmt->execute(array( $product_id, $user_name));
      
    }
    else {
      return;
    }
  }


  function get_all_genres(PDO $db): array{
    $stmt = $db->prepare('SELECT GENREName
                    FROM GENRE');
    $stmt->execute();
    $items = $stmt->fetchAll();
    return $items;
  }

  function get_all_devices(PDO $db): array{
    $stmt = $db->prepare('SELECT DEVICEName FROM DEVICE');
    $stmt->execute();
    $items = $stmt->fetchAll();
    return $items;
  }

  function search_by_genre(PDO $db, String $genre): array {
    $stmt = $db->prepare('SELECT DISTINCT * FROM PRODUCT JOIN PRODUCT_GENRE USING (PRODUCTId) JOIN GENRE USING (GENREName) WHERE GENREName = ? GROUP BY GENRE.GENREName, PRODUCT.PRODUCTId ');
    $stmt->execute(array ($genre));
    $items = $stmt->fetchAll();
    return $items;
  }
  function search_filter (PDO $db, array $genre, array $device, int $price, array $developer): array {
    $genre_filter = false;
    $device_filter = false;
    if (!empty($genre)){
      deleteView($db, 'GENREVIEW');
      get_genre_view($db, $genre);
      $genre_filter=true;
    }

    if (!empty($device)){
      deleteView($db, 'DEVICEVIEW');
      get_device_view($db, $device);
      $device_filter = true;

    }

    if ($genre_filter && $device_filter){
      $stmt = $db->prepare('SELECT * FROM PRODUCT JOIN USER USING (UserName) JOIN PRODUCT_GENRE USING(PRODUCTId) JOIN GENRE USING(GENREName) JOIN DEVICE USING (DEVICEId) JOIN GENREVIEW USING(GENREName) JOIN DEVICEVIEW USING(DEVICEName) WHERE PRODUCT.Price < ?');
      $stmt->execute(array($price));
      $items = $stmt->fetchAll();
      return $items;
    }
    if ($genre_filter){
      $stmt = $db->prepare('SELECT * FROM PRODUCT JOIN USER USING (UserName) JOIN PRODUCT_GENRE USING(PRODUCTId) JOIN GENRE USING(GENREName) JOIN GENREVIEW USING(GENREName) WHERE PRODUCT.Price < ?');
      $stmt->execute(array($price));
      $items = $stmt->fetchAll();
      return $items;
    }
    if ($device_filter){
      $stmt = $db->prepare('SELECT * FROM PRODUCT  JOIN USER USING (UserName) JOIN DEVICE USING (DEVICEId) JOIN DEVICEVIEW USING(DEVICEName) WHERE PRODUCT.Price < ?');
      $stmt->execute(array($price));
      $items = $stmt->fetchAll();
      return $items;
    }
    $stmt = $db->prepare('SELECT * FROM PRODUCT JOIN USER USING (UserName) WHERE PRODUCT.Price < ?');
      $stmt->execute(array($price));
      $items = $stmt->fetchAll();
      return $items;
    
  
  }
  
  function get_genre_view(PDO $db, array $genres) {
    $genres = array_map('trim', $genres);
    $viewName = 'GENREVIEW';

    // Construct the SQL query to create the view
    $sql = "CREATE VIEW $viewName AS SELECT '".implode("' AS GENREName UNION ALL SELECT '", $genres)."' AS GENREName";
    
    try {
        $db->exec($sql);
    } catch (Exception $e) {
        echo "Error:  unable to create view: " . $e->getMessage();
    }

  }
  function get_device_view(PDO $db, array $devices){
    $devices = array_map('trim', $devices);
    $viewName = 'DEVICEVIEW';

    // Construct the SQL query to create the view
    $sql = "CREATE VIEW $viewName AS SELECT '".implode("' AS DEVICEName UNION ALL SELECT '", $devices)."' AS DEVICEName";
    
    try {
        $db->exec($sql);
    } catch (Exception $e) {
        echo "Error:  unable to create view: " . $e->getMessage();
    }
  }

  function deleteView(PDO $db, string $viewName): bool {
    // Construct the SQL query to drop the view
    $sql = "DROP VIEW IF EXISTS $viewName";

    // Execute the SQL query
    try {
        $db->exec($sql);
        echo "View deleted successfully.";
        return true;
    } catch (Exception $e) {
        echo "Error deleting view: " . $e->getMessage();
        return false;
    }
}





?>

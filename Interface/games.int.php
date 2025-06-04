<?php

declare(strict_types=1);
require_once('Interface/generic.int.php');
require_once('Database/games.db.php');
require_once('Database/connect.db.php');



?>
<?php
    function draw_all_games(array $items){ ?>
        <main>
            <?php
               
                foreach($items as $item){
                    if($item['sold'] == 0){
                        $db = database_connect();
                        $stmt = $db->prepare('SELECT IMAGESId FROM PRODUCT_IMAGE WHERE PRODUCTId = ?');
                        $stmt->execute(array($item['PRODUCTId']));
                        $imgid = $stmt->fetch();

                        $stmt = $db->prepare('SELECT * FROM IMAGES WHERE IMAGESId = ?');
                        $stmt->execute(array($imgid['IMAGESId']));
                        $img = $stmt->fetch();

                    ?>
                <div class="item">
                            <a href="item.php?id=<?=$item['PRODUCTId']?>"><img src="<?php echo $img['LINK'];?>" width="100" height="100"></a>
                            <span class = "game_name"><?=$item['ProductName'] ?></span>
                            <span class = "seller"><a href="profile.php?Username=<?=$item['UserName']?>"><span><?=$item['UserName'] ?></span></a></span>
                            <span class = "price"><?=$item['Price'] ?>€ </span>
                            <?php if(isset($_SESSION['Username'])) { ?>
                                <button id="buy" value="<?= $item['PRODUCTId'] ?>"> 
                                    Add to Cart
                                </button>
                                <button id="favourite" value="<?= $item['PRODUCTId'] ?>"> 
                                &#10084;
                                </button>
                                
                           <?php } ?>
                </div>
            <?php } 
        } ?>
        </main>
<?php
    }
?>

<?php
    function draw_games_being_sold(array $items_sold){
        $items_in_sale = array();
        $i1 = 0;
        $i2 = 0;
        $items_already_sold = array();
        foreach($items_sold as $i){
            if($i['sold'] == 0){
                $items_in_sale[$i1] = $i;
                $i1++;
            }
            else{
                $items_already_sold[$i2] = $i;
                $i2++;
            }
        }
    ?>
        <main id = "items_being_sold">
            <section class="items_of_user items_selling">
                <h1>Items being sold</h1>
            <?php
                if (sizeof($items_in_sale) <= 0){ ?> 
                    <p id = "no_items_being_sold"> No items being sold!</p>
                <?php
                }
                else {
                    foreach( $items_in_sale as $item_sold){
                        $db = database_connect();
                        $stmt = $db->prepare('SELECT IMAGESId FROM PRODUCT_IMAGE WHERE PRODUCTId = ?');
                        $stmt->execute(array($item_sold['PRODUCTId']));
                        $imgid = $stmt->fetch();

                        $stmt = $db->prepare('SELECT * FROM IMAGES WHERE IMAGESId = ?');
                        $stmt->execute(array($imgid['IMAGESId']));
                        $img = $stmt->fetch(); ?>
                        <div class="item">
                            <a href="item.php?id=<?=$item_sold['PRODUCTId']?>"><img src="<?php echo $img['LINK'];?>" width="100" height="100"></a>
                            <span class = "game_name"><?=$item_sold['ProductName'] ?></span>
                            <a href="profile.php?Username=<?=$item_sold['UserName']?>"><span class="seller"><?=$item_sold['UserName'] ?></span></a>
                            <span class = "price"><?=$item_sold['Price'] ?>€ </span>
                            <form class="additem" action="Action/process_delete_item.php" method="post">
                                <button id="deletion_button" class="additem" name="ProductId" value="<?php echo $item_sold['PRODUCTId']; ?>" onclick="return confirm('Are you sure you want to delete this game?')" type="submit">
                                    Delete game
                                </button>
                            </form>
                        </div>
                <?php
                    }
                } ?>
            <br>
            <br>
            <br>
            </section>
        <section class="additem">
            <form class="additem">
               <button class="additem" formaction="sell_item.php" type="submit">
                  Sell another game
               </button>
            </form>
        </section>
        <section class="items_of_user items_sold">
                <h1>Items already sold</h1>
            <?php
                if (sizeof($items_already_sold) <= 0){ ?> 
                    <p> No items already sold!</p>
                <?php
                }
                else {
                    foreach( $items_already_sold as $item_sold){ 
                        $db = database_connect();
                        $stmt = $db->prepare('SELECT IMAGESId FROM PRODUCT_IMAGE WHERE PRODUCTId = ?');
                        $stmt->execute(array($item_sold['PRODUCTId']));
                        $imgid = $stmt->fetch();

                        $stmt = $db->prepare('SELECT * FROM IMAGES WHERE IMAGESId = ?');
                        $stmt->execute(array($imgid['IMAGESId']));
                        $img = $stmt->fetch();
                        ?>
                        <div class="item">
                            <a href="item.php?id=<?=$item_sold['PRODUCTId']?>"><img src="<?php echo $img['LINK'];?>" width="100" height="100"></a>
                            <span class = "game_name"><?=$item_sold['ProductName'] ?></span>
                            <span class="seller"><?=$item_sold['UserName'] ?></span>
                            <span class = "price"><?=$item_sold['Price'] ?>€ </span>
                        </div>
                <?php
                    }
                } ?>
            </section>
        </main>
    

<?php    
    }
?>

<?php 
    function draw_search_items( array $matching_items){ ?>
        <main>
            <?php
        
                if (sizeof($matching_items) <= 0){
                    ?>
                    <p>No matching items found! </p>
                <?php
                }
                else {
                    foreach( $matching_items as $matching_item){
                        $db = database_connect();
                        $stmt = $db->prepare('SELECT IMAGESId FROM PRODUCT_IMAGE WHERE PRODUCTId = ?');
                        $stmt->execute(array($matching_item['PRODUCTId']));
                        $imgid = $stmt->fetch();

                        $stmt = $db->prepare('SELECT * FROM IMAGES WHERE IMAGESId = ?');
                        $stmt->execute(array($imgid['IMAGESId']));
                        $img = $stmt->fetch();
                        if ($matching_item['sold'] == 0){
                    ?>
                        <div class="item">
                                    <a href="item.php?id=<?=$matching_item['PRODUCTId']?>"><img src="<?php echo $img['LINK'];?>" width="100" height="100"></a>
                                    <span class = "game_name"><?=$matching_item['ProductName'] ?></span>
                                    <span class="seller"> <a href="profile.php?Username=<?=$matching_item['UserName']?>"> seller: <?=$matching_item['UserName'] ?> </a> </span>
                                    <span class = "price"><?=$matching_item['Price'] ?> €</span>
                                    <?php if(isset($_SESSION['Username'])) { ?>
                                        <button id="buy" value="<?= $matching_item['PRODUCTId'] ?>"> 
                                            Add to Cart
                                        </button>
                                        <button id="favourite" value="<?= $matching_item['PRODUCTId'] ?>"> 
                                            &#10084;
                                        </button>
                                        
                                    <?php } ?>
                        </div>
                    <?php 
                        }
                    }
                } ?>
        </main>
        
<?php    
    }
?>

<?php

function draw_item(array $items){
    $db = database_connect();
    $stmt = $db->prepare('SELECT IMAGESId FROM PRODUCT_IMAGE WHERE PRODUCTId = ?');
    $stmt->execute(array($items[0]['PRODUCTId']));
    $imgid = $stmt->fetch();

    $stmt = $db->prepare('SELECT * FROM IMAGES WHERE IMAGESId = ?');
    $stmt->execute(array($imgid['IMAGESId']));
    $img = $stmt->fetch();?>
        <main id= "item_page">
         <section class="item">
            <h1 class="item"> <?=$items[0]['ProductName'] ?> </h1>
            <img class="item" id="cover" alt="cover" src="<?php echo $img['LINK'];?>" width="100" height="100">
            <h2 class="item"> <?=$items[0]['Price'] ?>€ </h2>
            <h3 class="item"> <?=$items[0]['Developer'] ?> </h3>
            <a href="profile.php?Username=<?=$items[0]['UserName']?>"><h4 class="item"> <?=$items[0]['UserName'] ?> </h4></a>
         </section>
         <section class="item">
            <h3 class="item"> Game Description </h3>
            <p class="item">  
                <?=htmlspecialchars($items[0]['Description']) ?>
            </p>
         </section>
         <section class="item">
            <h5 class="item">GENRES</h5>
            <?php
                $unique_genres = array();
                foreach($items as $item){
                    if (in_array($item['GENREName'], $unique_genres)) continue;
                    else $unique_genres[] = $item['GENREName'];?>
                    <ul class="item">
                        <li class="item"><?=$item['GENREName'] ?></li>
                    </ul>
            <?php } ?>
         </section>
         <section class="item">
            <h5 class="item">DEVICES</h5>
            <?php 
                $unique_devices = array();
                foreach($items as $item){
                    if (in_array($item['DEVICEName'], $unique_devices)) continue;
                    else $unique_devices[] = $item['DEVICEName'];?>
                    <ul class="item">
                        <li class="item"><?=$item['DEVICEName'] ?></li>
                    </ul>
            <?php } ?>
         </section>
         <?php
         if($items[0]['sold'] == 0){
         session_set_cookie_params(0, '/', 'localhost', true, true);
         session_start();
         if (isset($_SESSION['Username'])) { 
            if($_SESSION['Username'] !== $items[0]['UserName']){?>
            <section class="itembuy">
                <button id="buy" value="<?= $items[0]['PRODUCTId'] ?>"> 
                    Add to Cart
                </button>
            </section>
            <section class = "itemwish">
                <button id="favourite" value="<?= $items[0]['PRODUCTId'] ?>"> 
                    &#10084;
                </button>
            </section><?php
            }
         }
        
         } ?>
      </main>

<?php } ?>


<?php


function draw_ShoppingCart(array $items){ 
    $total_price = 0;
    ?>
    <main id = "shoppingCart">
            <?php 
                if (empty($items)){ ?>
                <h3 class = "emptyCart"> Your shopping cart is empty! </h3>
                <img class = "emptyCart" src="../Data/images/shoppingCart.png" width="50" height="50">
            <?php }
                else {
                    foreach( $items as $item) {
                        $db = database_connect();
                        $stmt = $db->prepare('SELECT IMAGESId FROM PRODUCT_IMAGE WHERE PRODUCTId = ?');
                        $stmt->execute(array($item['PRODUCTId']));
                        $imgid = $stmt->fetch();

                        $stmt = $db->prepare('SELECT * FROM IMAGES WHERE IMAGESId = ?');
                        $stmt->execute(array($imgid['IMAGESId']));
                        $img = $stmt->fetch();
                        $total_price += $item['Price'];
                        ?>
                        <section class="cart">
                            <img class="item" id="cover" alt="cover" src="<?php echo $img['LINK'];?>" width="100" height="100">

                            <h2 class="item" id="name"> <?=$item['ProductName']?> </h2>
                            <h2 class="item" id="price">price: <?=$item['Price']?>€ </h2>
                            <h2 class="item" id = "dev">developer: <?=$item['Developer'] ?> </h2>
                            <h2 class="item" id = "seller"> <a href="profile.php?Username=<?=$item['UserName']?>"> seller: <?=$item['UserName'] ?> </a> </h2>

                            <!--<button class="remove"> X </button> -->
                            <button id="remove" value="<?= $item['PRODUCTId'] ?>"> X </button>
                        </section>
                        
                    <?php 
                    }?>
                    <div id ="total_price">
                        <h1>Total:</h1>
                        <h2 id="total"><?php echo $total_price?>€</h2>
                    </div>
                    <form class="buyitem">
                        <button class="buyitem" id="purchase_button" formaction="buy_item.php" type="submit">
                            PURCHASE
                        </button>
                    </form>
                    <?php
                } ?>
         
    </main>
    

<?php } ?>



<?php


function draw_WishList(array $items){ ?>
    <main id = "wishList">
            <?php 
                if (empty($items)){ ?>
                <h3 class = "emptyWishList"> Your wishList is empty! </h3>
            <?php }
                else {
                    foreach( $items as $item) { 
                        $db = database_connect();
                        $stmt = $db->prepare('SELECT IMAGESId FROM PRODUCT_IMAGE WHERE PRODUCTId = ?');
                        $stmt->execute(array($item['PRODUCTId']));
                        $imgid = $stmt->fetch();

                        $stmt = $db->prepare('SELECT * FROM IMAGES WHERE IMAGESId = ?');
                        $stmt->execute(array($imgid['IMAGESId']));
                        $img = $stmt->fetch();
                        ?>
                        <section class="wish_item">
                            <img class="item" id="cover" alt="cover" src="<?php echo $img['LINK'];?>" width="100" height="100">

                            <h2 class="item" id="name"> <?=$item['ProductName']?> </h2>
                            <h2 class="item" id="price">price: <?=$item['Price']?>€ </h2>
                            <h2 class="item" id = "dev">developer: <?=$item['Developer'] ?> </h2>
                            <h2 class="item" id = "seller"> <a href="profile.php?Username=<?=$item['UserName']?>"> seller: <?=$item['UserName'] ?> </a> </h2>

                            <!--<button class="remove"> X </button> -->
                            <button id="remove" value="<?= $item['PRODUCTId'] ?>"> X </button>
                        </section>
                    <?php 
                    } 
                } ?>
         
    </main>
    

<?php } ?>

<?php
function draw_purchased_item(array $items){
    $db = database_connect();

    $stmt = $db->prepare('SELECT * FROM TRANSACTIONS WHERE PRODUCTId = ?');
    $stmt->execute(array($items[0]['PRODUCTId']));
    $transaction = $stmt->fetch();

    $stmt = $db->prepare('SELECT * FROM USER WHERE UserName = ?');
    $stmt->execute(array($items[0]['UserName']));
    $seller = $stmt->fetch();

    $stmt = $db->prepare('SELECT * FROM USER WHERE UserName = ?');
    $stmt->execute(array($transaction['UserName']));
    $buyer = $stmt->fetch();

    ?>
    <aside id="purchased_item_page">
    <section class="profile">
        <img class="profile" id="profile_img" alt="profile_img" src="https://play-lh.googleusercontent.com/Fro4e_osoDhhrjgiZ_Y2C5FNXBMWvrb4rGpmkM1PDAcUPXeiAlPCq7NeaT4Q6NRUxRqo=w240-h480-rw"  width="100" height="100">
    </section>
    <section>
    <table border="1">
        <tr>
            <th>Original Owner</th>
            <th>Sold to</th>
        </tr>
        <tr>
            <td><?php echo $seller['Email']; ?></td>
            <td><?php echo $buyer['Email']; ?></td>
        </tr>
        <tr>
            <td><?php echo $seller['UserName']; ?></td>
            <td><?php echo $buyer['UserName']; ?></td>
        </tr>
</table>

    <h1>Address Sent to:</h1><br>
    <p><?php echo $transaction['Address']; ?></p>
    </section>
</aside>
<?php
    draw_item($items);
} ?>

<?php
function draw_purchased_items(array $users){
    $user = $users[0];
    $db = database_connect();
    $stmt = $db->prepare('SELECT TRANSACTIONSId FROM TRANSACTIONS WHERE UserName = ?');
    $stmt->execute(array($user['UserName']));
    
    $transactions = $stmt->fetchAll();
    ?>
    <main>
        <?php
    if(! $transactions){
        ?>
        <h3 class = "emptyCart"> You haven't made a purchase yet! </h3>
    <?php
    }
    else{
        $tra = array();
        $index = 0;
        foreach($transactions as $t){
            if(! in_array($t['TRANSACTIONSId'], $tra)){
                $tra[$index] = $t['TRANSACTIONSId'];
                $index++;
            }
        }
        //$transactions = array_unique($transactions);
        foreach($tra as $p){
            $stmt = $db->prepare('SELECT * FROM TRANSACTIONS WHERE TRANSACTIONSId = ?');
            $stmt->execute(array($p));
            $purchase = $stmt->fetchAll();
            $total = 0;
            ?>
            <section class="past_purchase">
                <?php 
                foreach($purchase as $pur){
                    $stmt = $db->prepare('SELECT * FROM PRODUCT WHERE PRODUCTId = ?');
                    $stmt->execute(array($pur["PRODUCTId"]));
                    $product = $stmt->fetch();
                    $total += $product['Price'];
                    ?>
                    <p><?php echo $product['UserName'];?></p>
                    <p><?php echo $product['ProductName'];?> : <?php echo $product['Price'];?> €</p>
                    <?php
                }
                ?>
                <p><?php echo $purchase[0]['Address'];?></p>
                <h1>Total: <?php echo $total?> €</h1>
            </section>
            <?php

        }
    }
    ?>
    </main>
    
    <?php

}?>


<?php
    function draw_set_of_items_except_current_user(array $items, string $current_username){ ?>
        <main>
                <?php
                
                    foreach($items as $item){
                        if($item['sold'] == 0 && $item['UserName'] != $current_username){
                            $db = database_connect();
                            $stmt = $db->prepare('SELECT IMAGESId FROM PRODUCT_IMAGE WHERE PRODUCTId = ?');
                            $stmt->execute(array($item['PRODUCTId']));
                            $imgid = $stmt->fetch();

                            $stmt = $db->prepare('SELECT * FROM IMAGES WHERE IMAGESId = ?');
                            $stmt->execute(array($imgid['IMAGESId']));
                            $img = $stmt->fetch();

                        ?>
                    <div class="item">
                                <a href="item.php?id=<?=$item['PRODUCTId']?>"><img src="<?php echo $img['LINK'];?>" width="100" height="100"></a>
                                <span class = "game_name"><?=$item['ProductName'] ?></span>
                                <span class="seller"><?=$item['UserName'] ?></span>
                                <span class = "price"><?=$item['Price'] ?>€ </span>
                                <?php if(isset($_SESSION['Username'])) { ?>
                                    <button id="buy" value="<?= $item['PRODUCTId'] ?>"> 
                                        Add to Cart
                                    </button>
                                    <button id="favourite" value="<?= $item['PRODUCTId'] ?>"> 
                                    &#10084;
                                    </button>
                                    
                            <?php } ?>
                    </div>
                <?php } 
            } ?>
            </main>
        
<?php
}
?>
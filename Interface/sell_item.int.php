<?php
require_once('Database/connect.db.php');

function draw_add_item_to_sale(){
    $db = database_connect();
    $stmt = $db->prepare('SELECT * FROM DEVICE');
    $stmt->execute();
    $devices = $stmt->fetchAll();

    $stmt = $db->prepare('SELECT * FROM GENRE');
    $stmt->execute();
    $genres = $stmt->fetchAll();
?>
    <main>
    <section class="addItem">
            <h1>Welcome!</h1>
            <h3>Write the information about your game</h3>
            <form action="Action/process_add_item.php" method="POST"  enctype="multipart/form-data">
                <div>
                    <label>Game Name</label><br>
                    <input type="text" name="Name"><br>
                </div>
                <div>
                    <label>Price</label><br>
                    <input type="number" name="Price"><br>
                </div>
                <div>
                    <label>Developer</label><br>
                    <input type="text" name="Developer"><br>
                </div>
                <div>
                    <label>Genre</label><br>
                    <?php
                    foreach($genres as $genre){ ?>
                    <input type="checkbox" id="<?php echo $genre['GENREName'];?>" name='Genres[]' value="<?php echo $genre['GENREName'];?>">
                    <label for="<?php echo $genre['GENREName'];?>"><?php echo $genre['GENREName'];?></label><br>
                    <?php
                    }
                    ?>
                </div>
                <div>
                    <label>Device</label><br>
                    <select name="Device">
                    <?php
                    foreach($devices as $device){
                        ?>
                        <option value="<?php echo $device['DEVICEId']?>"><?php echo $device['DEVICEName']?></option>
                        <?php
                    }
                    ?>
                    <select>
                </div>
                <div>
                    <label>Description</label><br>
                    <input type="text" name="Description"><br>
                </div>
                <div>
                    <label>Image</label><br>
                    <input type="file" name="image">
                </div>
                    <button type="submit">Sell Game</button>
            </form>
        </section>
</main>

<?php 

}

?>

<?php
require_once('Database/connect.db.php');

session_set_cookie_params(0, '/', 'localhost', true, true);
session_start();

function draw_buy_items(){
    $db = database_connect();
    $stmt = $db->prepare('SELECT * FROM PRODUCT AS P JOIN SHOPPINGCART AS S ON (P.PRODUCTId = S.PRODUCTId) WHERE S.UserName == ?');
    $stmt->execute(array($_SESSION['Username']));

    $items = $stmt->fetchAll();
    $total = 0;
    ?>
    <main id= "buy_items_page">
    <section class="purchase" >
    <?php
        foreach($items as $item){
            $stmt = $db->prepare('SELECT IMAGESId FROM PRODUCT_IMAGE WHERE PRODUCTId = ?');
                        $stmt->execute(array($item['PRODUCTId']));
                        $imgid = $stmt->fetch();
                        $stmt = $db->prepare('SELECT * FROM IMAGES WHERE IMAGESId = ?');
                        $stmt->execute(array($imgid['IMAGESId']));
                        $img = $stmt->fetch(); 
            $total += $item['Price'];
        ?>
        <div class = "item">
            <img src="<?php echo $img['LINK'];?>" width="100" height="100">
            <span class = "game_name"> <?=$item['ProductName']?></span>
            <span class = "seller"> <?=$item[5] ?> </span>
            <span class = "price"> <?=$item['Price']?>€</span>
        </div>
        <?php
        }
        ?>
    </section>
    <div>
        <h1>Total:</h1><h2><?php echo $total ?>€</h2>
    </div>
    <form action="Action/process_purchase.php" method="POST">
        <label for="address">Please insert the address</label><input id="address" type="text" name="address"><br>
        <label for="email">Insert your email:</label><input id="email" type="email" name="email"><br>
        <label for="password">Insert your password:</label><input id="password" type="password" name="password"><br>
        <button type="submit" id="purchase_button">Purchase</button>
    </form>
</main>
<?php }

?>

<?php


function draw_ShippingForm(array $items){

$db = database_connect();
    $address = $items[0]['Address'];
    $total = 0;
    ?>
<html>
    <head>
        <title>Shipping Form</title>
        <meta charset="UTF-8">
        <link href="Css/style.css" rel="stylesheet">
        <link href="Css/layout.css" rel="stylesheet">
    </head>
    <body>
    <main id="main_shipping">
        <div class="div_shipping">
            <a href="mainPage.php"><img id="logo_shipping" src="../Data/images/logo.png" height="150px"></a>
            <h3>The games are being shipped to your address!</h3>
        </div>
        <section>
            <?php 
            foreach($items as $item){
                $stmt = $db->prepare('SELECT * FROM PRODUCT WHERE PRODUCTId = ?');
                $stmt->execute(array($item['PRODUCTId']));
                $game = $stmt->fetch();

                $total += $game['Price'];
                $stmt = $db->prepare('SELECT IMAGESId FROM PRODUCT_IMAGE WHERE PRODUCTId = ?');
                $stmt->execute(array($item['PRODUCTId']));
                $imgid = $stmt->fetch();

                $stmt = $db->prepare('SELECT * FROM IMAGES WHERE IMAGESId = ?');
                $stmt->execute(array($imgid['IMAGESId']));
                $img = $stmt->fetch();

                $stmt = $db->prepare('SELECT * FROM USER WHERE UserName = ?');
                $stmt->execute(array($game['UserName']));
                $user = $stmt->fetch();
                ?>
                <div class="item_shipping">
                    <img src="<?php echo $img['LINK'];?>" height="300px">
                    <div>
                    <span><?php echo $user['UserName'];?></span>
                    <span><?php echo $user['Email'];?></span>
                    </div>
                </div>
                <?php
            }?>
            
            <div>
                <span><p>This items were shipped to the location:</p></span>
                <h4><?php echo $address;?></h4>
                <span><p>The Total was: <?php echo $total?> €</p></span>
                <p>Payment method: direct debit</p>
                <p>Date: <?php $datetime = new DateTime('now', new DateTimeZone('+0100'));
                                $current_time = $datetime->format('Y-m-d H:i:s');
                                echo $current_time; ?>
                </p>
        </div>
        </section>
        <h1>Thank you for using our WebSite!!</h1>
        <button id="button_shipping" onclick="window.print()">Print this page</button>
    </main>
    <body>
<html>
    <?php
}
?>
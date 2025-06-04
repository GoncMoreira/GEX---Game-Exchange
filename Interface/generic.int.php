<?php
declare(strict_types=1);


?>

<?php 

    function draw_header(string $title){ $show_menu = false; $show_search = true; ?>
        <!DOCTYPE html>

            <html > <!-- <html lang="en"> para pôr linguagem em ingles-->
                <head>
                    <title>
                        <?=$title?>
                    </title>
                    <meta charset="UTF-8">
                    <link href="Css/style.css" rel="stylesheet">
                    <link href="Css/layout.css" rel="stylesheet">
                    
                    <?php if( $title === "Item Page"){?>
                        <script src="Javascript/script.js" defer></script> 
                        <script src= "https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"> </script> 
                    <?php } ?>
                    <?php if ($title === "ShoppingCart Page"){ ?>
                        <script src="Javascript/script1.js" defer></script> 
                        <script src= "https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"> </script> 
                    <?php } ?>
                    <?php if ($title === "Main Page" || $title == "Search Page" || $title === "FilterResults Page"){  $show_menu = true?>
                        <script src="Javascript/script5.js" defer></script> 
                        <script src="Javascript/script2.js" defer></script> 
                        <script src= "https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"> </script> 
                    <?php } ?>
                    <?php if( $title === "WishList Page"){ ?>
                        <script src="Javascript/script3.js" defer></script> 
                        <script src= "https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"> </script> 
                    <?php } ?>
                    <?php if( $title === "Profile Page"){ ?>
                        <!--<script src="Javascript/script4.js" defer></script> --> 
                        <script src= "https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"> </script> 
                    <?php } ?>
                    <?php if( $title === "Register" || $title === "Login"){ $show_search = false;} ?>
                    

                </head>
                <>
                    <header>
                    <div class = "header_imgs">
                        <?php if ($show_menu){?>
                        <img id ="sidebar_logo" class="left_element" src="https://cdn.icon-icons.com/icons2/930/PNG/512/menu_icon-icons.com_72311.png"  width="50" height="50">
                        <?php } ?>
                        <a id= "main" href = "mainPage.php"> <img class="left_element" src = "../Data/images/logo.png" width="50" height="50"> </a> 
                    </div>
                    <?php if ($show_search){ ?> 
                        <div class = "search" >
                            <form id = "searchBar" action="Search.php" method="get">
                                <input type="search" name="search" placeholder="search for an item">
                                <input type="submit" value="Search">
                            </form>
                            <!-- 
                            <label> Search:</label>
                            <input type="search" name="search" placeholder="search for an item">
                            -->
                        </div>
                    <?php } ?>
                    <div class = "user_status" >
                    <?php 
                        
                        if (isset($_SESSION['Username'])) { ?>
                       
                        <a id = "username"  href="profile.php?Username=<?=$_SESSION['Username']?>">
                        <?= $_SESSION['Username'] ?></a> <span>|</span>
                        <a id = "logout" href="Action/process_logout.php">Logout</a>
                        
                    <?php } else { ?>
                        
                        <a id = "register"  href="Register.php">REGISTER</a> <span>|</span>
                        <a id = "login" href="Login.php">LOGIN</a>
                    
                    <?php } ?>
                    </div>

                    </header>
                    <?php if (isset($_SESSION["Error"])){ ?> <p id = "error"> <?php echo $_SESSION["Error"]; ?> </p>  <?php  unset($_SESSION["Error"]);}?>

                    
                    
    <?php                
    }
    ?>

<?php 


    function draw_footer() {
?>          </main>
            <footer>

                <?php if (isset($_SESSION['Username'])) { ?>
                    <div class = "footer_icons" id="left">
                    <a class = "left_element" href="ItemsBeingSold.php" > <img src="../Data/images/itemsBeingSold.png" width="50" height="50"></a>
                    <a class = "left_element" href="pastPurchases.php" > <img src="../Data/images/pastPurchases.png" width="50" height="50"></a>
                </div>
                    <div class ="footer_icons" id="right">

                    <a class = "right_element" id = "first_right_element" href="WishList.php"><img src="../Data/images/wishList.png" width="50" height="50"></a>
                    <a class = "right_element" href="ShoppingCart.php"><img src="../Data/images/shoppingCart.png" width="50" height="50"></a>
                    <a class = "right_element" href="Messages.php"><img src="../Data/images/messages.png" width="50" height="50"></a>

                </div>


                    <?php } else { ?>
                    <a href="Register.php"> Please REGISTER/LOGIN to access your shopping cart and whish list!</a>
                    
                <?php } ?>
                
            </footer>
            
        </body>
        
    </html>
    <?php
    }
    ?>

<?php
function draw_side_menu(array $genres, array $devices){
    ?>
    <aside id = "menu" class = "hidden">

        
        <div class = "genre_filter">
        <h1>Genres</h1>

            <?php foreach($genres as $genre){ ?>
                <div class = "genre_filter">
                    <span class = "unmarked">  <?=$genre['GENREName'] ?></span>
                    <input type="checkbox">
                </div>

            <?php } ?>
        </div>

        
        <div class ="device_filter">
            <h1>Devices</h1>

            <?php foreach($devices as $device){ ?>
                <div class = "device_filter" >
                    <span class = "unmarked">  <?=$device['DEVICEName'] ?></span>
                    <input type="checkbox">
                </div>

            <?php } ?>
        </div>

        
        <div class ="price_filter">
        <h1>Maximum price</h1>

            <?php $max_prices = [10,20,50] ?>
            
                <?php foreach($max_prices as $max_price){?>
                    <div class = "price_filter">
                        <span class = "price"> <?=$max_price ?></span>
                        <input type="checkbox">
                    </div>
                <?php } ?>
                
        </div>
        
        <button id = "submit">SUBMIT </button>
    </aside>

<?php
}
?>

<?php
declare(strict_types=1);

require_once('Interface/generic.int.php');
require_once('Interface/games.int.php');
require_once('Database/games.db.php');
require_once('Database/connect.db.php');



?>

<?php 
    function draw_admin_delete_user(array $user){
        ?>
        
        <form class="profile" action="Action/process_delete_user.php" method="post">
            <button id="deletion_button" class="profile" name="UserName" value="<?php echo $user['UserName']; ?>" onclick="return confirm('Are you sure you want to remove this user?')" type="submit">
                Remove user
            </button>
        </form>
      <?php
    }
?>

<?php 
    function draw_admin_promote_user(array $user){
        ?>
        <form class="profile" action="Action/process_promote_user.php" method="post">
            <button id="promotion_button" class="profile" name="UserName" value="<?php echo $user['UserName']; ?>" onclick="return confirm('Are you sure you want to promote this user to admin status?')" type="submit">
                Promote to admin
            </button>
        </form>
      <?php
    }
?>

<?php 
    function draw_admin_demote_user(array $user){
        ?>
        <form class="profile" action="Action/process_promote_user.php" method="post">
            <button id="demotion_button" class="profile" name="UserName" value="<?php echo $user['UserName']; ?>" onclick="return confirm('Are you sure you want to demote this user from admin status?')" type="submit">
                Demote user from admin
            </button>
        </form>
      <?php
    }
?>

<?php 
    function draw_admin_block_user(array $user){
        ?>
        
        <form class="profile" action="Action/process_block_user.php" method="post">
            <button id="block_button" class="profile" name="UserName" value="<?php echo $user['UserName']; ?>" onclick="return confirm('Are you sure you want to block this user from the platform?')" type="submit">
                Block User
            </button>
        </form>
      <?php
    }
?>

<?php 
    function draw_admin_unblock_user(array $user){
        ?>
        
        <form class="profile" action="Action/process_block_user.php" method="post">
            <button id="unblock_button" class="profile" name="UserName" value="<?php echo $user['UserName']; ?>" onclick="return confirm('Are you sure you want to unblock this user?')" type="submit">
                Unblock User
            </button>
        </form>
      <?php
    }
?>

<?php 
    function draw_blocked_users(array $users){
        ?><main id="admin_page"><?php
        if (sizeof($users) <= 0){
            ?>
            <section id="blocked_users">
            <h1>There are no blocked users </h1>
        <?php } 
        else {?>
        <section id="blocked_users">
        <h1>Blocked users </h1>
        
        <?php
            foreach($users as $user){ ?>
                <a href="profile.php?Username=<?=$user['UserName']?>"><?php echo $user['UserName'] ?></a><br>
            <?php 
            } ?> </section> <?php
        }
    }
?>

<?php 
    function draw_admin_page_button(){
        ?>
        <aside id = "admin_management">
        <a id = "button_admin_management" href="adminPage.php">
            <button>Admin management</button>
        </a>
        </aside>
      <?php
    }
?>

<?php 
    function draw_admin_add_category($devices, $genres){
        ?>
        <section id="admin_page_main">
        <h2>Existing Devices (<?php echo sizeof($devices)?>)</h2>
        <?php
            foreach($devices as $device){ ?>
                <p><?php echo $device['DEVICEName'] ?>
                <form action="Action/process_remove_device.php" method="post">
                    <button name="DEVICEId" value="<?php echo $device['DEVICEId']; ?>" onclick="return confirm('Are you sure you want to remove this device?')" type="submit">
                        X
                    </button>
                </form>
                </p>
            <?php 
            } ?> 
        <form action="Action/process_add_device.php" method="post">
            <input type="text" name="DEVICEName"><br>
            <button type="submit">
                Add device
            </button>
        </form>
        <br>
        <h2>Existing Genres (<?php echo sizeof($genres)?>)</h2>
        <?php
            foreach($genres as $genre){ ?>
                <p><?php echo $genre['GENREName'] ?>
                <form action="Action/process_remove_genre.php" method="post">
                    <button name="GENREName" value="<?php echo $genre['GENREName']; ?>" onclick="return confirm('Are you sure you want to remove this genre?')" type="submit">
                        X
                    </button>
                </form>
                </p>
            <?php 
            } ?> 
        <form action="Action/process_add_genre.php" method="post">
            <input type="text" name="GENREName"><br>
            <button type="submit">
                Add genre
            </button>
        </form>
        <br>
        </section>
        </main>
        
      <?php
    }
?>

<?php 
    function draw_admin_remove_item(array $items){
        ?>
        <br>
        <form class="item" action="Action/process_delete_item.php" method="post">
            <button id="item_deletion_button" class="profile" name="ProductId" value="<?php echo $items[0]['PRODUCTId']; ?>" onclick="return confirm('Are you sure you want to delete this item?')" type="submit">
                Delete item
            </button>
        </form>
      <?php
    }
?>
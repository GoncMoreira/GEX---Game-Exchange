<?php
declare(strict_types=1);

require_once('Interface/generic.int.php');
require_once('Database/games.db.php');
require_once('Database/connect.db.php');




?>

<?php 


    function draw_own_profile(array $user){
        ?>
        <main id="profile_page">
        <script src="Javascript/script4.js" defer></script> 
        <script src= "https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"> </script> 
        
        <form id="edition_form" action="Action/process_edit_profile.php" method="post">
            <section class="profile">
                <h2 class="profile">Informations</h2>
                <ul class="profile">
                    <li class="profile">
                        Username: <label class="profile"> <input type="text" name="UserName" value="<?php echo $user['UserName']; ?>" readonly>
                        <button type="button" class="edit_button" id="edit_UserName">
                            <i>Edit</i>
                        </button>
                        </label>
                    </li>
                    <li class="profile">
                        Email: <label class="profile"> <input type="text" name="Email" value="<?php echo $user['Email']; ?>" readonly>
                        <button type="button" class="edit_button" id="edit_Email">
                            <i>Edit</i>
                        </button>
                        </label>
                    </li>
                    <li class="profile">
                        Name: <label class="profile"> <input type="text" name="FullName" value="<?php echo $user['FullName']; ?>" readonly>
                        <button type="button" class="edit_button" id="edit_FullName">
                            <i>Edit</i>
                        </button>
                        </label>
                    </li>
                </ul>
                <button id="submit_edition" type="submit">Submit changes</button>
            </section>
        </form>
        
        <form class="profile" id = "deletion_form" action="Action/process_delete_user.php" method="post">
            <button id="deletion_button" class="profile" name="UserName" value="<?php echo $user['UserName']; ?>" onclick="return confirm('Are you sure you want to delete your account?')" type="submit">
                Delete your account
            </button>
        </form>
      </main>

      <?php

    }

?>


<?php 

    function draw_profile(array $user){
        ?>
        <main id="profile_page">
        
            <section class="profile">
                <h2 class="profile">Informations</h2>
                <ul class="profile">
                    <li class="profile">Username: <?=$user['UserName']?></li>
                    <li class="profile">Email: <?=$user['Email']?></li>
                    <li class="profile">Name: <?=$user['FullName']?></li>
                </ul>
            </section>
        </main>

      <?php

    }

?>
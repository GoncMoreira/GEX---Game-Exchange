<?php
declare(strict_types=1);

require_once('Interface/generic.int.php');
require_once('Interface/games.int.php');
require_once('Database/games.db.php');
require_once('Database/connect.db.php');



?>

<?php 
    function draw_conversations(array $users, array $time){
        ?>
        <main id="conversations">
            <section class="conversations">
                <h2>Conversations (<?php echo sizeof($users)?>)</h2>
                <?php
                    for($i=0; $i<sizeof($users);$i++){ ?>
                    <div class="chat">
                        <a href="chat.php?UserName=<?=$users[$i]?>">
                            <?php echo $users[$i] ?> (<?php echo $time[$i] ?>)
                        </a>
                    </div>
                    <?php 
                    } ?> 
                <form class="chat_form" action="Action/process_start_conversation.php" method="post">
                    <input type="text" name="ReceiverUserName" placeholder="Type a username to start a conversation">
                    <input type="submit" hidden>
                </form>
            </section>
        </main>
      <?php
    }
?>

<?php 
    function draw_chat(array $texts, string $user){
        ?>
        
        <main id="chat">
        <h2 class="chat">Chat with <a href="profile.php?Username=<?=$user?>"><?php echo $user ?></a></h2>
        <section class="chats">
        <?php
            foreach($texts as $text){ 
                if ($text['SenderUserName'] === $_SESSION['Username']){?>
                <p id="myText">
                    <?php echo $text['MessageText']; if ($text['Seen'] === 1 && $text===end($texts)){?> 
                        <span class="seen-marker">Seen</span>
                    <?php };?>
                    <span id="my-message" class="message-time"> <?php echo $text['TimeSent'] ?></span>
                </p>
                <?php }
                else{ ?>
                <p id="theirText">
                    <?php echo $text['MessageText'] ?>
                    <span id="their-message" class="message-time"> <?php echo $text['TimeSent'] ?></span>
                </p>
            <?php }
            } ?> 
            <form class="conversation-form" action="Action/process_send_message.php" method="post">
                <input type="text" name="MessageText" placeholder="Type your message here">
                <input type="hidden" name="ReceiverUserName" value="<?php echo $user ?>">
                <input type="submit" hidden>
            </form>
        </section>
        
        </main>
      <?php
    }
?>
<?php
require_once("Database/connect.db.php");



?>

<?php
function draw_login(){
?>
    <main>
    <section class="login">
    <h1>Login</h1>
    <form action="Action/process_login.php" method="POST">
    <label>Email</label><br>
    <input type="email" name="email"><br>
    <label>Password</label><br>
    <input type="password" name="password"><br>
    <button type="submit">Login</button>
    </form>
    </section>
</main>
<?php 
}
?>

<?php
function draw_register(){
?>
    <main>
    <section class="login">
            <h1>Welcome!</h1>
            <h3>Create your account</h3>
            <form action="Action/process_register.php" method="POST">
                <div>
                    <label>UserName</label><br>
                    <input type="text" placeholder="Username" name="Username"><br>
                </div>
                <div>
                    <label>Email</label><br>
                    <input type="email" name="email"><br>
                </div>
                <div>
                    <label>Password</label><br>
                    <input type="password" name="password"><br>
                </div>
                    <button type="submit">Register</button>
            </form>
        </section>
</main>
<?php 
}
?>



<?php

    require_once('../Database/connect.db.php');

    session_set_cookie_params(0, '/', 'localhost', true, true);
    session_start();
    $usernameRef = urlencode($_SESSION['Username']);

    if (empty($_POST["Email"])) {
        $_SESSION["Error"] = "Email is required.";
        
        header("Location: ../profile.php?Username=$usernameRef");
        exit();
    }
    if (empty($_POST["UserName"])) {
        $_SESSION["Error"] = "UserName is required.";
        header("Location: ../profile.php?Username=$usernameRef");
        exit();
    }

    $username = $_POST["UserName"];
    if (!preg_match("/^[a-zA-Z0-9_-]+$/", $username)){
        $_SESSION["Error"] = "Username can only contain letters, numbers, underscores (_) and hyphes (-)!";
        header("Location: ../profile.php?Username=$usernameRef");
        exit();
    }

    $email = $_POST["Email"];
    $pattern = '/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/';
    if (!preg_match($pattern, $email )){
        $_SESSION["Error"] = "Please provide a valid email address.";
        header("Location: ../profile.php?Username=$usernameRef");
        exit();
    }

    if (strlen($username) > 30){
        $_SESSION["Error"] = "Username must not have more than 30 characters.";
        header("Location: ../profile.php?Username=$usernameRef");
        exit();
    }
    if (strlen($email) > 50){
        $_SESSION["Error"] = "Email must not have more than 50 characters.";
        header("Location: ../profile.php?Username=$usernameRef");
        exit();
    }

    $db =  database_connect();

    $statement1 = $db->prepare('SELECT * FROM USER WHERE (UserName = ? OR Email = ?) AND UserName!=?');
    $statement1->execute(array($_POST['UserName'], $_POST['Email'], $_SESSION['Username']));
    if($statement1->fetch() !== false){
        $_SESSION["Error"] = "UserName or Email already in use.";
        
        header("Location: ../profile.php?Username=$usernameRef");
        exit();
    }
    else{

        $username = $_POST['UserName'];
        $email = $_POST['Email'];
        $fullname = $_POST['FullName'];
        $originalname = $_SESSION['Username'];

        $fullname = trim($fullname);
        if (empty($fullname)){
            $_SESSION["Error"] = "Name should not be empty.";
            header("Location: ../profile.php?Username=$usernameRef");
            exit();
        }

        if (!preg_match("/^[a-zA-Z\s]+$/", $fullname)){
            $_SESSION["Error"] = "Name should only contain letters and spaces.";
            header("Location: ../profile.php?Username=$usernameRef");
            exit();
        }
        
        if (strlen($fullname) > 50){
            $_SESSION["Error"] = "Name should not have more than 50 characters.";
            header("Location: ../profile.php?Username=$usernameRef");
            exit();
        }

        $stmt = $db->prepare('UPDATE USER SET Email = ?, UserName = ?, FullName = ? WHERE UserName = ?');
        $stmt->bindParam(1, $email);
        $stmt->bindParam(2, $username);
        $stmt->bindParam(3, $fullname);
        $stmt->bindParam(4, $originalname);
        if ($stmt->execute()) {

            $stmt2 = $db->prepare('UPDATE PRODUCT SET UserName = ? WHERE UserName = ?');
            $stmt2->bindParam(1, $username);
            $stmt2->bindParam(2, $originalname);
            if ($stmt2->execute()) {
                $_SESSION['Username'] = $username;
                header("Location: ../mainPage.php?Username=$usernameRef");
                exit();
            } 
        } 

    }

?>
<?php

    session_set_cookie_params(0, '/', 'localhost', true, true);
    session_start();

    require_once('../Database/connect.db.php');

    $db = database_connect();

    $new_name = $_POST["DEVICEName"];

    $stmt = $db->prepare('SELECT * FROM DEVICE WHERE DEVICEName = ?');
    $stmt->execute(array($new_name));

    if (sizeof($stmt->fetchAll())>0){
        $_SESSION["Error"] = "Device already exists";
        header('Location: ../adminPage.php');
        exit();
    }
    else{
        $stmt = $db->prepare('SELECT MAX(DEVICEId) FROM DEVICE');
        $stmt->execute();
        $new_id = $stmt->fetch()[0] + 1;

        $stmt = $db->prepare('INSERT INTO DEVICE (DEVICEId, DEVICEName) VALUES (?, ?)');
        $stmt->execute(array($new_id, $new_name));
    }

    header('Location: ../mainPage.php')
?>
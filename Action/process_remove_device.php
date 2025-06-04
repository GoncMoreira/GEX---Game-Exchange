<?php

    session_set_cookie_params(0, '/', 'localhost', true, true);
    session_start();

    require_once('../Database/connect.db.php');

    $db = database_connect();

    $device_id = $_POST["DEVICEId"];

    $stmt = $db->prepare('DELETE FROM DEVICE WHERE DEVICEId = ?');
    $stmt->execute(array($device_id));

    $stmt = $db->prepare('DELETE FROM PRODUCT_IMAGE WHERE PRODUCTId IN (SELECT PRODUCTId FROM PRODUCT WHERE DEVICEId = ?) ');
    $stmt->execute(array($device_id));

    $stmt = $db->prepare('DELETE FROM PRODUCT WHERE DEVICEId = ?');
    $stmt->execute(array($device_id));

    header('Location: ../mainPage.php')
?>
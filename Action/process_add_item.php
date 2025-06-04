<?php

session_set_cookie_params(0, '/', 'localhost', true, true);
session_start();

if (empty($_POST["Name"])) {
    $_SESSION["Error"] = "Name is required.";
    header('Location: ../sell_item.php');
    exit();
}
if (empty($_POST["Price"])) {
    $_SESSION["Error"] = "Price is required.";
    header('Location: ../sell_item.php');
    exit();
}
if ($_POST["Price"] <= 0) {
    $_SESSION["Error"] = "Price must be higher than 0 euros.";
    header('Location: ../sell_item.php');
    exit();
}
if ($_POST["Price"] >= 100) {
    $_SESSION["Error"] = "Price must be lower than 100 euros.";
    header('Location: ../sell_item.php');
    exit();
}
if (empty($_POST["Developer"])) {
    $_SESSION["Error"] = "Developer is required.";
    header('Location: ../sell_item.php');
    exit();
}
if (empty($_POST["Device"])) {
    $_SESSION["Error"] = "Device is required.";
    header('Location: ../sell_item.php');
    exit();
}

if (empty($_POST["Genres"])) {
    $_SESSION["Error"] = "Genres are required. (at least one)";
    header('Location: ../sell_item.php');
    exit();
}
if (empty($_POST["Description"])) {
    $_SESSION["Error"] = "Description is required.";
    header('Location: ../sell_item.php');
    exit();
}

if (empty($_FILES['image'])) {
    $_SESSION["Error"] = "Image is required.";
    header('Location: ../sell_item.php');
    exit();
}

if (!preg_match("/^[a-zA-Z0-9-.\s]+$/", $_POST["Name"])){
    $_SESSION["Error"] = "The name must contain only letters, numbers, hyphens (-), dots (.) or spaces!";
    header('Location: ../sell_item.php');
    exit();
}

if (!preg_match("/^[0-9]+$/", $_POST["Price"])){
    $_SESSION["Error"] = "The price must contain numbers only!";
    header('Location: ../sell_item.php');
    exit();
}

if (!preg_match("/^[a-zA-Z\s]+$/", $_POST["Developer"])){
    $_SESSION["Error"] = "The developer's name must contain only letters or spaces!";
    header('Location: ../sell_item.php');
    exit();
}

$pattern = '/^[a-zA-Z0-9\s.,?!\-:;()\'"]*$/';
if (!preg_match($pattern, $_POST["Description"])){
    $_SESSION["Error"] = "Make shure hat you are only using letters, numbers spaces, and the following special characters \".,?!\-:;()'";
    header('Location: ../sell_item.php');
    exit();
}

$name = trim($_POST["Name"]);
$developer= trim($_POST["Developer"]);
$description = trim($_POST["Description"]);
if (strlen($name) > 30 || empty($name)){
    $_SESSION["Error"] = "The Game's name must be shorter than 30 characters and not empty!";
    header('Location: ../sell_item.php');
    exit();
}
if (strlen($developer) > 20 || empty($developer) ){
    $_SESSION["Error"] = "The Developer's name must be shorter than 20 characters and not empty!";
    header('Location: ../sell_item.php');
    exit();
}
if (strlen($description) > 200 || empty($description)){
    $_SESSION["Error"] = "The Description must be shorter than 200 characters and not empty!";
    header('Location: ../sell_item.php');
    exit();
}

$tempFileName = $_FILES['image']['tmp_name'];
$fileError = $_FILES['image']["error"];
if ($fileError !== UPLOAD_ERR_OK) {
    $_SESSION["Error"] = "Error: File upload failed";
    header('../Location: ../sell_item.php');
    exit();
}


require_once('../Database/connect.db.php');

$db = database_connect();
$stmt = $db->prepare('SELECT MAX(PRODUCTId) FROM PRODUCT');
$stmt->execute();
$id = $stmt->fetch()[0] + 1;
$_SESSION["Error"] = $id;
exit();
$stmt = $db->prepare('INSERT INTO PRODUCT (PRODUCTId, ProductName, Price, Description, Developer, UserName, DEVICEId, sold) VALUES ( ?, ?, ?, ?, ?, ?, ?, 0)');
$stmt->execute(array($id, $_POST['Name'], $_POST['Price'], $_POST['Description'], $_POST['Developer'],$_SESSION['Username'], $_POST['Device']));

foreach($_POST['Genres'] as $genre){
    $stmt = $db->prepare('INSERT INTO PRODUCT_GENRE (PRODUCTId, GENREName) VALUES ( ?, ?)');
    $stmt->execute(array($id, $genre));
}

    $db = database_connect();
    $db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Create an image representation of the original image
    // @ before function is to prevent warning messages
    $original = @imagecreatefromjpeg($tempFileName);
    if(!$original){
        $original = @imagecreatefrompng($tempFileName);
    } 
    
    if(!$original){
        $original = @imagecreatefromgif($tempFileName);
    } 
    if(!$original){
        $_SESSION["Error"] = "Unknown image format!";
        header('Location: ../sell_item.php');
        exit();
    } 


    $originalFileName = "../Data/images/$id.jpg";
    imagejpeg($original, $originalFileName);

    $stmt = $db->prepare('INSERT INTO IMAGES (IMAGESId, LINK) VALUES ( ?, ?)');
    $stmt->execute(array($id, $originalFileName));

    $stmt = $db->prepare('INSERT INTO PRODUCT_IMAGE (IMAGESId, PRODUCTId) VALUES ( ?, ?)');
    $stmt->execute(array($id, $id));


    header('Location: ../ItemsBeingSold.php');
    

?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>Login/Registrera</title>
    <link rel="stylesheet" href="normalize.css" />
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.4/css/bootstrap.min.css" integrity="sha384-2hfp1SzUoho7/TsGGGDaFdsuuDL0LX2hnUp6VkX3CUQ2K4K+xjboZdsXyp4oUHZj" crossorigin="anonymous">
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
<?php

session_start();
if(isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == TRUE ) {
    // ------------------------------------------------------------------------
    // IF LOGGED IN
    // ------------------------------------------------------------------------
    $userid = $_SESSION['user_id'];
    require "dbconnect.php";

    $stmt = $conn->stmt_init();
    $stmt->prepare("SELECT * FROM users WHERE user_id = '{$userid}'");
    $stmt->execute();
    $stmt->bind_result($user_id, $firstname, $lastname, $email, $encrypt_password, $profilepic);
    $stmt->fetch();
?>

    <header>     
        <nav>
            <p>Hej <?php echo $firstname;?></p>
            <a href="index.php">Till bloggen</a><br>
            <a href="dashboard.php">Skriv inlägg</a><br>
            <a href="logout.php">Logga ut</a>
        </nav>
    </header>

<?php
} else {
    // ------------------------------------------------------------------------
    // IF NOT LOGGED IN
    // ------------------------------------------------------------------------    
?>
    <header>
    </header>
    <?php
        }
?>
   
    

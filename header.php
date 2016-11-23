<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Login/Registrera</title>
    <link rel="stylesheet" href="normalize.css" />
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
</head>
<body>
<?php
require "dbconnect.php";
session_start();
if(isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == TRUE ) {
    // ------------------------------------------------------------------------
    // IF LOGGED IN
    // ------------------------------------------------------------------------
    $userid = $_SESSION['user_id'];

    $stmt = $conn->stmt_init();
    $stmt->prepare("SELECT * FROM users WHERE user_id = '{$userid}'");
    $stmt->execute();
    $stmt->bind_result($user_id, $firstname, $lastname, $email, $encrypt_password, $profilepic);
    $stmt->fetch();
?>

    <header>     
        <nav class="navbar navbar-default">
            <div class="container-fluid">
            <div class="navbar-header">
                <a class="navbar-brand" href="index.php">Till bloggen</a>
                <a class="navbar-brand" href="dashboard.php">Profil</a>
                <a class="navbar-brand" href="comments.php">Kommentarer</a>
                <a class="navbar-brand" href="index.php">Arkiv</a>
                <a class="navbar-brand" href="index.php">Statistik</a>
            </div>
            <div class="navbar-header navbar-right">
                <a class="navbar-brand" href="logout.php">Logga ut</a>
            </div>
        </div>
    </nav>
    </header>

<?php
 // ------------------------------------------------------------------------
    // IF NOT LOGGED IN
    // ------------------------------------------------------------------------

} else {
    ?>
        <header>     
        <nav class="navbar navbar-default">
            <div class="container-fluid">
            <div class="navbar-header">
                <a class="navbar-brand" href="index.php">Hem</a>
                <ul class="nav navbar-nav">
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Kategori<span class="caret"></span></a>
                        <ul class="dropdown-menu">
                            <li><a href="#">Action</a></li>
                            <li><a href="#">Another action</a></li>
                            <li><a href="#">Something else here</a></li>
                            <li role="separator" class="divider"></li>
                            <li><a href="#">Separated link</a></li>
                            <li role="separator" class="divider"></li>
                            <li><a href="#">One more separated link</a></li>
                        </ul>
                    </li>
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Arkiv<span class="caret"></span></a>
                        <ul class="dropdown-menu">
                            <li><a href="#">Action</a></li>
                            <li><a href="#">Another action</a></li>
                            <li><a href="#">Something else here</a></li>
                            <li role="separator" class="divider"></li>
                            <li><a href="#">Separated link</a></li>
                            <li role="separator" class="divider"></li>
                            <li><a href="#">One more separated link</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
            <div class="navbar-header navbar-right">
                <a class="navbar-brand" href="login.php">Logga in</a>
            </div>
        </div>
    </nav>
    </header>

    <header>
    </header>
    <?php
        }
?>
   
    

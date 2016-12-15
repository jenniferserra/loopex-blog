<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Loopex bloggportal</title>
    <link rel="stylesheet" href="normalize.css"/>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="style/css/style.css">
</head>
<body class="dashboard comments drafts archive statistics index">
<?php
require_once "dbconnect.php";
session_start();
if(isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == TRUE ) {
    // ------------------------------------------------------------------------
    // IF LOGGED IN
    // ------------------------------------------------------------------------
    $userid = $_SESSION['user_id'];
    // $stmt = $conn->stmt_init();
    $stmt->prepare("SELECT * FROM users WHERE user_id = '{$userid}'");
    $stmt->execute();
    $stmt->bind_result($user_id, $firstname, $lastname, $email, $encrypt_password, $profilepic, $role);
    $stmt->fetch();
?>

    <header>
        <nav class="navbar navbar-default">
            <div class="container-fluid">
            <div class="navbar-header">
                <a class="navbar-brand" href="index.php">Till bloggen</a>
                <a class="navbar-brand" href="dashboard.php">Profil</a>
                <a class="navbar-brand" href="comments.php">Kommentarer</a>
                <a class="navbar-brand" href="archive.php">Arkiv</a>
                <a class="navbar-brand" href="drafts.php">Utkast</a>
                <a class="navbar-brand" href="statistics.php">Statistik</a>
            </div>
            <div class="navbar-header navbar-right">
                <a class="navbar-brand" href="logout.php">Logga ut</a>
            </div>
        </nav>
    </header>

    <?php
    $stmt->close();
       // ---------------------------------------------------------------------
        // IF NOT LOGGED IN
        // --------------------------------------------------------------------

    } else {
        ?>
        <header>
            <nav class="navbar navbar-default">
                <ul>
                    <li><a href="#">Hem</a></li>
                    <li>
                        <a href="?category=0">Kategori</a>
                        <ul>
                            <li><a href="?category=1">Sport</a></li>
                            <li><a href="?category=2">Mode</a></li>
                            <li><a href="?category=3">Fotografi</a></li>
                            <li><a href="?category=4">Annat</a></li>
                        </ul>
                    </li>

                    <li>
                        <a href="#">Arkiv</a>
                        <ul>
                            <li><a href="#">Januari</a></li>
                            <li><a href="#">Februari</a></li>
                        </ul>
                    </li>
                </ul>
                <div class="navbar-header navbar-right">
                    <a class="navbar-brand" href="login.php">Logga in</a>
                </div>
            </nav>
        </header>

        <!-- start a wrapper -->
        <div class="page-content">
    <?php
        }
?>

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

    <header>
            <nav class="navbar navbar-default">
                <ul>


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

                    <li class="menu-btn-lvl-1"><a href="index.php">Bloggen</a></li>
                    <li class="menu-btn-lvl-1"><a href="dashboard.php">Profil</a></li>
                    <li class="menu-btn-lvl-1"><a href="comments.php">Kommentarer</a></li>
                    <li class="menu-btn-lvl-1"><a href="archive.php">Arkiv</a></li>
                    <li class="menu-btn-lvl-1"><a href="drafts.php">Utkast</a></li>
                    <li class="menu-btn-lvl-1"><a href="dashboard.php">Profil</a></li>
                    <li class="menu-btn-lvl-1"><a href="statistics.php">Statistik</a></li>
                    <li class="menu-btn-lvl-1"><a href="logout.php">Logga ut</a></li>

    <?php
    $stmt->close();
       // ---------------------------------------------------------------------
        // IF NOT LOGGED IN
        // --------------------------------------------------------------------

    } else {
        ?>
                    <li class="menu-btn-lvl-1"><a href="index.php">Hem</a></li>
                    <li class="menu-btn-lvl-1"><a href="?category=0">Kategori</a>
                        <ul>
                            <li class="menu-btn-lvl-2"><a class="nav-link" href="?category=1">Sport</a></li>
                            <li class="menu-btn-lvl-2"><a class="nav-link" href="?category=2">Mode</a></li>
                            <li class="menu-btn-lvl-2"><a class="nav-link" href="?category=3">Fotografi</a></li>
                            <li class="menu-btn-lvl-2"><a class="nav-link" href="?category=4">Annat</a></li>
                        </ul>
                    </li>

                    <li class="menu-btn-lvl-1"><a href="#">Arkiv</a>
                        <ul>
                            <li class="menu-btn-lvl-2"><a href="#">Januari</a></li>
                            <li class="menu-btn-lvl-2"><a href="#">Februari</a></li>
                        </ul>
                    </li>
                    <div class="navbar-header navbar-right">
                        <li class="menu-btn-lvl-1">
                            <a class="navbar-brand" href="login.php">Logga in</a>
                        </li>
                    </div>
    <?php
        }
?>

                </ul>
            </nav>
        </header>

        <!-- start a wrapper -->
        <div class="page-content">

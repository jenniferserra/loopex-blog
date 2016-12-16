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
                    require"header_btns/default_inlog_btns.php";
    $stmt->close();
       // ---------------------------------------------------------------------
        // IF NOT LOGGED IN
        // --------------------------------------------------------------------

    } else {
                    require"header_btns/default_outlog_btns.php";
                    require"header_btns/index_outlog_btns.php";
        }
?>

                </ul>
            </nav>
        </header>

        <!-- start a wrapper -->
        <div class="page-content">

<?php
/* ----------------------------------------------------------------------------
    LOGIN CHECK
---------------------------------------------------------------------------- */
session_start();
$_SESSION['loggedin'] = false;

if (isset($_POST["login"])) {

    if (!empty($_POST["email"]) && !empty($_POST["password"])) {

        require "dbconnect.php";
        $email = mysqli_real_escape_string($conn, $_POST["email"]);
        $password = mysqli_real_escape_string($conn, $_POST["password"]);

        $sql = "SELECT * FROM users WHERE email = '{$email}' ";
        $query = mysqli_query($conn, $sql);
        
        while($getUser = mysqli_fetch_array($query, MYSQLI_ASSOC)) {
            $cryptPassword = $getUser["password"];
            $userId = $getUser["user_id"];
            $userRole = $getUser["role"];
        }


        if (password_verify($password, $cryptPassword)) {

            session_start();

            $_SESSION['loggedin'] = true;
            $_SESSION['user_id'] = $userId;
            $_SESSION['role'] = $userRole;

            /* If superuser logs in */
            if ($_SESSION['role'] == admin) {

                header('Location:superuser.php');

            } else {
                /* else if ordinary user in logged in */
                header('Location: dashboard.php');
            }
        } else {
            echo $testvar;
            /*header('Location: login.php?error');*/
        }
    } else {
        header('Location: login.php?empty');
    }
} 
?>
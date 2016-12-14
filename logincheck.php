<?php
// Before lgged is_nan
session_start();
$_SESSION['loggedin'] = false;

// Start login process
if (isset($_POST["login"])) {
    if (!empty($_POST["email"]) && !empty($_POST["password"])) {
        $conn = new mysqli("localhost", "root", "", "db_blogg");
        $email = mysqli_real_escape_string($conn, $_POST["email"]);
        $password = mysqli_real_escape_string($conn, $_POST["password"]);

        $stmt = $conn->stmt_init();

        if ($stmt->prepare("SELECT * FROM users WHERE email = '{$email}' ")) {
            $stmt->execute();
            $stmt->bind_result($user_id, $firstname, $lastname, $email, $encrypt_password, $profilepic, $role);
            $stmt->fetch();

            if (password_verify($password, $encrypt_password)) {

                //TODO gör en SESSION istället för en COOKIE
                // setcookie("user_id", $user_id, time() + (3600*8));

                // STARTING SESSION
                session_start();
                $_SESSION['loggedin'] = true;
                $_SESSION['user_id'] = $user_id;
                $_SESSION['role'] = $role;
                  /* If superuser logs in */
                 if ($_SESSION['role'] == admin) {
                   header('Location:superuser.php');
                   /* else if ordinary user in logged in */
                 }else {
                   header('Location: dashboard.php');
                 }
            } else {
                header('Location: login.php?error');
            }
        }
    } else {
        header('Location: login.php?empty');
    }
}

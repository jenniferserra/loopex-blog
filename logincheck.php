<?php
if(isset($_POST["login"])) {

	if(!empty($_POST["email"]) && !empty($_POST["password"])) {

		include "dbconnect.php";
		$conn = new mysqli("localhost", "root", "", "db_blogg");


		$email = mysqli_real_escape_string($conn, $_POST["email"]);
		$password = mysqli_real_escape_string($conn, $_POST["password"]);

		$stmt = $conn->stmt_init();

		if($stmt->prepare("SELECT * FROM users WHERE email = '{$email}' ")) {
			$stmt->execute();
			$stmt->bind_result($user_id, $firstname, $lastname, $email, $encrypt_password, $profilepic);
			$stmt->fetch();

			if(password_verify($password, $encrypt_password)) {

				//TODO gör en SESSION istället för en COOKIE	
				setcookie("user_id", $user_id, time() + (3600*8));

				header('Location: dashboard.php');

			}else {

				header('Location: login.php?error');
			}
		}

	}else {

		header('Location: login.php?empty');
	}
}

?>
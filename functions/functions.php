<?php

function regUser() {

	if(isset($_POST["register"])) {

		if(	!empty($_POST["firstname"]) &&
			!empty($_POST["lastname"]) &&
			!empty($_POST["email"]) &&
			!empty($_POST["password"])
			) {

			$conn = new mysqli("localhost", "root", "", "db_blogg");

			$firstname = mysqli_real_escape_string($conn, $_POST["firstname"]);
			$lastname = mysqli_real_escape_string($conn, $_POST["lastname"]);
			$email = mysqli_real_escape_string($conn, $_POST["email"]);
			$password = mysqli_real_escape_string($conn, $_POST["password"]);
			$role = "user"; //standard för användaren är user.
			$encrypt_pass = password_hash($password, PASSWORD_DEFAULT);

			include "dbconnect.php";
			//$conn = new mysqli("localhost", "root", "", "db_blogg");

			$query = "INSERT INTO users VALUES (
			NULL, /* för att user_id ska skapas per automatik */
			'$firstname',
			'$lastname',
			'$email',
			'$encrypt_pass',
			'', /* istället för profilbild eftersom den inte läggs in nu */
			'$role'
			)";

			mysqli_query($conn, $query);
		}
	}
}

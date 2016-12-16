

		<?php
		require "header.php";

		if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] == TRUE ) {
		//-----------------------------------------------------------------------------
		// LOGGED IN
		//-----------------------------------------------------------------------------
			$userId = $_SESSION["user_id"];
		?>

		<?php

		$stmt = $conn->stmt_init();

		if($stmt->prepare("SELECT * FROM users WHERE user_id = '{$userId}' ")) {
			$stmt->execute();
			$stmt->bind_result($user_id, $firstname, $lastname, $email, $encrypt_password, $profilepic, $role);
			$stmt->fetch();
		}

		//-----------------------------------------------------------------------------
		// HTML-STRUKTUR FÖR INLÄGG
		//-----------------------------------------------------------------------------

		?>
		<div class="blogpost-box col-sm-12 col-xs-12">
		<?php echo '<div class="welcome"> Hej '. $firstname .' '. $lastname .'! </div>'; ?>

		<h1 class="dashboard-title">Dags att skriva nästa succéinlägg?</h1>
			<form method="POST" action="dashboard.php" class="blogposts">
		        <input type="text" placeholder="Skriv din rubrik här" name="blogpost_title" class="blogpost_title"><br>
				<textarea rows="15" cols="80" placeholder="Skriv ditt inlägg här" name="blogpost_text" class="blogpost_text">
				</textarea><br>
				<select name="category" class="categories">
					<option value ="0">Välj kategori</option>
					<option value ="1">Sport</option>
					<option value ="2">Mode</option>
					<option value ="3">Fotografi</option>
					<option value ="4">Annat</option>
				</select><br>
				<input name="publish" class="btn button btn-lg btn-primary btn-block" type="submit" value="Publicera inlägg">
				<input name="draft" class="btn button btn-lg btn-primary btn-block" type="submit" value="Spara utkast">
			</form>

		<?php
		//-----------------------------------------------------------------------------
		// PUBLISH
		//-----------------------------------------------------------------------------
		if(isset($_POST["publish"])) {
			if(	!empty($_POST["blogpost_title"]) &&
				!empty($_POST["blogpost_text"]) &&
				$_POST["category"] != "0" ) {

				// Preparing the statement
				$stmt = $conn->stmt_init();

				// Stripping off harmful characters
				$text = mysqli_real_escape_string($conn, $_POST["blogpost_text"]);
				$title = mysqli_real_escape_string($conn, $_POST["blogpost_title"]);

				$timeStamp = date("Y-m-d H:i:s");
				$category = $_POST["category"];

				// Upload post into database. Published = TRUE
				$query = "INSERT INTO posts VALUES (NULL, '{$timeStamp}', '', '{$title}', '{$text}', TRUE, '$user_id', '$category')";

				if ( mysqli_query($conn, $query)) {
						echo "Ditt inlägg är sparat i databasen";
				} else {
						echo "Inlägget är inte sparat i databasen";
				}
			} else { echo "Du har inte fyllt i alla fält eller valt kategori"; }
		}

		//-----------------------------------------------------------------------------
		// SAVE AS DRAFT
		//-----------------------------------------------------------------------------

		if(isset($_POST["draft"])) {
			if(	!empty($_POST["blogpost_title"]) &&
				!empty($_POST["blogpost_text"]) &&
				$_POST["category"] != "0") {

				// Preparing the statement
				$stmt = $conn->stmt_init();

				// Stripping off harmful characters
				$text = mysqli_real_escape_string($conn, $_POST["blogpost_text"]);
				$title = mysqli_real_escape_string($conn, $_POST["blogpost_title"]);

				$timeStamp = date("Y-m-d H:i:s");
				$category = $_POST["category"];

				// Upload post into database. Published = FALSE
				$query = "INSERT INTO posts VALUES (NULL, '{$timeStamp}', '', '{$title}', '{$text}', FALSE, '$user_id', '$category')";

				if ( mysqli_query($conn, $query)) {
						echo "Ditt inlägg är sparat i databasen";
				} else {
						echo "Inlägget är inte sparat i databasen";
				}
			} else { echo "Du har inte fyllt i alla fält eller valt kategori"; }
		}


		?>
	</div>



<!-- if logged in -->
<?php

}else {
//-----------------------------------------------------------------------------
// LOGGED OUT
//-----------------------------------------------------------------------------
	echo "Du är inte inloggad";
	echo "<br><a href='login.php'>Logga in</a>";
}

require "footer.php";
?>

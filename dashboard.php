<?php
require "header.php";

if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] == TRUE ) {
//-----------------------------------------------------------------------------
// LOGGED IN
//-----------------------------------------------------------------------------
	$userId = $_SESSION["user_id"];
?>
<div class="frida-form">
<?php

$stmt = $conn->stmt_init();

if($stmt->prepare("SELECT * FROM users WHERE user_id = '{$userId}' ")) {
	$stmt->execute();
	$stmt->bind_result($user_id, $firstname, $lastname, $email, $encrypt_password, $profilepic, $role);
	$stmt->fetch();
}
echo "Hej " . $firstname . " " . $lastname;


//-----------------------------------------------------------------------------
// HTML-STRUKTUR FÖR INLÄGG
//-----------------------------------------------------------------------------

?>
<h1>Blogginlägg</h1>

<form method="POST" action="dashboard.php">
	<p>Rubrik</p>
	<input type="text" name="blogpost_title"><br>
	<p>Text</p>
	<textarea rows="15" cols="80" name="blogpost_text"></textarea><br>
	<select name="category">
		<option value ="0">Välj kategori</option>
		<option value ="1">Sport</option>
		<option value ="2">Mode</option>
		<option value ="3">Fotografi</option>
		<option value ="4">Annat</option>
	</select><br>
	<input name="publish" class="btn btn-lg btn-primary btn-block" type="submit" value="Publicera inlägg">
	<input name="draft" class="btn btn-lg btn-primary btn-block" type="submit" value="Spara utkast">
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
</body>
</html>

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

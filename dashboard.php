<?php 

//if logged in
if(isset($_COOKIE["user_id"])) {
	$userId = $_COOKIE["user_id"];
?>

<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="UTF-8">
		<title>Dashboard</title>
	</head>
<body>
<?php 
require "dbconnect.php";

$stmt = $conn->stmt_init();

if($stmt->prepare("SELECT * FROM users WHERE user_id = '{$_COOKIE["user_id"]}' ")) { 
	$stmt->execute();
	$stmt->bind_result($user_id, $firstname, $lastname, $email, $encrypt_password, $profilepic);
	$stmt->fetch();
}		
echo "Hej " . $firstname;


//-----------------------------------------------------------------------------
// HTML-STRUKTUR FÖR INLÄGG
//-----------------------------------------------------------------------------

?>
<h1> TEST </h1>
<form action="logout.php">
	<input name="logout" class="btn btn-lg btn-primary btn-block" type="submit" value="Logga ut">
</form>

<form method="POST" action="dashboard.php">
	<input type="text" name="blogpost_title"><br>
	<textarea rows="15" cols="80" name="blogpost_text"></textarea><br>
	<select name="categories"> 
		<option value ="0">Välj kategori</option>
		<option value ="1">Mode</option>
		<option value ="2">Fotografi</option>
	</select><br>
	<input name="publish" class="btn btn-lg btn-primary btn-block" type="submit" value="Publicera inlägg">
	<input name="draft" class="btn btn-lg btn-primary btn-block" type="submit" value="Spara utkast">
</form>

<?php 



//-----------------------------------------------------------------------------
// PRINTING OUT BLOG POST
//-----------------------------------------------------------------------------

$query = "SELECT posts.*, users.firstname, users.lastname FROM posts LEFT JOIN users ON posts.fk_user_id = users.user_id WHERE posts.fk_user_id = '{$userId}'";



if($stmt->prepare($query)) {
	$stmt->execute();
	$stmt->bind_result($postId, $createTime, $editTime, $title, $text, $isPublished, $fkUserId, $fkCatId, $firstName, $lastName);

	while(mysqli_stmt_fetch($stmt)) {

	?>
	<div class="blogpost">
		<h1><?php echo $title; ?></h1>
		<div class="text"><?php echo $text; ?></div>
		<div class="author">Written by:
			<?php
			echo "<a href='author.php?id=$fkUserId'>$firstName $lastName</a>";
			?>
			</div>
	</div>
	<?php	
	}
}

//-----------------------------------------------------------------------------
//PUBLISH
//-----------------------------------------------------------------------------

if($stmt->prepare($query)) {
	$stmt->execute();
	$stmt->bind_result($postId, $createTime, $editTime, $title, $text, $isPublished, $fkUserId, $fkCatId, $firstName, $lastName);
}

// If fields are filled
if(isset($_POST["publish"])) {
	if(	!empty($_POST["blogpost_title"]) &&
		!empty($_POST["blogpost_text"]) &&
		$_POST["categories"] != "0" ) {

		
		// Preparing the statement
		$stmt = $conn->stmt_init();
		
		// Stripping off harmful characters
		$text = mysqli_real_escape_string($conn, $_POST["blogpost_text"]);
		$title = mysqli_real_escape_string($conn, $_POST["blogpost_title"]);

		$category = $_POST["categories"];
		$timeStamp = date("Y-m-d H:i:s");
		// Upload post into databease
		$query = "INSERT INTO posts VALUES (NULL, '{$timeStamp}', '', '{$title}', '{$text}', TRUE, '{$userId}', '');";
		$query .= "INSERT INTO categories VALUES (NULL, '{$category}')";
		
		if ( mysqli_multi_query($conn, $query)) {
				echo "Ditt inlägg är sparat i databasen";
			} else {
				echo "inlägget är inte sparat i databasen";
		}
	} else { echo "Du har inte fyllt i alla fält eller valt kategori"; } 
	

}
//-----------------------------------------------------------------------------
//PUBLISH
//-----------------------------------------------------------------------------

// DRAFT
//If button draft is selected
if(isset($_POST["draft"])) {
	if(	!empty($_POST["blogpost_title"]) &&
		!empty($_POST["blogpost_text"]) &&
		$_POST["categories"] != "0") {

		//prepare the statement
		$stmt = $conn->stmt_init();

		$text = mysqli_real_escape_string($conn, $_POST["blogpost_text"]);
		$title = mysqli_real_escape_string($conn, $_POST["blogpost_title"]);

		$query = "INSERT INTO posts VALUES (NULL, 'time()', '', '$title', '$text', FALSE, '', '')"; 

			
			if ( mysqli_query($conn, $query) ) {
				echo "Ditt inlägg är sparat i databasen";
			} else {
				echo "inlägget är inte sparat i databasen";
			}


	} else {
		echo "Du har inte fyllt i alla fält eller valt kategori";
	}
} 


?>
	
</body>
</html>

<!-- if logged in -->
<?php

}else {
	//IF NOT LOGGED IN
	echo "Du är inte inloggad";
}

?>
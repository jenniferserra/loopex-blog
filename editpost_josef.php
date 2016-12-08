<?php
require "header.php";

if (!isset($_SESSION["loggedin"])) {
	echo "Du är inte inloggad";
	die();
}

$conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

if ( isset($_POST["publish"]) && !empty($_POST["blogpost_title"]) && !empty($_POST["blogpost_text"])) {

echo "Hästen";

	// Preparing the statement
	$stmt = $conn->stmt_init();

	// Stripping off harmful characters
	$text = mysqli_real_escape_string($conn, $_POST["blogpost_text"]);
	$title = mysqli_real_escape_string($conn, $_POST["blogpost_title"]);
	$timeStamp = date("Y-m-d H:i:s");
	$cat = $_POST['category'];

	// Update posts with new content as entered in previous form
	$query = "
		UPDATE posts SET
		title = '{$title}',
		text = '{$text}',
		cat_id = '{$cat}',
		edit_time = '{$timeStamp}'
		WHERE post_id = " . $_GET['editid'];
		echo $query;

	if ( mysqli_query($conn, $query)) {
			$_SESSION['msg'] = "Funkar bra";
			header('Location: editpost_josef.php?editid=' . $_GET['editid']);
	} else {
			echo "Inlägget är inte sparat i databasen";
	}
}


$editid = mysqli_real_escape_string($conn, $_GET['editid']);

$query = "SELECT * FROM posts WHERE post_id = " . $_GET['editid'];
$post = $conn->query($query)->fetch_object();

$query = "SELECT * FROM categories";
$cats = $conn->query($query);
//-----------------------------------------------------------------------------
// HTML-STRUKTUR FÖR INLÄGG
//-----------------------------------------------------------------------------

?>
<h1>Blogginlägg</h1>
<h2><?php if ( isset($_SESSION['msg']) ) { echo $_SESSION['msg']; unset($_SESSION['msg']); } ?></h2>

<form method="POST" action="editpost_josef.php?editid=<?= $post->post_id; ?>">
	<p>Rubrik</p>
	<input type="text" name="blogpost_title" value="<?= $post->title; ?>"><br>
	<p>Text</p>
	<textarea rows="15" cols="80" name="blogpost_text"><?= $post->text; ?></textarea><br>
	<select name="category">
		<?php while($cat = $cats->fetch_object()) : ?>
			<option<?= $cat->cat_id == $post->cat_id ? " selected" : null; ?> value="<?= $cat->cat_id; ?>">
				<?= $cat->cat_name; ?>
			</option>
		<?php endwhile; ?>
	</select><br>
	<input name="publish" class="btn btn-lg btn-primary btn-block" type="submit" value="Publicera redigering">
	<input name="draft" class="btn btn-lg btn-primary btn-block" type="submit" value="Spara redigering till utkast">
</form>
</body>
</html>
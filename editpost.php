<?php
require "header.php";

if (!isset($_SESSION["loggedin"])) {
	echo "Du är inte inloggad";
	die();
}
if ( isset($_POST["publish"]) && !empty($_POST["blogpost_title"]) && !empty($_POST["blogpost_text"])) {
	// Preparing the statement
	$stmt = $conn->stmt_init();

	// Stripping off harmful characters
	$text = mysqli_real_escape_string($conn, $_POST["blogpost_text"]);
	$title = mysqli_real_escape_string($conn, $_POST["blogpost_title"]);
	$timeStamp = date("Y-m-d H:i:s");
	$category = $_POST['category'];

	// Update posts with new content as entered in previous form
	$query = "
		UPDATE posts SET 
		title = '{$title}',
		text = '{$text}',
		cat_id = '{$category}',
		edit_time = '{$timeStamp}',
		is_published = 1
		WHERE post_id = " . $_GET['editid'];

	if ( mysqli_query($conn, $query)) {
			$_SESSION['msg'] = "Ditt inlägg är publicerad!";
			//header('Location: editpost.php?editid=' . $_GET['editid']);
	} else {
			echo "Någonting fick fel, testa igen";
	}
}
if(isset($_POST["draft"]) && !empty($_POST["blogpost_title"]) && !empty($_POST["blogpost_text"])) {

	// Preparing the statement
	$stmt = $conn->stmt_init();

	// Stripping off harmful characters
	$text = mysqli_real_escape_string($conn, $_POST["blogpost_text"]);
	$title = mysqli_real_escape_string($conn, $_POST["blogpost_title"]);
	$timeStamp = date("Y-m-d H:i:s");
	$category = $_POST["category"];

	// Upload post into database. Published = FALSE
	$query = "
		UPDATE posts SET 
		title = '{$title}',
		text = '{$text}',
		cat_id = '{$category}',
		edit_time = '{$timeStamp}',
		is_published = 0
		WHERE post_id = " . $_GET['editid'];

	if ( mysqli_query($conn, $query)) {
			$_SESSION['msg'] = "Ditt inlägg är sparat i utkast!";
			//header('Location: editpost.php?editid=' . $_GET['editid']);
	} else {
			echo "Någonting fick fel, testa igen";
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
<h1><?php if ( isset($_SESSION['msg']) ) { echo $_SESSION['msg']; unset($_SESSION['msg']); } else echo "Blogginlägg" ?></h1>
<form method="POST" action="editpost.php?editid=<?= $post->post_id; ?>">
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
<?php
include "footer.php";
?>
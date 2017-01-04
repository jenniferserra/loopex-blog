<?php
require_once "code_open.php";
?>
<body class="editpost">
	<!-- start a wrapper -->
	<div class="page-content">
	    <?php
	    require_once "header.php";

		if (!isset($_SESSION["loggedin"])) {
	        header('Location: index.php');
	        die();
	    }
		
		/* ----------------------------------------------------------------------------
				PUBLISH POST
				- Published = True
		---------------------------------------------------------------------------- */
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
					$_SESSION['msg'] = "Ditt inlägg är publicerat!";
			} else {
                $_SESSION['msg'] = "<span class='error'>Error: </span>Någonting fick fel, testa igen!";
            }
		}

		/* ----------------------------------------------------------------------------
				SAVE POST TO DRAFTS
				- Published = False
		---------------------------------------------------------------------------- */
		if(isset($_POST["draft"]) && !empty($_POST["blogpost_title"]) && !empty($_POST["blogpost_text"])) {

			$stmt = $conn->stmt_init();

			$text = mysqli_real_escape_string($conn, $_POST["blogpost_text"]);
			$title = mysqli_real_escape_string($conn, $_POST["blogpost_title"]);
			$timeStamp = date("Y-m-d H:i:s");
			$category = $_POST["category"];

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
			} else {
		        $_SESSION['msg'] = "<span class='error'>Error: </span>Någonting fick fel, testa igen!";
		    }
		}

		$editid = mysqli_real_escape_string($conn, $_GET['editid']);

		$query = "SELECT * FROM posts WHERE post_id = " . $_GET['editid'];
		$post = $conn->query($query)->fetch_object();

		$query = "SELECT * FROM categories";
		$cats = $conn->query($query);

		/* ----------------------------------------------------------------------------
				HTML-STRUCTURE FOR POSTSFORM
		---------------------------------------------------------------------------- */
		?>
		<div class="whitebox col-sm-12 col-xs-12">

			<h1><?php if ( isset($_SESSION['msg']) ) { echo $_SESSION['msg']; unset($_SESSION['msg']); } else echo "Redigera ditt blogginlägg" ?></h1>
			<form method="POST" class="blogposts" action="editpost.php?editid=<?= $post->post_id; ?>">

				<!-- Heading -->
				<input type="text" name="blogpost_title" value="<?= $post->title; ?>">
				<br>

				<!-- Post text -->
				<textarea rows="15" cols="80" name="blogpost_text"><?= $post->text; ?></textarea>
				<br>

				<!---------------------------------------------------------------------
                	Looping out categories and the choosen one is selected 
                ----------------------------------------------------------------------> 
				<select name="category" class="categories">

					<?php while($cat = $cats->fetch_object()) : ?>
						<option<?= $cat->cat_id == $post->cat_id ? " selected" : null; ?> value="<?= $cat->cat_id; ?>">
							<?= $cat->cat_name; ?>
						</option>
					<?php endwhile; ?>

				</select> <!-- .category -->
				<br>

				<!-- Publish post button -->
				<input name="publish" class="btn btn-lg btn-primary btn-block" type="submit" value="Publicera redigering">

				<!-- Save as draft button -->
				<input name="draft" class="btn btn-lg btn-primary btn-block" type="submit" value="Spara redigering till utkast">
			</form> <!-- .blogposts -->
		</div> <!-- .whitebox col-sm-12 col-xs-12 -->
	</div> <!-- .page-content -->
<?php
require_once "code_end.php";
?>
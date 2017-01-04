<?php
require_once "code_open.php";
?>
<body class="statistics">
	<!-- start a wrapper -->
	<div class="page-content">
		<?php
		require_once "header.php";
		
		if (!isset($_SESSION["loggedin"])) {
	        header('Location: index.php');
	        die();
	    }
		?>
		
		<div class="whitebox col-xs-12">
			<h1 class="statistics">Statistik</h1>
			
			<?php
			/* ----------------------------------------------------------------------------
					STATISTICS - POSTS
					Count published posts
			---------------------------------------------------------------------------- */
			$query = "SELECT COUNT(*) AS count FROM posts WHERE is_published = 1 AND user_id = $userid";
			$result = $conn->query($query);
			echo mysqli_error($conn);
			$post = $conn->query($query)->fetch_object();

			if ($post->count >= 1) {
			echo '<div class="statistics-count">Du har skrivit '. $post->count . ' inlägg.<br></div>';
			} else {
				echo "<p>Du har inga inlägg</p>";
				die();
			}

			/* ----------------------------------------------------------------------------
					STATISTICS - COMMENTS
					Count comments on posts
			---------------------------------------------------------------------------- */
			$query = "SELECT COUNT(*) AS count, posts.post_id FROM comments LEFT JOIN posts ON posts.post_id = comments.fk_post_id WHERE is_published = 1 AND user_id = $userid";
			$comment = $conn->query($query)->fetch_object();

			echo '<div class="statistics-count">Du har '. $comment->count . ' kommentarer.<br></div>';

			/* ----------------------------------------------------------------------------
					STATISTICS - COMMENTS/POSTS
					Divide comments/posts and round it to integear
			---------------------------------------------------------------------------- */
			$spare = $comment->count/$post->count;
			$step = 1;
			$nbr = round($spare * $step,-0.5) / $step;

			echo '<div class="statistics-count">Du har '. $nbr . ' kommentarer per inlägg.</div>';
			?>
		</div> <!-- .whitebox col-xs-12 -->
	</div> <!-- .page-content -->
<?php		
require_once "code_end.php";
?>
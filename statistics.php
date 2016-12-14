<?php
/* ----------------------------------------------------------------------------
		REQUIRED - the required statement takes all that exists in the 
		specfied file and copies it inte this file. 
---------------------------------------------------------------------------- */
require "header.php";
?>
<div class="statistics-bg">
	<div class="statistics-box col-xs-12">
		<h1 class="statistics">Statistik</h1>
		<?php
/* ----------------------------------------------------------------------------
			STATISTICS - statistics of posts and comments
---------------------------------------------------------------------------- */
/* ----------------------------------------------------------------------------
*	The query counts all from the table "posts", from the logged in user 
*	(user_id) and from the posts that are published (1). 
*	If the posts count is equal/more to 1 the number of posts prints. 
*	
*	The second query counts all from the table "comments" where the foreign 
*	key id is the same as the post id in the table "posts".    
*
*	$spare divides comments with posts and ... EJ KLAR!
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
		$query = "SELECT COUNT(*) AS count, posts.post_id FROM comments LEFT JOIN posts ON posts.post_id = comments.fk_post_id WHERE user_id = $userid";
		$comment = $conn->query($query)->fetch_object();

		echo '<div class="statistics-count">Du har '. $comment->count . ' kommentarer.<br></div>';

		$spare = $comment->count/$post->count;
		$step = 1;
		$nbr = round($spare * $step,-0.5) / $step;

		echo '<div class="statistics-count">Du har '. $nbr . ' kommentarer per inlägg.</div>';
		?>
	</div> <!-- .statistics-box.col-xs-12 --> 
</div> <!-- .statistics-bg --> 	
<?php
	require "footer.php";


	//detta kan man använda om man har en superuser som vill se vad alla användarna har för post count
	//SELECT user_id, count(*) as postcount_per_user FROM posts WHERE user_id in (SELECT user_id FROM users) GROUP BY user_id
?>
	
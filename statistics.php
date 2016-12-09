<div class="statistics-bg">
	
	<?php

	require "header.php";

	?>
	<div class="statistics-box col-xs-12">
	
	<h1 class="statistics">Statistik</h1>
	
	<?php

	// require_once 'dbconnect.php';
	$conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

	$query = "SELECT COUNT(*) AS count FROM posts WHERE user_id = $userid";
	$post = $conn->query($query)->fetch_object();

	echo '<div class="statistics-count">Du har skrivit '. $post->count . ' inlägg.<br></div>';


	//SELECT * FROM `comments` WHERE fk_post_id = 150

	$query = "SELECT COUNT(*) AS count, posts.post_id FROM comments LEFT JOIN posts ON posts.post_id = comments.fk_post_id WHERE user_id = $userid";
	$comment = $conn->query($query)->fetch_object();

	echo '<div class="statistics-count">Du har '. $comment->count . ' kommentarer.<br></div>';

	$spare = $comment->count/$post->count;
	$step = 1;
	$nbr = round($spare * $step,-0.5) / $step;

	echo '<div class="statistics-count">Du har '. $nbr . ' kommentarer per inlägg.</div>';

	// // räkna inlägg 
	// $NumberOfPosts = NULL;
	// $errorMessage = NULL;
	// // Fetching post row id from database
	// $query = "SELECT post_id FROM posts WHERE is_published = 1 AND user_id = '{$user_id}'";

	// if ($stmt->prepare($query)) {

	//     $stmt->execute();
	//     $stmt->bind_result($post_id);
	// } else {
	//     $errorMessage = "Något gick fel vid försök att hämta statistik";
	// }
	// // Counting number of posts id and sums it up
	// while (mysqli_stmt_fetch($stmt)) {

	//     $stmt->store_result();
	//     $NumberOfPosts++;
	// }
	// echo $NumberOfPosts . " inlägg";
	?>
	</div>
</div>	

<?php
	require "footer.php";
	//detta kan man använda om man har en superuser som vill se vad alla användarna har för post count

	//SELECT user_id, count(*) as postcount_per_user FROM posts WHERE user_id in (SELECT user_id FROM users) GROUP BY user_id
?>
	
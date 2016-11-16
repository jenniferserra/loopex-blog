<?php
require "header.php";

$stmt = $conn->stmt_init();

$query = "SELECT posts.*, users.firstname, users.lastname FROM posts LEFT JOIN users ON posts.fk_user_id = users.user_id";
// LEFT JOIN categories ON posts.fk_cat_id = categories.cat_id
if ( mysqli_query($conn, $query) ) {
	$stmt = $conn->stmt_init();
}
if($stmt->prepare($query)) {
	$stmt->execute();
	$stmt->bind_result($postId, $createTime, $editTime, $title, $text, $isPublished, $fkUserId, $fkCatId, $firstName, $lastName);
	
	while(mysqli_stmt_fetch($stmt)) {
        
//echo "$postId $createTime $editTime $title $text $isPublished $fkUserId $fkCatId $firstName $lastName";
?>

	<div class="blogpost">
		<h1><?php echo $title; ?></h1>
		<div class="text"><?php echo $text; ?></div>
		<div class="author">Written by:
			<?php
			echo "<a href='author.php?id=$fkUserId'>$firstName $lastName</a>";
            echo "<br>$createTime<br>$fkCatId";
			?>
			</div>
	</div>
	<?php	
	}		
}	


require "footer.php";
?>		

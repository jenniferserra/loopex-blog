<?php
require "header.php";

$stmt = $conn->stmt_init();

$query = "SELECT posts.*, users.firstname, users.lastname, categories.cat_name FROM posts
            LEFT JOIN users ON posts.user_id = users.user_id
            LEFT JOIN categories ON posts.cat_id = categories.cat_id
            ORDER BY create_time DESC";

if ( mysqli_query($conn, $query) ) {
}
if($stmt->prepare($query)) {
	$stmt->execute();
	$stmt->bind_result($postId, $createTime, $editTime, $title, $text, $isPublished, $userId, $catId, $firstName, $lastName, $catName);

	while(mysqli_stmt_fetch($stmt)) {

        // Only displaying drafts
        if(isset($isPublished) && $isPublished == FALSE) {
        ?>
        <div class="drafts">
            <h1><?php echo $title; ?></h1>
            <div class="date"><p><?php echo $createTime; ?></p></div>
            <input name="edit" class="btn btn-lg btn-primary btn-block" type="submit" value="Redigera utkast">
            <input name="delete" class="btn btn-lg btn-primary btn-block" type="submit" value="Radera utkast">
        </div>
        <?php
        }
	}		
}	
require "footer.php";
?>	
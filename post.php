<?php


//include "header.php";
include "dbconnect.php";

var_dump($_GET);

$stmt = $conn->stmt_init();

$query = "SELECT posts.*, users.firstname, users.lastname, categories.cat_name 
			FROM posts WHERE post_id='" . mysql_real_escape_string($_GET['id']) . "'
            LEFT JOIN users ON posts.user_id = users.user_id
            LEFT JOIN categories ON posts.cat_id = categories.cat_id
            ";

if ( mysqli_query($conn, $query) ) {
}
if($stmt->prepare($query)) {
	$stmt->execute();
	$stmt->bind_result($postId, $createTime, $editTime, $title, $text, $isPublished, $userId, $catId, $firstName, $lastName, $catName);

	while(mysqli_stmt_fetch($stmt)) {
		
	
	?>
        <div class="blogpost">
            <h1><?php echo $title; ?></h1>
            <div class="date"><p><?php echo $createTime; ?></p></div>
            <div class="text"><p><?php echo $text; ?></p></div>
            <div class="author"><p>Written by:
                <?php
                echo "<a href='author.php?id=$userId'>$firstName $lastName</p></a>";
                echo "<p>Kategori: $catName</p>";
                ?>
            </div>
            <div class="comments"> 
            <?php 
                echo "<a href='post.php?id=$postId'>";
                echo "(X) Kommentarer </a>"; 
            ?>
            </div>
        </div>
  
		<form method="POST" action="post.php">
			<h2>Kommentera</h2>
			<input type="name" name="comment_name"><br>
			<textarea rows="5" cols="30" name="blogpost_text"></textarea><br>
			<input type="text" name="comment_text"><br>
			<textarea rows="15" cols="80" name="blogpost_text"></textarea><br>
			<input name="publish" class="btn btn-lg btn-primary btn-block" type="submit" value="Publicera kommentar">
		</form>

      <?php   
	}
}
//}

include "footer.php";

?>
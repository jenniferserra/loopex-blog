<?php
require "header.php";
?>

<div class="banner"> </div>
<div class="col-md-2"></div> <div class="col-md-8">
    
<?php


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

        // Only displaying published posts
        if(isset($isPublished) && $isPublished == TRUE) {
        ?>
        <div class="blogpost">
            <h1><?php echo $title; ?></h1>
            <div class="date"><?php echo $createTime; ?></div>
            <div class="text"><?php echo $text; ?></div>
            <div class="author">Written by:
                <?php
                echo "<a href='author.php?id=$userId'>$firstName $lastName</a>";
                echo "<br>Kategori: $catName";
                ?>
                </div>
        </div>
        <?php
        }
	}		
}	


require "footer.php";
?>		

</div>
<div class="col-md-2"></div>

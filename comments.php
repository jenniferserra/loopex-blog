<?php
include "header.php";

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
        if(isset($isPublished) && $isPublished == TRUE && $_SESSION["user_id"] == $userId) {
        ?>
        <div class="blogpost_center">
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
                    echo "<a href='post.php?id=$postId' name='btn'>";
                    echo "(X) Kommentarer </a>"; 
                ?>
                </div>
                <div class="edit">
                <?php 
                if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] == TRUE && $_SESSION["user_id"] == $userId) {
                    echo "<a href='editpost.php?editid=$postId' name='btn'>";
                    
                    echo "Redigera </a>";
                }
                ?>
                </div>
            </div>
        </div>
        <?php
        }
        ?>
        <hr>
        <?php
            // Print comment 
            $stmt = $conn->stmt_init();

            $query  = "SELECT * FROM comments";

            if ( mysqli_query($conn, $query) ) {
            }
            if($stmt->prepare($query)) {
                $stmt->execute();
                $stmt->bind_result($com_id, $c_name, $createTime, $editTime, $c_text, $c_epost, $fk_post_id);
    
                while(mysqli_stmt_fetch($stmt)) {
                    if ($fk_post_id === $postId) {
                    ?> 
                    <div class="container">
						<div class="row">
							<div class="col-sm-4"></div>
							<div class="col-sm-4">
			                    <div class="blogpost border">
			                        <div class="text"><p><?php echo $c_text; ?></p></div>
			                        <div class="author"><p><?php echo $c_name . " " . $createTime; ?></p></div>
			                    </div>
                 			</div>
							<div class="col-sm-4"></div>
						</div>
					</div>
                    <?php
                    }
                }
            }
    }   
}   
include "footer.php";
?>
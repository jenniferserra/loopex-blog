<?php
include "header.php";
// include "dbconnect.php";

var_dump($_GET);

$stmt = $conn->stmt_init();

$query = "SELECT * FROM comments";
if (mysqli_query($conn, $query)) {
}
if($stmt->prepare($query)) {
    $stmt->execute();
    $stmt->bind_result($com_id, $create_time, $edit_time, $text, $email, $fk_post_id);

    while(mysqli_stmt_fetch($stmt)) {
          
            $userId = "posts.user_id = users.user_id";
            $postId = "posts.post_id";

            if ($postId) {
        ?>
        <div class="blogpost">
            <h1><?php echo $com_id; ?></h1>
            <div class="date"><p><?php echo $create_time; ?></p></div>
            <div class="text"><p><?php echo $text; ?></p></div>
            <div class="author"><p>Written by:
                <?php
                echo "<a href='author.php?id=$userId'>$fk_post_id</p></a>";
                ?>
            </div>
        </div>
        <?php
            } else {
                echo "funkar inte";
            }
        }
    }
include "footer.php";
?>
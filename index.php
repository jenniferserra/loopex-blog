<?php
require "header.php";
?>
<div class="banner"> </div>
<div class="col-md-2"></div> <div class="col-md-8">
<?php
$stmt = $conn->stmt_init();

$query = "SELECT posts.*, users.firstname, users.lastname, users.email, categories.cat_name FROM posts
            LEFT JOIN users ON posts.user_id = users.user_id
            LEFT JOIN categories ON posts.cat_id = categories.cat_id
            ORDER BY create_time DESC";

if ( mysqli_query($conn, $query) ) {
}
if($stmt->prepare($query)) {
    $stmt->execute();
    $stmt->bind_result($postId, $createTime, $editTime, $title, $text, $isPublished, $userId, $catId, $firstName, $lastName, $user_email, $catName);

    while(mysqli_stmt_fetch($stmt)) {

        // Only displaying published posts
        if(isset($isPublished) && $isPublished == TRUE) {

        ?>
        <div class="blogpost_center">
            <div class="blogpost">
                <h1><?php echo $title; ?></h1>
                <div class="date"><p><?php echo $createTime; ?></p></div>
                <div class="text"><p><?php echo $text; ?></p></div>
                <div class="text"><p><?php echo "<p>Kategori: $catName</p>"; ?></p></div>
                <div class="author"><p>Skriven av:
                    <?php
                    echo "<a href='author.php?id=$userId'>$firstName $lastName</p></a>";
                    echo "<p><a href='mailto:$user_email'>$user_email</a></p>";
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
                if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] == TRUE && $_SESSION["user_id"] == $userId || $_SESSION["role"] == "admin") {
                    echo "<a href='editpost.php?editid=$postId' name='btn'>";

                    echo "Redigera </a>";
                }
                ?>
                </div>
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

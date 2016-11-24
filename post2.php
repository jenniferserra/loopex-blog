<!-- #################################### 
# I denna filen ligger lite övrig kod ! # 
# Ingenting är kopplat till någonting   #
# / frida                               #
##################################### -->

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


// från comments.php

<hr>
<?php
// Print comment 
$stmt = $conn->stmt_init();

$query  = "SELECT * FROM comments";

if ( mysqli_query($conn, $query) ) {
}
if($stmt->prepare($query)) {
    $stmt->execute();
    $stmt->bind_result($com_id, $c_name, $c_url, $createTime, $editTime, $c_text, $c_epost, $fk_post_id);

    while(mysqli_stmt_fetch($stmt)) {
        if ($fk_post_id === $postId) {
        ?> 
        <div class="container">
            <div class="row">
                <div class="col-sm-4"><a href="comments.php?delete=<?php echo $postId; ?>&sort=<?php echo $sort; ?>"><i class="fa fa-trash"></i></a></div>
                <div class="col-sm-4"> 
                    <div class="blogpost border">
                    <div class="text"><p><?php echo $c_text; ?></p></div>
                    <div class="author">
                        <p><?php echo $c_name . " " . $createTime; ?></p>
                        <p><a href="http://<?php echo $c_url; ?>"><?php echo $c_url; ?></a></p>
                    </div>
                </div>
                </div>
                <div class="col-sm-4"></div>
            </div>
        </div>
        <?php
        }
    }
} 

?>

<a href="comments.php?delete=<?php echo $postId; ?>"><i class="fa fa-trash"></i></a>


<hr>
        <?php
        // Print comment 
        $stmt = $conn->stmt_init();

        $query  = "SELECT * FROM comments";

        if ( mysqli_query($conn, $query) ) {
        }
        if($stmt->prepare($query)) {
            $stmt->execute();
            $stmt->bind_result($com_id, $c_name, $c_url, $createTime, $editTime, $c_text, $c_epost, $fk_post_id);

            while(mysqli_stmt_fetch($stmt)) {
                if ($fk_post_id === $postId) {
                ?> 
                <div class="container">
                    <div class="row">
                        <div class="col-sm-4"></div>
                        <div class="col-sm-4">
                            <div class="blogpost border">
                            <div class="text"><p><?php echo $c_text; ?></p></div>
                            <div class="author">
                                <p><?php echo $c_name . " " . $createTime; ?></p>
                                <p><a href="http://<?php echo $c_url; ?>"><?php echo $c_url; ?></a></p>
                            </div>
                        </div>
                        </div>
                        <div class="col-sm-4"></div>
                    </div>
                </div>
                <?php
                }
            }
        }
SELECT posts.*, comments.*, users.firstname, users.lastname, categories.cat_name FROM posts 
            LEFT JOIN comments ON comments.fk_post_id = posts.post_id 
            LEFT JOIN users ON posts.user_id = users.user_id
            LEFT JOIN categories ON posts.cat_id = categories.cat_id
            ORDER BY create_time DESC


$query = "SELECT posts.*, comments.*, users.firstname, users.lastname, categories.cat_name FROM posts 
            LEFT JOIN comments ON comments.fk_post_id = posts.post_id 
            LEFT JOIN users ON posts.user_id = users.user_id
            LEFT JOIN categories ON posts.cat_id = categories.cat_id";
<?php
require "header.php";
$stmt = $conn->stmt_init();

$query = "SELECT posts.*, users.firstname, users.lastname, categories.cat_name FROM posts
            LEFT JOIN users ON posts.user_id = users.user_id
            LEFT JOIN categories ON posts.cat_id = categories.cat_id
            ORDER BY create_time DESC";

if (mysqli_query($conn, $query)) {
}
if ($stmt->prepare($query)) {
    $stmt->execute();
    $stmt->bind_result($postId, $createTime, $editTime, $title, $text, $isPublished, $userId, $catId, $firstName, $lastName, $catName); ?>

              <h1>Välj ett utkast att redigera</h1>
              <?php
              /* Start printing unpublished posts */
              while (mysqli_stmt_fetch($stmt)) {

                  if (isset($isPublished) && $isPublished == false && $userId == $_SESSION["user_id"]) {
                      ?>


                <div class="form-check">
                    <div id="<?=$postId?>">

                      <?php echo "$title " . "<em>$createTime</em>"; ?>

                      <!-- Link to edit post -->
                      <a href="editpost.php?editid=<?php echo $postId ?>" class="btn btn-sm btn-primary">
                      Redigera
                      </a>
                      <!-- Link to delete post -->
                      <a href="drafts.php?delete=<?=$postId?>" class="btn btn-sm btn-primary">
                      Radera
´                     </a>
                </div>

                    <?php

                  }
              }
            /* end print */

            /* delete from database if get-request is sent */
            if (isset($_GET["delete"])) {

                $deletePost = $_GET["delete"];
                $deleteQuery = "DELETE FROM posts
                                WHERE post_id = '{$deletePost}'";
                mysqli_query($conn, $deleteQuery);
                header("Location:drafts.php");
            }
}

require "footer.php";
?>

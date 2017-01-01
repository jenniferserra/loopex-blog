<?php
require_once "code_open.php";
?>
<body class="drafts">
    <!-- start a wrapper -->
    <div class="page-content">
    <?php
    require_once "header.php";

    if (!isset($_SESSION["loggedin"])) {
        header('Location: index.php');
        die();
    }

    /* delete from database if get-request is sent */
    if (isset($_GET["delete"])) {

        $deletePost = $_GET["delete"];
        $deleteQuery = "DELETE FROM posts
                        WHERE post_id = '{$deletePost}'";
        mysqli_query($conn, $deleteQuery);
    }
    $stmt = $conn->stmt_init();

    $query = "SELECT posts.*, users.firstname, users.lastname, categories.cat_name 
            FROM posts
            LEFT JOIN users ON posts.user_id = users.user_id
            LEFT JOIN categories ON posts.cat_id = categories.cat_id
            ORDER BY create_time DESC";

    if (mysqli_query($conn, $query)) {
    }

    if ($stmt->prepare($query)) {
        $stmt->execute();
        $stmt->bind_result($postId, $createTime, $editTime, $title, $text, $isPublished, $userId, $catId, $firstName, $lastName, $catName); ?>

        <div class="whitebox">
            <h1>Välj ett utkast att redigera</h1>
            <?php
            /* Start printing unpublished posts */
            while (mysqli_stmt_fetch($stmt)) {

                if (isset($isPublished) && $isPublished == false && $userId == $_SESSION["user_id"]) {
                ?>
                    <div class="form-check">
                        <!-- Post title -->
                        <div id="<?=$postId?>">
                        <?php echo "<p class='highlighted-text'>$title </p>" . "<p class='date'> ($createTime)</p>"; ?>
                            <!-- Link to edit post -->
                            <a href="editpost.php?editid=<?php echo $postId?>">
                                <i class="fa fa-pencil" aria-hidden="true"></i>
                            </a>
                            <!-- Link to delete post -->
                            <a href="drafts.php?delete=<?=$postId?>">
                                <i class="fa fa-trash" aria-hidden="true"></i>
                            </a>
                        </div>
                       <hr class="divider">
                    </div>
                <?php
                }
            }
            ?>
        </div>
        <?php
    /* end print */
    }
include "footer.php";
?>
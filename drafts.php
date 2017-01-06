<?php
require_once "code_open.php";
?>
<body class="drafts">
    <!-- start a wrapper -->
    <div class="page-content">

        <div class="whitebox">
            <h1>Välj ett utkast att redigera</h1>

            <?php
            require_once "header.php";

            if (!isset($_SESSION["loggedin"])) {
                header('Location: index.php');
                die();
            }

            /* ----------------------------------------------------------------------------
                    DELETE A POST FROM DRAFTS
            ---------------------------------------------------------------------------- */
            if (isset($_GET["delete"])) {

                $deletePost = $_GET["delete"];
                $deleteQuery = "DELETE FROM posts
                                WHERE post_id = '{$deletePost}'";
                mysqli_query($conn, $deleteQuery);
            }

            $sqlAllPosts = "SELECT posts.*, users.firstname, users.lastname, categories.cat_name
                          	FROM posts
                          	LEFT JOIN users ON posts.user_id = users.user_id
                          	LEFT JOIN categories ON posts.cat_id = categories.cat_id
                          	ORDER BY create_time DESC";

            $queryAllPosts = mysqli_query($conn, $sqlAllPosts);

            while($getPost = mysqli_fetch_array($queryAllPosts, MYSQLI_ASSOC)) {
                $postId = $getPost["post_id"];
                $createTime = $getPost["create_time"];
                $title = $getPost["title"];
                $text = $getPost["text"];
                $isPublished = $getPost["is_published"];
                $userId = $getPost["user_id"];
                $catId = $getPost["cat_id"];

                /* ----------------------------------------------------------------------------
                      PRINT POSTS
                ---------------------------------------------------------------------------- */

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
                    </div> <!-- .form-check -->
                <?php
                }
            }
            ?>
        </div> <!-- .whitebox -->
    </div> <!-- .page-content -->
<?php
require_once "code_end.php";
?>

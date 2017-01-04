<?php
require_once "code_open.php";
?>
<body class="post">
    <!-- start a wrapper -->
    <div class="page-content">
        <?php
        require_once "header.php";

        /* ----------------------------------------------------------------------------
            INSERT COMMENT TO DATABASE
        ---------------------------------------------------------------------------- */
        if(isset($_POST["publish"])) {

            if( !empty($_POST["comment_name"]) &&
                !empty($_POST["comment_epost"]) &&
                !empty($_POST["comment_text"])) {

                // Preparing the statement
                $stmt = $conn->stmt_init();

                // Stripping off harmful characters
                $c_name = mysqli_real_escape_string($conn, $_POST["comment_name"]);
                $c_epost = mysqli_real_escape_string($conn, $_POST["comment_epost"]);
                $c_text = mysqli_real_escape_string($conn, $_POST["comment_text"]);

                $timeStamp = date("Y-m-d H:i:s");

                if (filter_var($c_epost, FILTER_VALIDATE_EMAIL) === false) {
                    echo "Ogiltig e-post.";
                    exit;
                }

                $fk_post_id = $_GET['id'];
                // Upload post into database. Published = TRUE
                $query = "INSERT INTO comments VALUES ('','{$c_name}', '{$c_epost}', '{$timeStamp}', '{$c_text}', '{$fk_post_id}')";
                // header("Refresh:0");
                if ( mysqli_query($conn, $query)) {
                    $_SESSION['msg'] = "Du har kommenterat inlägget!";
                } else {
                    $_SESSION['msg'] = "<span class='error'>Error: </span>Någonting fick fel, testa igen!";
                }
            } else {
                $_SESSION['msg'] = "<span class='error'>Error: </span>Fyll i alla fält och testa igen!";
            }
        }

        $stmt = $conn->stmt_init();
        /* ----------------------------------------------------------------------------
                PRINT POST
        ---------------------------------------------------------------------------- */
        $query  = "SELECT posts.*, users.firstname, users.lastname, categories.cat_name ";
        $query .= "FROM posts ";
        $query .= "LEFT JOIN users ON posts.user_id = users.user_id ";
        $query .= "LEFT JOIN categories ON posts.cat_id = categories.cat_id ";
        $query .= "WHERE post_id = ";
        $query .= $_GET['id'];

        if ( mysqli_query($conn, $query) ) {
        }

        if($stmt->prepare($query)) {
        	$stmt->execute();
        	$stmt->bind_result($postId, $createTime, $editTime, $title, $text, $isPublished, $userId, $catId, $firstName, $lastName, $catName);

        	while(mysqli_stmt_fetch($stmt)) {
        	?>
                <div class="whitebox col-sm-12 col-xs-12">
                    <div class="blogpost mobile-margin">
                        <h1 class="blog-text-center"><?php echo $title; ?></h1>
                        <div class="date blog-text-center">
                            <p><?php echo $createTime; ?></p>
                        </div>
                        <br>
                        <div>
                            <p><?php echo $text; ?></p>
                        </div>
                        <br>
                        <br>
                        <div class="right-align">
                            <span class="highlighted-text">Skrivet av:</span> <?php echo "$firstName $lastName<br>";?>
                            <span class='highlighted-text'>Kategori:</span> <?php echo "$catName";?>
                        </div> <!-- .right-align -->
                    </div> <!-- . blogpost divider mobile-margin -->

                    <?php
                    /* ----------------------------------------------------------------------------
                            PRINT COMMENTS TO POST
                    ---------------------------------------------------------------------------- */
                    $stmt = $conn->stmt_init();

                    $query  = "SELECT * FROM comments WHERE fk_post_id = $postId";

                    if ( mysqli_query($conn, $query) ) {
                    }
                    if($stmt->prepare($query)) {
                        $stmt->execute();
            			$stmt->bind_result($com_id, $c_name, $c_epost, $createTime, $c_text, $fk_post_id);

                        while(mysqli_stmt_fetch($stmt)) {
                            ?>
                            <div class="blogpost posted-comments mobile-margin">
                                <hr>
                              		<div>
                                        <?php echo "<span class='highlighted-text'> $c_name </span>
                                                    <a href='mailto:$c_epost'>$c_epost</a>
                                        "; ?>
                                    </div>
                                    <?php echo $createTime; ?>
                                    <div>
                                        <p><?php echo $c_text; ?></p><br>
            						</div>
                                <br>
                            </div> <!-- .blogpost posted-comments mobile-margin -->
                        <?php
                        }
                    }
                    /* ----------------------------------------------------------------------------
                            COMMENT A POST
                    ---------------------------------------------------------------------------- */
                    ?>

                </div> <!-- .whitebox col-sm-12 col-xs-12 -->
                
                <div class="whitebox col-sm-12 col-xs-12">
                    <div class="comments_to_post mobile-margin">
                        <h3><?php if ( isset($_SESSION['msg']) ) { echo $_SESSION['msg']; unset($_SESSION['msg']); } else echo "Kommentera" ?></h3>
                		<form method="POST">
                            <input type="text" placeholder="Namn" name="comment_name"><br>
                            <input type="email" placeholder="E-post" name="comment_epost"><br>
                			<textarea rows="5" cols="30" placeholder="Kommentar" name="comment_text"></textarea><br>
                			<input name="publish" class="btn btn-lg btn-primary btn-block" type="submit" value="Publicera kommentar">
                		</form>
                    </div> <!-- .comments_to_post mobile-margin -->
                </div> <!-- .whitebox col-sm-12 col-xs-12 -->
            <?php
            }
        }
        ?>
    </div> <!-- .page-content -->
<?php
include "footer.php";
require_once "code_end.php";
?>
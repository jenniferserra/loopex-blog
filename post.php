<?php
require "header.php";

?>

<!-- BANNER IMAGE -->
    <div class="banner col-md-12 col-xs-12">
    </div>

<?php

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


		<div class="blogpost-box divider">
            <div class="blogpost divider mobile-margin">
            <h1 class="blog-text-center"><?php echo $title; ?></h1>
            <div class="date blog-text-center"><p><?php echo $createTime; ?></p></div><br>
            <div class="text"><p><?php echo $text; ?></p></div><br>
            <div class="right-align"><span class="bold">Skrivet av:
                <?php
                echo "<a href='author.php?id=$userId'>$firstName $lastName</p></a><br>";
                echo "<span class='bold'>Kategori:</span>$catName";
                ?>
            </div>
        </div>
       
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

                    <div class="blogpost posted-comments mobile-margin"><hr>

                      		<div class="author">
                                <p><?php echo "<span class='bold'> $c_name ($createTime)"; ?></p>
                              <!--  <p class="comment-email"><a href="mailto:<?php echo $c_epost; ?>"><?php echo $c_epost; ?></a></p>-->
                            </div>
                            <div class="text">
	                            <p><?php echo $c_text; ?></p><br> 
							</div>

                        
                        <br>
                    </div>
                <?php
                }
            }
        ?>
        <!-- *********************************************************************
                COMMENT A POST
        ********************************************************************* -->
        <hr>
        <div class="comments_to_post mobile-margin">
            <h3>Kommentera</h3>
    		<form method="POST">
                <input type="text" placeholder="Namn" name="comment_name"><br>
                <input type="email" placeholder="E-post" name="comment_epost"><br>
    			<textarea rows="5" cols="30" placeholder="Kommentar" name="comment_text"></textarea><br>
    			<input name="publish" class="btn btn-lg btn-primary btn-block" type="submit" value="Publicera kommentar">
    		</form>
        </div>
    <?php
    }
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
                echo "Ditt inlägg är sparat i databasen";
                header("Refresh:0");
            }   else {
                echo "Inlägget är inte sparat i databasen";
                }
        } else { echo "Du har inte fyllt i alla fält eller valt kategori"; }
    }
}
include "footer.php";
?>

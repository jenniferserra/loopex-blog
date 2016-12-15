<?php
require "header.php";

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
        </div>
        <hr>
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
                    <div class="blogpost">
                        <div class="text">
                            <p><?php echo $c_text; ?></p>
                            <p><?php echo $c_name . " " . $createTime; ?></p>
                        </div>
                        <div class="author">
                            <p><a href="mailto:<?php echo $c_epost; ?>"><?php echo $c_epost; ?></a></p>
                        </div>
                        <br>
                    </div>
                <?php
                }
            }
        ?>
        <!-- --------------------------------------------------------------------------
                COMMENT A POST
        --------------------------------------------------------------------------- -->
        <hr>
        <div class="comments_to_post">
            <h3>Kommentera</h3>
    		<form method="POST">
    			<p>Namn</p>
                <input type="text" name="comment_name"><br>
                <p>E-post</p>
                <input type="email" name="comment_epost"><br>
                <p>Kommentar</p>
    			<textarea rows="5" cols="30" name="comment_text"></textarea><br>
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

<?php
include "header.php";
// include "dbconnect.php";

$stmt = $conn->stmt_init();

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
        <div class="comments_to_post">
            <h2>Kommentarer</h2>
    		<form method="POST" action="post.php?id=140">
    			<p>Namn</p>
                <input type="text" name="comment_name"><br>
                <p>E-post</p>
                <input type="text" name="comment_epost"><br>
                <p>Kommentar</p>
    			<textarea rows="5" cols="30" name="comment_text"></textarea><br>
    			<input name="publish" class="btn btn-lg btn-primary btn-block" type="submit" value="Publicera kommentar">
    		</form>
        </div>
    <?php
    }
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

            // Upload post into database. Published = TRUE
            $query = "INSERT INTO comments VALUES ('', '{$timeStamp}', '', '{$c_text}', '{$c_epost}', '')";
            // header("Refresh:0");
            if ( mysqli_query($conn, $query)) {
                    echo "Ditt inlägg är sparat i databasen";
            } else {echo "Inlägget är inte sparat i databasen";}
        } else { echo "Du har inte fyllt i alla fält eller valt kategori"; } 
    }
    ?>
     <div class="blogpost">
        <h1><?php echo $c_name; ?></h1>
        <div class="date"><p><?php echo $c_epost; ?></p></div>
        <div class="text"><p><?php echo $c_text; ?></p></div>
        <div class="author"><p>Written by:
        </div>
    </div>
<?php
}
include "footer.php";
?>
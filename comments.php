<?php
include "header.php";
echo $firstname;
$stmt = $conn->stmt_init();

$query  = "SELECT posts.*, users.firstname, users.lastname, categories.cat_name ";
$query .= "FROM posts ";
$query .= "LEFT JOIN users ON posts.user_id = users.user_id ";
$query .= "LEFT JOIN categories ON posts.cat_id = categories.cat_id ";
$query .= "WHERE users.user_id =";
$query .= $userid;
if (mysqli_query($conn, $query)) {
}
if($stmt->prepare($query)) {
	$stmt->execute();
	$stmt->bind_result($postId, $createTime, $editTime, $title, $text, $isPublished, $userId, $catId, $firstName, $lastName, $catName);
	$myPostDataArray = array();
	while($stmt->fetch()) {

		$myPostDataArray[] = array('postId' => $postId, 'createTime' => $createTime, 'editTime' => $editTime, 'title' => $title, 'text' => $text, 'isPublished' => $isPublished, 'userId' => $userId, 'catId' => $catId, 'firstName' => $firstName, 'lastName' => $lastName, 'catName' => $catName);
	}
}	
foreach ($myPostDataArray as $post) {
?>
    <div class="blogpost">
        <h1><?php echo $post['title']; ?></h1>
        <div class="date"><p><?php echo $post['createTime']; ?></p></div>
        <div class="text"><p><?php echo $post['text']; ?></p></div>
        <div class="author"><p>Written by:
            <?php
            echo $post['firstName']; 
            ?>
        </div>
    </div>
    <hr>
    <?php
        // Print comment
    	//
    	// TO-DO, change stmt2 to stmt???
    	// and query2 to query????
        $stmt2 = $conn->stmt_init();

        $query2  = "SELECT * FROM comments WHERE fk_post_id = {$post['postId']}";

        if (mysqli_query($conn, $query2)) {
        }
        if($stmt2->prepare($query2)) {
            $stmt2->execute();
            $stmt2->bind_result($com_id, $c_name, $c_url, $createTime, $editTime, $c_text, $c_epost, $fk_post_id);

            while($stmt2->fetch()) {
            ?>
				<div class="blogpost">
				<div class="text"><p><?php echo $c_text; ?></p></div>
				<div class="author">
				    <p><?php echo $c_name . " " . $createTime; ?></p>
				    <p><?php echo $c_url; ?></p>
				</div>
				</div>
            <?php
            }
        }
        ?>
    <hr>
<?php
}      
include "footer.php";
?>
<?php
include "header.php";
echo $firstname;
/**
* if "delete" is set.
* $query, is to delete the specific item from tasks where the id is the $taskToDelete.
* prepares if the query is correct.
* $stmt, the prepared statement executes.
**/
if (isset($_GET["delete"])) {
	$taskToDelete = $_GET["delete"];
	$query = "DELETE FROM comments WHERE com_id = '{$taskToDelete}'";

	if ($stmt->prepare($query)) {
		$stmt->execute();
	}
}
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

    <table>
    <?php
        // Print comment
    	//
    	// TO-DO, change stmt2 to stmt???
    	// and query2 to query????
        $stmt2 = $conn->stmt_init();

        $query2  = "SELECT * FROM comments WHERE fk_post_id = {$post['postId']}
        ORDER BY create_time DESC";

        if (mysqli_query($conn, $query2)) {
        }
        if($stmt2->prepare($query2)) {
            $stmt2->execute();
            $stmt2->bind_result($com_id, $c_name, $c_epost, $createTime, $c_text, $fk_post_id);

            while($stmt2->fetch()) {
            ?><tr style="border: solid 1px;">
            	<td style="border: solid 1px;"><a href="comments.php?delete=<?php echo $com_id; ?>">Radera</a></td>
				<div class="blogpost">
				<td style="border: solid 1px;">
					<div class="author">
						<p>
							<?php echo $c_name?> kommenterade <?php echo $post['title']; ?>
						<?php echo $c_name?>
						</p>
					</div>
					<div class="text"><p><?php echo $c_text; ?></p></div>
				</td>
				</div>
            <?php
            }
        }
        ?>
        </tr>
        </table>
<?php
}
include "footer.php";
?>

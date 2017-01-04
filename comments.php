<?php
require_once "code_open.php";
?>
<body class="comments">
	<!-- start a wrapper -->
	<div class="page-content">
		<?php
		require_once "header.php";

		if (!isset($_SESSION["loggedin"])) {
	        header('Location: index.php');
	        die();
	    }

	    /* ----------------------------------------------------------------------------
				DELETE A COMMENT
		---------------------------------------------------------------------------- */
		if (isset($_GET["delete"])) {
			$taskToDelete = $_GET["delete"];
			$query = "DELETE FROM comments WHERE com_id = '{$taskToDelete}'";

		    $stmt = $conn->stmt_init();
			if ($stmt->prepare($query)) {
				$stmt->execute();
			}
		    $stmt->close();
		}
		$stmt = $conn->stmt_init();
		?>

	 	<!-- start of whitebox -->
		<div class="whitebox col-sm-12 col-xs-12">
			<h1>Kommentarer</h1>
			<?php
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

			/* ----------------------------------------------------------------------------
					PRINT COMMENTS
			---------------------------------------------------------------------------- */
			foreach ($myPostDataArray as $post) {

		        $stmt2 = $conn->stmt_init();

		        $query2  = "SELECT * FROM comments WHERE fk_post_id = {$post['postId']}
		        ORDER BY create_time DESC";

		        $result = mysqli_query($conn, $query2);

		        if($stmt2->prepare($query2)) {
		            $stmt2->execute();
		            $stmt2->bind_result($com_id, $c_name, $c_epost, $createTime, $c_text, $fk_post_id);


		          	while($stmt2->fetch()) { ?>

						<p>
							<span class='highlighted-text'><?php echo $c_name;?></span> kommenterade inlägget:
							<span class="highlighted-text"><?php echo $post['title'];?></span>
							<a href="comments.php?delete=<?php echo $com_id;?>">
								<i class="fa fa-trash" aria-hidden="true"></i>
							</a>
						</p>
						<br>
						<p><?php echo $c_text;?></p>
						<hr class="divider">
		            <?php
		          	}
		        }
		        $stmt2->close();
			}
			?>
		</div> <!-- .whitebox -->
	</div> <!-- .page-content -->
	<?php
	$stmt->close();
require_once "code_end.php";
?>
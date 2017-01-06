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

			$sqlGetPost  = "SELECT posts.*, users.firstname, users.lastname, categories.cat_name ";
			$sqlGetPost .= "FROM posts ";
			$sqlGetPost .= "LEFT JOIN users ON posts.user_id = users.user_id ";
			$sqlGetPost .= "LEFT JOIN categories ON posts.cat_id = categories.cat_id ";
			$sqlGetPost .= "WHERE users.user_id =";
			$sqlGetPost .= $userid;


			$queryGetPost = mysqli_query($conn, $sqlGetPost);

			while($getPostCommentUser = mysqli_fetch_array($queryGetPost, MYSQLI_ASSOC)) {

			      $postId = $getPostCommentUser["post_id"];
			      $createTime = $getPostCommentUser["create_time"];
						$editTime = $getPostCommentUser["edit_time"];
			      $title = $getPostCommentUser["title"];
			      $text = $getPostCommentUser["text"];
			      $isPublished = $getPostCommentUser["is_published"];
			      $userId = $getPostCommentUser["user_id"];
			      $catId = $getPostCommentUser["cat_id"];
						$catName = $getPostCommentUser["cat_name"];
						$lastName = $getPostCommentUser["lastname"];
						$firstName = $getPostCommentUser["firstname"];

						$myPostDataArray[] = array(

						'postId' => $postId,
						'createTime' => $createTime,
						'editTime' => $editTime,
						'title' => $title,
						'text' => $text,
						'isPublished' => $isPublished,
						'userId' => $userId,
						'catId' => $catId,
						'firstName' => $firstName,
						'lastName' => $lastName,
						'catName' => $catName

						);

						/* ----------------------------------------------------------------------------
								PRINT COMMENTS
						---------------------------------------------------------------------------- */

						foreach ($myPostDataArray as $post) {


									$sqlGetCommentsDesc  = "SELECT * FROM comments WHERE fk_post_id = {$post['postId']}
									ORDER BY create_time DESC";

									$queryGetCommentsDesc = mysqli_query($conn, $sqlGetCommentsDesc);

									while($getComment = mysqli_fetch_array($queryGetCommentsDesc, MYSQLI_ASSOC)) {
												$comId = $getComment["com_id"];
												$comName = $getComment["name"];
												$comEmail = $getComment["email"];
												$createTime = $getComment["create_time"];
												$comText = $getComment["text"];
												$postId = $getComment["fk_post_id"];

												?>

												<p>
													<span class='highlighted-text'><?php echo $comName;?></span> kommenterade inlägget:
													<span class="highlighted-text"><?php echo $post['title'];?></span>
													<a href="comments.php?delete=<?php echo $comId;?>">
														<i class="fa fa-trash" aria-hidden="true"></i>
													</a>
												</p>
												<br>
												<p><?php echo $comText;?></p>
												<hr class="divider">
						<?php
								}
							}
						}
						?>





		</div> <!-- .whitebox -->
	</div> <!-- .page-content -->
	<?php
require_once "code_end.php";
?>

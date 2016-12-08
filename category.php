<?php
require "header.php";
?>
<div class="sort_list">
	<h3>Sort:</h3>
	<a title="Sort by name" href="list.php?sort=name"><i class="fa fa-sort-alpha-asc"></i></a>
	<a title="Sort by number asc" href="category.php?sort=asc"><i class="fa fa-sort-numeric-asc"></i></a>
	<a title="Sort by number desc" href="category.php?sort=desc"><i class="fa fa-sort-numeric-desc"></i></a>
</div> <!-- .sort_list -->

<?php

$sort = "";
if (isset($_GET["sort"])) {
	$sort = $_GET["sort"];
}

//Exempel om vi använder switch:
// switch ($sort) { // SWITCH-sats för sortering, lättläst och elegant!
//
// 	case "name":
// 	$query = "SELECT * FROM posts ORDER BY title";
// 	break;
//
// 	case "asc":
// 	$query = "SELECT * FROM posts ORDER BY prio ASC";
// 	break;
//
// 	case "desc":
// 	$query = "SELECT * FROM posts ORDER BY prio DESC";
// 	break;
//
// 	default:
// 	$query = "SELECT * FROM posts";
// 	break;
// }


$sort = "";
if (isset($_GET["sort"])) {
	$sort = $_GET["sort"];
}
if($sort == "name") {
	$query = "SELECT * FROM posts ORDER BY title";
}
else if($sort == "asc") {
	$query = "SELECT * FROM posts ORDER BY priority ASC";
}
else if($sort == "desc") {
	$query = "SELECT * FROM posts ORDER BY priority DESC";
}

$stmt = $conn->stmt_init();

$query = "SELECT posts.*, users.firstname, users.lastname, users.email, categories.cat_name FROM posts
            LEFT JOIN users ON posts.user_id = users.user_id
            LEFT JOIN categories ON posts.cat_id = categories.cat_id";

if ( mysqli_query($conn, $query) ) {
}
if($stmt->prepare($query)) {
    $stmt->execute();
    $stmt->bind_result($postId, $createTime, $editTime, $title, $text, $isPublished, $userId, $catId, $firstName, $lastName, $user_email, $catName);

    while(mysqli_stmt_fetch($stmt)) {

        // Only displaying published posts
        if(isset($isPublished) && $isPublished == TRUE) {

        ?>
        <div class="blogpost_center">
            <div class="blogpost">
                <h1><?php echo $title; ?></h1>
                <div class="date" name="priority"><p><?php echo $createTime; ?></p></div>
                <div class="text"><p><?php echo $text; ?></p></div>
                <div class="text"><p><?php echo "<p>Kategori: $catName</p>"; ?></p></div>
                <div class="author"><p>Skriven av:
                    <?php
                    echo "<a href='author.php?id=$userId'>$firstName $lastName</p></a>";
                    echo "<p><a href='mailto:$user_email'>$user_email</a></p>";
                    ?>
                </div>
                <div class="comments">
                <?php
                    echo "<a href='post.php?id=$postId' name='btn'>";
                    echo "(X) Kommentarer </a>";
                ?>
                </div>
                <div class="edit">
                <?php
                if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] == TRUE && $_SESSION["user_id"] == $userId) {
                    echo "<a href='editpost.php?editid=$postId' name='btn'>";

                    echo "Redigera </a>";
                }
                ?>
                </div>
            </div>
        </div>
        <?php
        }
    }
}
require "footer.php";
?>

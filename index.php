<?php
require "header.php";
?>
    <div class="banner"> </div>
    <div class="col-md-3"></div> <div class="col-md-6">
<?php

//-----------------------------------------------------------------------------
// Pagination start
//-----------------------------------------------------------------------------

$sql = "SELECT posts.*, users.firstname, users.lastname, users.email, categories.cat_name FROM posts
            LEFT JOIN users ON posts.user_id = users.user_id
            LEFT JOIN categories ON posts.cat_id = categories.cat_id
            WHERE is_published = TRUE
            ORDER BY create_time DESC";

$query = mysqli_query($conn, $sql);

$post = mysqli_fetch_row($query);
$posts = $post[0];
$postsPerPage = 5;

// Tells the page nr of the very last page ("ceil" rounds numbers up)
$last = ceil($posts/$postsPerPage);
$first = 1;

// Makes sure that last page cannot be less than 1
if ($last < 1) {
    $last = 1;
}

// If no page-number URL-variables are available
$pageNumber = 1;

// Replacing pagenumber in url
if(isset($_GET['pn'])) {
    $pageNumber = preg_replace('#[^0-9]#', '', $_GET['pn']);
}

// Page number must be more than 1 and cannot be more than last page
if($pageNumber < 1) {
    $pageNumber = 1;
} elseif ($pageNumber > $last) {
    $pageNumber = $last;
}

// Query for a limited amount of posts
$limit = 'LIMIT ' .($pageNumber - 1) * $postsPerPage .',' . $postsPerPage;

$sql = "SELECT posts.*, users.firstname, users.lastname, users.email, categories.cat_name FROM posts
        LEFT JOIN users ON posts.user_id = users.user_id
        LEFT JOIN categories ON posts.cat_id = categories.cat_id
        WHERE is_published = TRUE
        ORDER BY create_time DESC $limit";

$query = mysqli_query($conn, $sql);


// Establishing the $paginationCtrls variable
$paginationCtrls = '';

// If there is more than one page of results
if ($last !=1) {
    if ($pageNumber > 1) {
        $previous = $pageNumber - 1;
        $fillNumbersBehind = -3;
        $jumpBackward = $pageNumber - 3;

        if ($pageNumber >= $last - 3){
            $fillNumbersBehind = $pageNumber - $last;
            $jumpBackward = $pageNumber - 6 - $fillNumbersBehind;
        }

        // Previous-button and long-backward-jump
        $paginationCtrls .= '<a href="' .$_SERVER['PHP_SELF'] . '?pn=' . $jumpBackward . '"> << </a> &nbsp
        <a href="' . $_SERVER['PHP_SELF'] . '?pn=' . $previous . '">Previous</a> &nbsp;';

        // LEFT - Render clickable number links to the left
        for($i = $pageNumber-6-$fillNumbersBehind; $i < $pageNumber; $i++) {
            if ($i > 0) {
                $paginationCtrls .= '<a href="' .$_SERVER['PHP_SELF'] . '?pn=' . $i . '">' . $i . '</a> &nbsp; ';

            }
        }
    }

    // CURRENT PAGE - Render the target page number (not being a link)
    $paginationCtrls .= ''.$pageNumber.' &nbsp; ';

    // RIGHT - Render clickable number links that should appear on the right
    for ($i = $pageNumber+1; $i <= $last; $i++) {
        $paginationCtrls .= '<a href="' . $_SERVER['PHP_SELF'] . '?pn=' . $i . '">' . $i . '</a> &nbsp; ';
        
        // Making the index always show the same amount of page links
        if ($pageNumber <= 3){
            $fillNumbersInfront= 4 - $pageNumber;
        } else {
            $fillNumbersInfront= 0;
        }
        // End of pagination links
        if ($i >= $pageNumber + 3 + $fillNumbersInfront) {
            break;
        }
    }

    // Next-button and long-forward-jump button
    if ($pageNumber != $last) {
        $next = $pageNumber + 1;
        $jumpForward = $pageNumber + 3 + $fillNumbersInfront;
        $paginationCtrls .= '&nbsp; <a href="' .$_SERVER['PHP_SELF'] . '?pn=' . $next . '">Next</a> &nbsp
        <a href="' .$_SERVER['PHP_SELF'] . '?pn=' . $jumpForward . '"> >> </a> ';
    }
}

//-----------------------------------------------------------------------------
// Pagination end
//-----------------------------------------------------------------------------


//-----------------------------------------------------------------------------
// Looping out blog posts
//-----------------------------------------------------------------------------

// Looping out blog posts a few at a time
while ($post = mysqli_fetch_array($query, MYSQLI_ASSOC)) {
    $postId = $post["post_id"];
    $createTime = $post["create_time"];
    $editTime = $post["edit_time"];
    $title = $post["title"];
    $text = $post["text"];
    $isPublished = $post["is_published"];
    $userId = $post["user_id"];
    $catId = $post["cat_id"];
    $firstName = $post["firstname"];
    $lastName = $post["lastname"];
    $user_email = $post["email"];
    $catName = $post["cat_name"];


    // Only displaying published posts
    if(isset($isPublished) && $isPublished == TRUE) {

    ?>

    <div class="blogpost_center">
        <div class="blogpost">
            <h1><?php echo $title; ?></h1>
            <div class="date"><p><?php echo $createTime; ?></p></div>
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
                
                if(isset($_SESSION["role"])) {
                    if(isset($_SESSION["loggedin"])
                        && $_SESSION["loggedin"] == TRUE
                        && $_SESSION["user_id"] == $userId
                        || $_SESSION["role"] == "admin") {
                        echo "<a href='editpost.php?editid=$postId' name='btn'>Redigera</a>";
                    }
                }
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
            if(isset($_SESSION["loggedin"])
                && $_SESSION["loggedin"] == TRUE
                && $_SESSION["user_id"] == $userId) {
                echo "<a href='editpost.php?editid=$postId' name='btn'>Redigera</a>";
            }
            ?>
            </div>
        </div>
    </div>

<?php 
    }
}
//-----------------------------------------------------------------------------
// End of looping out blog posts
//-----------------------------------------------------------------------------


//Closing database connection
mysqli_close($conn);
?>

</div>

<div class="col-md-3"></div>

<!-----------------------------------------------------------------------------
Pagination printed out
------------------------------------------------------------------------------>
<div class="col-sm-12 col-xs-12 text-center pagination_controls"><?php echo $paginationCtrls; ?></div>
<?php

// Closing html-structure
require "footer.php";
?>

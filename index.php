<?php
require_once "code_open.php";
?>
<body class="index">  
    <!-- start a wrapper -->
    <div class="page-content">
<?php
  require_once "header.php";
    ?>
    <!-- BANNER IMAGE -->
    <div class="banner col-md-12 col-xs-12"></div>
    <div class="col-md-6 pagination"> <!-- Jonatan, vad gör denna?? -->

<?php

$sqlCategory = 1 . ' OR ' . 2 . ' OR ' . 3 . ' OR ' . 4;
if (isset($_GET["category"])) {
	$sqlCategory = $_GET["category"];
}

// The number 2 indicates that the blog post begins in the 2:nd millenium
$sqlYearAndMonth = 2;
if (isset($_GET["yrmnth"])) {
    $sqlYearAndMonth = $_GET["yrmnth"];
}

//-----------------------------------------------------------------------------
// Pagination start
//-----------------------------------------------------------------------------

$conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

// Getting the number of published blog posts
$sql = "SELECT count(*) FROM posts
        WHERE is_published = TRUE
        AND (cat_id = $sqlCategory)
        AND (substr(create_time, 1, 7) LIKE '$sqlYearAndMonth%')";


$query = mysqli_query($conn, $sql);
$post = mysqli_fetch_row($query);
$amountOfPosts = $post[0];
$postsPerPage = 5;

// Tells the page nr of the very last page ("ceil" rounds numbers up)
$last = ceil($amountOfPosts/$postsPerPage);

// Makes sure that last page cannot be less than 1
if ($last < 1) {
    $last = 1;
}

// If no page-number URL-variables are available
$pageNumber = 1;

// Simplifying GET-value
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

$sql = "SELECT posts.*, users.firstname, users.lastname, users.email, categories.cat_name
        FROM posts
        LEFT JOIN users ON posts.user_id = users.user_id
        LEFT JOIN categories ON posts.cat_id = categories.cat_id
        WHERE is_published = 1
        AND (posts.cat_id = $sqlCategory)
        AND (substr(create_time, 1, 7) LIKE '$sqlYearAndMonth%')
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
            if($jumpBackward < 1){
                $jumpBackward = 1;
            }
        }

        // Previous-button and long-backward-jump
        $paginationCtrls .= '<a href="?' . $categoryURL . $selectedYearAndMonthURL . '&pn=' . $jumpBackward . '"> << </a> &nbsp
        <a href="?' . $categoryURL . $selectedYearAndMonthURL . '&pn=' . $previous . '">Previous</a> &nbsp; &nbsp';

        // LEFT - Render clickable number links to the left
        for($i = $pageNumber-6-$fillNumbersBehind; $i < $pageNumber; $i++) {
            if ($i > 0) {
                $paginationCtrls .= '<a href="?' . $categoryURL . $selectedYearAndMonthURL . '&pn=' . $i . '">' . $i . '</a> &nbsp; ';
            }
        }
    }

    // CURRENT PAGE - Render the target page number (not being a link)
    $paginationCtrls .= '<span class="current_page_nr">'.$pageNumber.'</span> &nbsp; ';

    // RIGHT - Render clickable number links that should appear on the right
    for ($i = $pageNumber+1; $i <= $last; $i++) {
        $paginationCtrls .= '<a href="?' . $categoryURL . $selectedYearAndMonthURL . '&pn=' . $i . '">' . $i . '</a> &nbsp; ';

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
        $paginationCtrls .= '&nbsp; <a href="?' . $categoryURL . $selectedYearAndMonthURL . '&pn=' . $next . '">Next</a> &nbsp
        <a href="?' . $categoryURL . $selectedYearAndMonthURL . '&pn=' . $jumpForward . '"> >> </a> ';
    }
}
//-----------------------------------------------------------------------------
// Pagination end
//-----------------------------------------------------------------------------
?>
</div> <!-- col-md-6 -->

<div class="col-sm-12 col-xs-12">
    <div class="selection-display-box">
    <?php

    if(isset($_GET["yrmnth"])) {
        $selectedReadableDate = strtoupper(date("F Y", strtotime($selectedYearAndMonth)));
        echo '<div class="selection-display">
                <p>MÅNADSARKIV: ' . $selectedReadableDate . '</p>
            </div>';
    }
    if(isset($_GET["category"]) && isset($_GET["yrmnth"])) {
        echo '<div class="selection-display">
             <p class="divider-line"> ____ </p> <br><br>
        </div>';
    }

    if(isset($_GET["category"])) {
        $selectedCategory =  $_GET["category"];
        $sql_getCategoryName = "SELECT cat_name FROM categories WHERE cat_id = $selectedCategory";
        $query_getCategoryName = mysqli_query($conn, $sql_getCategoryName);
        $categoryRow = mysqli_fetch_row($query_getCategoryName);
        $selectedCategoryName = strtoupper($categoryRow[0]);
        echo '<div class="selection-display">
                <p>KATEGORI: ' . $selectedCategoryName . '</p>
            </div>';
    }

    ?>
    </div> <!-- selection-display-box -->

<!-----------------------------------------------------------------------------
Pagination-top printed out
------------------------------------------------------------------------------>
    <div class="text-center pagination_controls"><?php echo $paginationCtrls; ?></div>



    <?php

    //-----------------------------------------------------------------------------
    // Looping out blog posts
    //-----------------------------------------------------------------------------
    // Looping out blog posts a few at a time
    while ($post = mysqli_fetch_array($query, MYSQLI_ASSOC)) {
        $postId = $post["post_id"];
        $createTime = substr($post['create_time'], 0, 16); // Printing out only yyyy-mm-dd hh:mm
        $editTime = $post["edit_time"];
        $title = $post["title"];
        $text = $post["text"];
        $isPublished = $post["is_published"];
        $userId = $post["user_id"];
        $catId = $post["cat_id"];
        //Left join
        $firstName = $post["firstname"];
        $lastName = $post["lastname"];
        $user_email = $post["email"];
        //Left join
        $catName = $post["cat_name"];

        // Getting the amout of comments for each post
        $sql = "SELECT count(*) FROM comments WHERE fk_post_id = $postId";
        $queryForCommentAmount = mysqli_query($conn, $sql);
        $comment = mysqli_fetch_row($queryForCommentAmount);
        $comments = $comment[0];
        ?>

        <div class="blogpost_center mobile-margin">
            <div class="blogpost">
                <h1 class="blog-text-center"><?php echo $title; ?></h1>
                <div class="date-container blog-text-center"><p class="date"><?php echo $createTime; ?></p></div><br>
                <div class="text"><p><?php echo $text; ?></p></div><br><br>
                <div class="text right-align"><?php echo "<span class='bold'>Kategori:</span> $catName";?></div>
                <div class="right-align"><span class='bold'>Skriven av:
                <?php echo "<a href='author.php?id=$userId'>$firstName $lastName,</span></a>
                    <p><a href='mailto:$user_email'>$user_email</a></p>";
                    ?>
                </div>

                <div class="comments bold right-align">
                    <?php
                    echo "<a href='post.php?id=$postId' name='btn'>
                    ($comments) Kommentarer </a>";
                    ?><hr>
                </div>
            </div>
        </div>
    <?php

    }

    //-----------------------------------------------------------------------------
    // End of looping out blog posts
    //-----------------------------------------------------------------------------

    //Closing database connection
    mysqli_close($conn);
    ?>

    </div> <!-- text-center pagination_controls -->
</div> <!-- col-sm-12 col-xs-12 -->

<div class="col-md-3"></div>
<!-----------------------------------------------------------------------------
Pagination-bottom printed out
------------------------------------------------------------------------------>
<div class="col-sm-12 col-xs-12 text-center pagination_controls"><?php echo $paginationCtrls; ?></div>
<?php

// Closing html-structure

//fucking footer funkar inte som den ska. någon med tålamod får fixa
//require "footer.php";
?>

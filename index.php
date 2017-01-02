<?php
require_once "code_open.php";
?>
<body class="index">
    <?php
    require_once "header.php";
    ?>

    <!-- start a wrapper -->
    <div class="page-content">
        <!-- banner image -->
        <div class="banner col-md-12 col-xs-12"></div>
        <div class="bounce col-md-6 pagination">
            <?php
            /* ----------------------------------------------------------------------------
                    Values to insert into SQL-queries
            ---------------------------------------------------------------------------- */

            $sqlCategory = '>' . 0;

            if (isset($_GET["category"])) {
                $sqlCategory = '=' . $_GET["category"];
            }

            // The number 2 indicates that the blog post begins in the 2:nd millenium
            $sqlYearAndMonth = 2;

            if (isset($_GET["yrmnth"])) {
                $sqlYearAndMonth = $_GET["yrmnth"];
            }

            /* ----------------------------------------------------------------------------
                    PAGINATION START
            ---------------------------------------------------------------------------- */

            // Getting the total number of published blog posts
            $sqlGetPostAmount = "SELECT count(*) FROM posts
                                WHERE is_published = TRUE
                                AND (cat_id $sqlCategory)
                                AND (substr(create_time, 1, 7)
                                LIKE '$sqlYearAndMonth%')
                                ";

            $queryGetPostAmount = mysqli_query($conn, $sqlGetPostAmount);
            $post = mysqli_fetch_row($queryGetPostAmount);
            $amountOfPosts = $post[0];

            // Defining how many posts there are per page
            $postsPerPage = 5;

            // Tells the page nr of the very last page ("ceil" rounds numbers up)
            $last = ceil($amountOfPosts/$postsPerPage);

            // Making sure that last page cannot be less than 1
            if ($last < 1) {
                $last = 1;
            }

            // If no page-number has been selected
            $pageNumber = 1;

            // Otherwise it the selected value
            if (isset($_GET['pn'])) {
                $pageNumber = $_GET['pn'];
            }

            // Page number must be more than 1 and cannot be more than last page
            if ($pageNumber < 1) {
                $pageNumber = 1;
            } elseif ($pageNumber > $last) {
                $pageNumber = $last;
            }

            // Query for a desired amount of posts per page
            $limit = 'LIMIT ' .($pageNumber - 1) * $postsPerPage .',' . $postsPerPage;

            // Sorting posts on decending or ascending create-time
            $postOrder = 'desc';

            if (isset($_GET["order"])) {
                $postOrder = $_GET["order"];
            }

            $sqlGetPaginatedPosts = "SELECT posts.*, users.firstname, users.lastname, users.email, categories.cat_name
                                    FROM posts
                                    LEFT JOIN users ON posts.user_id = users.user_id
                                    LEFT JOIN categories ON posts.cat_id = categories.cat_id
                                    WHERE is_published = TRUE
                                    AND (posts.cat_id $sqlCategory)
                                    AND (substr(create_time, 1, 7) LIKE '$sqlYearAndMonth%')
                                    ORDER BY create_time $postOrder $limit
                                    ";

            $queryGetPaginatedPosts = mysqli_query($conn, $sqlGetPaginatedPosts);

            // Establishing $paginationCtrls variable
            $paginationCtrls = '';

            // If there is more than one page of results
            if ($last !=1) {
                if ($pageNumber > 1) {
                    $previous = $pageNumber - 1;
                    $fillNumbersBehind = -3;
                    $jumpBackward = $pageNumber - 3;

                    if ($pageNumber >= $last - 3) {
                        $fillNumbersBehind = $pageNumber - $last;
                        $jumpBackward = $pageNumber - 6 - $fillNumbersBehind;

                        if ($jumpBackward < 1) {
                            $jumpBackward = 1;
                        }
                    }

                    // Previous-button and long-backward-jump
                    $paginationCtrls .= '<a href="' . createUrl($jumpBackward) . '"> << </a> &nbsp;
                    <a href="' . createUrl($previous) . '">Previous</a> &nbsp; &nbsp;';

                    // LEFT - Render clickable number links to the left
                    for ($i = $pageNumber-6-$fillNumbersBehind; $i < $pageNumber; $i++) {
                        if ($i > 0) {
                            $paginationCtrls .= '<a href="' . createUrl($i) . '">' . $i . '</a> &nbsp; ';
                        }
                    }
                }

                // CURRENT PAGE - Render the target page number (not being a link)
                $paginationCtrls .= '<span class="current_page_nr">'.$pageNumber.'</span> &nbsp; ';

                // RIGHT - Render clickable number links that should appear on the right
                for ($i = $pageNumber+1; $i <= $last; $i++) {
                    $paginationCtrls .= '<a href="' . createUrl($i) . '">' . $i . '</a> &nbsp; ';

                    // Making the index always show the same amount of page links
                    if ($pageNumber <= 3) {
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
                    $paginationCtrls .= '&nbsp; <a href="' . createUrl($next) . '">Next</a> &nbsp;
                    <a href="' . createUrl($jumpForward) . '"> >> </a> ';
                }
            }

            /* ----------------------------------------------------------------------------
                    PAGINATION END
            ---------------------------------------------------------------------------- */
            ?>
        </div> <!-- col-md-6 pagination -->
        <div class="col-sm-12 col-xs-12">
            <div class="selection-display-box">

                <?php
                $order = '?&order=desc';

                $queryStringOrder = $_SERVER['REQUEST_URI'] . $order;

                if (isset($_GET["order"])) {
                    $queryStringOrder = $_SERVER['REQUEST_URI'];
                }
                if (isset($_GET["order"]) && $_GET["order"] == 'asc') {
                    $queryStringOrder = preg_replace('/asc/', 'desc', $queryStringOrder);
                    echo '<a class="order-sorting" href="' . $queryStringOrder . '">Sortera: nyast inlägg först</a>';
                } else {
                    $queryStringOrder = preg_replace('/desc/', 'asc', $queryStringOrder);
                    echo '<a class="order-sorting" href="' . $queryStringOrder . '">Sortera: äldst inlägg först</a>';
                }

                if (isset($_GET["yrmnth"])) {
                    $selectedReadableDate = strtoupper(date("F Y", strtotime($selectedYearAndMonth)));
                    echo '<div class="selection-display">
                            <p>MÅNADSARKIV: ' . $selectedReadableDate . '</p>
                        </div>';
                }

                if (isset($_GET["category"]) && isset($_GET["yrmnth"])) {
                    echo '<div class="selection-display">
                            <p class="divider-line"> ____ </p> <br><br>
                        </div>';
                }

                if (isset($_GET["category"])) {
                    $selectedCategory =  $_GET["category"];
                    $sql_getCategoryName = "SELECT cat_name FROM categories WHERE cat_id = $selectedCategory";
                    $query_getCategoryName = mysqli_query($conn, $sql_getCategoryName);
                    $categoryRow = mysqli_fetch_row($query_getCategoryName);
                    $selectedCategoryName = strtoupper($categoryRow[0]);
                    echo '<div class="selection-display">
                            <p>KATEGORI: ' . $selectedCategoryName . '</p>
                        </div>';
                } ?>

            </div> <!-- selection-display-box -->

            <!-----------------------------------------------------------------------------
                        PAGINATION-TOP
                        - printed out
            ------------------------------------------------------------------------------>

            <div class="text-center pagination_controls">
                <?php echo $paginationCtrls; ?>
            </div>

            <?php
            /* ----------------------------------------------------------------------------
                    LOOPING
                    - Looping out blog posts a few at a time
            ---------------------------------------------------------------------------- */

            while ($post = mysqli_fetch_array($queryGetPaginatedPosts, MYSQLI_ASSOC)) {
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
                $comments = $comment[0]; ?>

                <div class="blogpost_center mobile-margin">
                    <div class="blogpost">
                        <h1 class="blog-text-center"><?php echo $title; ?></h1>
                        <div class="date-container blog-text-center"><p class="date"><?php echo $createTime; ?></p></div><br>
                        <div><p><?php echo $text; ?></p></div><br><br>
                        <?php
                        ?>
                            <div class="text right-align">
                                <span class='highlighted-text'>Kategori: </span>
                                <?php
                                if ($catName == null) {
                                    echo "Okategoriserat";
                                } else {
                                    echo $catName;
                                } ?>
                            </div>
                        <div class="right-align">
                            <span class='highlighted-text'>Skriven av:</span>
                                <?php echo "$firstName $lastName, <a href='mailto:$user_email'>$user_email</a>"; ?>
                        </div>
                        <div class="comments right-align">
                            <?php
                            echo "<a href='post.php?id=$postId'>
                            ($comments) Kommentarer</a>"; ?><hr class="divider">
                        </div>
                    </div>
                </div>
            <?php

            }
            /* ----------------------------------------------------------------------------
                    END OF LOOPING OUT BLOG POSTS
            ---------------------------------------------------------------------------- */

            //Closing database connection
            mysqli_close($conn);
            ?>

            <div class="col-md-3"></div>

            <!-----------------------------------------------------------------------------
                    Pagination-bottom printed out
            ------------------------------------------------------------------------------>

            <div class="col-sm-12 col-xs-12 text-center pagination_controls">
                <?php echo $paginationCtrls; ?>
            </div>
        </div>
    <?php
    include "footer.php";
    ?>

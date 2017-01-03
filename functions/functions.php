<?php
/* ----------------------------------------------------------------------------
                FUNCTIONS
---------------------------------------------------------------------------- */

/* ----------------------------------------------------------------------------
        FUNCTION FOR REGISTER A NEW USER
---------------------------------------------------------------------------- */
function regUser()
{
    if (isset($_POST["register"])) {
        if (!empty($_POST["firstname"]) &&
            !empty($_POST["lastname"]) &&
            !empty($_POST["email"]) &&
            !empty($_POST["password"])
            ) {
            $conn = new mysqli("localhost", "root", "", "db_blogg");

            $firstname = mysqli_real_escape_string($conn, $_POST["firstname"]);
            $lastname = mysqli_real_escape_string($conn, $_POST["lastname"]);
            $email = mysqli_real_escape_string($conn, $_POST["email"]);
            $password = mysqli_real_escape_string($conn, $_POST["password"]);
            $role = "user"; //standard för användaren är user.
            $encrypt_pass = password_hash($password, PASSWORD_DEFAULT);

            $regQuery = "INSERT INTO users
                        VALUES (
						NULL, /* för att user_id ska skapas per automatik */
						'$firstname',
						'$lastname',
						'$email',
						'$encrypt_pass',
						'', /* istället för profilbild eftersom den inte läggs in nu */
						'$role'
						)";

            if (mysqli_query($conn, $regQuery)) {
                $_SESSION['msg'] = "Användaren är registrerad!";
            } else {
                echo "Någonting fick fel, testa igen";
            }
        }
    }
}

/* ----------------------------------------------------------------------------
        FUNCTION FOR PRINTING A POST
---------------------------------------------------------------------------- */
function printPost()
{
    $conn = new mysqli("localhost", "root", "", "db_blogg");
    $stmt = $conn->stmt_init();

    $query =   "SELECT posts.*, users.firstname, users.lastname, users.email, categories.cat_name
                FROM posts
				LEFT JOIN users ON posts.user_id = users.user_id
				LEFT JOIN categories ON posts.cat_id = categories.cat_id
				ORDER BY create_time DESC";

    if (mysqli_query($conn, $query)) {
    }

    if ($stmt->prepare($query)) {
        $stmt->execute();
        $stmt->bind_result($postId, $createTime, $editTime, $title, $text, $isPublished, $userId, $catId, $firstName, $lastName, $user_email, $catName);

        while (mysqli_stmt_fetch($stmt)) {

            echo "<h1>$title</h1>";
            echo "<p>$createTime</p>";
            echo "<p>$text</p>";
            echo "<p>Kategori: $catName</p>";
            echo "<a href='author.php?id=$userId'>$firstName $lastName</p></a>";
            echo "<p><a href='mailto:$user_email'>$user_email</a></p>";
            echo "<a href='post.php?id=$postId' name='btn'>";
            echo "(X) Kommentarer </a>";

            if (isset($_SESSION["loggedin"])
                && $_SESSION["loggedin"] == true
                && $_SESSION["user_id"] == $userId
                || $_SESSION["role"] == "admin") {

                echo "<a href='editpost.php?editid=$postId'>";
                echo "Redigera </a>";
                echo "<a href='superuser.php?deletePost=$postId'>Radera </a>";
            }
        }
    }
}

/* ----------------------------------------------------------------------------
        FUNCTION FOR DELETE
        - Delete posts, comments, user or categories
---------------------------------------------------------------------------- */
function deleteCommand($command, $id, $redirect)
{
    global $conn;

    $query = "";

    switch($command) {

    case "deletePost":
        $query = "DELETE FROM posts WHERE post_id = '{$id}'";
        break;

    case "deleteComment":

        $query = "DELETE FROM comments WHERE com_id = '{$id}'";
        break;

    case "deleteUser":

        if(!empty(posts.user_id)) {
          $query = "DELETE from users
                    WHERE user_id='{$id}'";
        }else {

          $query = "DELETE FROM users, posts USING users
                    INNER JOIN posts on (users.user_id = posts.user_id)
                    WHERE users.user_id='{$id}'";
        }

        // $query =    "SELECT users.*, posts.*, comments.* 
        //             FROM users 
        //             INNER JOIN posts 
        //             ON users.user_id = posts.user_id 
        //             LEFT JOIN comments 
        //             ON posts.post_id = comments.fk_post_id  
        //             WHERE users.user_id = '{$id}'  
        //             ";

        break;

    case "deleteCategory":

        $query = "DELETE FROM categories WHERE cat_id = '{$id}'";
        break;

    default:

        echo "Någonting gick fel!";
        break;
    }

    if (!mysqli_query($conn, $query)) {
        // Skriver ut ett felmeddelande om något blir fel med queryn
        echo mysqli_error($conn);
    } else {
        header("Location: " . $redirect);
    }

}


/* ----------------------------------------------------------------------------
        CREATE URL QUERIES
        The $input variable must always be given an identifying string-value.
        The identifying string-value will determine how it is handeled and which
        $_GET-variable is inserter into.
        The identifier is followed by the input value.
---------------------------------------------------------------------------- */
function createUrl($input) {
    $urlArray = $_GET;
    
    /* ----------------------------------------------------------------------------
        PAGE NUMBER
        createUrl('pageNrDiff' . $input)
    ---------------------------------------------------------------------------- */
    if (strpos($input, 'pageNrDiff') !== false) {
        $input = str_replace('pageNrDiff', '', $input);
        $pageNumber = 1;
        if(isset($urlArray['pn'])) {
            $pageNumber = $urlArray['pn'];
        }
        $urlArray['pn'] = $pageNumber + $input;
    }

    /* ----------------------------------------------------------------------------
        ORDER
        createUrl('order' . $input)
    ---------------------------------------------------------------------------- */
    if (strpos($input, 'order') !== false) {
        $input = str_replace('order', '', $input);
        $urlArray['order'] = $input;
    }

     /* ----------------------------------------------------------------------------
        CATEGORY
        createUrl('category' . $input)
    ---------------------------------------------------------------------------- */
    if (strpos($input, 'category') !== false) {
        $input = str_replace('category', '', $input);
        $urlArray['category'] = $input;
    }

    /* ----------------------------------------------------------------------------
        YEAR AND MONTH
        createUrl('yrmnth' . $input)
    ---------------------------------------------------------------------------- */
    if (strpos($input, 'yrmnth') !== false) {
        $input = str_replace('yrmnth', '', $input);
        $urlArray['yrmnth'] = $input;
    }

    // BUILDING URL FROM $urlArray (WHICH IS AN EDITED $_GET-ARRAY)
    $url = $_SERVER['PHP_SELF'] . '?' . http_build_query($urlArray);
    return $url;
}


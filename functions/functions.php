<?php
/* ----------------------------------------------------------------------------
                FUNCTIONS
---------------------------------------------------------------------------- */

/* ----------------------------------------------------------------------------
        FUNCTION FOR REGISTER A NEW USER
---------------------------------------------------------------------------- */
function regUser() {

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
            $role = "user"; // The standard role for the user is "user".
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
                $_SESSION['msg'] = "<span class='error'>Error: </span>Någonting fick fel, testa igen!";
            }
        } else {
            $_SESSION['msg'] = "<span class='error'>Error: </span>Fyll i alla fält och testa igen!";
        }
    }
}

/* ----------------------------------------------------------------------------
        FUNCTION FOR PRINTING A POST
---------------------------------------------------------------------------- */
function printPost() {

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
function deleteCommand($command, $id, $redirect) {

    global $conn;

    $query = "";

    switch($command) {

        case "deletePost":

            $query = "DELETE FROM posts WHERE post_id = '{$id}'";

        break; /* break case deletePost */

        case "deleteComment":

            $query = "DELETE FROM comments WHERE com_id = '{$id}'";

        break; /* break case deleteComment */

        case "deleteUser":

              /* 1: Tar bara bort användare om användaren har post */

              // $query = "DELETE FROM users, posts USING users
              // INNER JOIN posts on (users.user_id = posts.user_id)
              // WHERE users.user_id='{$id}'";

              /* 2: Villkoren för if-satsen borde vara något i stil med
                    "Om det inte finns någon rad i där user_id = $id " */

              // if(!empty(posts.user_id)) {
              //
              //   $query = "DELETE from users
              //             WHERE user_id='{$id}'";
              //
              // }else {
              //   $query = "DELETE FROM users, posts USING users
              //   INNER JOIN posts on (users.user_id = posts.user_id)
              //   WHERE users.user_id='{$id}'";
              // }


              /* 3: Tar bara bort användaren men inte posts. */

              // $query = "DELETE FROM posts WHERE posts.user_id='{$id}'";
              // $query = "DELETE FROM users WHERE users.user_id='{$id}'";

              /* 4: Länktips */

              /*

              http://stackoverflow.com/questions/4839905/mysql-delete-from-multiple-tables-with-one-query

              http://php.net/manual/en/mysqli.multi-query.php

              http://stackoverflow.com/questions/1233451/delete-from-two-tables-in-one-query

              */

             
              /* Detta är något som Frida förmodligen skrivit, har inget med mina lösningar att göra */

              // $query =    "SELECT users.*, posts.*, comments.*
              //             FROM users
              //             INNER JOIN posts
              //             ON users.user_id = posts.user_id
              //             LEFT JOIN comments
              //             ON posts.post_id = comments.fk_post_id
              //             WHERE users.user_id = '{$id}'
              //             ";

        break; /* break case deleteUser */

        case "deleteCategory":

            $query = "DELETE FROM categories WHERE cat_id = '{$id}'";

        break; /* break case deleteCategory */

        default:

            echo "Någonting gick fel!";

        break; /* break default */
    }

    if (!mysqli_query($conn, $query)) {
        // Skriver ut ett felmeddelande om något blir fel med queryn
        echo mysqli_error($conn);
    } else {
        header("Location: " . $redirect);
    }
}


/* ----------------------------------------------------------------------------
    CREATE URL
    The $input variable must always be given an identifying string.
    The identifying string will determine how it is handeled with and which
    $_GET-variable it is inserted into.
    The identifying string is followed by the real input value.
---------------------------------------------------------------------------- */
function createUrl($input) {
    $urlArray = $_GET;

    /* ----------------------------------------------------------------------------
        PAGE NUMBER DIFF
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



/* ----------------------------------------------------------------------------
    DELETE USER
---------------------------------------------------------------------------- */
function deleteUser($postArray, $conn) {

    // Getting chosen user-id
    $deleteUserId = $postArray['deleteUser'];

    // Checking connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    } 

    // Getting the post-id needed for deletion of comments
    $sqlGetPostId = "SELECT * FROM posts WHERE user_id = $deleteUserId";
    $queryGetPostId = mysqli_query($conn, $sqlGetPostId);
    while($getPostId = mysqli_fetch_array($queryGetPostId, MYSQLI_ASSOC)) {
        $postId = $getPostId['post_id'];
    }

    // Multi query deleting in three tables
    $sqlDelete = "DELETE FROM users WHERE user_id = $deleteUserId;";
    $sqlDelete .= "DELETE FROM posts WHERE user_id = $deleteUserId;";
    if(isset($postId)) {
    $sqlDelete .= "DELETE FROM comments WHERE fk_post_id = $postId;";
    }
    
    // Executing query
    if ($conn->multi_query($sqlDelete) === TRUE) {
        // Reloading page
        header('Refresh:0');    
    } else {
        echo "Lyckades inte ta bort användaren: " . $conn->error;
    }

}
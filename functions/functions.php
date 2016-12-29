<?php

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

            $regQuery = "INSERT INTO users VALUES (
													NULL, /* för att user_id ska skapas per automatik */
													'$firstname',
													'$lastname',
													'$email',
													'$encrypt_pass',
													'', /* istället för profilbild eftersom den inte läggs in nu */
													'$role'
													)";

            mysqli_query($conn, $regQuery);
        }
    }
}

/* PRINT POST FUNCTION */

function printPost()
{
    $conn = new mysqli("localhost", "root", "", "db_blogg");
    $stmt = $conn->stmt_init();

    $query =   "SELECT posts.*, users.firstname, users.lastname, users.email, categories.cat_name FROM posts
							LEFT JOIN users ON posts.user_id = users.user_id
							LEFT JOIN categories ON posts.cat_id = categories.cat_id
							ORDER BY create_time DESC";

    if (mysqli_query($conn, $query)) {
    }

    if ($stmt->prepare($query)) {
        $stmt->execute();
        $stmt->bind_result($postId, $createTime, $editTime, $title, $text,
                                                 $isPublished, $userId, $catId, $firstName,
                                                 $lastName, $user_email, $catName);

        while (mysqli_stmt_fetch($stmt)) {
            echo "<h1> $title</h1>";
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
/****************************************************/

function deleteCommand($command, $id, $redirect)
{
    global $conn;

    $query = "";

    if ($command == "deletePost") {
        $query = "DELETE FROM posts WHERE post_id = '{$id}'";
    } elseif ($command == "deleteComment") {
        $query = "DELETE FROM comments WHERE com_id = '{$id}'";
    } elseif ($command == "deleteUser") {
        $query = "DELETE FROM users, posts USING users
                  INNER JOIN posts on (users.user_id = posts.user_id)
                  WHERE users.user_id='{$id}'";
    } elseif ($command == "deleteCategory") {
        $query = "DELETE FROM categories WHERE cat_id = '{$id}'";
    }

    if (!mysqli_query($conn, $query)) {
        // Skriver ut ett felmeddelande om något blir fel med queryn
        echo mysqli_error($conn);
    } else {
        header("Location: " . $redirect);
    }
}


//-----------------------------------------------------------------------------
// Creating URL-queries
//-----------------------------------------------------------------------------

function createUrl($pageNr) {
    $urlArray = $_GET;
    $urlArray['pn'] = $pageNr;
    $url = $_SERVER['PHP_SELF'] . '?' . http_build_query($urlArray);
    return $url;
}
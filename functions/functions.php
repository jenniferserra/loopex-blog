<?php
/* ----------------------------------------------------------------------------
                FUNCTIONS
---------------------------------------------------------------------------- */

require"dbconnect.php";

/* ----------------------------------------------------------------------------
        FUNCTION FOR REGISTER A NEW USER
---------------------------------------------------------------------------- */
function regUser($conn) {

    if (isset($_POST["register"])) {

        if (!empty($_POST["firstname"]) &&
            !empty($_POST["lastname"]) &&
            !empty($_POST["email"]) &&
            !empty($_POST["password"])
            ) {

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
        FUNCTION FOR DELETE
        - Delete posts, comments, user or categories
---------------------------------------------------------------------------- */
function deleteCommand($conn, $command, $id, $redirect) {


    $query = "";

    switch($command) {

        case "deletePost":

            $query = "DELETE FROM posts WHERE post_id = '{$id}'";

        break; /* break case deletePost */

        case "deleteComment":

            $query = "DELETE FROM comments WHERE com_id = '{$id}'";

        break; /* break case deleteComment */

        case "deleteUser":


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

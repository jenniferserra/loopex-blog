<?php
require_once "code_open.php";
?>
<body class="superuser">
    <?php
    require_once "header.php";

    $stmt = $conn->stmt_init();

    /* ----------------------------------------------------------------------------
            CHECK IF USER IS
            A) logged in and
            B) logged in as admin
    ---------------------------------------------------------------------------- */
    if (isset($_SESSION['loggedin']) && $_SESSION['role'] == "admin") {

        /* ----------------------------------------------------------------------------
                DELETE INFORMATION
        - This code is run if user wants to i.e. delete a post, user etc...
        - Deleting information in the database calls on a FUNCTION called deleteCommand
        - All FUNCTIONS can be found in functions/functions.php
        ---------------------------------------------------------------------------- */

        /* ----------------------------------------------------------------------------
                    DELETE POSTS
        ---------------------------------------------------------------------------- */
        if (isset($_GET["postDelete"])) {
            deleteCommand("deletePost",
            $_GET["postDelete"],
            "superuser.php?admin=showPosts");
        }

        /* ----------------------------------------------------------------------------
                    DELETE COMMENTS
        ---------------------------------------------------------------------------- */
        if (isset($_GET["commentDelete"])) {
            deleteCommand("deleteComment",
            $_GET["commentDelete"],
            "superuser.php?admin=showComments");
        }

        /* ----------------------------------------------------------------------------
                    DELETE USER
        ---------------------------------------------------------------------------- */
        if (isset($_POST['deleteUser'])) {
        deleteUser($_POST, $conn);
        }

        /* ----------------------------------------------------------------------------
                    DELETE CATEGORY
        ---------------------------------------------------------------------------- */
        if (isset($_GET["categoryDelete"])) {
            deleteCommand("deleteCategory",
            $_GET["categoryDelete"],
            "superuser.php?admin=editCategories");
        }

        /* ----------------------------------------------------------------------------
                ADD INFORMATION
                - This code is run if administrator wants to add a category
        ---------------------------------------------------------------------------- */

        if (isset($_POST["addCategory"])) {
            if (!empty($_POST["nameCategory"])) {
                $nameCategory = mysqli_real_escape_string($conn, $_POST["nameCategory"]);
                $addQuery= "INSERT INTO categories
                            VALUES (NULL, '$nameCategory')";
                mysqli_query($conn, $addQuery);
                header("Location:superuser.php?admin=editCategories");
            }
        } ?>

        <!-----------------------------------------------------------------------------
                SUPERADMIN BANNER
        ------------------------------------------------------------------------------>

        <div class="jumbotron">
            <div class="container-fluid">
                <h1>Kontrollpanelen</h1>
                <small>Här kan du administrera bloggen</small>
            </div>
        </div> <!-- .jumbotron -->


        <!-----------------------------------------------------------------------------
                SUPERADMIN MENU START

            - Chosen option generates a GET-request
            - GET-Request is later picked up with the corresponding SWITCH-case
        ------------------------------------------------------------------------------>

        <div class="row">
            <div class="container-fluid">
                <div class="col-md-3">
                    <div class="list-group">
                        <a href="superuser.php?admin=showPosts" class="list-group-item">Redigera inlägg</a>
                        <a href="superuser.php?admin=showComments" class="list-group-item">Redigera kommentarer</a>
                        <a href="superuser.php?admin=showUsers" class="list-group-item">Redigera användare</a>
                        <a href="superuser.php?admin=regUser" class="list-group-item">Registrera ny användare</a>
                        <a href="superuser.php?admin=editCategories" class="list-group-item">Redigera kategorier</a>
                    </div> <!-- .list-group -->
                </div>

                <div class="col-md-7">

                    <?php
                    /* ----------------------------------------------------------------------------
                        THE IF STATEMENT IS TO ONLY RUN SWITCH-STATEMENT IF A GET-REQUEST IS SENT
                    ---------------------------------------------------------------------------- */
                    if (isset($_GET["admin"])) {

                        /* ----------------------------------------------------------------------------
                            USE MENU SELECTION TO SHOW REQUESTED INFORMATION
                        ---------------------------------------------------------------------------- */

                        /* ----------------------------------------------------------------------------
                                    SWITCH START
                        ---------------------------------------------------------------------------- */
                        switch ($_GET["admin"]) {

                            /* ----------------------------------------------------------------------------
                                        SHOW ALL POSTS
                            ---------------------------------------------------------------------------- */
                            case 'showPosts':

                            echo "<h2>Se alla inlägg</h2><br>";

                            $postQuery  =   "SELECT posts.*, users.firstname, users.lastname, users.email, categories.cat_name
                                            FROM posts
                                            LEFT JOIN users ON posts.user_id = users.user_id
                                            LEFT JOIN categories ON posts.cat_id = categories.cat_id
                                            ORDER BY create_time DESC";

                            mysqli_query($conn, $postQuery);

                            if ($stmt->prepare($postQuery)) {
                                $stmt->execute();
                                $stmt->bind_result($postId, $createTime, $editTime, $title, $text, $isPublished, $userId, $catId, $firstName, $lastName, $user_email, $catName);

                                while ($stmt->fetch()) {
                                    echo    "<h4>$title ";
                                    echo    "<a href='superuser.php?postDelete=$postId'><i class='fa fa-trash' aria-hidden='true'></i>
                                            </a>";

                                    if ($isPublished == 0) {
                                        echo    "*";
                                    }

                                    echo    " </h4>(" . $createTime . ")<br><br>";
                                    echo    "<p>$text </p>";
                                    echo    "<hr>";
                                }
                            }
                            echo    "<div id='row'> * = utkast </div>";

                            break; /* break case showPosts */

                            /* ----------------------------------------------------------------------------
                                        SHOW ALL COMMENTS
                            ---------------------------------------------------------------------------- */

                            case 'showComments':

                            echo "<h2>Se alla kommentarer</h2>";

                            $commentQuery  = "SELECT * FROM comments";
                            mysqli_query($conn, $commentQuery);
                            if ($stmt->prepare($commentQuery)) {
                                $stmt->execute();
                                $stmt->bind_result($com_id, $c_name, $c_epost, $createTime, $c_text, $fk_post_id);

                                while ($stmt->fetch()) {
                                    echo    "<p><a href='superuser.php?commentDelete=$com_id'>
                                            <i class='fa fa-trash' aria-hidden='true'></i>
                                            </a></p>";

                                    echo    " $c_name<br>";
                                    echo    " (" . $createTime . " )<br>";
                                    echo    "$c_text<br><hr>";
                                }
                            }

                            break; /* break case showComments */

                            /* ----------------------------------------------------------------------------
                                        SHOW ALL USERS
                            ---------------------------------------------------------------------------- */
                            case 'showUsers':

                            echo "<h2>Se alla användare</h2>";
                            echo "<div class='flex-container'>";

                            $userQuery  = "SELECT * FROM users";

                            mysqli_query($conn, $userQuery);

                            if ($stmt->prepare($userQuery)) {
                                $stmt->execute();
                                $stmt->bind_result($userId, $firstName, $lastName, $email, $password, $profilePic, $role);

                                while(mysqli_stmt_fetch($stmt)) {
                                echo "<div class='flex-item'>
                                        ID: $userId<br>
                                        Namn: $firstName $lastName<br>
                                        E-Post: $email<br>
                                        Roll: $role<br>
                                            <form action='$_SERVER[REQUEST_URI]' method='post'>
                                                <button class='btn' type='submit'  name='deleteUser' value='$userId'>
                                                    <i class='fa fa-trash'></i>
                                                </button>
                                            </form>
                                    </div>";
                                }
                            }
                            echo "</div>";


  
                            break; /* break case showUsers */

                            /* ----------------------------------------------------------------------------
                                        REGISTER A USER
                                        - Call the function regUser () to register user
                            ---------------------------------------------------------------------------- */

                            case 'regUser':

                            regUser();
                            ?>

                            <h2>
                                <?php 
                                if (isset($_SESSION['msg'])) {
                                    echo $_SESSION['msg'];
                                    unset($_SESSION['msg']);
                                } else {
                                    echo "Registrera";
                                } 
                                ?>
                            </h2>

                            <form method="post">

                                <!-- Input-field for Firstname -->
                                <div class="form-group row">
                                    <label for="Förnamn" class="col-md-2 col-form-label">Förnamn:</label>
                                    <div class="col-xs-10">
                                        <input class="form-control" name="firstname" type="text" placeholder="Ange förnamn" id="Förnamn">
                                    </div>
                                </div>

                                <!-- Input-field for Lastname -->
                                <div class="form-group row">
                                    <label for="Efternamn" class="col-md-2 col-form-label">Efternamn:</label>
                                    <div class="col-xs-10">
                                        <input class="form-control" name="lastname" type="text" placeholder="Ange efternamn" id="Efternamn">
                                    </div>
                                </div>

                                <!-- Input-field for E-Mail -->
                                <div class="form-group row">
                                    <label for="E-Post" class="col-md-2 col-form-label">E-Post:</label>
                                    <div class="col-xs-10">
                                        <input class="form-control" name="email" type="email" placeholder="Ange E-Post" id="E-Post">
                                    </div>
                                </div>

                                <!-- Input-field for Password -->
                                <div class="form-group row">
                                    <label for="Lösenord" class="col-md-2 col-form-label">Lösenord:</label>
                                    <div class="col-xs-10">
                                        <input class="form-control" name="password" type="password" placeholder="Ange ett lösenord" id="Lösenord">
                                    </div>
                                </div>

                                <!-- Register-button -->
                                <div class="form-group row">
                                    <div class="col-xs-10">
                                        <input name="register" class="btn btn-lg btn-primary" type="submit" value="Registrera">
                                    </div>
                                </div>
                            </form> <!-- end : form -->

                            <?php
                            break; /* break case regUser */

                            /* ----------------------------------------------------------------------------
                                        CATEGORIES
                                        - View and edit categories
                            ---------------------------------------------------------------------------- */

                            case 'editCategories':

                            echo "<h2>Redigera kategori</h2>";

                            $catQuery  = "SELECT * FROM categories";

                            mysqli_query($conn, $catQuery);

                            if ($stmt->prepare($catQuery)) {
                                $stmt->execute();
                                $stmt->bind_result($catID, $catName);

                                while ($stmt->fetch()) {
                                    echo "<a href='superuser.php?categoryDelete=$catID'><i class='fa fa-trash' aria-hidden='true'></i></a> ";
                                    echo "$catName <br><hr>";
                                }
                            }
                            ?>
                            <h3>Lägg till kategori</h3>

                            <form method='post'>
                                <div class='input-group'>
                                    <input type='text' class='form-control' placeholder='Ge kategorien ett namn...' name='nameCategory' required>
                                    <input class='btn btn-default' name='addCategory' type='submit' value='Lägg till'>
                                </div> <!-- .input-group -->
                            </form>

                            <?php
                            break; /* break case editCategories */

                            /* ----------------------------------------------------------------------------
                                Print this is nothing is selected (should never happen) or someone tries 
                                their own GET-Request not found in menu.
                            ---------------------------------------------------------------------------- */
                            default:

                            echo "<h2>Välj ett alternativ från menyn</h2>";

                            break;
                        } /* end SWITCH */
                    } /* end IF */
                    ?>
                </div> <!-- .col-md-7 -->
                <div class="col-md-2"></div>
            </div> <!-- .container-fluid -->
        </div> <!-- .row -->
    <?php
    /* ----------------------------------------------------------------------------
            ELSE THE USER IS
            A) logged in and
            B) logged in as admin
    ---------------------------------------------------------------------------- */
    } else {
        header("Location:index.php");
    }
include "footer.php";
require_once "code_end.php";
?>
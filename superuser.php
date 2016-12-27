<?php
require_once "code_open.php";
?>
<body class="statistics">
  <!-- start a wrapper -->
  <div class="page-content">
  <?php
  require_once "header.php";

$stmt = $conn->stmt_init();
      include "functions/functions.php";


      /* Check if user is a) logged in and b) logged in as admin */
      if(isset($_SESSION['loggedin']) && $_SESSION['role'] == "admin") {
?>
<div class="jumbotron">
  <div class="container-fluid">
    <h1>Kontrollpanelen</h1>
    <small>Här kan du administrera bloggen</small>
  </div>
</div>

<!--******************************************************************************

        SUPERADMIN MENU START
          - Chosen option generates a GET-request
          - GET-Request is later picked up with the corresponding SWITCH-case

******************************************************************************-->


  <div class="row">
    <div class="container-fluid">
      <div class="col-md-3">
        <div class="list-group">

        <a href="superuser.php?admin=showPosts" class="list-group-item">
          Visa alla inlägg
        </a>

        <a href="superuser.php?admin=showComments" class="list-group-item">
          Visa alla kommentarer
        </a>

        <a href="superuser.php?admin=showUsers" class="list-group-item">
          Visa alla bloggare
        </a>

        <a href="superuser.php?admin=regUser" class="list-group-item">
          Registrera ny bloggare
        </a>

        <a href="superuser.php?admin=editCategories" class="list-group-item">
          Redigera kategorier
        </a>

      </div>
    </div>

      <div class="col-md-7">

      <?php

        /* This IF-statement is to only run SWITCH-statement if a GET-request is sent */

        if (isset($_GET["admin"])) {

          /* Use menu selection to show requested information */

            /* Show all posts */
            switch ($_GET["admin"]) {

              case 'showPosts':

                  echo "<h2> Se alla inlägg </h2><br>";

                  $postQuery  = "SELECT posts.*, users.firstname, users.lastname, users.email, categories.cat_name FROM posts
                      							LEFT JOIN users ON posts.user_id = users.user_id
                      							LEFT JOIN categories ON posts.cat_id = categories.cat_id
                      							ORDER BY create_time DESC";

                  mysqli_query($conn, $postQuery);
                  if ($stmt->prepare($postQuery)) {
                      $stmt->execute();
                      $stmt->bind_result($postId, $createTime, $editTime, $title, $image, $text,
                                                                 $isPublished, $userId, $catId, $firstName,
                                                                 $lastName, $user_email, $catName);

                      while ($stmt->fetch()) {
                          echo "<h4>$title ";
                          echo "<a href='superuser.php?postDelete=$postId'><i class='fa fa-trash' aria-hidden='true'></i>
                                  </a>";
                          if ($isPublished == 0) {
                              echo "*";
                          }

                          echo " </h4>(" . $createTime . ")<br><br>";
                          echo "<p>$text </p>";
                          echo "<hr>";
                      }
                  }
                          echo "<div id='row'> * = utkast </div>";
                break;

              /* Show all comments */
              case 'showComments':

                echo "<h2> Se alla kommentarer </h2>";

                $commentQuery  = "SELECT * FROM comments";
                mysqli_query($conn, $commentQuery);
                if ($stmt->prepare($commentQuery)) {
                    $stmt->execute();
                    $stmt->bind_result($com_id, $c_name, $c_epost, $createTime, $c_text, $fk_post_id);

                    while ($stmt->fetch()) {
                        echo "<p><a href='superuser.php?commentDelete=$com_id'>
                            <i class='fa fa-trash' aria-hidden='true'></i>
                            </a></p>";
                        echo " $c_name<br>";
                        echo " (" . $createTime . " )<br>";
                        echo "$c_text<br><hr>";
                    }
                }

                break;

              /* Show all users */
              case 'showUsers':

              echo "<h2> Se alla användare </h2>";
              $userQuery  = "SELECT * FROM users";

              mysqli_query($conn, $userQuery);

            if ($stmt->prepare($userQuery)) {
                $stmt->execute();
                $stmt->bind_result($userId, $firstName, $lastName, $email, $password, $profilePic, $role);

                while ($stmt->fetch()) {
                    echo "ID: $userId<br>";
                    echo "Namn: $firstName $lastName</br>";
                    echo "E-Post: $email</br>";
                    echo "Roll: $role</br></br>";
                    echo "<a href='superuser.php?userDelete=$userId'>
                            <i class='fa fa-trash' aria-hidden='true'></i>
                            </a>
                            <hr>";
                }
            }
                break;

              /* Register a user */
              case 'regUser':
              ?>
                <form method="post">
                    <h2 class="form-center-heading">Registrera</h2>

                    <!-- Input-field for Firstname -->
                    <div class="form-group row">
                      <label for="Förnamn" class="col-md-2 col-form-label">Förnamn:</label>
                      <div class="col-xs-10">
                        <input class="form-control" name="firstname" type="text" placeholder="Ange förnamn">
                      </div>
                    </div>

                    <!-- Input-field for Lastname -->
                    <div class="form-group row">
                      <label for="Efternamn" class="col-md-2 col-form-label">Efternamn:</label>
                      <div class="col-xs-10">
                        <input class="form-control" name="lastname" type="text" placeholder="Ange efternamn">
                      </div>
                    </div>

                    <!-- Input-field for E-Mail -->
                    <div class="form-group row">
                      <label for="E-Post" class="col-md-2 col-form-label">E-Post:</label>
                      <div class="col-xs-10">
                        <input class="form-control" name="email" type="email" placeholder="Ange E-Post">
                      </div>
                    </div>


                    <!-- Input-field for Password -->
                    <div class="form-group row">
                      <label for="Lösenord" class="col-md-2 col-form-label">Lösenord:</label>
                      <div class="col-xs-10">
                        <input class="form-control" name="password" type="password" placeholder="Ange ett lösenord">
                      </div>
                    </div>

                    <!-- Register-button -->
                    <div class="form-group row">
                      <div class="col-xs-10">
                        <input name="register" class="btn btn-lg btn-primary" type="submit" value="Registrera">
                      </div>
                    </div> <!-- end div: form-group row -->
                </form> <!-- end form -->

                <?php
                /* Call the function regUser to register user... */
                regUser();
                break;

              /* View and edit categories */
              case 'editCategories':

                echo "<h2> Redigera kategori </h2>";

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
                            <span class='input-group-btn'>
                              <input class='btn btn-default' name='addCategory' type='submit' value='Lägg till'> <!-- TODO: This button is fucked -->
                            </span>
                          </div>
                        </form>
                <?php
                break;
              /* Default CASE, no option picked (never really used BC Previous IF-statement) */
              default:
                echo "<h2> Välj ett alternativ </h2>";
                break;

            }
            /* end SWITCH */
        }
          /* end IF */
?>

<?php
          //-----------------------------------------------------------------------------
          // DELETE INFORMATION
          //  - This code is run if user wants to i.e. delete a post, user etc...
          //  - Deleting information in the database calls on a FUNCTION called deleteCommand
          //  - All FUNCTIONS can be found in functions/functions.php
          //-----------------------------------------------------------------------------

          /* Delete Post */

          if (isset($_GET["postDelete"])) {
              deleteCommand("deletePost",
            $_GET["postDelete"],
            "superuser.php?admin=showPosts");
          }

          /* Delete Comment */

          if (isset($_GET["commentDelete"])) {
              deleteCommand("deleteComment",
            $_GET["commentDelete"],
            "superuser.php?admin=showComments");
          }

          /* Delete user */

          if (isset($_GET["userDelete"])) {
              deleteCommand("deleteUser",
            $_GET["userDelete"],
            "superuser.php?admin=showUsers");
          }

          /* Delete category */

          if (isset($_GET["categoryDelete"])) {
              deleteCommand("deleteCategory",
            $_GET["categoryDelete"],
            "superuser.php?admin=editCategories");
          }

          //-----------------------------------------------------------------------------
          // ADD INFORMATION
          //  - This code is run if administrator wants to add a category
          //-----------------------------------------------------------------------------

          /* Add category */

            if (isset($_POST["addCategory"])) {
                if (!empty($_POST["nameCategory"])) {
                    $nameCategory = mysqli_real_escape_string($conn, $_POST["nameCategory"]);
                    $addQuery= "INSERT INTO categories
                                VALUES (NULL, '$nameCategory')";
                    mysqli_query($conn, $addQuery);
                    header("Location:superuser.php?admin=editCategories");
                }
            }
           ?>

         </div><!-- end div: col-md-7 -->
      <div class="col-md-2"></div> <!-- end div: col-md-2 -->
    </div> <!-- end div: container-fluid -->
  </div> <!-- end div: row -->

<?php

/* if user is a) not logged in or b) not logged in as admin redirect back to index */
}else {
  header("Location:index.php");
      }

include "footer.php";
?>

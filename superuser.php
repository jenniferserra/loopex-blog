<?php include "header.php";
$stmt = $conn->stmt_init();
      include "functions/functions.php";
?>
<div class="jumbotron">
  <div class="container-fluid">
    <h1>Kontrollpanelen</h1>
    <small>Här kan du administrera bloggen</small>
  </div>
</div>

<!-- TODO: Add if so that only those with admin privileges may use page. If not sent back to index -->

<!-- Superadmin-menu-->

  <div class="row">
    <div class="container-fluid erik-container">
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
        /* Only run switch if there get-request is sent */
        if (isset($_GET["admin"])) {

          /* Use menu selection to show requested information */

            /* Show all posts */
            switch ($_GET["admin"]) {

              case 'showPosts':

                // echo "<h2> Se alla inlägg </h2>";
                //
                // printPost();


                  echo "<h2> Se alla inlägg </h2>";

                  $postQuery  = "SELECT posts.*, users.firstname, users.lastname, users.email, categories.cat_name FROM posts
                      							LEFT JOIN users ON posts.user_id = users.user_id
                      							LEFT JOIN categories ON posts.cat_id = categories.cat_id
                      							ORDER BY create_time DESC";

                  mysqli_query($conn, $postQuery);
                  if ($stmt->prepare($postQuery)) {
                      $stmt->execute();
                      $stmt->bind_result($postId, $createTime, $editTime, $title, $text,
                												 $isPublished, $userId, $catId, $firstName,
                												 $lastName, $user_email, $catName);

                      while ($stmt->fetch()) {
                          echo "<h4>$title"; if($isPublished == 0) {
                            echo "*";
                          }

                          echo " </h4>(" . $createTime . ")<p>";
                          echo "$text </p>";
                          echo "<p><a href='superuser.php?postDelete=$postId' class='btn btn-secondary'>Radera </a></p>";
                      }
                  }
                          echo "* = utkast";
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
                        echo "$c_name";
                        echo " (" . $createTime . " )<p>";
                        echo "$c_text </p>";
                        echo "<p><a href='superuser.php?commentDelete=$com_id' class='btn btn-secondary'>Radera </a></p>";
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
                      echo "<p>ID: $userId</p>";
                      echo "<p>Namn: $firstName $lastName</p>";
                      echo "<p>E-Post: $email</p>";
                      echo "<p>Roll: $role</p><hr>";
                      echo "<p><a href='superuser.php?userDelete=$userId' class='btn btn-secondary'>Radera </a></p>";


                  }
              }
                break;

              /* Register a user */
              case 'regUser':
              ?>
              <div class="container">
                <form method="POST" class="form-horizontal form-center">
                <h2 class="form-center-heading">Registrera</h2>
                  <div class="form-group">
                    <input type="text" name="firstname" placeholder="Förnamn" class="form-control" required>
                  </div>
                  <div class="form-group">
                    <input type="text" name="lastname" placeholder="Efternamn" class="form-control" required>
                  </div>
                  <div class="form-group">
                    <input type="email" name="email" placeholder="E-post" class="form-control" required>
                  </div>
                  <div class="form-group">
                    <input type="password" name="password" placeholder="*******" class="form-control" required>
                  </div>
                  <!-- TO DO: lägg till profilbild här -->
                    <input name="register" class="btn btn-lg btn-primary" type="submit" value="Registrera">
                </form>
              <div>

                <?php
                /* Call the function regUser to register user duh.. */
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
                        echo "Namn: $catName ";
                        echo "<p><a href='superuser.php?categoryDelete=$catID' class='btn btn-secondary'>Radera </a></p>";

                    }
                }
                ?><hr>
                      <h3>Lägg till kategori</h3>
                        <p>
                        <div class='input-group'>
                          <form method='post'>
                            <input type='text' class='form-control' placeholder='Ge kategorien ett namn...' name='newCat' required>
                              <span class='input-group-btn'>
                              <input class='btn btn-secondary' name='addCat' type='submit' value='Lägg till'>
                              </span>
                            </form>
                          </div>
                <?php

                break;

              /* Default switch, inget alternativ valt */
              default:
                echo "<h2> Välj ett alternativ </h2>";
                break;

            }
            /* end switch */

        }
          /* end if */

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

           ?>
      <div class="col-md-2"></div>
      </div>
    </div>
  </div>
<?php include "footer.php"




















//
//
//
// /* Add category */
//
//   if (isset($_POST["addCat"])) {
//
//     if (!empty($_POST["newCat"])) {
//
//       $newCat = mysqli_real_escape_string($conn, $_POST["newCat"]);
//       $addQuery = "INSERT INTO categories
//                    VALUES (NULL, '$newCat')";
//       mysqli_query($conn, $addQuery);
//
//       header("Location:superuser.php?admin=editCategories");
//
//     }
//   }
?>

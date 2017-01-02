<?php include "header.php";
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


<form method="post">

  <div class="row">
    <div class="container-fluid">

      <div class="col-md-3">
        <div class="list-group">
        <a href="superuser.php?admin=showPosts" class="list-group-item">Visa alla inlägg</a>
        <a href="superuser.php?admin=showComments" class="list-group-item">Visa alla kommentarer</a>
        <a href="superuser.php?admin=showUsers" class="list-group-item">Visa alla bloggare</a>
        <a href="superuser.php?admin=regUser" class="list-group-item">Registrera ny bloggare</a>
        <a href="superuser.php?admin=editCategories" class="list-group-item">Redigera kategorier</a>
      </div>

      </div>

      <div class="col-md-9">
</form>

          <?php
        /* Only run switch if there get-request is sent */
        if(isset($_GET["admin"])) {

          /* Use menu selection to show requested information */

            /* Show all posts */
            switch ($_GET["admin"]) {

              case 'showPosts':

                echo "<h2> Se alla inlägg </h2>";

                $stmt = $conn->stmt_init();

                $query =   "SELECT posts.*, users.firstname, users.lastname, users.email, categories.cat_name FROM posts
                            LEFT JOIN users ON posts.user_id = users.user_id
                            LEFT JOIN categories ON posts.cat_id = categories.cat_id
                            ORDER BY create_time DESC";

                if (mysqli_query($conn, $query)) {
                }

                if ($stmt->prepare($query)) {
                    $stmt->execute();
                    $stmt->bind_result($postId, $createTime, $editTime, $title, $text, $isPublished, $userId, $catId, $firstName, $lastName, $user_email, $catName);

                    while (mysqli_stmt_fetch($stmt)) {


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
                            echo "<p><a href='mailto:$user_email'>$user_email</a></p>"; ?>
                                </div>
                                <div class="comments">
                                <?php
                                    echo "<a href='post.php?id=$postId' name='btn'>";
                            echo "(X) Kommentarer </a>"; ?>
                                </div>
                                <div class="edit">
                                <?php
                                if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] == true && $_SESSION["user_id"] == $userId || $_SESSION["role"] == "admin") {
                                    echo "<a href='editpost.php?editid=$postId' name='btn'>";

                                    echo "Redigera </a>";
                                } ?>
                                </div>
                            </div>
                        </div>
                        <?php

                        }

                }

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
                    }
                }

                break;

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
                        echo "<p>Namn: $catName</p>";

                    }
                }


                break;

              default:
                echo "<h2> Välj ett alternativ </h2>";
                break;

            }
            /* end switch */
          }
          /* end if */

           ?>

      </div>
    </div>
  </div>
<?php include "footer.php"?>

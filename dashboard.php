<?php
require_once "code_open.php";
?>
<body class="dashboard">
    <!-- start a wrapper -->
    <div class="page-content">
        <?php
        require_once "header.php";

        if (!isset($_SESSION["loggedin"])) {
            header('Location: index.php');
            die();
        }

        $userId = $_SESSION["user_id"];

        $sqlGetUser = "SELECT * FROM users WHERE user_id = '{$userId}' ";
        $queryGetUser = mysqli_query($conn, $sqlGetUser);

          while($getUser = mysqli_fetch_array($queryGetUser, MYSQLI_ASSOC)) {
                $userId = $getUser["user_id"];
                $firstName = $getUser["firstname"];
                $lastName = $getUser["lastname"];
                $email = $getUser["email"];
                $role = $getUser["role"];
          }



        /* ----------------------------------------------------------------------------
                SAVE POST
        ---------------------------------------------------------------------------- */

        if(isset($_POST["publish"]) || isset($_POST["draft"] )) {
            if( !empty($_POST["blogpost_title"]) &&
                !empty($_POST["blogpost_text"]) &&
                $_POST["category"] != "0" ) {

                // Preparing the statement
                $stmt = $conn->stmt_init();

                // Stripping off harmful characters
                $text = mysqli_real_escape_string($conn, $_POST["blogpost_text"]);
                $title = mysqli_real_escape_string($conn, $_POST["blogpost_title"]);

                $timeStamp = date("Y-m-d H:i:s");
                $category = $_POST["category"];

                // SAVE AS PUBLISHED
                if(isset($_POST["publish"])) {
                $query = "INSERT INTO posts VALUES (NULL, '{$timeStamp}', '', '{$title}', '{$text}', TRUE, '$userId', '$category')";
                }

                // SAVE AS DRAFT
                elseif (isset($_POST["draft"])) {
                $query = "INSERT INTO posts VALUES (NULL, '{$timeStamp}', '', '{$title}', '{$text}', FALSE, '$userId', '$category')";
                }

                // Feedback and error messages
                if ( mysqli_query($conn, $query)) {
                    $_SESSION['msg'] = "Ditt inlägg är publicerat!";
                } else {
                    $_SESSION['msg'] = "<span class='error'>Error: </span>Någonting fick fel, testa igen!";
                }
            } else {
                $_SESSION['msg'] = "<span class='error'>Error: </span>Fyll i alla fält och välj kategori!";
            }
        }

         /* ----------------------------------------------------------------------------
                HTML-STRUCTURE FOR POSTFORM
        ---------------------------------------------------------------------------- */
        ?>
        <div class="whitebox col-sm-12 col-xs-12">
            <?php echo '<div class="welcome"> Hej '. $firstName .' '. $lastName .'! </div>'; ?>
            <h1><?php if ( isset($_SESSION['msg']) ) { echo $_SESSION['msg']; unset($_SESSION['msg']); } else echo "Dags att skriva nästa succéinlägg?" ?></h1>
            <form method="POST" action="dashboard.php" class="blogposts" enctype="multipart/form-data">

                <!-- Heading -->
                <input type="text" placeholder="Skriv din rubrik här" name="blogpost_title" class="blogpost_title">
                <br>

                <!-- Upload a file -->
                <input type="file" name="fileToUpload" id="fileToUpload">
                <br>

                <!-- Post text -->
                <textarea rows="15" cols="80" placeholder="Skriv ditt inlägg här" name="blogpost_text" class="blogpost_text"></textarea>
                <br>

                <!-- Select category -->
                <select name="category" class="categories">
                    <option value ="0">Välj kategori</option>
                    <?php
                    /*-------------------------------------------------------------------
                        Looping out category-choices
                    -------------------------------------------------------------------*/
                    $sql_selectCategory = "SELECT * FROM categories";
                    $query_giveCategory = mysqli_query($conn, $sql_selectCategory);
                    while ($selectCategory = mysqli_fetch_array($query_giveCategory)) {
                    $categoryName = $selectCategory["cat_name"];
                    $categoryId = $selectCategory["cat_id"];
                    echo '<option value ="' . $categoryId . '">' . $categoryName . '</option>';
                    }
                    mysqli_close($conn);
                    ?>
                </select> <!-- .categories -->
                <br>

                <!-- Publish post button -->
                <input name="publish" class="btn button btn-lg btn-primary btn-block" type="submit" value="Publicera inlägg">

                <!-- Save as draft button -->
                <input name="draft" class="btn button btn-lg btn-primary btn-block" type="submit" value="Spara utkast">
            </form> <!-- .blogposts -->

            <?php
            /*___________________________________________________________________________________________

            **Uppladdning av uppgiftsbild**

            * 1: Användaren trycker på upload -> definiera vart bilderna ska laddas upp i $target_folder. Här används mappen som skapas genom registreringen
            * 2: Ange att namnet på filen ska sparas som ska vara "task-image-task_id.jpg" i $target_folder
            * 3: Kolla så att storleken på bilden är under 10MB, om så är fallet informeras användaren att välja en mindre bild
            * 4: Kolla så att filen är en JPG eller JPEG, om så inte är fallet informeras användaren att välja en annan bild
            * 5: Flytta bilden från dess temporära plats till användarens egna mapp

            ___________________________________________________________________________________________
            */

            // $imageQuery  = "SELECT * FROM posts";
                    //
            //     mysqli_query($conn, $imageQuery);
                    //
            //     if ($stmt->prepare($imageQuery)) {
            //         $stmt->execute();
            //         $stmt->bind_result($postId, $createTime, $editTime, $title, $image, $text, $isPublished, $userId, $catId);
                    //
            //         $postId = $conn->insert_id;
                    //
            //         $targetFolder = "postimages/";
            //         $targetName = $targetFolder . basename("post-image-".$postId.".jpg");
                    //
                    //
            //         if ($_FILES["fileToUpload"]["size"] > 10000000) {
            //             echo "<div class='message'>" . 'Filen är för stor, den får max vara 10MB.' . "</div>";
            //             exit;
            //         }
                    //
            //         $type = pathinfo($targetName, PATHINFO_EXTENSION);
            //         if ($type !== 'jpg') {
            //             echo "<div class='message'>" . 'Du kan bara ladda upp JPEG-filer' . "</div>";
            //             exit;
            //         }
                    //
            //         if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $targetName)) {
                    //
            //             $lastInsertId = mysqli_insert_id($conn);
                    //
            //             $query ="UPDATE posts SET image = '{$targetName}' WHERE post_id = '{$lastInsertId}'";
                    //
            //             if ($stmt->prepare($query)) {
            //                 $stmt->execute();
            //                 echo "<div class='message'>" . 'Uppladdningen lyckades' . "</div>";
            //             }
            //         }
            //          }
            ?>
        </div> <!-- .whitebox col-sm-12 col-xs-12 -->
    </div> <!-- .page-content -->
<?php
require_once "code_end.php";
?>

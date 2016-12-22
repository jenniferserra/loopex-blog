

		<?php
        require "header.php";

        if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] == true) {
        //-----------------------------------------------------------------------------
        // LOGGED IN
        //-----------------------------------------------------------------------------
            $userId = $_SESSION["user_id"];

            $stmt = $conn->stmt_init();

            if ($stmt->prepare("SELECT * FROM users WHERE user_id = '{$userId}' ")) {
                $stmt->execute();
                $stmt->bind_result($user_id, $firstname, $lastname, $email, $encrypt_password, $profilepic, $role);
                $stmt->fetch();
            }

        //-----------------------------------------------------------------------------
        // HTML-STRUKTUR FÖR INLÄGG
        //-----------------------------------------------------------------------------

        ?>
		<div class="blogpost-box col-sm-12 col-xs-12">
		<?php echo '<div class="welcome"> Hej '. $firstname .' '. $lastname .'! </div>'; ?>

		<h1 class="dashboard-title">Dags att skriva nästa succéinlägg?</h1>
			<form method="POST" action="dashboard.php" class="blogposts" enctype="multipart/form-data">
				<!-- Rubrik -->
        <input type="text"  value="kul test" placeholder="Skriv din rubrik här" name="blogpost_title" class="blogpost_title"><br>
				<!-- Bilduppladdning -->
				<input type="file" name="fileToUpload" id="fileToUpload"><br>
				<!-- Inläggstext -->
				<textarea rows="15" cols="80" placeholder="Skriv ditt inlägg här" name="blogpost_text" class="blogpost_text">Kul Test</textarea><br>
				<!-- Välj kategori -->
				<select name="blogpost_category" class="categories">
					<option value ="0">Välj kategori</option>
					<option value ="1" selected>Sport</option>
					<option value ="2">Mode</option>
					<option value ="3">Fotografi</option>
					<option value ="4">Annat</option>
				</select><br>
				<!-- Publicera inlägg -->
				<input name="publish" class="btn button btn-lg btn-primary btn-block" type="submit" value="Publicera inlägg">
				<!-- Spara som utkast -->
				<input name="draft" class="btn button btn-lg btn-primary btn-block" type="submit" value="Spara utkast">
			</form>


		<?php

        //-----------------------------------------------------------------------------
        // PUBLISH
        //-----------------------------------------------------------------------------
        if (isset($_POST["publish"])) {
            if (!empty($_POST["blogpost_title"]) &&
                !empty($_POST["blogpost_text"]) &&
                $_POST["blogpost_category"] != "0") {

                // Preparing the statement
                $stmt = $conn->stmt_init();

                // Stripping off harmful characters
                $text = mysqli_real_escape_string($conn, $_POST["blogpost_text"]);
                $title = mysqli_real_escape_string($conn, $_POST["blogpost_title"]);
                $timeStamp = date("Y-m-d H:i:s");
                $category = $_POST["blogpost_category"];

                // Upload post into database. Published = TRUE
                $query = "INSERT INTO posts VALUES (NULL, '{$timeStamp}', '', '{$title}', '', '{$text}', TRUE, '$user_id', '$category')";

                if (mysqli_query($conn, $query)) {
                    echo "Ditt inlägg är sparat i databasen";
                } else {
                    echo "Inlägget är inte sparat i databasen";
                }
            } else {
                echo "Du har inte fyllt i alla fält eller valt kategori";
            }


        /*___________________________________________________________________________________________

        **Uppladdning av uppgiftsbild**

        * 1: Användaren trycker på upload -> definiera vart bilderna ska laddas upp i $target_folder. Här används mappen som skapas genom registreringen
        * 2: Ange att namnet på filen ska sparas som ska vara "task-image-task_id.jpg" i $target_folder
        * 3: Kolla så att storleken på bilden är under 10MB, om så är fallet informeras användaren att välja en mindre bild
        * 4: Kolla så att filen är en JPG eller JPEG, om så inte är fallet informeras användaren att välja en annan bild
        * 5: Flytta bilden från dess temporära plats till användarens egna mapp

        ___________________________________________________________________________________________
        */

        $imageQuery  = "SELECT * FROM posts";

            mysqli_query($conn, $imageQuery);

            if ($stmt->prepare($imageQuery)) {
                $stmt->execute();
                $stmt->bind_result($postId, $createTime, $editTime, $title, $image, $text, $isPublished, $userId, $catId);

                $postId = $conn->insert_id;

                $targetFolder = "postimages/";
                $targetName = $targetFolder . basename("post-image-".$postId.".jpg");


                if ($_FILES["fileToUpload"]["size"] > 10000000) {
                    echo "<div class='message'>" . 'Filen är för stor, den får max vara 10MB.' . "</div>";
                    exit;
                }

                $type = pathinfo($targetName, PATHINFO_EXTENSION);
                if ($type !== 'jpg') {
                    echo "<div class='message'>" . 'Du kan bara ladda upp JPEG-filer' . "</div>";
                    exit;
                }

                if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $targetName)) {

                    $lastInsertId = mysqli_insert_id($conn);

                    $query ="UPDATE posts SET image = '{$targetName}' WHERE post_id = '{$lastInsertId}'";

                    if ($stmt->prepare($query)) {
                        $stmt->execute();
                        echo "<div class='message'>" . 'Uppladdningen lyckades' . "</div>";
                    }
                }
							}

        //-----------------------------------------------------------------------------
        // SAVE AS DRAFT
        //-----------------------------------------------------------------------------

        if (isset($_POST["draft"])) {
            if (!empty($_POST["blogpost_title"]) &&
                !empty($_POST["blogpost_text"]) &&
                $_POST["category"] != "0") {

                // Preparing the statement
                $stmt = $conn->stmt_init();

                // Stripping off harmful characters
                $text = mysqli_real_escape_string($conn, $_POST["blogpost_text"]);
                $title = mysqli_real_escape_string($conn, $_POST["blogpost_title"]);

                $timeStamp = date("Y-m-d H:i:s");
                $category = $_POST["category"];

                // Upload post into database. Published = FALSE
                $query = "INSERT INTO posts VALUES (NULL, '{$timeStamp}', '', '{$title}', '{$text}', FALSE, '$user_id', '$category')";

                if (mysqli_query($conn, $query)) {
                    echo "Ditt inlägg är sparat i databasen";
                } else {
                    echo "Inlägget är inte sparat i databasen";
                }
            } else {
                echo "Du har inte fyllt i alla fält eller valt kategori";
            }
        } ?>
	</div>



<!-- if logged in -->
<?php

            } else {
                //-----------------------------------------------------------------------------
// LOGGED OUT
//-----------------------------------------------------------------------------
    echo "Du är inte inloggad";
                echo "<br><a href='login.php'>Logga in</a>";
            }
        }
require "footer.php";
?>

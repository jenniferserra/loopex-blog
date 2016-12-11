<?php
require "header.php";

$stmt = $conn->stmt_init();

$query = "SELECT posts.*, users.firstname, users.lastname, categories.cat_name FROM posts
            LEFT JOIN users ON posts.user_id = users.user_id
            LEFT JOIN categories ON posts.cat_id = categories.cat_id
            ORDER BY create_time DESC";

if ( mysqli_query($conn, $query) ) {
}
if($stmt->prepare($query)) {
	$stmt->execute();
	$stmt->bind_result($postId, $createTime, $editTime, $title, $text, $isPublished, $userId, $catId, $firstName, $lastName, $catName);
?>

        <div class="row">
          <div class="col-md-2"></div>
            <div class="col-md-8">
              <h1>Välj ett utkast att redigera</h1>
              <?php
              while(mysqli_stmt_fetch($stmt)) {
              if(isset($isPublished) && $isPublished == FALSE) {
              ?>
                <div class="form-check">
                  <label class="form-check-label">
                    <input class="form-check-input" type="radio" name="exampleRadios" id="exampleRadios1" value="option1" checked>
                    <?php echo "$title " . "$createTime"; }} ?>
                  </label>
                  <input name="edit" class="btn btn-sm btn-primary btn-block" type="submit" value="Redigera utkast">
                  <input name="delete" class="btn btn-sm btn-primary btn-block" type="submit" value="Radera utkast">

                </div>

              </div>
              <div class="col-md-2"></div>
            </row>
        <?php
        }
require "footer.php";
?>

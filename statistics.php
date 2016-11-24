<?php

require "header.php";

$conn->stmt_init();

$query = "SELECT count(*) as post_count FROM posts where user_id = '$user_id'";
$res = $conn->query($query);

$resArray = $res->fetch_assoc();

echo "Du har skrivit ". $resArray['post_count'] . " inlägg.<br>";



$query = "SELECT count(*) as comment_count FROM comments";
$res = $conn->query($query);

$resArray = $res->fetch_assoc();

echo "Du har " . $resArray['comment_count'] . " kommentarer.";

require "footer.php";


//detta kan man använda om man har en superuser som vill se vad alla användarna har för post count

//SELECT user_id, count(*) as postcount_per_user FROM posts WHERE user_id in (SELECT user_id FROM users) GROUP BY user_id




?>
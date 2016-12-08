<?php

// require "header.php";

require_once 'dbconnect.php';

// $conn->stmt_init();

$query = "SELECT COUNT(*) AS count FROM posts WHERE user_id = 15";
$post = $conn->query($query)->fetch_object();

echo "Du har skrivit ". $post->count . " inlägg.<br>";

//SELECT * FROM `comments` WHERE fk_post_id = 150

$query = "SELECT COUNT(*) AS count FROM comments";
$comment = $conn->query($query)->fetch_object();

echo "Du har " . $comment->count . " kommentarer.<br>";

$spare = $comment->count/$post->count;
$step = 1;
$nbr = round($spare * $step,-0.5) / $step;

echo "Du har " . $nbr . " kommentarer per inlägg.";

// // räkna inlägg 
// $NumberOfPosts = NULL;
// $errorMessage = NULL;
// // Fetching post row id from database
// $query = "SELECT post_id FROM posts WHERE is_published = 1 AND user_id = '{$user_id}'";

// if ($stmt->prepare($query)) {

//     $stmt->execute();
//     $stmt->bind_result($post_id);
// } else {
//     $errorMessage = "Något gick fel vid försök att hämta statistik";
// }
// // Counting number of posts id and sums it up
// while (mysqli_stmt_fetch($stmt)) {

//     $stmt->store_result();
//     $NumberOfPosts++;
// }
// echo $NumberOfPosts . " inlägg";

require "footer.php";
//detta kan man använda om man har en superuser som vill se vad alla användarna har för post count

//SELECT user_id, count(*) as postcount_per_user FROM posts WHERE user_id in (SELECT user_id FROM users) GROUP BY user_id
?>
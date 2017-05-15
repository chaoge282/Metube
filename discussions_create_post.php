<?php
session_start();
include_once "function.php";


// get form input
// var_dump($_POST);
$disc_id = $_POST['disc_id'];
$user_id = $_SESSION['user_id'];
$text = mysql_real_escape_string($_POST['text']);
$time = date('Y-m-d H:i:s');

// create 
$query = "INSERT INTO `db_76dp`.`Post` (`Id`, `Discussion`, `User`, `Text`, `Time`) 
VALUES (NULL, $disc_id, $user_id, '$text', '$time');";

$retval = mysql_query( $query );
if(! $retval ) {
    die('Could not create group: ' . mysql_error()." ".$query);
}

// return to the original page
header("Location: single_discussion.php?disc_id=$disc_id")


?>




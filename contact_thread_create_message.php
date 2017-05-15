<?php
session_start();
include_once "function.php";


// get form input
// var_dump($_POST);
$to_id = $_POST['to_id'];
$from_id = $_SESSION['user_id'];
$text = mysql_real_escape_string($_POST['text']);
$time = date('Y-m-d H:i:s');

// create 
$query = "INSERT INTO `db_76dp`.`Message` (`Id`, `Sender`, `Reciever`, `Text`, `SentTime`) 
VALUES (NULL, $from_id, $to_id, '$text', '$time');";

$retval = mysql_query( $query );
if(! $retval ) {
    die('Could not create it: ' . mysql_error()." ".$query);
}

// return to the original page
header("Location: contact_thread.php?contact_id=$to_id")


?>


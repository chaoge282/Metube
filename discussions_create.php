<?php
session_start();
include_once "function.php";


// get form input
// var_dump($_POST);
$disc_name = mysql_real_escape_string($_POST['disc_name']);
$group_id = $_POST['group_id'];
$user_id = $_SESSION['user_id'];


// create 
$query = "INSERT INTO `db_76dp`.`Discussion` (`Id`, `Title`, `DiscGroup`, `Owner`) 
VALUES (NULL, '$disc_name', $group_id, $user_id);";

$retval = mysql_query( $query );
if(! $retval ) {
    die('Could not create group: ' . mysql_error());
}


// return to the original page
header('Location: discussions.php')

?>




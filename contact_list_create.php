<?php
session_start();
include_once "function.php";


// get form input
// var_dump($_POST);
$name = mysql_real_escape_string($_POST['name']);
$user_id = $_SESSION['user_id'];


// create the specified groups
$query = "INSERT INTO `db_76dp`.`ContactList` (`Id`, `Name`, `Owner`) 
VALUES (NULL, '$name', $user_id);";

$retval = mysql_query( $query );
if(! $retval ) {
    die('Could not create thing: ' . mysql_error());
}


// return to the original page (groups.php) 
header('Location: contacts.php')

?>




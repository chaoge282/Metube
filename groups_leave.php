<?php
session_start();
include_once "function.php";


// get form input
//~ var_dump($_POST);
$group_id_to_leave = $_POST['group'];
$user_id = $_SESSION['user_id'];

// delete the specified groups
$query = "DELETE FROM `IsInDiscGroup` WHERE `User` = $user_id and DiscGroup=$group_id_to_leave";
$retval = mysql_query( $query );
if(! $retval ) {
    die('Could not delete data: ' . mysql_error());
}

// return to the original page (groups.php) 
header('Location: groups.php')

?>



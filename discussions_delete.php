<?php
session_start();
include_once "function.php";


// get form input
//~ var_dump($_POST);
$disc_id_to_delete = $_POST['discussion_to_delete']; //discussion_to_delete

// delete the specified groups
$query = "DELETE FROM `Discussion` WHERE `Discussion`.`Id` = $disc_id_to_delete";
$retval = mysql_query( $query );
if(! $retval ) {
    die('Could not delete data: ' . mysql_error());
}

// return to the original page (groups.php) 
header('Location: discussions.php')

?>



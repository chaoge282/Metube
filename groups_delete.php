<?php
session_start();
include_once "function.php";


// get form input
//~ var_dump($_POST);
$group_id_to_delete = $_POST['group_to_delete'];

// delete the specified groups
$query = "DELETE FROM `DiscGroup` WHERE `DiscGroup`.`Id` = $group_id_to_delete";
$retval = mysql_query( $query );
if(! $retval ) {
    die('Could not delete data: ' . mysql_error());
}

// return to the original page (groups.php) 
header('Location: groups.php')

?>



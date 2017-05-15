<?php
session_start();
include_once "function.php";


// get form input
//~ var_dump($_POST);

$to_delete = $_POST['id_to_remove'];

// delete the specified groups
$query = "DELETE FROM `ContactList` WHERE `Id` = $to_delete";
$retval = mysql_query( $query );
if(! $retval ) {
    die('Could not delete data: ' . mysql_error());
}

// return to the original page
header('Location: contacts.php')

?>



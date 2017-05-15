<?php
session_start();
include_once "function.php";


// get form input
// var_dump($_POST);
$name = mysql_real_escape_string($_POST['name']);
$category_id = $_POST['category'];
$user_id = $_SESSION['user_id'];


// create the specified groups
$query = "INSERT INTO  `db_76dp`.`DiscGroup` (
`Id` ,
`Name` ,
`Owner` ,
`Category`
)
VALUES (
NULL ,  '$name',  '$user_id',  '$category_id'
)";

$retval = mysql_query( $query );
if(! $retval ) {
    die('Could not create group: ' . mysql_error());
}


// return to the original page (groups.php) 
header('Location: groups.php')

?>




<?php
session_start();
include_once "function.php";


// get form input
//~ var_dump($_POST);
$to_join = $_POST['group_to_join'];
$user_id = $_SESSION['user_id'];

// delete the specified groups
$query = "INSERT INTO `db_76dp`.`IsInDiscGroup` (`Id`, `User`, `DiscGroup`) VALUES (NULL, '$user_id', '$to_join');";
$retval = mysql_query( $query );
if(! $retval ) {
    die('Could not delete data: ' . mysql_error());
}

// return to the original page (groups.php) 
header('Location: groups.php')

?>



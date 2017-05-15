<?php
	session_start();
	include_once "function.php";
?>	
<?php
	$mediaid=$_REQUEST['id'];
	$query = "select * from Media where Id='$mediaid'";
	$result = mysql_query($query);
	$path = mysql_fetch_assoc($result)['Path'];

	$query="delete from Media where Id='$mediaid'";
	$result=mysql_query($query);
	
	unlink($path);
			
?>

<meta http-equiv="refresh" content="0;url=mychannel.php">

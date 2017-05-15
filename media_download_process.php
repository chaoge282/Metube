<?php
session_start();
include_once "function.php";

/******************************************************
*
* download by username
*
*******************************************************/
date_default_timezone_set("America/New_York");
$time=date("y-m-d,h:i:sa");
$username=$_SESSION['username'];
$mediaid=$_REQUEST['id'];

$query="select * from User where Username='$username' ";
$result=mysql_query($query);
$userId = mysql_fetch_assoc($result)['Id'];

$mquery="select * from Media where Id='$mediaid'";
$mresult=mysql_query($mquery);
$path=mysql_fetch_assoc($mresult)['Path'];
$extension = pathinfo($path, PATHINFO_EXTENSION);
if($extension== "jpg" || $extension== "png" || $extension== "gif" || $extension== "jpeg")
    {
        $type="image/".$extension;
    }
elseif($extension== "mp4" || $extension== "avi" || $extension== "rmvb" || $extension== "flv" || $extension== "mov" || $extension= "mkv")
    {
        $type="video/".$extension;
    }
else
    {
        $type="audio/".$extension;
    }

//insert into download table
$insertDownload="insert into Download(User,Media,StartTime,Id) values('$userId','$mediaid','$time',NULL)";
$queryresult = mysql_query($insertDownload);
if(!$queryresult){
	die ("Could not insert into download table: <br />". mysql_error());
}

if (file_exists($path)) {
    header('Content-Description: File Transfer');
    header('Content-Type: $type');
    header('Content-Disposition: attachment; filename="'.basename($path).'"');
    header('Content-Transfer-Encoding: binary');
    header('Expires: 0');
    header('Cache-Control: must-revalidate');
    header("Cache-Control: private",false);
    header('Pragma: public');
    header('Content-Length: ' . filesize($path));
    ob_clean();
    flush();
    readfile($path);
    exit;
}
else
{
	echo 'file does not exist.';
}

?>



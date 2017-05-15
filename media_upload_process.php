<?php
session_start();
include_once "function.php";

/******************************************************
*
* upload document from user
*
*******************************************************/
date_default_timezone_set("America/New_York");
$time=date("y-m-d,h:i:sa");
$username=$_SESSION['username'];
$sharingLevel=$_POST['sharingLevel'];
$description=mysql_real_escape_string($_POST['description']);
$category=$_POST['category'];
$title=mysql_real_escape_string($_POST['title']);
$path=$_FILES["file"]["name"];
$extension = pathinfo($path, PATHINFO_EXTENSION);
$bytes=$_FILES["file"]["size"];
$size = (int)($bytes / 1048576);
$keywords = mysql_real_escape_string($_POST['keywords']); //new
$keywords = explode(', ', $keywords); // new

$query="select * from Category where Description='$category'";
$caresult=mysql_query($query);
$categoryId=mysql_fetch_assoc($caresult)['Id'];

$query="select * from User where Username='$username'";
$qresult=mysql_query($query);
$userId=mysql_fetch_assoc($qresult)['Id'];
//$processUser = posix_getpwuid(posix_geteuid());
//  echo($processUser['name']);
//Create Directory if doesn't exist
if(!file_exists('uploads/'))
	mkdir('uploads/', 0757);
$dirfile = 'uploads/'.$username.'/';
if(!file_exists($dirfile)){
	mkdir($dirfile,0755);
	chmod( $dirfile,0755);
}
if($_FILES["file"]["error"] > 0 )
	{ 	$result=$_FILES["file"]["error"];} //error from 1-4
else
{
	$upfile = $dirfile.$_FILES["file"]["name"];
	if($extension== "jpg" || $extension== "png" || $extension== "gif" || $extension== "jpeg")
	{
		$type="Image";
	}
	elseif($extension== "mp4" || $extension== "avi" || $extension== "rmvb" || $extension== "flv" || $extension== "mov" || $extension== "mkv")
	{
		$type="Video";
	}
	elseif($extension== "mp3" || $extension== "wma" || $extension== "wav" || $extension== "raw" || $extension== "3gp")
	{
		$type="Audio";
	}
	else
	{
		$result="5";
	}
	if($size >200)
	{
	  	$result ="6";
	}
	else
	{
	  	if(file_exists($upfile))
	  	{
	  		$result="7"; //The file has been uploaded.
	  	}
	  	else
	  		{
				if(is_uploaded_file($_FILES["file"]["tmp_name"]))
				{
					if(!move_uploaded_file($_FILES["file"]["tmp_name"],$upfile))
					{
						$result="8"; //Failed to move file from temporary directory
					}
					else /*Successfully upload file*/
					{


						// insert into keywords table
						$sql_to_insert_keys = "insert ignore into Keyword(Text) Values";
						$keyword_texts = "(";

						$i = 0;
						for ($i; $i<count($keywords)-1; $i++){
							$sql_to_insert_keys .= "('{$keywords[$i]}'),";
							$keyword_texts .= "'{$keywords[$i]}', ";
						}
						$sql_to_insert_keys .= "('{$keywords[$i]}');"; 	// fencepost
						$keyword_texts .= "'{$keywords[$i]}')";

						$success = mysql_query($sql_to_insert_keys);
						if(!$success){ die("fail: ".mysql_error());}


						//insert into media table
						$insert = "insert into Media(Id, Title, Path, FileType, SharingLevel, Description, Size, Category, User, UploadTime)values(NULL,'$title','$upfile','$type','$sharingLevel','$description','$size','$categoryId','$userId','$time')";
						$queryresult = mysql_query($insert)
						  or die("Insert into Media error in media_upload_process.php " .mysql_error());
						  
						// get id of media that was inserted
						$sql_get_last_insert = "SELECT Id from Media order by Id DESC limit 1;";
						$r_last_insert = mysql_query($sql_get_last_insert);
						$id_last_media_inserted = mysql_fetch_array($r_last_insert)[0];


						// insert into HasKeyword table
						// get keyword ids, and insert a row into the HasKeyword for each
						// "select Id from Keyword where Text in ('a', 'b', 'c');"
						$keyword_ids_query = "select Id from Keyword where Text in {$keyword_texts};";
						$keyword_ids = mysql_query($keyword_ids_query);
						if (!$keyword_ids) die("could not get keyword ids <br> ". mysql_error(). "<br>" . $keyword_ids_query);

						$sql_to_insert_into_HasKeywords = "insert into HasKeyword (`Keyword`, `Media`) values ";
						$row = mysql_fetch_assoc($keyword_ids); // stupid fencepost problem
						$sql_to_insert_into_HasKeywords .= "({$row['Id']}, $id_last_media_inserted)";
						while ($row = mysql_fetch_assoc($keyword_ids) ){
								$sql_to_insert_into_HasKeywords .= ", ({$row['Id']}, $id_last_media_inserted)";
						}
						$sql_to_insert_into_HasKeywords .= ";";
						// actually insert into HasKeyword table
						$result_HasKeywords = mysql_query($sql_to_insert_into_HasKeywords);
						if (!$result_HasKeywords){
							die ("failed to insert into HasKeywords<br> $sql_to_insert_into_HasKeywords");
						}

						$result="0";
						chmod($upfile, 0755);
					}
				}
				else  
				{
					$result="9"; //upload file failed
				}
			}
		}
	}
	
	$errorInfo = upload_error($result);
	echo "Information:".$errorInfo;
?>

<meta http-equiv="refresh" content="0;url=mychannel.php?result=<?php echo $result;?>">

<?php
	session_start();
	include_once "function.php";
?>
<?php
if(isset($_POST['submit'])){
	$mediaid = $_REQUEST['id'];
	$title=$_POST['title'];
	$sharingLevel=$_POST['sharingLevel'];
	$description=$_POST['description'];
	$category=$_POST['category'];
	
	$query="select * from Category where Description='$category'";
	$caresult=mysql_query($query);
	$categoryId=mysql_fetch_assoc($caresult)['Id'];
	$keywords = mysql_real_escape_string($_POST['keywords']);
	$keywords = explode(', ', $keywords);
	if($_POST['submit']== "Cancel"){
		header('Location: mychannel.php');
	}else{
		
		// Media table
		$query = "update Media set Title='$title', Description='$description', Category='$categoryId',  			SharingLevel='$sharingLevel' where Id ='$mediaid'";
		$result = mysql_query($query);
		if($result)
			echo "update successfully!";
		else
			echo "failed update!";
		header('Location: mychannel.php');
		
		// get id of media that was inserted
		$sql_get_last_insert = "SELECT Id from Media order by Id DESC limit 1;";
		$r_last_insert = mysql_query($sql_get_last_insert);
		$id_last_media_inserted = mysql_fetch_array($r_last_insert)[0];

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

		// remove entries saying that the media has other keywords
		$q_has_keywords = "delete from HasKeyword where Media=$mediaid";
		$r_has_keywords = mysql_query($q_has_keywords);
		if (!$r_has_keywords) { die("fail: <br>".mysql_error()." <br>".$q_has_keywords);}
		

		// insert into HasKeyword table
			// get keyword ids
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
			// insert a row into HasKeyword table for each keyword id
		$result_HasKeywords = mysql_query($sql_to_insert_into_HasKeywords);
		if (!$result_HasKeywords){
			die ("failed to insert into HasKeywords<br> $sql_to_insert_into_HasKeywords");
		}
	}
}
?>

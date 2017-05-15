<?php
session_start();
include_once "function.php";
?>


<?php include 'header.php'; ?>

<body>
<?php include "navbar.php"; ?>

    <div class="container mt-5 offset-2">
        <div class="col-12 col-md-9">
          <div class="row">
              <div class="col-10 col-lg-15">
                  <h2>Searched Media</h2>
                  <br>
                  
     
<?php
$user_id = 0;
if (isset($_SESSION['user_id'])) $user_id = $_SESSION['user_id'];

$query_end = " and Media.Id not in 
					(select Media.Id from Media, BlockedList
					where 
						Media.User = BlockedList.Owner
					and $user_id = BlockedList.Member)
				and Media.Id not in 
					(select Media.Id from Media where Media.SharingLevel = 'Private')
				and Media.Id not in 
					(
					select Media.Id from Media
					where Media.SharingLevel = 'Friends'
						and Media.Id not in 
						(select Media.Id from Media, ContactList, IsInContactList where
							Media.SharingLevel = 'Friends'
							and Media.User = ContactList.Owner
							and ContactList.Name = 'Friends'
							and ContactList.Id = IsInContactList.List
							and IsInContactList.User = $user_id
						)
						and Media.Id not in 
						(select Media.Id from Media where Media.User = $user_id)
					)";


if(isset($_REQUEST['search'])){
	$Search = $_REQUEST['search'];
	$query = "select * from Keyword where Text='$Search'";
	$result = mysql_query($query);
	if(!$result){
	
		die ("No media with that keywords: <br />". mysql_error());
	}
	else{

		if (mysql_num_rows($result) != 0){

		$keyword=mysql_fetch_assoc($result);
		$wordId=$keyword['Id'];
		$query = "select * from Media where Id in (select Media from HasKeyword where Keyword = $wordId)".$query_end;
		$sresult = mysql_query($query);
		make_media_table(5,$sresult); 
		} else {
		echo "There are no results for that keywords!";
		}
	}
}
	if(isset($_REQUEST['name'])){
		if($_REQUEST['name'] == "Video"){
			$query = "select * from Media where FileType = 'Video'".$query_end;
			$result = mysql_query($query);
			make_media_table(5,$result);
		}
		if($_REQUEST['name'] == "Audio"){
			$query = "select * from Media where FileType = 'Audio'".$query_end;
			$result = mysql_query($query);
			make_media_table(5,$result);
		}
		if($_REQUEST['name'] == "Image"){
			$query = "select * from Media where FileType = 'Image'".$query_end;
			$result = mysql_query($query);
			make_media_table(5,$result);
		}
		if($_REQUEST['name'] == "Today"){
			$query = "select * from Media where (day(curdate())-day(UploadTime)) <1".$query_end;
			$result = mysql_query($query);
			make_media_table(5,$result);

		}
		if($_REQUEST['name'] == "Week"){
			$query = "select * from Media where (day(curdate())-day(UploadTime)) <7".$query_end;
			$result = mysql_query($query);
			make_media_table(5,$result);
		}
		if($_REQUEST['name'] == "Month"){
			$query = "select * from Media where (day(curdate())-day(UploadTime)) <30".$query_end;
			$result = mysql_query($query);
			make_media_table(5,$result);
		}
		if($_REQUEST['name'] == "Year"){
			$query = "select * from Media where (day(curdate())-day(UploadTime)) <365".$query_end;
			$result = mysql_query($query);
			make_media_table(5,$result);
		}
		if($_REQUEST['name'] == "vssize"){
			$query = "select * from Media where Size < 1".$query_end;
			$result = mysql_query($query);
			make_media_table(5,$result);
		}
		if($_REQUEST['name'] == "ssize"){
			$query = "select * from Media where Size > 1 and Size < 10".$query_end;
			$result = mysql_query($query);
			make_media_table(5,$result);
		}
		if($_REQUEST['name'] == "msize"){
			$query = "select * from Media where Size >10 and Size<100".$query_end;
			$result = mysql_query($query);
			make_media_table(5,$result);
		}
		if($_REQUEST['name'] == "lsize"){
			$query = "select * from Media where Size>100 and Size<1024".$query_end;
			$result = mysql_query($query);
			make_media_table(5,$result);
		}
		if($_REQUEST['name'] == "vlsize"){
			$query = "select * from Media where Size>1024".$query_end;
			$result = mysql_query($query);
			make_media_table(5,$result);
		}
	}
		
?>

       		</div><!--/row-->
            </div><!--/span-->
      </div><!--/row-->

      <hr>

      <footer>
        <p>&copy; Database 2017</p>
      </footer>

  </div><!--/.container-->

<script type="text/javascript" src="js/navbar.js"></script>
<?php include 'footer.php'; ?>
    
    
  </body>
</html>

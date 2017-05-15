<?php
ob_start();
include_once "mysqlClass.inc.php";


function user_exist_check ($username, $password){

	$query = "select * from User where username='$username'";
	$result = mysql_query( $query );
	if (!$result){
		die ("user_exist_check() failed. Could not query the database: <br />". mysql_error());
	}	
	else {
		$row = mysql_fetch_assoc($result);
		if($row == 0){
			$query = "insert into User values ('$username','$password',NULL)";
			echo "insert query:" . $query;
			$insert = mysql_query( $query );
			if($insert)
				return 1;
			else
				die ("Could not insert into the database: <br />". mysql_error());		
		}
		else{
			return 2;
		}
	}
}

function is_subscribed($subscriber_id, $media_id){
	// is subscriber_id subscribed to the account of media_id

	$query = "select IsSubscribed.ToUser from IsSubscribed, Media where 
	$subscriber_id = IsSubscribed.FromUser
	and IsSubscribed.ToUser = Media.User
	and Media.Id = $media_id
	;";
	$result = mysql_query( $query );
	if (!$result){
		die ("failed is_subscribed: <br />".$query. mysql_error());
	}	
	if (mysql_num_rows($result) == 0) {// no subscription record, so not subscribed
		return false;
	}else {
		return true; 
	}

}
function is_blocked($blocker_id, $media_id){
	// is the account of media_id blocked by blocker_id
	// from_user -> Owner
	$query = "select BlockedList.Member from BlockedList, Media where 
	$blocker_id = BlockedList.Owner
	and BlockedList.Member = Media.User 
	and Media.Id = $media_id
	;";
	$result = mysql_query( $query );
	if (!$result){
		die ("failed is_blocked: <br />".$query. mysql_error());
	}	
	if (mysql_num_rows($result) == 0) {// no  record, so not blocked
		return false;
	}else {
		return true; 
	}

}

function get_user_id_for_media($media_id){
	$q1 = "select User.Id from Media, User 
	where Media.Id = $media_id
	and User.Id = Media.User
	 ;";
	$r1 = mysql_query($q1);
	if (!$r1){ die ("failed to get user id for media <br>".mysql_error()."<br>".$q1);}
	$i1 = mysql_fetch_assoc($r1);
	$subscribe_to_id = $i1['Id'];
	return $subscribe_to_id;
}

function subscribe($subscriber, $media_id){

	$subscribe_to_id = get_user_id_for_media($media_id);
	
	$query = "INSERT INTO `db_76dp`.`IsSubscribed` (`FromUser`, `ToUser`, `Id`) VALUES ('$subscriber', '$subscribe_to_id', NULL);";
	$r = mysql_query($query);
	if (!$r){ die ("failed to subscribe <br>".mysql_error()."<br>".$query);}
}

function block($blocker, $media_id){

	$subscribe_to_id = get_user_id_for_media($media_id);
	
	//~ $query = "INSERT INTO `db_76dp`.`IsSubscribed` (`FromUser`, `ToUser`, `Id`) VALUES ('$blocker', '$subscribe_to_id', NULL);";
	$query = "INSERT INTO `db_76dp`.`BlockedList` (`Owner`, `Member`, `Id`) VALUES ('$blocker', '$subscribe_to_id', NULL);";
	$r = mysql_query($query);
	if (!$r){ die ("failed to block <br>".mysql_error()."<br>".$query);}
}

function unsubscribe($subscriber, $media_id){

	$unsubscribe_from_id = get_user_id_for_media($media_id);

	$query ="DELETE FROM `db_76dp`.`IsSubscribed` WHERE `IsSubscribed`.`ToUser` = $unsubscribe_from_id
	and FromUser = $subscriber";
	$r = mysql_query($query);
	if (!$r){ die ("failed to unsubscribe <br>".mysql_error()."<br>".$query);}
}

function unblock($subscriber, $media_id){
		// from_user -> Owner


	$unsubscribe_from_id = get_user_id_for_media($media_id);

	$query ="DELETE FROM `db_76dp`.`BlockedList` WHERE `BlockedList`.`Member` = $unsubscribe_from_id
	and Owner = $subscriber";
	$r = mysql_query($query);
	if (!$r){ die ("failed to unsubscribe <br>".mysql_error()."<br>".$query);}
}

function user_pass_check($username, $password)
{
	
	$query = "select * from User where username='$username'";
	//echo  $query;
	$result = mysql_query( $query );
		
	if (!$result)
	{
	   die ("user_pass_check() failed. Could not query the database: <br />". mysql_error());
	}
	else{
		$row = mysql_fetch_row($result);
		if(strcmp($row[1],$password))
			return 2; //wrong password
		else 
			return 0; //Checked.
	}	
}

function updateMediaTime($mediaid)
{
	$query = "	update  media set lastaccesstime=NOW()
   						WHERE '$mediaid' = mediaid
					";
					 // Run the query created above on the database through the connection
    $result = mysql_query( $query );
	if (!$result)
	{
	   die ("updateMediaTime() failed. Could not query the database: <br />". mysql_error());
	}
}

function upload_error($result)
{
	//view erorr description in http://us2.php.net/manual/en/features.file-upload.errors.php
	switch ($result){
	case 0:
		return "Successfully uploaded";
	case 1:
		return "UPLOAD_ERR_INI_SIZE";
	case 2:
		return "UPLOAD_ERR_FORM_SIZE";
	case 3:
		return "UPLOAD_ERR_PARTIAL";
	case 4:
		return "UPLOAD_ERR_NO_FILE";
	case 5:
		return "This kind of file can't be uploaded";
	case 6:
		return "This file is too large";
	case 7:
		return "File has already been uploaded";
	case 8:
		return  "Failed to move file from temporary directory";
	case 9:
		return  "Upload file failed";
	}
}

function other()
{
	//You can write your own functions here.
}

function make_media_table($num_cols, $media){ // "media" should be mysql_query() result
	
	if (mysql_num_rows($media) != 0){
	// start the table
	$result = "<table width='100%' cellpadding='0' cellspacing='0' class='table'>";
		
	$counter = 0; // keeps track of when to start/end a row
	while ($one_media = mysql_fetch_assoc( $media ) ){ //for each table item
	  $path = $one_media['Path'];
	  $title = $one_media["Title"];//substr($path, 7);
	  $mediaid=$one_media['Id'];
	  $type = $one_media['FileType'];
	  $extension = pathinfo($path, PATHINFO_EXTENSION);
	  $str = "$type\\$extension";

	  if ($counter == 0){	// start a row, if necessary
		  $result .=   "<tr valign='top'>";
	  }
	  
	  // add a detail
	  $result .=" 
			<td>
			  <div class='media'>
				  <div class='media-left'>
					 <a href='media.php?id=$mediaid' class='thumbnail'>";

	if($type == 'Video')
		$result .="<img class='media-object' alt='video' width='100' height='80' src=./icons/videoIcon.png />";

	elseif($type == 'Audio')
		$result .="<img class='media-object' alt='audio' width='100' height='80' src=./icons/audioIcon.png />";

	else
		$result .="<img class='media-object' alt='image' width='100' height='80' src=$path />";

	$result .="
		</a>
		 <br>
		<label>$str</label>
		<br>
		<a href='media.php?id=$mediaid'> $title</a>
				  </div>
			  </div>
			</td>
			";
			
	 if ($counter == $num_cols){ // end the row, if necessary
		 $result .= "</tr>";
	 }

	$counter++;
	$counter = $counter % $num_cols;
	}

	 
	// end the table
	$result .= "</table>";
	echo $result;
	} else {
		echo "No results";
	}
}


function display_groups($media, $can_delete = false, $can_join=false, $can_leave = false){ // "media" should be mysql assoc array of media
	
	// start the table
	//~ $result = "<table width='100%' cellpadding='0' cellspacing='0' class='table'>";
	$result = "<table class='table'>";
		
	while ($one_media = mysql_fetch_assoc( $media ) ){ //add a group
	  $title = $one_media["Name"];
	  $id = $one_media["Id"];
	  
	  $result .="<tr>";
				
	  $result.="
			<td>
			  $title
			</td>
			";
			
	  if ($can_delete){
		    $result.="
			<td>
			  <label 'form-check-label'>
					<input type='radio' id='group_$id' name='group_to_delete' value='$id' > 
					Delete
			  </label>
			</td>
			";
			// note we gave the radio buttons the same name but different values, per this:  http://stackoverflow.com/questions/8416099/php-testing-if-a-radio-button-is-selected-and-get-the-value
	  }
	  
	  if ($can_join){
		  $result .= "
					<td>
						<form action='groups_join.php' method='POST'>
							<input type='hidden' name='group_to_join' value='$id'>
							<button type='submit' class='btn '>Join</button>
						</form>
					</td>
					";
	  }
	  
	  if ($can_leave){
		  $result .= "
					<td>
						<form action='groups_leave.php' method='POST'>
							<input type='hidden' name='group' value='$id'>
							<button type='submit' class='btn '>Leave</button>
						</form>
					</td>
					";
	  }
	  
	  $result.="</tr>";
			
	}

	 
	// end the table
	$result .= "</table>";
	echo $result;
}

function display_discussions($media, $can_delete = false){ // "media" should be mysql assoc array of media


	$result = "<table class='table table-hover'>";
	$prev_group_name = "";

	while($item = mysql_fetch_assoc( $media ) ){
		$group_name = $item["group_name"];
		$disc_name = $item["disc_name"];
		$disc_id = $item["disc_id"];

		if($prev_group_name == "" or $prev_group_name != $group_name){ // a new group: so make a header
			$result .= 	"
							<thead>
								<tr><th>$group_name</th></tr>
							</thead>
							<tbody>";
		}

		$result .= "<tr><td><a href='single_discussion.php?disc_id=$disc_id'>$disc_name</a></td>";
		if ($can_delete) {
			$result .="<td>
							<form action='discussions_delete.php' method='POST'>
								<input type='hidden' name='discussion_to_delete' value='$disc_id'>
								<button type='submit' class='btn btn-primary'>Delete</button>
							</form>
						</td>";
		}
		$result .= "</tr>";


		if($prev_group_name == "" or $prev_group_name != $group_name){ // close the body
			$result .= "</tbody>";
		}

		$prev_group_name = $group_name;
	}
	$result .= "</table>";
	echo $result;

}

function display_single_discussion($qresult, $disc_id){
	$r= "<div class='list-group'>";
	$first_time = true;
	$no_row = false;
	
	while ($i = mysql_fetch_assoc( $qresult) ){
		
			if ($first_time){ // print dicussion title for first post
				$disc_name = $i['Title'];
				$first_time = false;
				$r.="<h2>Discussion: $disc_name</h2>";
			}

			$date = $i['Time'];
			$date=date_create($date);
			$date = date_format($date,"m/d H:i");
			$text = $i['Text'];
			$user_name = $i['Username'];

			$r .= "
			<div class='list-group-item align-items-start'>
				<div class='d-flex w-100 justify-content-between'>
					<p class='mb-1'>$text</p>
					<small>$date</small>
				</div>
				<small>$user_name</small>
			</div>";
	}
	
	$r .= "
		<div class='list-group-item  align-items-start'>
			<div class='form-group'>
				<form action='discussions_create_post.php' method='POST'>
					<input type='hidden' name='disc_id' value='$disc_id'>
					<textarea rows='5' cols='100' class='form-control' name='text' placeholder='Type your post here.'></textarea>
					<button type='submit' class=' mt-2 btn btn-primary'>Post</button>
				</form>
			</div>
		</div>
	</div>";


	$r .= "</div>";
	echo $r;
}

function make_category_selector($diff=""){
	// $diff can be used to make ids different if two category selectors occurr on the same page
		$query = "SELECT Description, Id from Category where 1;";
		$result = mysql_query( $query );
		if (!$result){
		   die ("Could not query the database: <br />". mysql_error());
		}
		$return = "<label for='category'><b>Category: &nbsp;</b></label>
					  <select class='form-control mb-2 mr-sm-2 mb-sm-0'  id='category' name='category$diff'>";
		while ($item = mysql_fetch_assoc( $result )){ //add an item
			$id = $item['Id'];
			$desc = $item['Description'];
			$return .= "<option value='$id'>$desc</option>";
		}

		
		$return .="</select>";
		echo $return;
}	

function make_playlist_selector($user_id, $diff=""){
	// $diff can be used to make ids different if two category selectors occurr on the same page
		$query = "SELECT Name, Id from Playlist where Playlist.Owner = $user_id;";
		$result = mysql_query( $query );
		if (!$result){
		   die ("Could not query the database: <br />". mysql_error());
		}
		$return = "<br><label for='playlist'><b>Select Playlist: &nbsp;</b></label>
					  <select class='form-control mb-2 mr-sm-2 mb-sm-0' name='playlist$diff'>";
		while ($item = mysql_fetch_assoc( $result )){ //add an item
			$id = $item['Id'];
			$desc = $item['Name'];
			$return .= "<option value='$id'>$desc</option>";
		}

		
		$return .="</select>";
		echo $return;
}	
function make_contact_list_selector($user_id, $diff=""){
	// $diff can be used to make ids different if two category selectors occurr on the same page
		$query = "SELECT Name, Id from ContactList where Owner = $user_id;";
		$result = mysql_query( $query );
		if (!$result){
		   die ("Could not query the database: <br />". mysql_error());
		}
		$return = "<br><label for='contact_list'><b>Select Contact List: &nbsp;</b></label>
					  <select class='form-control mb-2 mr-sm-2 mb-sm-0' name='contact_list$diff'>";
		while ($item = mysql_fetch_assoc( $result )){ //add an item
			$id = $item['Id'];
			$desc = $item['Name'];
			$return .= "<option value='$id'>$desc</option>";
		}

		
		$return .="</select>";
		echo $return;
}	

function make_group_selector($query_result){
		$return = "<label for='group'><b>Group: &nbsp;</b></label>
					  <select class='form-control mb-2 mr-sm-2 mb-sm-0'  id='group' name='group_id'>";
		while ($item = mysql_fetch_assoc( $query_result ) ){ //add an item
			$id = $item['Id'];
			$desc = $item['group_name'];
			$return .= "<option value='$id'>$desc</option>";
		}

		
		$return .="</select>";
		echo $return;
}	
	
function add_to_list($media_id, $list_id){
	// add user to playlist $list_id
	$query = "INSERT INTO `db_76dp`.`IsInPlaylist` (`List`, `Media`, `Id`) VALUES ('$list_id', '$media_id', NULL);";
	$r = mysql_query($query);
	if (!$r){ die ("failed to add to playlist <br>".mysql_error()."<br>".$query);}
	
}
function add_to_contact_list($user_id, $list_id){
	// check if they are already present
	$query = "select * from IsInContactList 
		where User='$user_id'
		and List='$list_id'
		";
	//echo  $query;
	$result = mysql_query( $query );
		
	if (mysql_num_rows($result) == 0 ){ // they are not present so add them
		// add user to playlist $list_id
		$query = "INSERT INTO `db_76dp`.`IsInContactList` (`List`, `User`, `Id`) VALUES ('$list_id', '$user_id', NULL);";
		$r = mysql_query($query);
		if (!$r){ die ("failed to add to playlist <br>".mysql_error()."<br>".$query);}
	}	
	
	
	
	

	
}

function display_contacts($qresult, $can_remove = false){
	$r="<table class='table table-hover'>";
	$prev_list_name = "";
	
	while ($i = mysql_fetch_assoc($qresult)){
		//~ echo var_dump($i);
		
		$list_name = $i['list_name'];
		$list_id = $i['list_id'];
		$list_owner_id = $i["list_owner_id"];
		$member_id = $i["member_id"];
		$member_username = $i['member_username'];
		$connection_id = $i['connection_id'];

		if($prev_list_name != $list_name or $prev_list_name == ""){ // a new group: so make a header
			$r .= 	"
							<thead>
								<tr>
									<th>$list_name &nbsp; &nbsp;
										<form style='display: inline-block' 
										class='form-group tm-10'
										action='contact_list_remove.php' method='POST'>
											<input type='hidden' name='id_to_remove' value='$list_id'>
											<button type='submit' class='btn btn-sm'>Delete List</button>
										</form>
									</th>
									<th></th>
									<th></th>
								</tr>
							</thead>
							<tbody>";
		}
		
		if ($member_id != NULL ){ // add a row if there are people in the contact list
			$r .= "<tr>
				<td>$member_username</td>
				<td>
					<button class='btn btn-sm' 
						onClick=location.href='contact_thread.php?contact_id=$member_id'>View Messages
					</button>
			</td>";
			if ($can_remove) {
				$r .="<td>
								<form action='contact_remove.php' method='POST'>
									<input type='hidden' name='id_to_remove' value='$connection_id'>
									<button type='submit' class='btn btn-sm'>Remove Contact from List</button>
								</form>
							</td>";
			}
			$r .= "</tr>";
		}

		if($prev_list_name == "" or $prev_list_name != $list_name){ // close the body
			$r .= "</tbody>";
		}

		$prev_list_name = $list_name;
	}
	$r .= "</table>";
	echo $r;
	
}

function display_messages($qresult){
	$r= "<div class='list-group'>";
	
	$first_time = true;
	while ($i = mysql_fetch_assoc( $qresult) ){
		
			$date = $i['time'];
			$date=date_create($date);
			$date = date_format($date,"m/d H:i");
			$text = $i['text'];
			$sender_name = $i['sender_name'];
			
			if ($first_time){ // print dicussion title for first post
				$first_time = false;
				$r.="<h2>Your Messages</h2>";
			}

			$r .= "
			<div class='list-group-item align-items-start'>
				<small>$sender_name</small>
				<div class='d-flex w-100 justify-content-between'>
					<p class='mb-1'>$text</p>
					<small>$date</small>
				</div>
			</div>";
	}

	$r .= "</div>";
	echo $r;
}

function display_playlists($qresult){
	//~ $r= "<div class='list-group'>
	$r= "<table class='table'>
	<h2>My Playlists </h2>";
	
	while ($i = mysql_fetch_assoc( $qresult) ){

			$name = $i['Name'];
			$playlist_id = $i['Id'];

			//~ $r .= "
			//~ <div class='row'>
					//~ <div class='col-6'></div>
						//~ <p class='ms-4'>$name</p>
					//~ <button class='btn btn-sm ml-4' 
						//~ onClick=location.href='playlist_single.php?playlist_id=$playlist_id'>View
					//~ </button>
			//~ </div>"
			//~ ;
			$r .= "<tr>
				<td>
					<form action=\"\" method='POST'>
						<input type='hidden' name='playlist_to_delete' value='$playlist_id'>
						<button name='submit_delete' type='submit' class='btn btn-sm'>Delete</button>
					</form>
				</td>
				<td>
					<button class='btn btn-sm ml-4 mr-4' 
						onClick=location.href='playlist_single.php?playlist_id=$playlist_id'>View
					</button>
				</td>
				<td>
					$name
				</td>
				
			</tr>
				
			";
	}


	//~ $r .= "</div>";
	$r .= "</table>";
	echo $r;
}


function incr_view_count($media_id){
	
	$query = "update Media set NumViews = NumViews + 1 where Id = $media_id;";
	$r = mysql_query($query);
	if (!$r)  die("failed $query");
	
}

ob_clean();
?>


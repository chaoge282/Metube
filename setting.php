<?php
session_start();
include_once "function.php";

if(isset($_POST['submit'])){
	$user_id = $_SESSION['user_id'];
	$query = "select * from User where Id = '$user_id'";
	$result = mysql_query($query);
	
	if(!$result)
		{die("cannot query database!<br>".mysql_error()."<br>".$query);}
	if(mysql_num_rows($result) == 0 ){  die("only 0 rows in".$query);}
	$user = mysql_fetch_assoc($result);
	
	$username = $user['Username'];
	$password = $user['Password'];
		
	$newpass =$_POST['password1'];
	if($_POST['oldPassword'] == "$password"){
		if($_POST['password1'] != $_POST['password2'])
			$register_error = "Passwords don't match. Try again?";
		else{
		  if($_POST['username'] == "$username"){ 
			  // if they are not changing username, we do not want to check if username exits in db
			$query= "update User set Password='$newpass' where Id ='$user_id'";
			$update= mysql_query($query);
			if(!$update)
				{die("cannot query database!<br>".mysql_error()."<br>".$query);}
			header('Location: index.php');
		  }
		  else { // they're changing username, so check if it's available
			$newname= $_POST['username'];
			$query = "select * from User where Username='$newname'";
			$result = mysql_query( $query );
			if (!$result){
				die ("user_exist_check() failed. Could not query the database: <br />". mysql_error());
			}	
			else {
				if(mysql_num_rows($result) == 0){
					$qquery = "update User set Username='$newname', Password='$newpass' where Id=$user_id";
					$update = mysql_query( $qquery );
					echo $qquery;
					if (!$update){
						die ("foo<br>". mysql_error()."<br>".$query);
					}
					$_SESSION['username'] = "$newname";
     				header('Location: index.php');

				}
				else
					$register_error = "Username already exists. Please use a different username.";
		
			}
		  }
		}
	}
	else
		$register_error = "Your old password is wrong!";


}

?>
<html lang="en">
    <head>
        <meta charset="utf-8">
            <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
                <meta name="description" content="">
                    <meta name="author" content="">
                        
                        <title>Settings</title>
                        
                        <!-- Bootstrap core CSS -->
                        <link href="css/bootstrap.min.css" rel="stylesheet">
                            
                            <!-- Custom styles for this template -->
                            <link href="css/signin.css" rel="stylesheet">
    </head>
    <body>
        <div class="container">
            <form class="form-signin" action="" method="post">
                <h2 class="form-signin-heading">Update Your Profile</h2>
				<div class="form-group">
                    <input class="form-control" placeholder="OldPassword" name="oldPassword" type="password" value="">
                </div>
                <div class="form-group">
                    <input class="form-control" placeholder="NewUsername" name="username" type="text" value="">
                </div>
                <div class="form-group">
                    <input class="form-control" placeholder="NewPassword" name="password1" type="password" value="">
                </div>
                <div class="form-group">
                    <input class="form-control" placeholder="Repeat Password" name="password2" type="password" value="">
                </div>
                <input class="btn btn-lg btn-primary btn-block" type="submit" name="submit" value="Update">
            </form>
            
        </div>

<?php
  if(isset($register_error))
   {  echo "<div id='passwd_result'> register_error:".$register_error."</div>";}
?>

<script src="js/ie10-viewport-bug-workaround.js"></script>
    </body>
</html>

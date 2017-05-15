
<?php
session_start();
include_once "function.php";
?>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>Sign in</title>
    <!-- Bootstrap core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <!-- Custom styles for this template -->
    <link href="css/signin.css" rel="stylesheet">
  </head>
  <body>
<?php
if(isset($_POST['submit'])) {
		$username = mysql_real_escape_string($_POST['username']);
		$password = mysql_real_escape_string($_POST['password']);
		//~ if($_POST['username'] == "" || $_POST['password'] == "") {
		if($username == "" || $password == "") {
			$login_error = "One or more fields are missing.";
		}
		else {
			$check = user_pass_check($username, $password); // Call functions from function.php
			if($check == 1) {
				$login_error = "User ".$username." not found.";
			}
			elseif($check==2) {
				$login_error = "Incorrect password.";
			}
			else if($check==0){
				//~ $_SESSION['username']=$_POST['username']; //Set the $_SESSION['username']
				$_SESSION['username']=$username; //Set the $_SESSION['username']
				// query database to get id number, and set it in session

				$query = "SELECT Id from User where Username ='". $username."'"; 
				$result = mysql_query( $query );
				$user_id = mysql_fetch_array($result)[0];
				$_SESSION['user_id']=$user_id; 
				//~ file_put_contents("log", "this is the id: $id\n");
				header('Location: index.php');
			}		
		}
}
?>
	<div class="container">

      <form class="form-signin" method="post" action="" >
        <h2 class="form-signin-heading">Please Sign in</h2>
        <div class="form-group">
            <input class="form-control" placeholder="Username" name="username" type="username" autofocus>
        </div>
        <div class="form-group">
            <input class="form-control" placeholder="Password" name="password" type="password" value="">
        </div>
<!--
        <div class="checkbox">
          <label>
            <input type="checkbox" value="remember-me"> Remember me
          </label>
        </div>
-->
        <input class="btn btn-lg btn-success btn-block" type="submit" name="submit" value="Log in">
      </form>

    </div> 

<?php
  if(isset($login_error))
   {  echo "<div id='passwd_result'>".$login_error."</div>";}
?>
<script src="js/ie10-viewport-bug-workaround.js"></script>
  </body>
</html>


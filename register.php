<?php
session_start();
include_once "function.php";
if(isset($_POST['submit'])) {
	$username = mysql_real_escape_string($_POST['username']);
	$password1 = mysql_real_escape_string($_POST['password1']);
	$password2 = mysql_real_escape_string($_POST['password2']);
    //~ if( $_POST['passowrd1'] != $_POST['passowrd2']) {
    if($password1 != $password2) {
        $register_error = "Passwords don't match. Try again?";
    }
    else {
        //~ $check = user_exist_check($_POST['username'], $_POST['password1']); 
        $check = user_exist_check($username, $password1);
        if($check == 1){
            //echo "Rigister succeeds";
            $_SESSION['username']=$username;
            header('Location: login.php');
        }
        else if($check == 2){
            $register_error = "Username already exists. Please use a different username.";
        }
    }
}
?>
<html lang="en">
    <head>
        <meta charset="utf-8">
            <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
                <meta name="description" content="">
                    <meta name="author" content="">
                        
                        <title>Sign up</title>
                        
                        <!-- Bootstrap core CSS -->
                        <link href="css/bootstrap.min.css" rel="stylesheet">
                            
                            <!-- Custom styles for this template -->
                            <link href="css/signin.css" rel="stylesheet">
    </head>
    <body>
        <div class="container">
            <form class="form-signin" action="register.php" method="post">
                <h2 class="form-signin-heading">Please Sign up</h2>
                <div class="form-group">
                    <input class="form-control" placeholder="Username" name="username" type="text" value="">
                </div>
                <div class="form-group">
                    <input class="form-control" placeholder="Password" name="password1" type="password" value="">
                </div>
                <div class="form-group">
                    <input class="form-control" placeholder="Conform Password" name="password2" type="password" value="">
                </div>
                <input class="btn btn-lg btn-primary btn-block" type="submit" name="submit" value="Sign up">
            </form>
            
        </div>

<?php
  if(isset($register_error))
   {  echo "<div id='passwd_result'> register_error:".$register_error."</div>";}
?>

<script src="js/ie10-viewport-bug-workaround.js"></script>
    </body>
</html>

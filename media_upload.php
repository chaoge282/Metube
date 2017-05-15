<?php
session_start();
?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>Media Upload</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <!-- Bootstrap core CSS -->
    <link href="./css/bootstrap.min.css" rel="stylesheet">
    <link href="./css/sidenav.css" rel="stylesheet">
    <!-- Custom styles for this template -->
    <link href="./css/offcanvas.css" rel="stylesheet">
</head>
<body>

<?php
  include "navbar.php";
?>


	<div class="container-fluid mt-1 offset-3">
	 <div class="col-12 col-md-9">

		<form method="post" action="media_upload_process.php" enctype="multipart/form-data" >
  			<p style="margin:0; padding:10px">
  		<!--	<input type="hidden" name="MAX_FILE_SIZE" value="10485760" /> -->
   			<h2>Upload your media: </h2><label style="color:#663399"><em> (Each file limit 200M)</em></label><br/><br>
        <img class="offset-4" src="icons/upload.png" width="20%" style="cursor:pointer" onclick="document.getElementById('button').click();" />
   			<input  name="file" type="file" size="50" id="button" style="display: none" />
   			<br>
        <div class="row mt-3">
          <label style="font-size:20px;">Title: </label>
          <input class="form-control" placeholder="Your Title" name="title" type="text" autofocus>
        </div>
        <div class="row mt-3">
          <label style="font-size:20px;">Keywords: </label>
          <input class="form-control" placeholder="Separate with a comma AND a space,    e.g. hat, ice cream, seafood" name="keywords" type="text" autofocus>
        </div>
        <div class="row mt-3">
          <label style="font-size:20px;">Description: </label>
          <textarea class="form-control" placeholder="Description" rows="3" name="description" type="text" autofocus></textarea>
        </div>
        <div class="row mt-3 offset-2">
          <label style="font-size:20px;">Choose Category:</label>
          <select class="form-control" name="category" style="width:200px;">
            <option>Music</option>
            <option>Sports</option>
            <option>Travel</option>
            <option>Funny</option>
            <option>Tech</option>
            <option>Education</option>
            <option>DIY</option>
            <option>Cooking</option>
            <option>Fashion</option>
            <option>Gaming</option>
            <option>News</option>
            <option>Other</option>
            </select>
        </div>
      <div class="row mt-3 offset-2">
          <label style="font-size:20px;">Sharing Level:</label>
          <select class="form-control" name="sharingLevel" style="width:300px;">
            <option>Public</option>
            <option>Friends</option>
            <option>Private</option>
            </select>
        </div>
        <br>
			<input class="btn btn-lg btn-primary offset-4" value="Upload" name="submit" type="submit" />
  			</p>
 		</form>
 		</div>
 	</div>

   <script>
    function openNav() {
      document.getElementById("mySidenav").style.width = "200px";
    }

    function closeNav() {
      document.getElementById("mySidenav").style.width = "0";
    }
  </script>

  <script src="https://code.jquery.com/jquery-3.1.1.slim.min.js" integrity="sha384-A7FZj7v+d/sdmMqp/nOQwliLvUsJfDHW+k9Omg/a/EheAdgtzNs3hpfag6Ed950n" crossorigin="anonymous"></script>
    <script>window.jQuery || document.write('<script src="../../assets/js/vendor/jquery.min.js"><\/script>')</script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/tether/1.4.0/js/tether.min.js" integrity="sha384-DztdAPBWPRXSA/3eYEEUWrWCy7G5KFbe8fFjk5JAIxUYHKkDx6Qin1DkWx51bBrb" crossorigin="anonymous"></script>
    <script src="./js/bootstrap.min.js"></script>
    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <script src="./js/ie10-viewport-bug-workaround.js"></script>
    <script src="./js/offcanvas.js"></script>
</body>
</html>

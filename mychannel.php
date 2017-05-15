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
   <!-- <link rel="icon" href="../../favicon.ico"> -->

    <title>Channel</title>

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

<!--
<script>
function saveDownload(id)
{
  $.post("media_download_process.php",
  {
       id: id,
  },
  function(message) 
    { }
  );
} 
</script>
-->
<?php 
	if(isset($_REQUEST['result']) && $_REQUEST['result']!=0)
	{	
    echo "<h3>";
		echo upload_error($_REQUEST['result']);
    echo "</h3>";
	}
?>


<br/><br/>
<?php
	$username=$_SESSION['username'];
	$wquery="select * from User where Username='$username'";
	$wresult = mysql_query($wquery);
	$userId= mysql_fetch_assoc($wresult)['Id'];
  
	$query = "select * from Media where User='$userId'"; 
	$mresult = mysql_query( $query );
	if (!$mresult){
	   die ("Could not query the media table in the database: <br />". mysql_error());
	}
?>
	<h2 class="offset-2">Welcome,<?php echo $username ?></h2>
    <div class="container mt-5 offset-2">
	
        <div class="col-12 col-md-9">
          <div class="row">
              <div class="col-10 col-lg-15">
                  <h2>Uploaded Media</h2>
                  <br>
<?php
	while ($one_media = mysql_fetch_assoc($mresult)){
	  $path = $one_media['Path'];
	  $title = $one_media["Title"];
	  $mediaid=$one_media['Id'];
	  $type = $one_media['FileType'];
	  $time = $one_media['UploadTime'];
	  $extension = pathinfo($path, PATHINFO_EXTENSION);
	  $str = "$type\\$extension";
	  $result = "";
	  $result.= "<div class='row container mt-4'>
		<div class='col-sm-auto'>
		<a href='media.php?id=$mediaid' class='thumbnail'>";
	  if($type == 'Video')
		$result .="<img class='media-object' alt='video' width='160' height='120' src=./icons/videoIcon.png />";
	  elseif($type == 'Audio')
		$result .="<img class='media-object' alt='audio' width='160' height='120' src=./icons/audioIcon.png />";
	  else
		$result .="<img class='media-object' alt='image' width='160' height='120' src=$path />";

	  $result .="</a>
			</div>
		  <div class='col-sm-auto'>
		  <a href='media.php?id=$mediaid' style='font-size:2em;'> $title</a>
		  <br /><label>$str</label>
		  <br /><label>$time</label>
		  </div>
		  <div class='col-sm-auto'>
		  	<a href='mychannel_edit.php?id=$mediaid'><button  class='btn btn-success mt-2 offset-2'>Edit</button></a>
			<a href='mychannel_delete.php?id=$mediaid'><button  class='btn btn-success mt-2 offset-2'>Delete</button></a>
		  </div>
		</div>";
	echo $result;
}
?>
		</div>
	     </div>
	  </div>

      <hr>

      <footer>
        <p>&copy; Database 2017</p>
      </footer>

    </div><!--/.container-->

<script type="text/javascript" src="js/navbar.js"></script>
<?php include 'footer.php'; ?>
  </body>
</html>

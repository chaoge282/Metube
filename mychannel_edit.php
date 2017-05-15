<?php
	session_start();
	include_once "function.php";
?>

<?php include 'header.php'; ?>

<body>
<?php
 include "navbar.php";
?>

<div class="container-fluid mt-1 offset-3">
	<div class="col-12 col-md-9">
	<form method="post" action="mychannel_edit_process.php?id=<?php echo $_REQUEST['id']; ?>" >
  	<p style="margin:0; padding:10px">
   	<h2>Edit Your Media: </h2><label style="color:#663399"><br>
	<div class="row mt-3">
          <label style="font-size:20px;">Title: </label>
          <input class="form-control" placeholder="Your Title" name="title" type="text" autofocus>
        </div>
        <div class="row mt-3">
          <label style="font-size:20px;">Keywords: </label>
          <input class="form-control" placeholder="Keywords" name="keywords" type="text" autofocus>
        </div>
        <div class="row mt-3">
          <label style="font-size:20px;">Description: </label>
          <textarea class="form-control" placeholder="Description" rows="3" name="description" type="text" autofocus></textarea>
        </div>
        <div class="row mt-3 offset-1">
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
        <div class="row mt-3 offset-1">
          <label style="font-size:20px;">Sharing Level:</label>
          <select class="form-control" name="sharingLevel" style="width:200px;">
            <option>Public</option>
            <option>Friends</option>
            <option>Private</option>
            </select>
        </div>
        <br>
	<input class="btn btn-lg btn-default offset-2" value="Cancel" name="submit" type="submit" />
	<input class="btn btn-lg btn-primary " value="Save" name="submit" type="submit" />
  	</p>
 	</form>
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

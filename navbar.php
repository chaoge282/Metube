<?php
  if(isset($_SESSION['username'])){
   // echo "Welcome";
?>
    <nav class="navbar navbar-toggleable-md fixed-top navbar-inverse bg-inverse"> 
            <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarsExampleDefault" aria-controls="navbarsExampleDefault" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
            </button>
            <a  href="index.php" class="navbar-brand" style="font-size:2.2em;">Metube</a>
            <div id="mySidenav" class="sidenav">
              <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
              <a href="category.php?category=Music">Music</a>
              <a href="category.php?category=Sports">Sports</a>
              <a href="category.php?category=Funny">Funny</a>
              <a href="category.php?category=Tech">Tech</a>
              <a href="category.php?category=Education">Education</a>
              <a href="category.php?category=Travel">Travel</a>
              <a href="category.php?category=DIY">DIY</a>
              <a href="category.php?category=Cooking">Cooking</a>
              <a href="category.php?category=Fashion">Fashion</a>
              <a href="category.php?category=Gaming">Gaming</a>
              <a href="category.php?category=News">News</a>
              <a href="category.php?category=Other">Other</a>
            </div>
      <div class="collapse navbar-collapse" id="navbarsExampleDefault">
        <ul class="navbar-nav">
          <li class="nav-item">
            <span style="color:#fff;font-size:30px;cursor:pointer" onclick="openNav()">&#9776;</span>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="mychannel.php" style="font-size:1.2em;">Mychannel <span class="sr-only">(current)</span></a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="playlists.php" style="font-size:1.2em;">Playlist</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="downloadHistory.php" style="font-size:1.2em;">Downloaded</a>
          </li>
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" style="font-size:1.2em;" href="#" id="dropdown01" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Community</a>
            <div class="dropdown-menu" aria-labelledby="dropdown01">
              <a class="dropdown-item" href="subscription.php">Subsriptions</a>
              <a class="dropdown-item" href="contacts.php">Contacts/Messages</a>
              <a class="dropdown-item" href="./groups.php">Groups</a>
              <a class="dropdown-item" href="./discussions.php">Discussions</a>
            </div>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="word_cloud.php" style="font-size:1.2em;">Word Cloud</a>
          </li>
        </ul>
      <form class="form-inline my-2 my-lg-0" method="POST" action="search.php">
          <div class="btn-group">
          <input class="form-control" type="text" name="search" style="width:80%;" placeholder="Search for Multimedia">

            <button type="submit" class="btn btn-outline-success">Search</button>
	</form>
            <button type="button" class="btn btn-outline-success dropdown-toggle pl-2" data-toggle="dropdown">
                <span class="caret"></span>
            </button>
              <div class="dropdown-menu">
                  <div class="row container" style="width: 320px; margin:0px;">
                      <div class="col-sm-auto" style=" margin:10px;">
                          <b>Type</b><br>
                          <a href="search.php?name=Video">Video</a><br>
                          <a href="search.php?name=Audio">Audio</a><br>
                          <a href="search.php?name=Image">Image</a><br>
                      </div>
                      <div class="col-sm-auto" style="margin:10px;">
                          <b>Date</b><br>
                          <a href="search.php?name=Today">Today</a><br>
                          <a href="search.php?name=Week">This Week</a><br>
                          <a href="search.php?name=Month">This Month</a><br>
                          <a href="search.php?name=Year">This Year</a></div>
                      <div class="col-sm-auto" style="margin:10px;">
                          <b>Size</b><br>
                          <a href="search.php?name=vssize"> &lt 1M</a><br>
                          <a href="search.php?name=ssize">1M to 10M</a><br>
                          <a href="search.php?name=msize">10M to 100M</a><br>
                          <a href="search.php?name=lsize">100M to 1G</a><br>
                          <a href="search.php?name=vlsize">&gt 1G</a>
                      </div>
                  </div>
              </div>
          </div>
        
	<div class="offset-2"></div>
        <a href="media_upload.php"><img class="mt-2" alt="upload" src="icons/upload.png" width="40px;"></a>
        <div class="dropdown">
          <img class="btn dropdown-toggle" src="icons/paw_orange.png" width="75px;" alt="dropdown image" data-toggle="dropdown" class="img-responsive">
          <div class="dropdown-menu">
            <div class="row container" style="width: 200px; margin:0px;">
              <img class="img-thumbail" src="icons/paw_orange.png" width="50px;" height="50px;">
              <h6 class="mt-3">Hi!  
<?php
               echo $_SESSION['username'];
            echo '</h6> ';
?>
            </div>
            <br>
            <div class="row container" style="width: 200px; margin:0px;">
              <a href="setting.php"><button type="button" class="btn btn-info btn-sm">Settings</button></a>
              <a href="logout.php"><button type="button" class="btn btn-info btn-sm">Log out</button></a>
            </div>
          </div>
        </div>
    </nav>
<?php
  }
  else{ // is not logged in
?>
  <nav class="navbar navbar-toggleable-md fixed-top navbar-inverse bg-inverse"> 
      <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarsExampleDefault" aria-controls="navbarsExampleDefault" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <a  href="index.php" class="navbar-brand" style="font-size:2.2em;">Metube</a>
      <span style="color:#fff;font-size:30px;cursor:pointer" onclick="openNav()">&#9776;</span>
      <div id="mySidenav" class="sidenav">
        <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
          <a href="category.php?category=Music">Music</a>
          <a href="category.php?category=Sports">Sports</a>
          <a href="category.php?category=Funny">Funny</a>
          <a href="category.php?category=Tech">Tech</a>
          <a href="category.php?category=Education">Education</a>
		  <a href="category.php?category=Travel">Travel</a>
          <a href="category.php?category=DIY">DIY</a>
          <a href="category.php?category=Cooking">Cooking</a>
          <a href="category.php?category=Fashion">Fashion</a>
          <a href="category.php?category=Gaming">Gaming</a>
          <a href="category.php?category=News">News</a>
          <a href="category.php?category=Other">Other</a>
      </div>
	<div class="offset-3"></div>
        <form class="form-inline my-2 my-lg-0" method="post" action="search.php">
          <div class="btn-group">
          <input class="form-control mr-sm-2" type="text" name="search" style="width:100%;" placeholder="Search for Multimedia">
              <button type="button" class="btn btn-outline-success">Search</button>
            <button type="button" class="btn btn-outline-success dropdown-toggle pl-2" data-toggle="dropdown">
                <span class="caret"></span>
            </button>
              <div class="dropdown-menu">
                  <div class="row container" style="width: 320px; margin:0px;">
<!--
                      <div class="col-sm-auto" style=" margin:10px;">
                          <b>Type</b><br>
                          <a href="#">Video</a><br>
                          <a href="#">Audio</a><br>
                          <a href="#">image</a><br>
                      </div>
                      <div class="col-sm-auto" style="margin:10px;">
                          <b>Date</b><br>
                          <a href="#">Last Hour</a><br>
                          <a href="#">Today</a><br>
                          <a href="#">This Week</a><br>
                          <a href="#">This Month</a><br>
         

                   <a href="#">This Year</a></div>
                      <div class="col-sm-auto" style="margin:10px;">
                          <b>Size</b><br>
                          <a href="#"> &lt 100K</a><br>
                          <a href="#">100K to 1M</a><br>
                          <a href="#">1M to 100M</a><br>
                          <a href="#">100M to 1G</a><br>
                          <a href="#">&gt 1G</a>
                      </div>
-->

					<div class="col-sm-auto" style=" margin:10px;">
                          <b>Type</b><br>
                          <a href="search.php?name=Video">Video</a><br>
                          <a href="search.php?name=Audio">Audio</a><br>
                          <a href="search.php?name=Image">Image</a><br>
                      </div>
                      <div class="col-sm-auto" style="margin:10px;">
                          <b>Date</b><br>
                          <a href="search.php?name=Today">Today</a><br>
                          <a href="search.php?name=Week">This Week</a><br>
                          <a href="search.php?name=Month">This Month</a><br>
                          <a href="search.php?name=Year">This Year</a></div>
                      <div class="col-sm-auto" style="margin:10px;">
                          <b>Size</b><br>
                          <a href="search.php?name=vssize"> &lt 1M</a><br>
                          <a href="search.php?name=ssize">1M to 10M</a><br>
                          <a href="search.php?name=msize">10M to 100M</a><br>
                          <a href="search.php?name=lsize">100M to 1G</a><br>
                          <a href="search.php?name=vlsize">&gt 1G</a>
                      </div>
                  </div>
              </div>
          </div>
        </form>
        <div class="offset-2"></div>
        <a href="register.php" class="btn btn-primary mr-sm-3" style="font-size:1.1em;">Sign Up</a>
        <a href="login.php" class="btn btn-success" style="font-size:1.2em;">Login</a>
      </div>
    </nav>
<?php
  }
?>

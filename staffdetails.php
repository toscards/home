<?PHP
include("config.php");
if (!isset($_SESSION['UserId'])) 
{
	header("location: index.php");
	 exit();
}
if($_SESSION['UserRole'] == "admin")
{
	header('LOCATION: admin/index.php');
	 exit();
}

 
?><!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>View Teaching and Non-Teaching Staff details - Faculty Management System</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <link rel="stylesheet" href="css/bootstrap.css" media="screen">
    <link rel="stylesheet" href="css/custom.min.css">
	 <script type="text/javascript" src="js/date_time.js"></script>
       <script src="js/jquery-1.10.2.min.js"></script>   
<body>
    <div class="navbar navbar-default navbar-fixed-top">
      <div class="container">
        <div class="navbar-header">
          <a href="index.php" class="navbar-brand">F-Timesheet</a>
          <button class="navbar-toggle" type="button" data-toggle="collapse" data-target="#navbar-main">
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
        </div>
        <div class="navbar-collapse collapse" id="navbar-main">
        <ul class="nav navbar-nav">
         <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">Student Academic Report<span class="caret"></span></a>
          <ul class="dropdown-menu" role="menu">
            <li><a href="resultsadd.php">Add New Result</a></li>
            <li><a href="resultsedit.php">Edit, Delete Results</a></li>
            <li class="divider"></li>
            <li><a href="projectsadd.php">Add Project Details</a></li>
            <li><a href="projectsdit.php">Edit, Delete Project Details</a></li>
           </ul>
        </li>
			<li>
              <a href="timetableget.php">Get Timetable</a>
            </li>
			<li>
              <a href="subjectsget.php">Subejcts</a>
            </li>
		 <li>
              <a href="staffdetails.php">Staff Details</a>
            </li>
		 
		 
		<li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">Settings <span class="caret"></span></a>
          <ul class="dropdown-menu" role="menu">
            <li><a href="manageprofile.php">Manage Profile</a></li>
			<li><a href="managepass.php">Change Password</a></li>
            <li class="divider"></li>
			  <li><a href="regteachers.php">Online Registered Teacher Details</a></li>
           </ul>
        </li>
		
           
          </ul>

          <ul class="nav navbar-nav navbar-right">
            <li style="text-decoration:none;"><a><span id="date_time"></span></a>
            <script type="text/javascript">window.onload = date_time('date_time');</script></li>
			 <li>
              <a href="logout.php">Logout!</a>
            </li>
          </ul>

        </div>
      </div>
    </div>


    <div class="container">

      <div class="page-header" id="banner">
   <h2>Teaching Staff Details:</h2><br>
 <div class="col-lg-12"> 
		   
		   <div class="well bs-component">
 
  <?
		  $sql=" SELECT * from staffdetails WHERE StaffCategory='Teaching' ORDER BY StaffId ASC";
			//print_r($sql);
			 $result = mysqli_query($conn,$sql);
			if(mysqli_num_rows($result)>0){ $i=1;
 
	 
?>
		  <table class="table table-striped table-hover " border="1">
  <thead>
    <tr class="info">
      <th >STAFF. ID</th>
      <th >TEACHER. NAME</th>
      <th >MOBILE NUMBER</th>
	  <th >EMAIL</th>
     </tr>
  </thead>
  <tbody>
  
  <? 
 while ($ListData=mysqli_fetch_array($result)){ 
 ?>
  <tr>
      <td>&nbsp;<?=$ListData['StaffId'];?></td>
      <td><?=$ListData['StaffName'];?></td>
      <td><?=$ListData['StaffMobile'];?></td>
      <td><?=$ListData['StaffEmail'];?></td>
      
       
      
    </tr>

<?    $i= $i+1; }  
 echo "</tbody></table>";
 
}else{ echo "<center><font color='blue'><b>NO RESULTS FOUND !</b></font>!</center></td></tr>"; }   
?>
 
</div></div>
 
 <br><br><h2>Non-Teaching Staff Details:</h2><br>
 <div class="col-lg-12"> 
		   
		   <div class="well bs-component">
 
  <?
		  $sql=" SELECT * from staffdetails WHERE StaffCategory='Non-Teaching' ORDER BY StaffId ASC";
			//print_r($sql);
			 $result = mysqli_query($conn,$sql);
			if(mysqli_num_rows($result)>0){ $i=1;
 
	 
?>
		  <table class="table table-striped table-hover " border="1">
  <thead>
    <tr class="info">
      <th >STAFF. ID</th>
      <th >TEACHER. NAME</th>
      <th >MOBILE NUMBER</th>
	  <th >EMAIL</th>
     </tr>
  </thead>
  <tbody>
  
  <? 
 while ($ListData=mysqli_fetch_array($result)){ 
 ?>
  <tr>
      <td>&nbsp;<?=$ListData['StaffId'];?></td>
      <td><?=$ListData['StaffName'];?></td>
      <td><?=$ListData['StaffMobile'];?></td>
      <td><?=$ListData['StaffEmail'];?></td>
      
       
      
    </tr>

<?    $i= $i+1; }  
 echo "</tbody></table>";
 
}else{ echo "<center><font color='blue'><b>NO RESULTS FOUND !</b></font>!</center></td></tr>"; } mysqli_close($conn); 
?>
 
</div></div>
 

		  </div>
       

      

      <footer> <br><br> <br><br> <br><br>  <br><br>
        <div class="row">
		<ul class="list-unstyled">
              <li class="pull-right"><a href="#top">Back to top</a></li>
			  <li></li>
			  </ul>
          
        </div>

      </footer>


    </div>
	 
 <script src="js/bootstrap.min.js"></script>

 </body>
</html>

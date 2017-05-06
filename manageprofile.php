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

// FETCH USER/ADMIN PROFILE
$GetUser = "SELECT * from users where UserId=".$_SESSION['UserId']."";
$FetchUser = mysqli_query($conn,$GetUser);
$FetchUser = mysqli_fetch_array($FetchUser);

 // GET Departments and their data
$GetDept = "SELECT * from departments";
$FetchDept = mysqli_query($conn,$GetDept);

 
?><!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>Manage Profile - Faculty Management System</title>
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
 
  <div class="col-lg-6"> 
	 <div class="well bs-component">
	 
	 <form class="form-horizontal" onsubmit="return verify2();" id="infoForm2" method="POST" >
  <fieldset>
    <legend>Admin Profile Update</legend>
    <div class="form-group">
      <label for="inputPassword" class="col-lg-2 control-label">Full Name</label>
      <div class="col-lg-10"> 
        <input class="form-control" id="inputPassword" placeholder="Enter Full Name" value="<?=$FetchUser['FullName'];?>" type="text" name="fullname" maxlength="100" required>
         </div>
    </div>
     
     <div class="form-group">
      <label for="inputPassword" class="col-lg-2 control-label">Mobile</label>
      <div class="col-lg-10">
        <input class="form-control" id="inputPassword" pattern="[0-9]{10}" placeholder="Enter Valid Mobile Number" value="<?=$FetchUser['Mobile'];?>" type="text" name="mobile" maxlength="10" required>
         </div>
    </div>
     <div class="form-group">
      <label for="inputPassword" class="col-lg-2 control-label">Email</label>
      <div class="col-lg-10">
        <input class="form-control" id="inputPassword" placeholder="Enter Valid Email" type="email" value="<?=$FetchUser['Email'];?>" name="email" maxlength="50" required>
         </div>
    </div>
	<!--  <div class="form-group">
      <label for="select" class="col-lg-2 control-label">Stream</label>
      <div class="col-lg-10">
       <label>
	    < ? $jsontoArray = json_decode($FetchUser['DepartmentId']);
		print_r($jsontoArray);
		if(mysqli_num_rows($FetchDept)>0){ $i=1;
				while ($ListData=mysqli_fetch_array($FetchDept)){ 
				
				echo $resultMatched = array_intersect($jsontoArray, $ListData['DeptId']);
				
		?>
  
      <input type="checkbox" name="stream[]" value="< ?=$ListData['DeptId'];?>">&nbsp;< ?=$ListData['DeptInitials'];?> &nbsp;&nbsp;&nbsp;

< ?    $i= $i+1; }  }else{ echo "No Streams added to Display"; } mysqli_close($conn); ?>
          </label>
        </select>
      </div>
    </div>  -->
    <div class="form-group">
      <div class="col-lg-10 col-lg-offset-2">
	  <input type="hidden" value="<?=$_SESSION['UserId'];?>"  name="uid"/>
	  <input type="hidden" value="profileupdate" name="formtype"/>
        <button type="submit" class="btn btn-primary">Update Profile</button>
		<br><br><div id="show2" style="color:red; font-weight:bold;"></div>
      </div>
    </div>
  </fieldset>
</form>	
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
	<script type="text/javascript">
    
	 	 function  verify2(){
 
	$("#show2").html("<img src='images/loadingbar.gif'/>");
	var serializedValues = jQuery("#infoForm2").serialize();
	jQuery.ajax({ type: 'POST',url:"functions.php",data: serializedValues, success: function(returnval){
	
    //  alert("success");
       $("#show2").html(returnval);
	  // $('#show2').delay(2000).fadeOut();
	   $('#show2').show();
  }  });
	return false;
  } 
  
  </script>
 <script src="js/bootstrap.min.js"></script>

 </body>
</html>

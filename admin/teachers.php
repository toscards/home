<?PHP
include("../config.php");
if (!isset($_SESSION['UserId'])) 
{
	header("location: ../index.php");
	 exit();
}
if($_SESSION['UserRole'] == "user")
{
	header('LOCATION: ../index.php');
	 exit();
}

if ($_GET['typ'] == 'del'){
	$delete ="DELETE from teachers WHERE UserRole='user' AND UserId=".$_GET['id']."";
	mysqli_query($conn,$delete);//  or die(mysql_error());
	mysqli_close($conn);
	header('LOCATION: teachers.php?msg=Teacher Deleted Successfully!');
	exit;
}
if (isset($_GET['status'])) 
{
	 
			$query="update `users` set `UserStatus` = '".$_GET['status']."'  WHERE UserRole='user' AND UserId=".$_GET['id'].";";
			$result = mysqli_query($conn,$query);
			if($result){ 
			header("location: teachers.php?msg=User Status Updated!");
			mysqli_close($conn); exit();
			}else{
				header("location: teachers.php?msg=Error, Update user status Failled!");
				mysqli_close($conn); exit;}
  }
?><!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>View Teachers - Faculty Management System</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <link rel="stylesheet" href="../css/bootstrap.css" media="screen">
    <link rel="stylesheet" href="../css/custom.min.css">
	 <script type="text/javascript" src="../js/date_time.js"></script>
       <script src="../js/jquery-1.10.2.min.js"></script>     
  </head>
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
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">Department <span class="caret"></span></a>
          <ul class="dropdown-menu" role="menu">
            <li><a href="departmentadd.php">Add Department</a></li>
            <li><a href="departmentedit.php">Edit, Delete Departments</a></li>
            <li class="divider"></li>
            <li><a href="classadd.php">Add Class</a></li>
            <li><a href="classedit.php">Edit, Delete Classes</a></li>
           <li class="divider"></li>
			<li><a href="semesteradd.php">Add Semester</a></li>
            <li><a href="semesteredit.php">Edit, Delete Semesters</a></li>
			<li class="divider"></li>
			<li><a href="subjectadd.php">Add Subject</a></li>
            <li><a href="subjectedit.php">Edit, Delete Subjects</a></li>
            
          </ul>
        </li>
		
		<li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">Teachers <span class="caret"></span></a>
          <ul class="dropdown-menu" role="menu">
            <li><a href="teachers.php">View Teachers</a></li>
			<li class="divider"></li>
            <li><a href="projectreport.php">View Project Report</a></li>
            <li class="divider"></li>
			<li><a href="results.php">View Results</a></li>
		 </ul>
        </li>
		<li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">Time Table <span class="caret"></span></a>
          <ul class="dropdown-menu" role="menu">
            <li><a href="timetableadd.php">Add Time Table</a></li>
			<li class="divider"></li>
			<li><a href="timetableedit.php">View, Delete Time Table</a></li>
            </ul>
        </li>
		<li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">Settings <span class="caret"></span></a>
          <ul class="dropdown-menu" role="menu">
            <li><a href="managenews.php">Manage News Feeds</a></li>
			<li><a href="manageevents.php">Manage Events Updates</a></li>
            <li class="divider"></li>
			  <li><a href="managestaff.php">Manage Teaching & Non Teaching Staff</a></li>
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
        <div class="row">
          <div class="col-lg-8 col-md-7 col-sm-6">
            <h1>View Teachers</h1>
             <? if (isset($_GET['msg'])) { echo "<center><br> <font style='font-family:Verdana; font-size:19px; font-weight:bold; color:#FF0000;'>".$_GET['msg']."</font></center><br><br>"; } ?>
          </div>
		  <? if (!$_GET['typ']){ ?>
		   <div class="col-lg-12"> 
		   <p class="lead">Choose the option below to either make then Active/Inactive or Delete Teachers.</p>
		  <?
		  $sql=" SELECT * from users WHERE UserRole='user' ORDER BY UserId ASC";
			//print_r($sql);
			 $result = mysqli_query($conn,$sql);
			if(mysqli_num_rows($result)>0){ $i=1;
				
			 
?>
		  <table class="table table-striped table-hover " border="1">
  <thead>
    <tr class="info">
      <th >USER ID</th>
      <th >FULL NAME</th>
     <th >EMAIL</th>
    <th >MOBILE</th>
     <th >DEPT. TEACHING</th>
      <th >USER STATUS</th>
     <th >DELETE ?</th>
    </tr>
  </thead>
  <tbody>
  
  <? 
 while ($ListData=mysqli_fetch_array($result)){ 
 
				//GET DEPT IN WHICH TEACHER TEACHING
				$jsontoArray = json_decode($ListData['DepartmentId']);
				$DeptIdGot = implode(',', $jsontoArray);
				$GetDeptNames = "SELECT DeptInitials FROM `departments` WHERE `DeptId` IN (".$DeptIdGot.")";
				$FetchDeptNames = mysqli_query($conn,$GetDeptNames);
				
				while($getrows = mysqli_fetch_array($FetchDeptNames)) {
				  $getrows1[$i][] = $getrows['DeptInitials'];
				}
				 
				$GetDepta =implode(", " , $getrows1[$i]);
 	?>
  <tr>
      <td>&nbsp;<?=$ListData['UserId'];?></td>
      <td><?=$ListData['FullName'];?></td>
      <td><?=$ListData['Email'];?></td>
      <td><?=$ListData['Mobile'];?></td>
      <td><?=$GetDepta;?></td>
       <td><a title="Click on it to make User Active or Inactive" href="teachers.php?id=<?=$ListData['UserId'];?>&status=<? if($ListData['UserStatus']=="active"){echo "inactive";}else{echo "active";};?>" ><b><?=strtoupper($ListData['UserStatus']);?></b></a></td>
	   <td><a href="teachers.php?id=<?=$ListData['SubjectId'];?>&typ=del" onclick="return confirm('Are you sure you want to Delete this Teacher?');" ><b>Delete Teacher</b></a></td>
      
    </tr>

<?    $i= $i+1; }  
 echo "</tbody></table>";
 
}else{ echo "<center><font color='blue'><b>NO RESULTS FOUND !</b></font>!</center></td></tr>"; } mysqli_close($conn); 
?>
		  </div>
		  <? } ?>
		 
		  </div>
 
 

		  </div>
       

      

      <footer>  <br>
        <div class="row">
		<ul class="list-unstyled">
              <li class="pull-right"><a href="#top">Back to top</a></li>
			  <li></li>
			  </ul>
          
        </div>

      </footer>


    </div>
	
 <script src="../js/bootstrap.min.js"></script>

 </body>
</html>

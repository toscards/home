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
	$delete ="DELETE from departments WHERE DeptId=".$_GET['id']."";
	mysqli_query($conn,$delete);//  or die(mysql_error());
	mysqli_close($conn);
	header('LOCATION: departmentedit.php?msg=Department Deleted Successfully!');
	exit;
}
?><!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>Manage Department - Faculty Management System</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <link rel="stylesheet" href="../css/bootstrap.css" media="screen">
    <link rel="stylesheet" href="../css/custom.min.css">
	 <script type="text/javascript" src="../js/date_time.js"></script>
       <script src="../js/jquery-1.10.2.min.js"></script>    <script src="../js/custom.js"></script>
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
            <h1>Manage Departments</h1>
             <? if (isset($_GET['msg'])) { echo "<center><br> <font style='font-family:Verdana; font-size:19px; font-weight:bold; color:#FF0000;'>".$_GET['msg']."</font></center><br><br>"; } ?>
          </div>
		  <? if (!$_GET['typ']){ ?>
		   <div class="col-lg-10"> 
		   <p class="lead">Choose the option below to either edit or delete Department.</p>
		  <?
		  $sql=" SELECT * FROM departments ORDER BY DeptInitials ASC";
			//print_r($sql);
			 $result = mysqli_query($conn,$sql);
			if(mysqli_num_rows($result)>0){ $i=1;
 
	 
?>
		  <table class="table table-striped table-hover " border="1">
  <thead>
    <tr class="info">
      <th >DEPT. ID</th>
      <th >DEPT. INITIALS</th>
      <th >DEPT. FULL NAME</th>
       <th >EDIT ?</th>
     <th >DELETE ?</th>
    </tr>
  </thead>
  <tbody>
  
  <? 
 while ($ListData=mysqli_fetch_array($result)){ 
 //Date into Readable format
 	?>
  <tr>
      <td>&nbsp;<?=$ListData['DeptId'];?></td>
      <td><?=$ListData['DeptInitials'];?></td>
      <td><?=$ListData['DeptFullName'];?></td>
      <td><a href="departmentedit.php?id=<?=$ListData['DeptId'];?>&typ=edit" ><b>Edit Details</b></a></td>
	   <td><a href="departmentedit.php?id=<?=$ListData['DeptId'];?>&typ=del" onclick="return confirm('Are you sure you want to Delete this Department?');" ><b>Delete Department</b></a></td>
      
    </tr>

<?    $i= $i+1; }  
 echo "</tbody></table>";
 
}else{ echo "<center><font color='blue'><b>NO RESULTS FOUND !</b></font>!</center></td></tr>"; } mysqli_close($conn); 
?>
		  </div>
		  <? }  if ($_GET['typ'] == 'edit'){

// FETCH Department Details
$GetDept = "SELECT * from departments where DeptId=".$_GET['id']."";
$FetchDept = mysqli_query($conn,$GetDept);
$FetchDept = mysqli_fetch_array($FetchDept);
		  ?> 
		   <div class="col-lg-10">
		   <p class="lead">Edit Department.</p>
	 <div class="well bs-component">
	 
	 <form class="form-horizontal" onsubmit="return verify1();" id="infoForm1" method="POST" >
  <fieldset>
     <div class="form-group">
      <label for="inputPassword" class="col-lg-2 control-label">Dept. Initials</label>
      <div class="col-lg-10"> 
        <input class="form-control" id="inputPassword" placeholder="Enter Department initials. Eg. BCOM"  type="text" value="<?=$FetchDept['DeptInitials'];?>" name="deptinitials" maxlength="50"  required>
         </div>
    </div>
     
     <div class="form-group">
      <label for="inputPassword" class="col-lg-2 control-label">Dept. Name</label>
      <div class="col-lg-10">
        <input class="form-control" id="inputPassword" placeholder="Enter Full Department Name" type="text"  value="<?=$FetchDept['DeptFullName'];?>" name="deptfullname" maxlength="100" required>
         </div>
    </div>
    
	 
    <div class="form-group">
      <div class="col-lg-10 col-lg-offset-2">
	  <input type="hidden" value="departmentupdate" name="formtype"/>
	  <input type="hidden" value="<?=$_GET['id'];?>"  name="deptid"/>
        <button type="submit" class="btn btn-primary">Update Department</button>
		<br><br><div id="show1" style="color:red; font-weight:bold;"></div>
      </div>
    </div>
  </fieldset>
</form>	
</div></div>
<script type="text/javascript">
    
	 	 function  verify1(){
 
	$("#show1").html("<img src='../images/loadingbar.gif'/>");
	var serializedValues = jQuery("#infoForm1").serialize();
	jQuery.ajax({ type: 'POST',url:"functions.php",data: serializedValues, success: function(returnval){
	
    //  alert("success");
       $("#show1").html(returnval);
	  // $('#show1').delay(2000).fadeOut();
	   $('#show1').show();
  }  });
	return false;
  } 	  
  
  </script>
		  <? }  ?>
		 
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

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
	$delete ="DELETE from subjects WHERE SubjectId=".$_GET['id']."";
	mysqli_query($conn,$delete);//  or die(mysql_error());
	mysqli_close($conn);
	header('LOCATION: teachers.php?msg=Subject Deleted Successfully!');
	exit;
}
?><!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>Manage Subject - Faculty Management System</title>
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
            <h1>Manage Subjects</h1>
             <? if (isset($_GET['msg'])) { echo "<center><br> <font style='font-family:Verdana; font-size:19px; font-weight:bold; color:#FF0000;'>".$_GET['msg']."</font></center><br><br>"; } ?>
          </div>
		  <? if (!$_GET['typ']){ ?>
		   <div class="col-lg-12"> 
		   <p class="lead">Choose the option below to either edit or delete Subject.</p>
		  <?
		  $sql=" SELECT * from subjects su, departments d, semesters se WHERE  su.DeptId = d.DeptId AND su.SemesterId = se.SemesterId ORDER BY DeptInitials ASC";
			//print_r($sql);
			 $result = mysqli_query($conn,$sql);
			if(mysqli_num_rows($result)>0){ $i=1;
 
	 
?>
		  <table class="table table-striped table-hover " border="1">
  <thead>
    <tr class="info">
      <th >SUBJECT. ID</th>
      <th >DEPT. NAME</th>
     <th >SEMESTER NAME</th>
    <th >SUBJECT NAME</th>
     <th >VIEW SUBJECT</th>
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
      <td>&nbsp;<?=$ListData['SubjectId'];?></td>
      <td><?=$ListData['DeptInitials'];?></td>
      <td><?=$ListData['SemesterName'];?></td>
      <td><?=$ListData['SubjectName'];?></td>
      <td><a href="../subjects/<?=$ListData['SubjectUploadFileName'];?>" target="_blank"> View File</a></td>
     <td><a href="subjectedit.php?id=<?=$ListData['SubjectId'];?>&typ=edit" ><b>Edit Details</b></a></td>
	   <td><a href="subjectedit.php?id=<?=$ListData['SubjectId'];?>&typ=del" onclick="return confirm('Are you sure you want to Delete this Subject?');" ><b>Delete Subject</b></a></td>
      
    </tr>

<?    $i= $i+1; }  
 echo "</tbody></table>";
 
}else{ echo "<center><font color='blue'><b>NO RESULTS FOUND !</b></font>!</center></td></tr>"; } mysqli_close($conn); 
?>
		  </div>
		  <? }  if ($_GET['typ'] == 'edit'){

// FETCH Subject Details
$GetSubject = "SELECT * from subjects where SubjectId=".$_GET['id']."";
$FetchSubject = mysqli_query($conn,$GetSubject);
$FetchSubject = mysqli_fetch_array($FetchSubject);

// GET Departments and their data
$GetDept = "SELECT * from departments";
$FetchDept = mysqli_query($conn,$GetDept);
		
// GET Semester and their data from Dept chosen
$GetSem = "SELECT * from semesters WHERE DeptId=".$FetchSubject['DeptId'];
$FetchSem = mysqli_query($conn,$GetSem);
		

		?> 
		   <div class="col-lg-10">
		   <p class="lead">Edit Subject.</p>
	 <div class="well bs-component">
	 
	 <form class="form-horizontal" onsubmit="return verify1();" id="infoForm1" method="POST" >
  <fieldset>
    
     
    <div class="form-group">
      <label for="select" class="col-lg-2 control-label">Select Dept.</label>
      <div class="col-lg-10">
       <label><select class="form-control" name="selectdept" id="selectdept">
	   <option value=""> -- Select Department for Subject --</option>
	    <?  if(mysqli_num_rows($FetchDept)>0){ $i=1;
				while ($ListData=mysqli_fetch_array($FetchDept)){
					if($ListData['DeptId'] == $FetchSubject['DeptId']){ $selected = "selected";}else{$selected = "";}
		?>
  
          <option value="<?=$ListData['DeptId'];?>" <?=$selected;?>>&nbsp;<?=$ListData['DeptInitials'];?> </option>
     
<?    $i= $i+1; }  }else{ echo "No Streams added to Display"; } mysqli_close($conn); ?>
         </select> </label>
        </select>
      </div>
    </div>
     
    <div class="form-group">
      <label for="select" class="col-lg-2 control-label">Select Semester</label>
      <div class="col-lg-10">
       <label><select class="form-control" id="selectsemester"  name="selectsemester">
	   <option value=""> -- Select Semester for Subject --</option>
	    <?  if(mysqli_num_rows($FetchSem)>0){ $i=1;
				while ($ListData=mysqli_fetch_array($FetchSem)){
					if($ListData['SemesterId'] == $FetchSubject['SemesterId']){ $selected = "selected";}else{$selected = "";}
		?>
  
          <option value="<?=$ListData['SemesterId'];?>" <?=$selected;?>>&nbsp;<?=$ListData['SemesterName'];?> </option>
     
<?    $i= $i+1; }  }else{ echo "No Streams added to Display"; } mysqli_close($conn); ?>
         </select> </label>
        </select>
      </div>
    </div>
     
	 <div class="form-group">
      <label for="inputPassword" class="col-lg-2 control-label">Subject Name</label>
      <div class="col-lg-10">
        <input class="form-control" id="inputPassword" placeholder="Enter Full Subject Name" type="text" name="subjectname" value="<?=$FetchSubject['SubjectName'];?>" maxlength="100" required>
         </div>
    </div>
	
	<div class="form-group">
      <label for="inputPassword" class="col-lg-2 control-label">Upload File</label>
      <div class="col-lg-10">
			Current File: <a href="../subjects/<?=$FetchSubject['SubjectUploadFileName'];?>" target="_blank"> View File</a><br><br>
         <input type="file" name="subjectfile" accept=".pdf" >
         </div>
    </div>
    
    <div class="form-group">
      <div class="col-lg-10 col-lg-offset-2">
	  <input type="hidden" value="subjectupdate" name="formtype"/>
	  <input type="hidden" value="<?=$_GET['id'];?>"  name="subjectid"/>
	  <input type="hidden" value="<?=$FetchSubject['SubjectUploadFileName'];?>"  name="subjectfilename"/>
        <button type="submit" class="btn btn-primary">Update Subject Details</button>
		<br><br><div id="show1" style="color:red; font-weight:bold;"></div>
      </div>
    </div>
  </fieldset>
</form>	
</div></div>
<script type="text/javascript">
    
	 	  function  verify1(){
 
	$("#show1").html("<img src='../images/loadingbar.gif'/>");
	jQuery.ajax({ type: 'POST', url:"functions.php", data: new FormData($("#infoForm1")[0]), processData: false, contentType: false, success: function(returnval){
	
    //  alert("success");
       $("#show1").html(returnval);
	  // $('#show1').delay(2000).fadeOut();
	   $('#show1').show();
  }  });
	return false;
  } 

$(document).on("change", '#selectdept', function(e) {
            var department = $(this).val();
            var getsemfrmdept = "getsemfrmdept";
           
            $.ajax({
                type: "POST",
                data: {selectdept: department, formtype: getsemfrmdept },
				 dataType: 'json',
                url: 'functions.php',
               success: function(json) {
					$('#divsem').show();
				   var $el = $("#selectsemester");
                    $el.empty(); // remove old options
                    $el.append($("<option></option>")
                            .attr("value", '').text('-- Select Semester for Subject --'));
							
                    $.each(json, function(value, key) {
						// console.log(key.SemesterName + ':' + key.SemesterId);
						$el.append($("<option></option>").attr("value", key.SemesterId).text(key.SemesterName));
       
                    });														
	              }
            });

        });    
  
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

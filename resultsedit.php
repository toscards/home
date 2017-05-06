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

 
if ($_GET['typ'] == 'del'){
	$delete ="DELETE from reports WHERE ReportId=".$_GET['id']."";
	mysqli_query($conn,$delete);//  or die(mysql_error());
	mysqli_close($conn);
	header('LOCATION: resultsedit.php?msg=Report Deleted Successfully!');
	exit;
}
?><!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>Manage Report - Faculty Management System</title>
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
        <div class="row">
          <div class="col-lg-8 col-md-7 col-sm-6">
            <h1>Manage Student's Report</h1>
             <? if (isset($_GET['msg'])) { echo "<center><br> <font style='font-family:Verdana; font-size:19px; font-weight:bold; color:#FF0000;'>".$_GET['msg']."</font></center><br><br>"; } ?>
          </div>
		  <? if (!$_GET['typ']){ ?>
		   <div class="col-lg-12"> 
		   <p class="lead">Choose the option below to either edit or delete Report.</p>
		  <?
		  $sql=" SELECT * from reports rr, departments d, semesters se, classes c WHERE  rr.DeptId = d.DeptId AND rr.SemesterId = se.SemesterId AND rr.ClassId = c.ClassId ORDER BY SRollNum ASC";
			//print_r($sql);
			 $result = mysqli_query($conn,$sql);
			if(mysqli_num_rows($result)>0){ $i=1;
 
	 
?>
		  <table class="table table-striped table-hover " border="1">
  <thead>
    <tr class="info">
      <th >REPORT ID</th>
      <th >STUDENT ROLL NO.</th>
     <th >DEPT. NAME</th>
    <th >CLASS NAME</th>
     <th >SEMESTER NAME</th>
    <th >VIEW REPORT</th>
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
      <td>&nbsp;<?=$ListData['ReportId'];?></td>
      <td><?=$ListData['SRollNum'];?></td>
      <td><?=$ListData['DeptInitials'];?></td>
      <td><?=$ListData['ClassInitials'];?></td>
      <td><?=$ListData['SemesterName'];?></td>
      <td><a href="reports/<?=$ListData['ReportFileName'];?>" target="_blank"> View Report</a></td>
     <td><a href="resultsedit.php?id=<?=$ListData['ReportId'];?>&typ=edit" ><b>Edit Details</b></a></td>
	   <td><a href="resultsedit.php?id=<?=$ListData['ReportId'];?>&typ=del" onclick="return confirm('Are you sure you want to Delete this Result?');" ><b>Delete Result</b></a></td>
      
    </tr>

<?    $i= $i+1; }  
 echo "</tbody></table>";
 
}else{ echo "<td><center><font color='blue'><b>NO RESULTS FOUND !</b></font>!</center></td></tr>"; } mysqli_close($conn); 
?>
		  </div>
		  <? }  if ($_GET['typ'] == 'edit'){

// FETCH Report Details
$GetReport = "SELECT * from reports where ReportId=".$_GET['id'];
$FetchReport = mysqli_query($conn,$GetReport);
$FetchReport = mysqli_fetch_array($FetchReport);

// GET Departments and their data
$GetDept = "SELECT * from departments";
$FetchDept = mysqli_query($conn,$GetDept);
		
// GET Class Details
$GetClass = "SELECT * from classes WHERE DeptId=".$FetchReport['DeptId'];
$FetchClass = mysqli_query($conn,$GetClass);
		
// GET Semester and their data from Dept chosen
$GetSem = "SELECT * from semesters WHERE DeptId=".$FetchReport['DeptId'];
$FetchSem = mysqli_query($conn,$GetSem);
		

		?> 
		   <div class="col-lg-10">
		   <p class="lead">Edit Report Details.</p>
	 <div class="well bs-component">
	 
	 <form class="form-horizontal" onsubmit="return verify1();" id="infoForm1" method="POST" >
  <fieldset>
    
     
    <div class="form-group">
      <label for="select" class="col-lg-2 control-label">Select Dept.</label>
      <div class="col-lg-10">
       <label><select class="form-control" name="selectdept" id="selectdept">
	   <option value=""> -- Select Department for Time Table --</option>
	    <?  if(mysqli_num_rows($FetchDept)>0){ $i=1;
				while ($ListData=mysqli_fetch_array($FetchDept)){
					if($ListData['DeptId'] == $FetchReport['DeptId']){ $selected = "selected";}else{$selected = "";}
		?>
  
          <option value="<?=$ListData['DeptId'];?>" <?=$selected;?>>&nbsp;<?=$ListData['DeptInitials'];?> </option>
     
<?    $i= $i+1; }  }else{ echo "No Streams added to Display"; } mysqli_close($conn); ?>
         </select> </label>
        </select>
      </div>
    </div>
     
    <div class="form-group">
      <label for="select" class="col-lg-2 control-label">Select Class</label>
      <div class="col-lg-10">
       <label><select class="form-control" id="selectclass"  name="selectclass">
	   <option value=""> -- Select Class for Time Table --</option>
	    <?  if(mysqli_num_rows($FetchClass)>0){ $i=1;
				while ($ListData=mysqli_fetch_array($FetchClass)){
					if($ListData['ClassId'] == $FetchReport['ClassId']){ $selected = "selected";}else{$selected = "";}
		?>
  
          <option value="<?=$ListData['ClassId'];?>" <?=$selected;?>>&nbsp;<?=$ListData['ClassInitials'];?> </option>
     
<?    $i= $i+1; }  }else{ echo "No Streams added to Display"; } mysqli_close($conn); ?>
         </select> </label>
        </select>
      </div>
    </div>
	
         <div class="form-group">
      <label for="select" class="col-lg-2 control-label">Select Semester</label>
      <div class="col-lg-10">
       <label><select class="form-control" id="selectsemester"  name="selectsemester">
	   <option value=""> -- Select Semester for Time Table --</option>
	    <?  if(mysqli_num_rows($FetchSem)>0){ $i=1;
				while ($ListData=mysqli_fetch_array($FetchSem)){
					if($ListData['SemesterId'] == $FetchReport['SemesterId']){ $selected = "selected";}else{$selected = "";}
		?>
  
          <option value="<?=$ListData['SemesterId'];?>" <?=$selected;?>>&nbsp;<?=$ListData['SemesterName'];?> </option>
     
<?    $i= $i+1; }  }else{ echo "No Streams added to Display"; } mysqli_close($conn); ?>
         </select> </label>
        </select>
      </div>
    </div>
     
	 <div class="form-group">
      <label for="inputPassword" class="col-lg-2 control-label">Student Roll No.</label>
      <div class="col-lg-10">
        <input class="form-control" id="inputPassword" placeholder="Enter Student's Roll No." type="text" name="strollno" value="<?=$FetchReport['SRollNum'];?>" maxlength="10" required>
         </div>
    </div>
	
	  
	
	<div class="form-group">
      <label for="inputPassword" class="col-lg-2 control-label">Upload File</label>
      <div class="col-lg-10">
			Current File: <a href="reports/<?=$FetchReport['ReportFileName'];?>" target="_blank"> View Report</a><br><br>
         <input type="file" name="ttfile" accept=".pdf,.doc,.docx,.img" >
         </div>
    </div>
    
    <div class="form-group">
      <div class="col-lg-10 col-lg-offset-2">
	  <input type="hidden" value="reportupdate" name="formtype"/>
	  <input type="hidden" value="<?=$_GET['id'];?>"  name="reportid"/>
	  <input type="hidden" value="<?=$FetchReport['ReportFileName'];?>"  name="reportfilename"/>
        <button type="submit" class="btn btn-primary">Update Report Details</button>
		<br><br><div id="show1" style="color:red; font-weight:bold;"></div>
      </div>
    </div>
  </fieldset>
</form>	
</div></div>
<script type="text/javascript">
    
	 	  function  verify1(){
 
	$("#show1").html("<img src='images/loadingbar.gif'/>");
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
           var getsemclassfrmdept = "getsemclassfrmdept";
           
            $.ajax({
                type: "POST",
                data: {selectdept: department, formtype: getsemfrmdept },
				 dataType: 'json',
                url: 'functions.php',
               success: function(json) {
					$('#divsem').show();
				   
					var $el = $("#selectsemester");
                    $el.empty(); // remove old options
                    $el.append($("<option></option>").attr("value", '').text('-- Select Semester for Time Table --'));
							
                     $.each(json, function(value, key) {
						 // console.log(key.ClassId + ':' + key.ClassInitials);
						$el.append($("<option></option>").attr("value", key.SemesterId).text(key.SemesterName));
					 	 
                    });														
	              }
            });
			
			$.ajax({
                type: "POST",
                data: {selectdept: department, formtype: getsemclassfrmdept },
				 dataType: 'json',
                url: 'functions.php',
               success: function(json) {
					 
					var $el2 = $("#selectclass");
                    $el2.empty(); // remove old options
                    $el2.append($("<option></option>").attr("value", '').text('-- Select Class for Time Table --'));
				 			
                    $.each(json, function(value, key) {
						   console.log(key.ClassId + ':' + key.ClassInitials);
						$el2.append($("<option></option>").attr("value", key.ClassId).text(key.ClassInitials));
       
                    });														
	              }
            });

        }); 
  </script>
		  <? }  ?>
		 
		  </div>
 
 
       

      

      <footer> <br><br> <br><br>  
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

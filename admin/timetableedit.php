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
	$delete ="DELETE from timetable WHERE TimetableId=".$_GET['id']."";
	mysqli_query($conn,$delete);//  or die(mysql_error());
	mysqli_close($conn);
	header('LOCATION: timetableedit.php?msg=Time Table Deleted Successfully!');
	exit;
}
?><!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>Manage Time Table - Faculty Management System</title>
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
            <h1>Manage Time Table</h1>
             <? if (isset($_GET['msg'])) { echo "<center><br> <font style='font-family:Verdana; font-size:19px; font-weight:bold; color:#FF0000;'>".$_GET['msg']."</font></center><br><br>"; } ?>
          </div>
		  <? if (!$_GET['typ']){ ?>
		   <div class="col-lg-12"> 
		   <p class="lead">Choose the option below to either edit or delete Time Table.</p>
		  <?
		  $sql=" SELECT * from timetables tt, departments d, semesters se, classes c WHERE  tt.DeptId = d.DeptId AND tt.SemesterId = se.SemesterId AND tt.ClassId = c.ClassId ORDER BY DeptInitials ASC";
			//print_r($sql);
			 $result = mysqli_query($conn,$sql);
			if(mysqli_num_rows($result)>0){ $i=1;
 
	 
?>
		  <table class="table table-striped table-hover " border="1">
  <thead>
    <tr class="info">
      <th >TIMETABLE ID</th>
      <th >TIMETABLE NOTE</th>
     <th >DEPT. NAME</th>
    <th >CLASS NAME</th>
     <th >SEMESTER NAME</th>
    <th >VIEW TIMETABLE</th>
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
      <td>&nbsp;<?=$ListData['TimetableId'];?></td>
      <td><?=$ListData['TimetableNote'];?></td>
      <td><?=$ListData['DeptInitials'];?></td>
      <td><?=$ListData['ClassInitials'];?></td>
      <td><?=$ListData['SemesterName'];?></td>
      <td><a href="../timetable/<?=$ListData['TimetableFileName'];?>" target="_blank"> View File</a></td>
     <td><a href="timetableedit.php?id=<?=$ListData['TimetableId'];?>&typ=edit" ><b>Edit Details</b></a></td>
	   <td><a href="timetableedit.php?id=<?=$ListData['TimetableId'];?>&typ=del" onclick="return confirm('Are you sure you want to Delete this Time Table?');" ><b>Delete Time Table</b></a></td>
      
    </tr>

<?    $i= $i+1; }  
 echo "</tbody></table>";
 
}else{ echo "<td><center><font color='blue'><b>NO RESULTS FOUND !</b></font>!</center></td></tr>"; } mysqli_close($conn); 
?>
		  </div>
		  <? }  if ($_GET['typ'] == 'edit'){

// FETCH Time Table Details
$GetTimetable = "SELECT * from timetables where TimetableId=".$_GET['id'];
$FetchTimetable = mysqli_query($conn,$GetTimetable);
$FetchTimetable = mysqli_fetch_array($FetchTimetable);

// GET Departments and their data
$GetDept = "SELECT * from departments";
$FetchDept = mysqli_query($conn,$GetDept);
		
// GET Class Details
$GetClass = "SELECT * from classes WHERE DeptId=".$FetchTimetable['DeptId'];
$FetchClass = mysqli_query($conn,$GetClass);
		
// GET Semester and their data from Dept chosen
$GetSem = "SELECT * from semesters WHERE DeptId=".$FetchTimetable['DeptId'];
$FetchSem = mysqli_query($conn,$GetSem);
		

		?> 
		   <div class="col-lg-10">
		   <p class="lead">Edit Time Table.</p>
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
					if($ListData['DeptId'] == $FetchTimetable['DeptId']){ $selected = "selected";}else{$selected = "";}
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
					if($ListData['ClassId'] == $FetchTimetable['ClassId']){ $selected = "selected";}else{$selected = "";}
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
					if($ListData['SemesterId'] == $FetchTimetable['SemesterId']){ $selected = "selected";}else{$selected = "";}
		?>
  
          <option value="<?=$ListData['SemesterId'];?>" <?=$selected;?>>&nbsp;<?=$ListData['SemesterName'];?> </option>
     
<?    $i= $i+1; }  }else{ echo "No Streams added to Display"; } mysqli_close($conn); ?>
         </select> </label>
        </select>
      </div>
    </div>
     
	 <div class="form-group">
      <label for="inputPassword" class="col-lg-2 control-label">Time Table Note</label>
      <div class="col-lg-10">
        <input class="form-control" id="inputPassword" placeholder="Enter Note for Time Table" type="text" name="ttnote" value="<?=$FetchTimetable['TimetableNote'];?>" maxlength="200" required>
         </div>
    </div>
	
	  
	
	<div class="form-group">
      <label for="inputPassword" class="col-lg-2 control-label">Upload File</label>
      <div class="col-lg-10">
			Current File: <a href="../timetable/<?=$FetchTimetable['TimetableFileName'];?>" target="_blank"> View File</a><br><br>
         <input type="file" name="timetablefile" accept=".pdf" >
         </div>
    </div>
    
    <div class="form-group">
      <div class="col-lg-10 col-lg-offset-2">
	  <input type="hidden" value="timetableupdate" name="formtype"/>
	  <input type="hidden" value="<?=$_GET['id'];?>"  name="timetableid"/>
	  <input type="hidden" value="<?=$FetchTimetable['TimetableFileName'];?>"  name="timetablefilename"/>
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

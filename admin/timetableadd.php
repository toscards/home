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

// GET Departments and their data
$GetDept = "SELECT * from departments";
$FetchDept = mysqli_query($conn,$GetDept);

?><!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>Add Time Table - Faculty Management System</title>
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
            <h1>Add New Time Table</h1>
             
          </div>
           <div class="col-lg-10"> 
	 <div class="well bs-component">
	 
	 <form class="form-horizontal" onsubmit="return verify1();" id="infoForm1" method="POST" >
  <fieldset>
    <legend>You can Add New Time Table from this page.</legend>
    <div class="form-group">
	
	<div class="form-group">
      <label for="select" class="col-lg-2 control-label">Select Dept.</label>
      <div class="col-lg-10">
       <label><select class="form-control" name="selectdept" id="selectdept" required>
	   <option value=""> -- Select Department for Subject --</option>
	    <?  if(mysqli_num_rows($FetchDept)>0){ $i=1;
				while ($ListData=mysqli_fetch_array($FetchDept)){ 
		?>
  
          <option value="<?=$ListData['DeptId'];?>">&nbsp;<?=$ListData['DeptInitials'];?> </option>
     
<?    $i= $i+1; }  }else{ echo "No Streams added to Display"; } mysqli_close($conn); ?>
         </select> </label>
        </select>
      </div>
    </div>
	
	<div id="divsem" style="display:none;">
	
	 <div class="form-group" >
      <label for="select" class="col-lg-2 control-label">Select Class</label>
	  <div class="col-lg-10">
       <label><select class="form-control" name="selectclass" id="selectclass" required>
	   <option value="">-- Select Class for Time Table --</option>
	    
         </select> </label>
        </select>
      </div>
    </div>
	
	<div class="form-group" >
      <label for="select" class="col-lg-2 control-label">Select Semester</label>
	  <div class="col-lg-10">
       <label><select class="form-control" name="selectsemester" id="selectsemester" required>
	   <option value="">-- Select Semester for Time Table --</option>
	    
         </select> </label>
        </select>
      </div>
      
    </div>
	
	<div class="form-group">
      <label for="inputPassword" class="col-lg-2 control-label">Time Table Note</label>
      <div class="col-lg-10">
        <input class="form-control" id="inputPassword" placeholder="Enter Note for Time Table" type="text" name="ttnote" maxlength="200" required>
         </div>
    </div>
	
	<div class="form-group">
      <label for="inputPassword" class="col-lg-2 control-label">Upload File</label>
      <div class="col-lg-10">
         <input type="file" name="ttfile" accept=".pdf" required>
         </div>
    </div>
	
	<div class="form-group">
      <div class="col-lg-10 col-lg-offset-2">
	  <input type="hidden" value="timetableadd" name="formtype"/>
        <button type="submit" class="btn btn-primary">Add Time Table</button>
		<br><br><div id="show1" style="color:red; font-weight:bold;"></div>
      </div>
    </div>
	
	
	</div>
	
	 </div>
	 </fieldset>
</form>	
</div></div>
		
		 
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
 <script src="../js/bootstrap.min.js"></script>

 </body>
</html>

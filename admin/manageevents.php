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

// GET NEWS
$GetNews = "SELECT * from events";
$FetchNews = mysqli_query($conn,$GetNews);

if ($_GET['typ'] == 'del'){
	$delete ="DELETE from events WHERE EventId=".$_GET['id']."";
	mysqli_query($conn,$delete);//  or die(mysql_error());
	mysqli_close($conn);
	header('LOCATION: manageevents.php?msg=Event Deleted Successfully!');
	exit;
}

?><!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>Add Event - Faculty Management System</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <link rel="stylesheet" href="../css/bootstrap.css" media="screen">
      <script type="text/javascript" src="../js/date_time.js"></script>
       <script src="../js/jquery-1.10.2.min.js"></script>   
  <link rel="stylesheet" href="../js/jquery-ui.css">
			   <script src="../js/jquery-ui.js"></script>	   
	   <script>
	
 $(document).ready(function() {
   $('#msg').delay(2000).fadeOut();
   $("#showc").hide();
   
		$("#show").click(function(){
			$("#showc").show(1000);
		});

		$("#hide").click(function(){
			$("#showc").hide(1000);
		});
}); 

</script>
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
           <br><h1>Manage Event</h1><br>
		   <div class="jumbotron">
	<div id="msg"><?
	if (isset($_GET['msg'])) { echo "<center><br><font style='font-family:Verdana; font-size:19px; font-weight:bold; color:#FF0000;'>".$_GET['msg']."</font></center><br><br>"; } ?></div>
	
	  <? if ($_GET['typ'] == 'edit'){
		  
		  // FETCH Events Details
$GetEvent = "SELECT * from events where EventId=".$_GET['id'];
$FetchEvent = mysqli_query($conn,$GetEvent);
$FetchEvent = mysqli_fetch_array($FetchEvent);
?>
	  
	  <div class="well bs-component">
			 <form class="form-horizontal"  onsubmit="return verify1();" id="infoForm1" method="post">
                
                <fieldset>
                  <div class="form-group">
				     <label for="inputName" class="col-lg-2 control-label">Event Name: </label>
                    <div class="col-lg-10">
                    <input type="text" class="form-control"   name="EventName" value="<?=$FetchEvent['EventName'];?>"   placeholder="Please Enter Event Name" maxlength="100" required>
                  </div></div>
				   
				   <div class="form-group">
				     <label for="inputName" class="col-lg-2 control-label">Event Description: </label>
                    <div class="col-lg-10">
                    <input type="text" class="form-control" id="EventDesc" name="EventDesc" value="<?=$FetchEvent['EventDesc'];?>" placeholder="Please Enter Event Description" maxlength="600" required>
                  </div></div>
				   
				   <div class="form-group">
				     <label for="inputName" class="col-lg-2 control-label">Event Date: </label>
                    <div class="col-lg-10">
                    <input type="text" class="form-control" id="datepicker" value="<?=$FetchEvent['EventDate'];?>"  name="EventDate" style="background-color:#FFF;"  placeholder="Please Enter Event Date" maxlength="50" readonly required>
                  </div></div>
				   
				   <div class="form-group">
                    <div class="col-lg-10 col-lg-offset-2"> 
					 <input type="hidden" value="updateevent" name="formtype"/>
					 <input type="hidden" value="<?=$_GET['id'];?>"  name="eventid"/>
                        <input type="submit" value="Update Event Details" name="submit"  class="btn btn-primary"/>
             <br><br><div id="show1" style="color:red; font-weight:bold;"></div>
                    </div>
                  </div>
                </fieldset>
              </form>
			 </div>
	  
	  <? }else{ ?>
	 <table class="table table-striped table-hover " border="1">
  <thead>
    <tr class="info">
      <th class="row-1 row">ID</th>
      <th class="row-2 row">Event Name</th>
      <th class="row-2 row">Event Description</th>
      <th class="row-2 row">Event Date</th>
   <th class="row-2 row"> Edit Event</th>
   <th class="row-2 row"> Delete?</th>
    </tr>
  </thead>
  <tbody>
 <?  if(mysqli_num_rows($FetchNews)>0){ $i=1;
 while ($ListData=mysqli_fetch_array($FetchNews)){ 
 ?>
  <tr>
      <td><?=$ListData['EventId'];?></td>
      <td><?=$ListData['EventName'];?></td>
       <td><?=wordwrap($ListData['EventDesc'], 110, "<br />\n");?></td>
	   <td><?=$ListData['EventDate'];?></td>
	   <td><a href="manageevents.php?id=<?=$ListData['EventId'];?>&typ=edit" ><b>Edit Event</b></a></td>
	   <td><a href="manageevents.php?id=<?=$ListData['EventId'];?>&typ=del"  onclick="return confirm('Are you sure you want to Delete this Event?');"><b>Delete Event</b></a></td>
    </tr>

<?    $i= $i+1; }  }else{ echo "<tr><td></td><td><center><strong>No Records to Display</strong></center></td></tr>"; } mysqli_close($conn); ?> </tbody></table>
					 <br><br><button class="btn btn-primary" id="show" >Add New Event! </button> <center> </center><br><br> 
             <div id="showc">
			  <div class="col-lg-10">
			  <br><b>Please Enter Event details below and submit.</b>
            <div class="well bs-component">
			 <form class="form-horizontal"  onsubmit="return verify1();" id="infoForm1" method="post">
                
                <fieldset>
                  <div class="form-group">
				     <label for="inputName" class="col-lg-2 control-label">Event Name: </label>
                    <div class="col-lg-10">
                    <input type="text" class="form-control"   name="EventName" placeholder="Please Enter Event Name" maxlength="100" required>
                  </div></div>
				   
				   <div class="form-group">
				     <label for="inputName" class="col-lg-2 control-label">Event Description: </label>
                    <div class="col-lg-10">
                    <input type="text" class="form-control" id="EventDesc" name="EventDesc" placeholder="Please Enter Event Description" maxlength="600" required>
                  </div></div>
				   
				   <div class="form-group">
				     <label for="inputName" class="col-lg-2 control-label">Event Date: </label>
                    <div class="col-lg-10">
                    <input type="text" class="form-control" id="datepicker" name="EventDate" style="background-color:#FFF;"  placeholder="Please Enter Event Date" maxlength="50" readonly required>
                  </div></div>
				   
				   <div class="form-group">
                    <div class="col-lg-10 col-lg-offset-2"> 
					 <input type="hidden" value="addevent" name="formtype"/>
                      <button type="reset" id="hide" class="btn btn-default">Cancel</button>
					    <input type="submit" value="Add New Event" name="submit"  class="btn btn-primary"/>
             <br><br><div id="show1" style="color:red; font-weight:bold;"></div>
                    </div>
                  </div>
                </fieldset>
              </form>
			 </div></div>
			 </div>
	  <?}?>
  </div>
		 
		  </div>
 
 

		  </div>
       
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
  
       $(function() {
		  $( "#datepicker" ).datepicker({  inline: true, minDate: "<?=date("d/m/Y");?>", dateFormat: 'dd/mm/yy' }); 
		$("#datepicker").datepicker("option","defaultDate", "<?=date("d/m/Y");?>");
  });
 
  </script>
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

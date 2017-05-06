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
$GetNews = "SELECT * from news";
$FetchNews = mysqli_query($conn,$GetNews);

/* if (isset($_POST['news'])) {

 $insert = "insert into news(NewsDetails) 
			VALUES ('".mysqli_real_escape_string($conn,$_POST['news'])."')";	
			 //print_r($insert);	
			$result = mysqli_query($conn,$insert);
			// exit;
			if ($result){ 
			header('LOCATION: managenews.php?msg=News Inserted Successfully!');
			}else {header('LOCATION: managenews.php?msg=Error, Something went wrong!');
			}

} */

if ($_GET['typ'] == 'del'){
	$delete ="DELETE from news WHERE NewsId=".$_GET['id']."";
	mysqli_query($conn,$delete);//  or die(mysql_error());
	mysqli_close($conn);
	header('LOCATION: managenews.php?msg=News Deleted Successfully!');
	exit;
}

?><!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>Add News - Faculty Management System</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <link rel="stylesheet" href="../css/bootstrap.css" media="screen">
    <link rel="stylesheet" href="../css/custom.min.css">
	 <script type="text/javascript" src="../js/date_time.js"></script>
       <script src="../js/jquery-1.10.2.min.js"></script>    
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
           <h1>Manage News</h1>
		   <div class="jumbotron">
	<div id="msg"><? if (isset($_GET['msg'])) { echo "<center><br><font style='font-family:Verdana; font-size:19px; font-weight:bold; color:#FF0000;'>".$_GET['msg']."</font></center><br><br>"; } ?></div>
	 <table class="table table-striped table-hover " border="1">
  <thead>
    <tr class="info">
      <th class="row-1 row">ID</th>
      <th class="row-2 row">News</th>
   <th class="row-2 row"> Delete?</th>
    </tr>
  </thead>
  <tbody>
 <?  if(mysqli_num_rows($FetchNews)>0){ $i=1;
 while ($ListData=mysqli_fetch_array($FetchNews)){ 
 ?>
  <tr>
      <td><?=$ListData['NewsId'];?></td>
      <td><?=wordwrap($ListData['NewsDetails'], 110, "<br />\n");?></td>
         <td><a href="managenews.php?id=<?=$ListData['NewsId'];?>&typ=del"  onclick="return confirm('Are you sure you want to Delete this News?');"><b>Delete News</b></a></td>
    </tr>

<?    $i= $i+1; }  }else{ echo "<tr><td></td><td><center><strong>No Records to Display</strong></center></td></tr>"; } mysqli_close($conn); ?> </tbody></table>
					 <br><br><button class="btn btn-primary" id="show" >Add New News! </button> <center> </center><br><br> 
             <div id="showc">
			  <div class="col-lg-6">
			  <br><b>Please Enter News below and submit.</b>
            <div class="well bs-component">
			 <form class="form-horizontal"  onsubmit="return verify1();" id="infoForm1" method="post">
                
                <fieldset>
                  <div class="form-group">
				     <label for="inputName" class="col-lg-2 control-label">News: </label>
                    <div class="col-lg-10">
                    <input type="text" class="form-control" id="news" name="NewsDetails" placeholder="Please Enter News" maxlength="600" required>
                  </div></div>
				   
				   <div class="form-group">
                    <div class="col-lg-10 col-lg-offset-2"> 
					<input type="hidden" value="addnews" name="formtype"/>
                      <button type="reset" id="hide" class="btn btn-default">Cancel</button>
					    <input type="submit" value="Add New News" name="submit"  class="btn btn-primary"/>
             <br><br><div id="show1" style="color:red; font-weight:bold;"></div>
                    </div>
                  </div>
                </fieldset>
              </form>
			 </div></div>
			 </div>
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

<?
//INCLUDED OUR CONFIG FILE WHICH HAS DATABASE CONNECTION DETAILS :P
include("config.php");

// GET Departments and their data
$GetDept = "SELECT * from departments";
$FetchDept = mysqli_query($conn,$GetDept);

?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>Registration - Faculty Management System</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <link rel="stylesheet" href="css/bootstrap.css" media="screen">
    <link rel="stylesheet" href="css/custom.min.css">
	 <script type="text/javascript" src="js/date_time.js"></script>
       <script src="js/jquery-1.10.2.min.js"></script>    <script src="js/custom.js"></script>
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
             <li>
              <a href="index.php">Login</a>
            </li>
            <li>
              <a  href="registration.php">Registration</a>
            </li>
             
          </ul>

          <ul class="nav navbar-nav navbar-right">
            <li style="text-decoration:none;"><a><span id="date_time"></span></a>
            <script type="text/javascript">window.onload = date_time('date_time');</script></li>
          </ul>

        </div>
      </div>
    </div>


    <div class="container">

      <div class="page-header" id="banner">
        <div class="row">
          <div class="col-lg-8 col-md-7 col-sm-6">
            <h1>Faculty Registration Page!</h1>
            <p class="lead">Please use the form below to make your Registration.<br> We will Activate your Account after verification.</p>
          </div>
           
		  </div>
        
		  <div class="col-lg-6"><br> 
              <form class="form-horizontal"  onsubmit="return verify1();" id="infoForm1" method="POST" >
  <fieldset>
     <div class="form-group">
      <label for="inputEmail" class="col-lg-2 control-label"> Name</label>
      <div class="col-lg-10">
        <input type="text" class="form-control" id="inputEmail" placeholder="Enter Full Name" autocomplete="off" name="lfname" oninvalid="setCustomValidity('Please enter your Full Name')" onchange="try{setCustomValidity('')}catch(e){}"  required>
      </div>
    </div>
	
	 <div class="form-group">
      <label for="inputEmail" class="col-lg-2 control-label"> Email</label>
      <div class="col-lg-10">
        <input type="email" class="form-control" id="inputEmail" placeholder="Enter Email" autocomplete="off" name="lemail" oninvalid="setCustomValidity('Please enter your valid email address')" onchange="try{setCustomValidity('')}catch(e){}"  required>
      </div>
    </div>
	
	 <div class="form-group">
      <label for="inputEmail" class="col-lg-2 control-label"> Mobile</label>
      <div class="col-lg-10">
        <input type="text" class="form-control" id="inputEmail" pattern="[0-9]{10}"  maxlength="10"  placeholder="Enter Mobile Number" autocomplete="off" name="lmobile" oninvalid="setCustomValidity('Please enter your valid Mobile Number')" onchange="try{setCustomValidity('')}catch(e){}"  required>z
      </div>
    </div>
	
	<div class="form-group">
      <label for="select" class="col-lg-2 control-label">Stream</label>
      <div class="col-lg-10">
       <label>
	    <?  if(mysqli_num_rows($FetchDept)>0){ $i=1;
				while ($ListData=mysqli_fetch_array($FetchDept)){ 
		?>
  
      <input type="checkbox" name="stream[]" value="<?=$ListData['DeptId'];?>">&nbsp;<?=$ListData['DeptInitials'];?> &nbsp;&nbsp;&nbsp;

<?    $i= $i+1; }  }else{ echo "No Streams added to Display"; } mysqli_close($conn); ?>
          </label>
        </select>
      </div>
    </div>
	
    <div class="form-group">
      <label for="inputPassword" class="col-lg-2 control-label">Password <br></label>
      <div class="col-lg-10">
        <input type="password" class="form-control" id="inputPassword" placeholder="Enter Password" autocomplete="off" name="lpassword" maxlength="20" oninvalid="setCustomValidity('Please enter valid Password')" onchange="try{setCustomValidity('')}catch(e){}"  required>
      </div>
	  
	   </div>
	     <div class="form-group">
      <label for="inputPassword" class="col-lg-2 control-label">Confirm Password <br></label>
      <div class="col-lg-10">
        <input type="password" class="form-control" id="inputPassword" placeholder="Confirm Password" autocomplete="off" maxlength="20" name="lcpassword" oninvalid="setCustomValidity('Please confirm your valid Password')" onchange="try{setCustomValidity('')}catch(e){}"  required>
      </div>
	   </div>
	   
   <div class="form-group">
      <div class="col-lg-10 col-lg-offset-2">
        <button type="reset" class="btn btn-default">Reset</button>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		<input type="hidden" value="registration" name="formtype"/>
        <button type="submit" class="btn btn-success">Register Now!</button>
		<br><br><div id="show1" style="color:red; font-weight:bold;"></div>
      </div>
    </div>
  </fieldset>
</form>
         </div>
		  
		   
			     
      </div>

      

      <footer> 
        <div class="row"><br><br> <br> <br> <br><br> <br> <br> <br> <br> <br> <br>
		<ul class="list-unstyled">
              <li class="pull-right"><a href="#top">Back to top</a></li>
			  <li></li>
			  </ul>
          
        </div>

      </footer>


    </div>
	<script type="text/javascript">
    
	 	 function  verify1(){
 
	$("#show1").html("<img src='images/loadingbar.gif'/>");
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
 <script src="js/bootstrap.min.js"></script>

 </body>
</html>

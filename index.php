<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>NFC | Login & Register</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <link rel="stylesheet" href="css/bootstrap.css" media="screen">
    <link rel="stylesheet" href="css/custom.min.css">
	 <script type="text/javascript" src="js/date_time.js"></script>
       <script src="js/jquery-1.10.2.min.js"></script>   
  </head>
  <body>
    <div class="navbar navbar-default navbar-fixed-top">
      <div class="container">
        <div class="navbar-header">
          <a href="index.php" class="navbar-brand">LOGO</a>
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
              <a href="registration.php">Registration</a>
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
            <h1>Welcome!</h1>
            <p class="lead">Please Enter Your Registered Email ID and Password to Login</p>
          </div>
           
		  </div>
        
		  <div class="col-lg-6"><br> 
            
            <form class="form-horizontal"  onsubmit="return verify1();" id="infoForm1" method="POST" >
  <fieldset>
     <div class="form-group">
      <label for="inputEmail" class="col-lg-2 control-label"> Email</label>
      <div class="col-lg-10">
        <input type="email" class="form-control" id="inputEmail" placeholder="Enter Email" autocomplete="off" name="lemail" oninvalid="setCustomValidity('Please enter your valid email address')" onchange="try{setCustomValidity('')}catch(e){}"  required>
      </div>
    </div>
    <div class="form-group">
      <label for="inputPassword" class="col-lg-2 control-label">Password <br></label>
      <div class="col-lg-10">
        <input type="password" class="form-control" id="inputPassword" placeholder="Enter Password" autocomplete="off" name="lpassword" oninvalid="setCustomValidity('Please enter your valid Password')" onchange="try{setCustomValidity('')}catch(e){}"  required>
      </div>
	   </div>
   <div class="form-group">
      <div class="col-lg-10 col-lg-offset-2">
        <button type="reset" class="btn btn-default">Reset</button>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		<input type="hidden" value="login" name="formtype"/>
        <button type="submit" class="btn btn-success">Login Now!</button>
		<br><br><div id="show1" style="color:red; font-weight:bold;"></div>
      </div>
    </div>
  </fieldset>
</form>
         </div>
		  
		   
			<br>    
      </div>

      

      <footer> <br><br> <br> <br> <br> <br> <br> 
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

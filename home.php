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

// FETCH USER/ADMIN PROFILE
$GetUser = "SELECT * from users where UserId=".$_SESSION['UserId']."";
$FetchUser = mysqli_query($conn,$GetUser);
$FetchUser = mysqli_fetch_array($FetchUser);


//FETCH News
$GetNews = "SELECT * from news";
$FetchNews = mysqli_query($conn,$GetNews);
$today = date("d/m/Y");
//FETCH Events
$GetEvents = "SELECT * from events WHERE EventDate >= ".$today."";
$FetchEvents = mysqli_query($conn,$GetEvents);
 
 
?><!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>Home - Faculty Management System</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <link rel="stylesheet" href="css/bootstrap.css" media="screen">
    <link rel="stylesheet" href="css/custom.min.css">
	 <script type="text/javascript" src="js/date_time.js"></script>
       <script src="js/jquery-1.10.2.min.js"></script>   

<style type="text/css">
#pscroller1{
width: 100%;
height: 200px;
border: 1px solid black;
padding: 5px;
background-color: lightyellow;
}
</style>
<script type="text/javascript">
var pausecontent=new Array()
<? 
 if(mysqli_num_rows($FetchEvents)>0){ $ii=0;
 while ($ListData=mysqli_fetch_array($FetchEvents)){ 
  if($ListData['EventDate']>=$today){
 
 ?>
pausecontent[<?=$ii;?>]='<b>&bull; <?=$ListData['EventName'];?></b><br /><i><?=$ListData['EventDate'];?></i><br><?=$ListData['EventDesc'];?>'

  <?       }
 $ii= $ii+1; }  }else{ echo 'pausecontent[0]=\'<strong>No Upcoming Events</strong><br />There are currently No Events to be happened in college. We will update it here once we get info about it.\' '; }   ?>
 </script>
<script type="text/javascript">

/***********************************************
* Pausing up-down scroller- (c) Dynamic Drive (www.dynamicdrive.com)
* Please keep this notice intact
* Visit http://www.dynamicdrive.com/ for this script and 100s more.
***********************************************/

function pausescroller(content, divId, divClass, delay){
this.content=content //message array content
this.tickerid=divId //ID of ticker div to display information
this.delay=delay //Delay between msg change, in miliseconds.
this.mouseoverBol=0 //Boolean to indicate whether mouse is currently over scroller (and pause it if it is)
this.hiddendivpointer=1 //index of message array for hidden div
document.write('<div id="'+divId+'" class="'+divClass+'" style="position: relative; overflow: hidden"><div class="innerDiv" style="position: absolute; width: 100%" id="'+divId+'1">'+content[0]+'</div><div class="innerDiv" style="position: absolute; width: 100%; visibility: hidden" id="'+divId+'2">'+content[1]+'</div></div>')
var scrollerinstance=this
if (window.addEventListener) //run onload in DOM2 browsers
window.addEventListener("load", function(){scrollerinstance.initialize()}, false)
else if (window.attachEvent) //run onload in IE5.5+
window.attachEvent("onload", function(){scrollerinstance.initialize()})
else if (document.getElementById) //if legacy DOM browsers, just start scroller after 0.5 sec
setTimeout(function(){scrollerinstance.initialize()}, 500)
}

// -------------------------------------------------------------------
// initialize()- Initialize scroller method.
// -Get div objects, set initial positions, start up down animation
// -------------------------------------------------------------------

pausescroller.prototype.initialize=function(){
this.tickerdiv=document.getElementById(this.tickerid)
this.visiblediv=document.getElementById(this.tickerid+"1")
this.hiddendiv=document.getElementById(this.tickerid+"2")
this.visibledivtop=parseInt(pausescroller.getCSSpadding(this.tickerdiv))
//set width of inner DIVs to outer DIV's width minus padding (padding assumed to be top padding x 2)
this.visiblediv.style.width=this.hiddendiv.style.width=this.tickerdiv.offsetWidth-(this.visibledivtop*2)+"px"
this.getinline(this.visiblediv, this.hiddendiv)
this.hiddendiv.style.visibility="visible"
var scrollerinstance=this
document.getElementById(this.tickerid).onmouseover=function(){scrollerinstance.mouseoverBol=1}
document.getElementById(this.tickerid).onmouseout=function(){scrollerinstance.mouseoverBol=0}
if (window.attachEvent) //Clean up loose references in IE
window.attachEvent("onunload", function(){scrollerinstance.tickerdiv.onmouseover=scrollerinstance.tickerdiv.onmouseout=null})
setTimeout(function(){scrollerinstance.animateup()}, this.delay)
}


// -------------------------------------------------------------------
// animateup()- Move the two inner divs of the scroller up and in sync
// -------------------------------------------------------------------

pausescroller.prototype.animateup=function(){
var scrollerinstance=this
if (parseInt(this.hiddendiv.style.top)>(this.visibledivtop+5)){
this.visiblediv.style.top=parseInt(this.visiblediv.style.top)-5+"px"
this.hiddendiv.style.top=parseInt(this.hiddendiv.style.top)-5+"px"
setTimeout(function(){scrollerinstance.animateup()}, 50)
}
else{
this.getinline(this.hiddendiv, this.visiblediv)
this.swapdivs()
setTimeout(function(){scrollerinstance.setmessage()}, this.delay)
}
}

// -------------------------------------------------------------------
// swapdivs()- Swap between which is the visible and which is the hidden div
// -------------------------------------------------------------------

pausescroller.prototype.swapdivs=function(){
var tempcontainer=this.visiblediv
this.visiblediv=this.hiddendiv
this.hiddendiv=tempcontainer
}

pausescroller.prototype.getinline=function(div1, div2){
div1.style.top=this.visibledivtop+"px"
div2.style.top=Math.max(div1.parentNode.offsetHeight, div1.offsetHeight)+"px"
}

// -------------------------------------------------------------------
// setmessage()- Populate the hidden div with the next message before it's visible
// -------------------------------------------------------------------

pausescroller.prototype.setmessage=function(){
var scrollerinstance=this
if (this.mouseoverBol==1) //if mouse is currently over scoller, do nothing (pause it)
setTimeout(function(){scrollerinstance.setmessage()}, 100)
else{
var i=this.hiddendivpointer
var ceiling=this.content.length
this.hiddendivpointer=(i+1>ceiling-1)? 0 : i+1
this.hiddendiv.innerHTML=this.content[this.hiddendivpointer]
this.animateup()
}
}

pausescroller.getCSSpadding=function(tickerobj){ //get CSS padding value, if any
if (tickerobj.currentStyle)
return tickerobj.currentStyle["paddingTop"]
else if (window.getComputedStyle) //if DOM2
return window.getComputedStyle(tickerobj, "").getPropertyValue("padding-top")
else
return 0
}

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
		<h3><font><b>NEWS: </b> <marquee style="width:80%" onmouseover="this.stop()" onmouseout="this.start()" >
		<?  if(mysqli_num_rows($FetchNews)>0){ $i=1;
 while ($ListData=mysqli_fetch_array($FetchNews)){ 
 ?>
 &bull; <?=$ListData['NewsDetails'];?>&nbsp;&nbsp;&nbsp;
 
 <?    $i= $i+1; }  }else{ echo " <center><strong>No News in Database to Display</strong></center>"; } mysqli_close($conn); ?>
		</marquee></font></h3>

          <div class="col-lg-8 col-md-7 col-sm-6">
            <h1>Welcome <?=$FetchUser['FullName'];?>!</h1>
            <p class="lead">F-Timesheet's Faculty Management Portal.</p>
          </div>
            <div class="col-lg-6">
		 <strong>Here You can do the following Tasks:</strong>
		 <br>&bull; Add Results and Manage it.
		 <br>&bull; Add Project Results and Manage it.
		 <br>&bull; View Time Table uploaded by Admin.
		 <br>&bull; View Subjects according to Dept., Class and Semester.
		 <br>&bull; View Teaching and Non-Teaching Staff Details.
		 <br>&bull; View Project Report uploaded by Teachers.
		 <br><br>&bull; View Online Registered Users.
		 <br>&bull; Change Password and update Profile.
		<br><br> </div>
		
		<div class="col-lg-6">
		<div class="well bs-component">
		 <legend>Event Updates:</legend>
		 
		 <script type="text/javascript">

//new pausescroller(name_of_message_array, CSS_ID, CSS_classname, pause_in_miliseconds)

new pausescroller(pausecontent, "pscroller1", "someclass", 3000)

</script>

</div></div>
		  </div>
  
		  </div>
       

      

      <footer> <br><br>  
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

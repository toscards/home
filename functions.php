<?
// ALL AJAX REQUESTS WILL BE CARRIED BY THIS FILE. 

//INCLUDED OUR CONFIG FILE WHICH HAS DATABASE CONNECTION DETAILS :P
include("config.php");


//CHECK LOGIN
if($_POST['formtype'] == "login"){
	
if($_POST['lemail'] == "" || $_POST['lemail'] == " " || $_POST['lemail'] == "  " ){
$error = "Please enter valid Email!"; echo $error; exit;
}elseif($_POST['lpassword'] == "" || $_POST['lpassword'] == " "  || $_POST['lpassword'] == "  " ){
$error = "Please enter valid Password!"; echo $error; exit;
}
$sql = "SELECT * FROM users WHERE Email='".mysqli_real_escape_string($conn,$_POST['lemail'])."' and Password='".mysqli_real_escape_string($conn,$_POST['lpassword'])."'";
$result = mysqli_query($conn,$sql);
	if (@mysqli_num_rows($result)!=0){
			$row = @mysqli_fetch_array($result);
			//$_SESSION['id']=$row['id'];
			if($row['UserStatus'] == "active"){
			$_SESSION['UserId']=$row['UserId'];
			$_SESSION['UserRole']=$row['UserRole'];
			if($row['UserRole'] == "admin")
			{
				echo "<script>window.location = 'admin/index.php';</script>";
				exit();
			}else{
				echo "<script>window.location = 'home.php';</script>";
				exit();
			}
			}else{ echo $msg = "ERROR: Your Account is Inactive. Contact Admin!";}	
	}
	else{
			echo $msg = "ERROR: Invalid Username or Password. Try Again!";
		}

}


//DO REGISTRATION
if($_POST['formtype'] == "registration"){
	 
if($_POST['lemail'] == "" || $_POST['lemail'] == " " || $_POST['lemail'] == "  " ){
$error = "ERROR: Please enter valid Email!"; echo $error; exit;
}if(!filter_var($_POST['lemail'], FILTER_VALIDATE_EMAIL) ){
$error = "ERROR: Please enter valid Email!"; echo $error; exit;
}elseif($_POST['lfname'] == "" || $_POST['lfname'] == " "  || $_POST['lfname'] == "  " ){
$error = "ERROR: Please enter valid Name!"; echo $error; exit;
}elseif($_POST['lmobile'] == "" || $_POST['lmobile'] == " "  || $_POST['lmobile'] == "  " ){
$error = "ERROR: Please enter valid Mobile!"; echo $error; exit;
}elseif(!is_numeric($_POST['lmobile'])){
$error = "ERROR: Please enter valid Mobile!"; echo $error; exit;
}elseif($_POST['lpassword'] == "" || $_POST['lpassword'] == " " ){
$error = "ERROR: Please enter New Password!"; echo $error; exit;
}elseif($_POST['lcpassword'] == "" || $_POST['lcpassword'] == " " ){
$error = "ERROR: Please Confirm New Password!"; echo $error; exit;}
elseif($_POST['stream'] == "" || $_POST['stream'] == " " ){
$error = "ERROR: Please select Depratment!"; echo $error; exit;}
elseif($_POST['lpassword'] != $_POST['lcpassword']){
$error = "ERROR: New and Confirmed Password do not match!"; echo $error; exit;}
elseif(strlen($_POST['lpassword']) <=5 ){
$error = "ERROR: New Password is too Short!"; echo $error; exit;}

$DeptIds = json_encode($_POST['stream'], true);  

$insert = "insert into users(FullName, Email, Mobile, Password, DepartmentId, UserRole, UserStatus) 
			VALUES (
			'".mysqli_real_escape_string($conn,$_POST['lfname'])."',
			'".mysqli_real_escape_string($conn,$_POST['lemail'])."',
			'".mysqli_real_escape_string($conn,$_POST['lmobile'])."',
			'".mysqli_real_escape_string($conn,$_POST['lcpassword'])."',
			'".mysqli_real_escape_string($conn,$DeptIds)."',
			'".mysqli_real_escape_string($conn,$DefaultRegistration)."',
			'".mysqli_real_escape_string($conn,$DefaultUserStatus)."')"; 
			//  print_r($insert);	
			$result = mysqli_query($conn,$insert);
			// exit;
			if($result){
		
		  $error = "User Registered Successfully!<script>document.getElementById('infoForm1').reset(); </script> "; echo $error; mysqli_close($conn); exit;}else{ $error = "ERROR: Your Email already in use or you already Registered."; echo $error; mysqli_close($conn); exit;}
 

}


// USER PASSWORD CHANGE  
if($_POST['formtype'] == "passwordupdate"){
	
if($_POST['oldpassword'] == "" || $_POST['oldpassword'] == " " ){
$error = "ERROR: Please enter old Password!"; echo $error; exit;
}elseif($_POST['newpassword'] == "" || $_POST['newpassword'] == " " ){
$error = "ERROR: Please enter New Password!"; echo $error; exit;
}elseif($_POST['confirmpassword'] == "" || $_POST['confirmpassword'] == " " ){
$error = "ERROR: Please Confirm New Password!"; echo $error; exit;}
elseif($_POST['newpassword'] != $_POST['confirmpassword']){
$error = "ERROR: New and Confirmed Password do not match!"; echo $error; exit;}
elseif(strlen($_POST['newpassword']) <=5 ){
$error = "ERROR: New Password is too Short!"; echo $error; exit;}
	
$sql = "SELECT * FROM users WHERE UserId=".$_POST['uid']." and Password='".$_POST['oldpassword']."'";
$result = mysqli_query($conn,$sql);
	if (@mysqli_num_rows($result)!=0){
			$query="update `users` set `Password` = '".mysqli_real_escape_string($conn,$_POST['confirmpassword'])."' WHERE UserId=".$_POST['uid'].";";
			$result = mysqli_query($conn,$query);
			if($result){ $error = "Password changed Successfully!"; echo $error; mysqli_close($conn); exit;}else{ $error = "ERROR: Please Try Again"; echo $error; mysqli_close($conn); exit;}
			
	}else{
$error = "ERROR: Entered old Password is Wrong!"; echo $error; mysqli_close($conn); exit;}	
}


// PROFILE UPDATE OF USER
if($_POST['formtype'] == "profileupdate"){
	
if($_POST['fullname'] == "" || $_POST['fullname'] == " " || $_POST['fullname'] == "  " ){
$error = "ERROR: Please enter Full Name!"; echo $error; exit;
}elseif($_POST['mobile'] == "" || $_POST['mobile'] == " " || $_POST['mobile'] == "  " ){
$error = "ERROR: Please enter Mobile No.!"; echo $error; exit;}
elseif(!is_numeric($_POST['mobile'])){
$error = "ERROR: Please enter valid Mobile!"; echo $error; exit;}
elseif(strlen($_POST['mobile']) != 10) {
$error = "ERROR: Please enter valid Mobile Number!"; echo $error; exit;}elseif($_POST['email'] == "" || $_POST['email'] == " " || $_POST['email'] == "  " ){
$error = "ERROR: Please enter valid Email!"; echo $error; exit;
}elseif(!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL) ){
$error = "ERROR: Please enter valid Email!"; echo $error; exit;
}elseif($_POST['stream'] == "" || $_POST['stream'] == " " ){
$error = "ERROR: Please select Depratment!"; echo $error; exit;}
 
 $DeptIds = json_encode($_POST['stream'], true);
 
			$query="update `users` set `FullName` = '".mysqli_real_escape_string($conn,$_POST['fullname'])."',`Mobile` = '".mysqli_real_escape_string($conn,$_POST['mobile'])."',`Email` = '".mysqli_real_escape_string($conn,$_POST['email'])."' ,`DepartmentId` = '".mysqli_real_escape_string($conn,$DeptIds)."'  WHERE UserId=".mysqli_real_escape_string($conn,$_POST['uid']).";";
			$result = mysqli_query($conn,$query);
			if($result){ $error = "Profile Updated Successfully!"; echo $error; mysqli_close($conn); exit;}else{ $error = "ERROR: Please Try Again."; echo $error; mysqli_close($conn); exit;}
}


// SHOW SEMESTER
if($_POST['formtype'] == "getsemfrmdept"){
	
$GetDept = "SELECT SemesterId,SemesterName from semesters WHERE DeptId=".mysqli_real_escape_string($conn,$_POST['selectdept']);
$FetchDept = mysqli_query($conn,$GetDept);
	
	$rows = array();
while($r = mysqli_fetch_assoc($FetchDept)) {
    $rows[] = $r;
}
 
 print json_encode($rows);
	
}


// ADD REPORT
if($_POST['formtype'] == "addreport"){
if($_POST['selectdept'] == "" || $_POST['selectdept'] == " " || $_POST['selectdept'] == "  " ){
$error = "ERROR: Please select Department for Time Table!"; echo $error; exit;} 
elseif($_POST['selectclass'] == "" || $_POST['selectclass'] == " " || $_POST['selectclass'] == "  " ){
$error = "ERROR: Please select Class for Time Table!"; echo $error; exit;} 
elseif($_POST['selectsemester'] == "" || $_POST['selectsemester'] == " " || $_POST['selectsemester'] == "  " ){
$error = "ERROR: Please select Semester for Time Table!"; echo $error; exit;} 
elseif($_POST['strollno'] == "" || $_POST['strollno'] == " " || $_POST['strollno'] == "  " ){
$error = "ERROR: Please add Student's Roll Number"; echo $error; exit;} 
//print_r($_FILES);
//CHECK UPLOADED FILE IS PDF AND STORE
$target_path = "reports/";	
$validextensions = array("PDF", "pdf", ".DOC", ".doc", ".DOCX", ".docx", ".JPG", ".jpg", ".JPEG", ".jpeg" );  //Extensions which are allowed
$ext = explode('.', basename($_FILES['ttfile']['name']));//explode file name from dot(.) 
$file_extension = end($ext); //store extensions in the variable
  
$fileNames = md5(uniqid()) . "." . $ext[count($ext) - 1];
$target_paths = $target_path . $fileNames;//set the target path with a new name of image  

 if (in_array($file_extension, $validextensions)) {

if(move_uploaded_file($_FILES['ttfile']['tmp_name'], $target_paths)) {//if file moved to uploads folder
               //echo 'uploaded successfully!';
				
			$insert = "insert into reports(SRollNum, ReportFileName, DeptId, SemesterId, ClassId) 
			VALUES ('".mysqli_real_escape_string($conn,$_POST['strollno'])."','".mysqli_real_escape_string($conn,$fileNames)."',".mysqli_real_escape_string($conn,$_POST['selectdept']).",".mysqli_real_escape_string($conn,$_POST['selectsemester']).",".mysqli_real_escape_string($conn,$_POST['selectclass']).")";	
			// print_r($insert);	
			$result = mysqli_query($conn,$insert);
			// exit;
			if($result){ $error = "New Report Added Successfully! <script>document.getElementById('infoForm1').reset(); </script>"; echo $error; mysqli_close($conn); exit;}else{ $error = "ERROR: Error occurred, Please Try Another."; echo $error; mysqli_close($conn); exit;}
				
            } else {//if file was not moved.
                echo 'ERROR: Error occurred, Please Try Another.'; exit;
            }

 }else {//if file size and file type was incorrect.
            echo 'Error: You have not uploaded valid File. Please try again!'; exit;
        } 
}


// REPORT UPDATE
if($_POST['formtype'] == "reportupdate"){
	
if($_POST['selectdept'] == "" || $_POST['selectdept'] == " " || $_POST['selectdept'] == "  " ){
$error = "ERROR: Please select Department for Time Table!"; echo $error; exit;} 
elseif($_POST['selectclass'] == "" || $_POST['selectclass'] == " " || $_POST['selectclass'] == "  " ){
$error = "ERROR: Please select Class for Time Table!"; echo $error; exit;} 
elseif($_POST['selectsemester'] == "" || $_POST['selectsemester'] == " " || $_POST['selectsemester'] == "  " ){
$error = "ERROR: Please select Semester for Time Table!"; echo $error; exit;} 
elseif($_POST['strollno'] == "" || $_POST['strollno'] == " " || $_POST['strollno'] == "  " ){
$error = "ERROR: Please add Student's Roll Number"; echo $error; exit;} 

if($_FILES['ttfile']['name']){
//CHECK UPLOADED FILE IS PDF AND STORE
$target_path = "reports/";	
$validextensions = array("PDF", "pdf", ".DOC", ".doc", ".DOCX", ".docx", ".JPG", ".jpg", ".JPEG", ".jpeg" );  //Extensions which are allowed
$ext = explode('.', basename($_FILES['ttfile']['name']));//explode file name from dot(.) 
$file_extension = end($ext); //store extensions in the variable
  
$fileNames = md5(uniqid()) . "." . $ext[count($ext) - 1];
$target_paths = $target_path . $fileNames;//set the target path with a new name of image  

 if (in_array($file_extension, $validextensions)) {

if(move_uploaded_file($_FILES['ttfile']['tmp_name'], $target_paths)) { 
$oldFile = $_POST['reportfilename']; unlink("".$target_path.$oldFile."");
}else{  echo 'Error: Error occurred while uploading File. Please try again!'; exit; }
	}else {//if file size and file type was incorrect.
            echo 'Error: You have not uploaded valid File. Please try again!'; exit;
        } 
} else{ $fileNames = $_POST['reportfilename'];}

			$query="update `reports` set `SRollNum` = '".mysqli_real_escape_string($conn,$_POST['strollno'])."',`ReportFileName` = '".mysqli_real_escape_string($conn,$fileNames )."',`DeptId` = ".mysqli_real_escape_string($conn,$_POST['selectdept']).",`SemesterId` = ".mysqli_real_escape_string($conn,$_POST['selectsemester']).",`ClassId` = ".mysqli_real_escape_string($conn,$_POST['selectclass'])." WHERE ReportId=".mysqli_real_escape_string($conn,$_POST['reportid']).";";
			$result = mysqli_query($conn,$query);
			if($result){ $error = "Report Details Updated Successfully!"; echo $error; mysqli_close($conn); exit;}else{ $error = "ERROR: Error Occurred, Please Try Again."; echo $error; mysqli_close($conn); exit;}
}


// ADD PROJECT
if($_POST['formtype'] == "addproject"){
if($_POST['selectdept'] == "" || $_POST['selectdept'] == " " || $_POST['selectdept'] == "  " ){
$error = "ERROR: Please select Department for Time Table!"; echo $error; exit;} 
elseif($_POST['selectclass'] == "" || $_POST['selectclass'] == " " || $_POST['selectclass'] == "  " ){
$error = "ERROR: Please select Class for Time Table!"; echo $error; exit;} 
elseif($_POST['selectsemester'] == "" || $_POST['selectsemester'] == " " || $_POST['selectsemester'] == "  " ){
$error = "ERROR: Please select Semester for Time Table!"; echo $error; exit;} 
elseif($_POST['projecttitle'] == "" || $_POST['projecttitle'] == " " || $_POST['projecttitle'] == "  " ){
$error = "ERROR: Please add Title for Project"; echo $error; exit;} 
//print_r($_FILES);
//CHECK UPLOADED FILE IS PDF AND STORE
$target_path = "projects/";	
$validextensions = array("PDF", "pdf", ".DOC", ".doc", ".DOCX", ".docx", ".JPG", ".jpg", ".JPEG", ".jpeg" );  //Extensions which are allowed
$ext = explode('.', basename($_FILES['ttfile']['name']));//explode file name from dot(.) 
$file_extension = end($ext); //store extensions in the variable
  
$fileNames = md5(uniqid()) . "." . $ext[count($ext) - 1];
$target_paths = $target_path . $fileNames;//set the target path with a new name of image  

 if (in_array($file_extension, $validextensions)) {

if(move_uploaded_file($_FILES['ttfile']['tmp_name'], $target_paths)) {//if file moved to uploads folder
               //echo 'uploaded successfully!';
				
			$insert = "insert into projects(ProjectTitle, ProjectFileName, DeptId, SemesterId, ClassId) 
			VALUES ('".mysqli_real_escape_string($conn,$_POST['projecttitle'])."','".mysqli_real_escape_string($conn,$fileNames)."',".mysqli_real_escape_string($conn,$_POST['selectdept']).",".mysqli_real_escape_string($conn,$_POST['selectsemester']).",".mysqli_real_escape_string($conn,$_POST['selectclass']).")";	
			// print_r($insert);	
			$result = mysqli_query($conn,$insert);
			// exit;
			if($result){ $error = "New Project Added Successfully! <script>document.getElementById('infoForm1').reset(); </script>"; echo $error; mysqli_close($conn); exit;}else{ $error = "ERROR: Error occurred, Please Try Another."; echo $error; mysqli_close($conn); exit;}
				
            } else {//if file was not moved.
                echo 'ERROR: Error occurred, Please Try Another.'; exit;
            }

 }else {//if file size and file type was incorrect.
            echo 'Error: You have not uploaded valid File. Please try again!'; exit;
        } 
}


// REPORT UPDATE
if($_POST['formtype'] == "projectupdate"){
	
if($_POST['selectdept'] == "" || $_POST['selectdept'] == " " || $_POST['selectdept'] == "  " ){
$error = "ERROR: Please select Department for Time Table!"; echo $error; exit;} 
elseif($_POST['selectclass'] == "" || $_POST['selectclass'] == " " || $_POST['selectclass'] == "  " ){
$error = "ERROR: Please select Class for Time Table!"; echo $error; exit;} 
elseif($_POST['selectsemester'] == "" || $_POST['selectsemester'] == " " || $_POST['selectsemester'] == "  " ){
$error = "ERROR: Please select Semester for Time Table!"; echo $error; exit;} 
elseif($_POST['projecttitle'] == "" || $_POST['projecttitle'] == " " || $_POST['projecttitle'] == "  " ){
$error = "ERROR: Please add Title for Project"; echo $error; exit;} 

if($_FILES['ttfile']['name']){
//CHECK UPLOADED FILE IS PDF AND STORE
$target_path = "projects/";	
$validextensions = array("PDF", "pdf", ".DOC", ".doc", ".DOCX", ".docx", ".JPG", ".jpg", ".JPEG", ".jpeg" );   //Extensions which are allowed
$ext = explode('.', basename($_FILES['ttfile']['name']));//explode file name from dot(.) 
$file_extension = end($ext); //store extensions in the variable
  
$fileNames = md5(uniqid()) . "." . $ext[count($ext) - 1];
$target_paths = $target_path . $fileNames;//set the target path with a new name of image  

 if (in_array($file_extension, $validextensions)) {

if(move_uploaded_file($_FILES['ttfile']['tmp_name'], $target_paths)) { 
$oldFile = $_POST['projectfilename']; unlink("".$target_path.$oldFile."");
}else{  echo 'Error: Error occurred while uploading File. Please try again!'; exit; }
	}else {//if file size and file type was incorrect.
            echo 'Error: You have not uploaded valid File. Please try again!'; exit;
        } 
} else{ $fileNames = $_POST['projectfilename'];}

			$query="update `projects` set `ProjectTitle` = '".mysqli_real_escape_string($conn,$_POST['projecttitle'])."',`ProjectFileName` = '".mysqli_real_escape_string($conn,$fileNames )."',`DeptId` = ".mysqli_real_escape_string($conn,$_POST['selectdept']).",`SemesterId` = ".mysqli_real_escape_string($conn,$_POST['selectsemester']).",`ClassId` = ".mysqli_real_escape_string($conn,$_POST['selectclass'])." WHERE ProjectId=".mysqli_real_escape_string($conn,$_POST['projectid']).";";
			$result = mysqli_query($conn,$query);
			if($result){ $error = "Project Details Updated Successfully!"; echo $error; mysqli_close($conn); exit;}else{ $error = "ERROR: Error Occurred, Please Try Again."; echo $error; mysqli_close($conn); exit;}
}


// SHOW SEMESTER AND CLASS
if($_POST['formtype'] == "getsemclassfrmdept"){
	
$GetClass = "SELECT ClassId,ClassInitials from classes WHERE DeptId=".mysqli_real_escape_string($conn,$_POST['selectdept']);
$FetchClass = mysqli_query($conn,$GetClass);
$ClassRows = array();
while($r = mysqli_fetch_assoc($FetchClass)) {  $ClassRows[] = $r; }
 print json_encode($ClassRows);
}


// SHOW SUBJECTS ACCORDING TO DEPT / SEM SELECTIOn
if($_POST['formtype'] == "showsubjects"){
if($_POST['selectdept'] == "" || $_POST['selectdept'] == " " || $_POST['selectdept'] == "  " ){
$error = "ERROR: Please select Depratment!"; echo $error; exit;
}elseif($_POST['selectsemester'] == "" || $_POST['selectsemester'] == " " || $_POST['selectsemester'] == "  " ){
$error = "ERROR: Please select Semester!"; echo $error; exit;}	
	
	
	 $sql=" SELECT * from subjects WHERE DeptId=".$_POST['selectdept']." AND SemesterId=".$_POST['selectsemester']." ORDER BY SubjectName ASC";
			//print_r($sql);
			 $result = mysqli_query($conn,$sql);
			if(mysqli_num_rows($result)>0){ $i=1;
?>
  <table class="table table-striped table-hover " border="1">
  <thead>
    <tr class="info">
      <th > </th>
      <th >SUBJECT</th>
     <th >VIEW SYLLABUS</th>
    </tr>
  </thead>
  <tbody>
  <? 
 while ($ListData=mysqli_fetch_array($result)){ 
 ?>
  <tr>
      <td>&nbsp;<?=$i;?></td>
      <td><?=$ListData['SubjectName'];?></td>
      <td><a href="subjects/<?=$ListData['SubjectUploadFileName'];?>" target="_blank">Click to view Syllabus Details</a></td>
    </tr>

<?    $i= $i+1; }  
 echo "</tbody></table>";
}else{ echo "<center><font color='blue'><b>NO RESULTS FOUND !</b></font>!</center></td></tr>"; } mysqli_close($conn); 
}


// SHOW TIME TABLE ACCORDING TO DEPT / SEM / CLASS SELECTION
if($_POST['formtype'] == "showtimetable"){
if($_POST['selectdept'] == "" || $_POST['selectdept'] == " " || $_POST['selectdept'] == "  " ){
$error = "ERROR: Please select Depratment!"; echo $error; exit;
}elseif($_POST['selectsemester'] == "" || $_POST['selectsemester'] == " " || $_POST['selectsemester'] == "  " ){
$error = "ERROR: Please select Semester!"; echo $error; exit;}	
elseif($_POST['selectclass'] == "" || $_POST['selectclass'] == " " || $_POST['selectclass'] == "  " ){
$error = "ERROR: Please select Class!"; echo $error; exit;}	
	
	
	 $sql=" SELECT * from timetables WHERE DeptId=".$_POST['selectdept']." AND SemesterId=".$_POST['selectsemester']." AND ClassId=".$_POST['selectclass']." ORDER BY TimetableId ASC";
			//print_r($sql);
			 $result = mysqli_query($conn,$sql);
			if(mysqli_num_rows($result)>0){ $i=1;
?>
  <table class="table table-striped table-hover " border="1">
  <thead>
    <tr class="info">
      <th > </th>
      <th >VIEW TIME-TABLE</th>
     <th >NOTE</th>
    </tr>
  </thead>
  <tbody>
  <? 
 while ($ListData=mysqli_fetch_array($result)){ 
 ?>
  <tr>
      <td>&nbsp;<?=$i;?></td>
      <td><a href="timetable/<?=$ListData['TimetableFileName'];?>" target="_blank">Click to view Time Table</a></td>
	  <td><?=$ListData['TimetableNote'];?></td>
     
    </tr>

<?    $i= $i+1; }  
 echo "</tbody></table>";
}else{ echo "<center><font color='blue'><b>NO RESULTS FOUND !</b></font>!</center></td></tr>"; } mysqli_close($conn); 
}


 
?>
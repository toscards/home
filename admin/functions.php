<?
// ALL AJAX REQUESTS WILL BE CARRIED BY THIS FILE FOR ADMIN. 

//INCLUDED OUR CONFIG FILE WHICH HAS DATABASE CONNECTION DETAILS :P
include("../config.php");


// ADMIN PASSWORD CHANGE  
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


// ADMIN PROFILE UPDATE
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
}
 
			$query="update `users` set `FullName` = '".mysqli_real_escape_string($conn,$_POST['fullname'])."',`Mobile` = '".mysqli_real_escape_string($conn,$_POST['mobile'])."',`Email` = '".mysqli_real_escape_string($conn,$_POST['email'])."'  WHERE UserId=".mysqli_real_escape_string($conn,$_POST['uid']).";";
			$result = mysqli_query($conn,$query);
			if($result){ $error = "Profile Updated Successfully!"; echo $error; mysqli_close($conn); exit;}else{ $error = "ERROR: Please Try Again."; echo $error; mysqli_close($conn); exit;}
}


// ADD NEW DEPARTMENT
if($_POST['formtype'] == "departmentadd"){
	
if($_POST['deptinitials'] == "" || $_POST['deptinitials'] == " " || $_POST['deptinitials'] == "  " ){
$error = "ERROR: Please enter valid Dept. Initials!"; echo $error; exit;
}elseif($_POST['deptfullname'] == "" || $_POST['deptfullname'] == " " || $_POST['deptfullname'] == "  " ){
$error = "ERROR: Please enter valid Dept. Full Name!"; echo $error; exit;}
 

$insert = "insert into departments(DeptInitials, DeptFullName) 
			VALUES (
			'".mysqli_real_escape_string($conn,$_POST['deptinitials'])."',
			'".mysqli_real_escape_string($conn,$_POST['deptfullname'])."')";	
			 
			// print_r($insert);	
			$result = mysqli_query($conn,$insert);
			// exit;
			if($result){ $error = "New Department Added Successfully! <script>document.getElementById('infoForm1').reset(); </script>"; echo $error; mysqli_close($conn); exit;}else{ $error = "ERROR: Department Initials with same Name already Exists, Please Try Another."; echo $error; mysqli_close($conn); exit;}

}


// UPDATE DEPARTMENT
if($_POST['formtype'] == "departmentupdate"){
	
if($_POST['deptinitials'] == "" || $_POST['deptinitials'] == " " || $_POST['deptinitials'] == "  " ){
$error = "ERROR: Please enter valid Dept. Initials!"; echo $error; exit;
}elseif($_POST['deptfullname'] == "" || $_POST['deptfullname'] == " " || $_POST['deptfullname'] == "  " ){
$error = "ERROR: Please enter valid Dept. Full Name!"; echo $error; exit;}
 

			$query="update `departments` set `DeptInitials` = '".mysqli_real_escape_string($conn,$_POST['deptinitials'])."',`DeptFullName` = '".mysqli_real_escape_string($conn,$_POST['deptfullname'])."' WHERE DeptId=".mysqli_real_escape_string($conn,$_POST['deptid']).";";
			$result = mysqli_query($conn,$query);
			if($result){ $error = "Department Updated Successfully!"; echo $error; mysqli_close($conn); exit;}else{ $error = "ERROR: Dept. Initials with same Name already Exists, Please Try Another."; echo $error; mysqli_close($conn); exit;}
}


// ADD NEW CLASS
if($_POST['formtype'] == "classadd"){
	//print_r($_POST);
if($_POST['classinitials'] == "" || $_POST['classinitials'] == " " || $_POST['classinitials'] == "  " ){
$error = "ERROR: Please enter Class Initials!"; echo $error; exit;
}elseif($_POST['classfullname'] == "" || $_POST['classfullname'] == " " || $_POST['classfullname'] == "  " ){
$error = "ERROR: Please enter Class Full Name!"; echo $error; exit;}
elseif($_POST['classstrength'] == "" || $_POST['classstrength'] == " " || $_POST['classstrength'] == "  " ){
$error = "ERROR: Please enter Class Strength in Numeric!"; echo $error; exit;}
elseif(!is_numeric($_POST['classstrength'])){
$error = "ERROR: Please enter Class Strength in Numeric!"; echo $error; exit;
}elseif($_POST['selectdept'] == "" || $_POST['selectdept'] == " " || $_POST['selectdept'] == "  " ){
$error = "ERROR: Please select Department for this Class!"; echo $error; exit;}

$insert = "insert into classes(ClassInitials, ClassFullName, ClassStrength, DeptId) 
			VALUES (
			'".mysqli_real_escape_string($conn,$_POST['classinitials'])."',
			'".mysqli_real_escape_string($conn,$_POST['classfullname'])."',
			".mysqli_real_escape_string($conn,$_POST['classstrength']).",	
			".mysqli_real_escape_string($conn,$_POST['selectdept']).")";	
			// print_r($insert);	
			$result = mysqli_query($conn,$insert);
			// exit;
			if($result){ $error = "New Class Added Successfully! <script>document.getElementById('infoForm1').reset(); </script>"; echo $error; mysqli_close($conn); exit;}else{ $error = "ERROR: Class Initials with same Name already Exists, Please Try Another."; echo $error; mysqli_close($conn); exit;}

}


// UPDATE CLASS
if($_POST['formtype'] == "classupdate"){
	
if($_POST['classinitials'] == "" || $_POST['classinitials'] == " " || $_POST['classinitials'] == "  " ){
$error = "ERROR: Please enter Class Initials!"; echo $error; exit;
}elseif($_POST['classfullname'] == "" || $_POST['classfullname'] == " " || $_POST['classfullname'] == "  " ){
$error = "ERROR: Please enter Class Full Name!"; echo $error; exit;}
elseif($_POST['classstrength'] == "" || $_POST['classstrength'] == " " || $_POST['classstrength'] == "  " ){
$error = "ERROR: Please enter Class Strength in Numeric!"; echo $error; exit;}
elseif(!is_numeric($_POST['classstrength'])){
$error = "ERROR: Please enter Class Strength in Numeric!"; echo $error; exit;
}
elseif($_POST['selectdept'] == "" || $_POST['selectdept'] == " " || $_POST['selectdept'] == "  " ){
$error = "ERROR: Please select Department for this Class!"; echo $error; exit;}

			$query="update `classes` set `ClassInitials` = '".mysqli_real_escape_string($conn,$_POST['classinitials'])."',`ClassFullName` = '".mysqli_real_escape_string($conn,$_POST['classfullname'])."',`ClassStrength` = ".mysqli_real_escape_string($conn,$_POST['classstrength']).",`DeptId` = ".mysqli_real_escape_string($conn,$_POST['selectdept'])." WHERE ClassId=".mysqli_real_escape_string($conn,$_POST['classid']).";";
			$result = mysqli_query($conn,$query);
			if($result){ $error = "Class Updated Successfully!"; echo $error; mysqli_close($conn); exit;}else{ $error = "ERROR: Class Initials with same Name already Exists, Please Try Another."; echo $error; mysqli_close($conn); exit;}
}


// ADD NEW SEMESTER
if($_POST['formtype'] == "semesteradd"){
	
if($_POST['semestername'] == "" || $_POST['semestername'] == " " || $_POST['semestername'] == "  " ){
$error = "ERROR: Please enter Semester Name!"; echo $error; exit;
}elseif($_POST['selectdept'] == "" || $_POST['selectdept'] == " " || $_POST['selectdept'] == "  " ){
$error = "ERROR: Please select Department for this Class!"; echo $error; exit;}
$insert = "insert into semesters(SemesterName, DeptId) 
			VALUES ('".mysqli_real_escape_string($conn,$_POST['semestername'])."',".mysqli_real_escape_string($conn,$_POST['selectdept']).")";	
			// print_r($insert);	
			$result = mysqli_query($conn,$insert);
			// exit;
			if($result){ $error = "New Semester Added Successfully! <script>document.getElementById('infoForm1').reset(); </script>"; echo $error; mysqli_close($conn); exit;}else{ $error = "ERROR: Semester with same Name already Exists, Please Try Another."; echo $error; mysqli_close($conn); exit;}

}


// UPDATE SEMESTER
if($_POST['formtype'] == "semesterupdate"){
	
if($_POST['semestername'] == "" || $_POST['semestername'] == " " || $_POST['semestername'] == "  " ){
$error = "ERROR: Please enter Semester Name!"; echo $error; exit;} 

			$query="update `semesters` set `SemesterName` = '".mysqli_real_escape_string($conn,$_POST['semestername'])."' WHERE SemesterId=".mysqli_real_escape_string($conn,$_POST['semesterid']).";";
			$result = mysqli_query($conn,$query);
			if($result){ $error = "Semester Updated Successfully!"; echo $error; mysqli_close($conn); exit;}else{ $error = "ERROR: Semester with same Name already Exists, Please Try Another."; echo $error; mysqli_close($conn); exit;}
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


// ADD SUBJECT
if($_POST['formtype'] == "subjectadd"){
if($_POST['selectdept'] == "" || $_POST['selectdept'] == " " || $_POST['selectdept'] == "  " ){
$error = "ERROR: Please select Department for Subject!"; echo $error; exit;} 
elseif($_POST['selectsemester'] == "" || $_POST['selectsemester'] == " " || $_POST['selectsemester'] == "  " ){
$error = "ERROR: Please select Semester for Subject!"; echo $error; exit;} 
elseif($_POST['subjectname'] == "" || $_POST['subjectname'] == " " || $_POST['subjectname'] == "  " ){
$error = "ERROR: Please Subject Name!"; echo $error; exit;} 
//print_r($_FILES);
//CHECK UPLOADED FILE IS PDF AND STORE
$target_path = "../subjects/";	
$validextensions = array("PDF", "pdf" );  //Extensions which are allowed
$ext = explode('.', basename($_FILES['subjectfile']['name']));//explode file name from dot(.) 
$file_extension = end($ext); //store extensions in the variable
  
$fileNames = md5(uniqid()) . "." . $ext[count($ext) - 1];
$target_paths = $target_path . $fileNames;//set the target path with a new name of image  

 if (in_array($file_extension, $validextensions)) {

if(move_uploaded_file($_FILES['subjectfile']['tmp_name'], $target_paths)) {//if file moved to uploads folder
               //echo 'uploaded successfully!';
				
			$insert = "insert into subjects(SubjectName, SubjectUploadFileName, DeptId, SemesterId) 
			VALUES ('".mysqli_real_escape_string($conn,$_POST['subjectname'])."','".mysqli_real_escape_string($conn,$fileNames)."',".mysqli_real_escape_string($conn,$_POST['selectdept']).",".mysqli_real_escape_string($conn,$_POST['selectsemester']).")";	
			// print_r($insert);	
			$result = mysqli_query($conn,$insert);
			// exit;
			if($result){ $error = "New Subject Added Successfully! <script>document.getElementById('infoForm1').reset(); </script>"; echo $error; mysqli_close($conn); exit;}else{ $error = "ERROR: Error occurred, Please Try Another."; echo $error; mysqli_close($conn); exit;}
				
            } else {//if file was not moved.
                echo 'ERROR: Error occurred, Please Try Another.'; exit;
            }

 }else {//if file size and file type was incorrect.
            echo 'Error: You have not uploaded valid File. Please try again!'; exit;
        } 
}


// SUBJECT UPDATE
if($_POST['formtype'] == "subjectupdate"){
	
if($_POST['selectdept'] == "" || $_POST['selectdept'] == " " || $_POST['selectdept'] == "  " ){
$error = "ERROR: Please select Department for Subject!"; echo $error; exit;} 
elseif($_POST['selectsemester'] == "" || $_POST['selectsemester'] == " " || $_POST['selectsemester'] == "  " ){
$error = "ERROR: Please select Semester for Subject!"; echo $error; exit;} 
elseif($_POST['subjectname'] == "" || $_POST['subjectname'] == " " || $_POST['subjectname'] == "  " ){
$error = "ERROR: Please Subject Name!"; echo $error; exit;}

if($_FILES['subjectfile']['name']){
	//CHECK UPLOADED FILE IS PDF AND STORE
$target_path = "../subjects/";	
$validextensions = array("PDF", "pdf" );  //Extensions which are allowed
$ext = explode('.', basename($_FILES['subjectfile']['name']));//explode file name from dot(.) 
$file_extension = end($ext); //store extensions in the variable
  
$fileNames = md5(uniqid()) . "." . $ext[count($ext) - 1];
$target_paths = $target_path . $fileNames;//set the target path with a new name of image  

 if (in_array($file_extension, $validextensions)) {

if(move_uploaded_file($_FILES['subjectfile']['tmp_name'], $target_paths)) { 
$oldFile = $_POST['subjectfilename']; unlink("".$target_path.$oldFile."");
}else{  echo 'Error: Error occurred while uploading File. Please try again!'; exit; }
	}else {//if file size and file type was incorrect.
            echo 'Error: You have not uploaded valid File. Please try again!'; exit;
        } 
} else{ $fileNames = $_POST['subjectfilename'];}

			$query="update `subjects` set `SubjectName` = '".mysqli_real_escape_string($conn,$_POST['subjectname'])."',`SubjectUploadFileName` = '".mysqli_real_escape_string($conn,$fileNames )."',`DeptId` = ".mysqli_real_escape_string($conn,$_POST['selectdept']).",`SemesterId` = ".mysqli_real_escape_string($conn,$_POST['selectsemester'])." WHERE SubjectId=".mysqli_real_escape_string($conn,$_POST['subjectid']).";";
			$result = mysqli_query($conn,$query);
			if($result){ $error = "Semester Updated Successfully!"; echo $error; mysqli_close($conn); exit;}else{ $error = "ERROR: Error Occurred, Please Try Again."; echo $error; mysqli_close($conn); exit;}
}


// SHOW SEMESTER AND CLASS
if($_POST['formtype'] == "getsemclassfrmdept"){
	
$GetClass = "SELECT ClassId,ClassInitials from classes WHERE DeptId=".mysqli_real_escape_string($conn,$_POST['selectdept']);
$FetchClass = mysqli_query($conn,$GetClass);
$ClassRows = array();
while($r = mysqli_fetch_assoc($FetchClass)) {  $ClassRows[] = $r; }
 
 print json_encode($ClassRows);
 
}


// ADD TIME TABLE
if($_POST['formtype'] == "timetableadd"){
if($_POST['selectdept'] == "" || $_POST['selectdept'] == " " || $_POST['selectdept'] == "  " ){
$error = "ERROR: Please select Department for Time Table!"; echo $error; exit;} 
elseif($_POST['selectclass'] == "" || $_POST['selectclass'] == " " || $_POST['selectclass'] == "  " ){
$error = "ERROR: Please select Class for Time Table!"; echo $error; exit;} 
elseif($_POST['selectsemester'] == "" || $_POST['selectsemester'] == " " || $_POST['selectsemester'] == "  " ){
$error = "ERROR: Please select Semester for Time Table!"; echo $error; exit;} 
elseif($_POST['ttnote'] == "" || $_POST['ttnote'] == " " || $_POST['ttnote'] == "  " ){
$error = "ERROR: Add Note for Time Table, If No Note Enter text as: No Note!"; echo $error; exit;} 
//print_r($_FILES);
//CHECK UPLOADED FILE IS PDF AND STORE
$target_path = "../timetable/";	
$validextensions = array("PDF", "pdf" );  //Extensions which are allowed
$ext = explode('.', basename($_FILES['ttfile']['name']));//explode file name from dot(.) 
$file_extension = end($ext); //store extensions in the variable
  
$fileNames = md5(uniqid()) . "." . $ext[count($ext) - 1];
$target_paths = $target_path . $fileNames;//set the target path with a new name of image  

 if (in_array($file_extension, $validextensions)) {

if(move_uploaded_file($_FILES['ttfile']['tmp_name'], $target_paths)) {//if file moved to uploads folder
               //echo 'uploaded successfully!';
				
			$insert = "insert into timetables(TimetableNote, TimetableFileName, DeptId, SemesterId, ClassId) 
			VALUES ('".mysqli_real_escape_string($conn,$_POST['ttnote'])."','".mysqli_real_escape_string($conn,$fileNames)."',".mysqli_real_escape_string($conn,$_POST['selectdept']).",".mysqli_real_escape_string($conn,$_POST['selectsemester']).",".mysqli_real_escape_string($conn,$_POST['selectclass']).")";	
			// print_r($insert);	
			$result = mysqli_query($conn,$insert);
			// exit;
			if($result){ $error = "New Time Table Added Successfully! <script>document.getElementById('infoForm1').reset(); </script>"; echo $error; mysqli_close($conn); exit;}else{ $error = "ERROR: Error occurred, Please Try Another."; echo $error; mysqli_close($conn); exit;}
				
            } else {//if file was not moved.
                echo 'ERROR: Error occurred, Please Try Another.'; exit;
            }

 }else {//if file size and file type was incorrect.
            echo 'Error: You have not uploaded valid File. Please try again!'; exit;
        } 
}


// TIME TABLE UPDATE
if($_POST['formtype'] == "timetableupdate"){
	
if($_POST['selectdept'] == "" || $_POST['selectdept'] == " " || $_POST['selectdept'] == "  " ){
$error = "ERROR: Please select Department for Time Table!"; echo $error; exit;} 
elseif($_POST['selectclass'] == "" || $_POST['selectclass'] == " " || $_POST['selectclass'] == "  " ){
$error = "ERROR: Please select Class for Time Table!"; echo $error; exit;} 
elseif($_POST['selectsemester'] == "" || $_POST['selectsemester'] == " " || $_POST['selectsemester'] == "  " ){
$error = "ERROR: Please select Semester for Time Table!"; echo $error; exit;} 
elseif($_POST['ttnote'] == "" || $_POST['ttnote'] == " " || $_POST['ttnote'] == "  " ){
$error = "ERROR: Add Note for Time Table, If No Note Enter text as: No Note!"; echo $error; exit;} 

if($_FILES['timetablefile']['name']){
//CHECK UPLOADED FILE IS PDF AND STORE
$target_path = "../timetable/";	
$validextensions = array("PDF", "pdf" );  //Extensions which are allowed
$ext = explode('.', basename($_FILES['timetablefile']['name']));//explode file name from dot(.) 
$file_extension = end($ext); //store extensions in the variable
  
$fileNames = md5(uniqid()) . "." . $ext[count($ext) - 1];
$target_paths = $target_path . $fileNames;//set the target path with a new name of image  

 if (in_array($file_extension, $validextensions)) {

if(move_uploaded_file($_FILES['timetablefile']['tmp_name'], $target_paths)) { 
$oldFile = $_POST['timetablefilename']; unlink("".$target_path.$oldFile."");
}else{  echo 'Error: Error occurred while uploading File. Please try again!'; exit; }
	}else {//if file size and file type was incorrect.
            echo 'Error: You have not uploaded valid File. Please try again!'; exit;
        } 
} else{ $fileNames = $_POST['timetablefilename'];}

			$query="update `timetables` set `TimetableNote` = '".mysqli_real_escape_string($conn,$_POST['ttnote'])."',`TimetableFileName` = '".mysqli_real_escape_string($conn,$fileNames )."',`DeptId` = ".mysqli_real_escape_string($conn,$_POST['selectdept']).",`SemesterId` = ".mysqli_real_escape_string($conn,$_POST['selectsemester']).",`ClassId` = ".mysqli_real_escape_string($conn,$_POST['selectclass'])." WHERE TimetableId=".mysqli_real_escape_string($conn,$_POST['timetableid']).";";
			$result = mysqli_query($conn,$query);
			if($result){ $error = "Time Table Updated Successfully!"; echo $error; mysqli_close($conn); exit;}else{ $error = "ERROR: Error Occurred, Please Try Again."; echo $error; mysqli_close($conn); exit;}
}


// ADD NEW NEWS
if($_POST['formtype'] == "addnews"){
	
if($_POST['NewsDetails'] == "" || $_POST['NewsDetails'] == " " || $_POST['NewsDetails'] == "  " ){
$error = "ERROR: Please enter some News!"; echo $error; exit;} 
$insert = "insert into news(NewsDetails) 
			VALUES ('".mysqli_real_escape_string($conn,$_POST['NewsDetails'])."')";		
			 
			// print_r($insert);	
			$result = mysqli_query($conn,$insert);
			// exit;
			if($result){ $error = "New News Added Successfully! <script>window.location.reload(true); </script>"; echo $error; mysqli_close($conn); exit;}else{ $error = "ERROR: Please Try Another."; echo $error; mysqli_close($conn); exit;}

}


// ADD NEW EVENT
if($_POST['formtype'] == "addevent"){
	
if($_POST['EventName'] == "" || $_POST['EventName'] == " " || $_POST['EventName'] == "  " ){
$error = "ERROR: Please enter Event Name!"; echo $error; exit;}
elseif($_POST['EventDesc'] == "" || $_POST['EventDesc'] == " " || $_POST['EventDesc'] == "  " ){
$error = "ERROR: Please enter Event Description!"; echo $error; exit;}
elseif($_POST['EventDate'] == "" || $_POST['EventDate'] == " " || $_POST['EventDate'] == "  " ){
$error = "ERROR: Please enter Event Date!"; echo $error; exit;}

 
$insert = "insert into events(EventName, EventDesc, EventDate) 
			VALUES ('".mysqli_real_escape_string($conn,$_POST['EventName'])."','".mysqli_real_escape_string($conn,$_POST['EventDesc'])."','".mysqli_real_escape_string($conn,$_POST['EventDate'])."')";		
			 
			// print_r($insert);	
			$result = mysqli_query($conn,$insert);
			// exit;
			if($result){ $error = "New Event Added Successfully! <script>window.location.reload(true); </script>"; echo $error; mysqli_close($conn); exit;}else{ $error = "ERROR: Please Try Another."; echo $error; mysqli_close($conn); exit;}

}


// UPDATE EVENT
if($_POST['formtype'] == "updateevent"){
	
if($_POST['EventName'] == "" || $_POST['EventName'] == " " || $_POST['EventName'] == "  " ){
$error = "ERROR: Please enter Event Name!"; echo $error; exit;}
elseif($_POST['EventDesc'] == "" || $_POST['EventDesc'] == " " || $_POST['EventDesc'] == "  " ){
$error = "ERROR: Please enter Event Description!"; echo $error; exit;}
elseif($_POST['EventDate'] == "" || $_POST['EventDate'] == " " || $_POST['EventDate'] == "  " ){
$error = "ERROR: Please enter Event Date!"; echo $error; exit;}

			$query="update `events` set `EventName` = '".mysqli_real_escape_string($conn,$_POST['EventName'])."',`EventDesc` = '".mysqli_real_escape_string($conn,$_POST['EventDesc'])."',`EventDate` = '".mysqli_real_escape_string($conn,$_POST['EventDate'])."' WHERE EventId=".mysqli_real_escape_string($conn,$_POST['eventid']).";";
			$result = mysqli_query($conn,$query);
			if($result){ $error = "Event Updated Successfully!"; echo $error; mysqli_close($conn); exit;}else{ $error = "ERROR: Please Try Another."; echo $error; mysqli_close($conn); exit;}
}


// ADD NEW Staff
if($_POST['formtype'] == "addstaff"){
	
if($_POST['StaffName'] == "" || $_POST['StaffName'] == " " || $_POST['StaffName'] == "  " ){
$error = "ERROR: Please enter Staff Name!"; echo $error; exit;}
elseif($_POST['staffcategory'] == "" || $_POST['staffcategory'] == " " || $_POST['staffcategory'] == "  " ){
$error = "ERROR: Please select Staff Category!"; echo $error; exit;}
elseif($_POST['StaffMobile'] == "" || $_POST['StaffMobile'] == " " || $_POST['StaffMobile'] == "  " ){
$error = "ERROR: Please enter Mobile Number!"; echo $error; exit;}
elseif(!is_numeric($_POST['StaffMobile'])){
$error = "ERROR: Please enter Mobile Number in Numeric!"; echo $error; exit;}
elseif(strlen($_POST['StaffMobile']) != 10) {
$error = "ERROR: Please enter valid Mobile Number!"; echo $error; exit;}
elseif($_POST['StaffEmail'] == "" || $_POST['StaffEmail'] == " " || $_POST['StaffEmail'] == "  " ){
$error = "ERROR: Please enter Staff's Email!"; echo $error; exit;}
elseif(!filter_var($_POST['StaffEmail'], FILTER_VALIDATE_EMAIL) ){
$error = "ERROR: Please enter valid Email!"; echo $error; exit;
}

 
$insert = "insert into staffdetails(StaffName, StaffCategory, StaffMobile, StaffEmail) 
			VALUES ('".mysqli_real_escape_string($conn,$_POST['StaffName'])."','".mysqli_real_escape_string($conn,$_POST['staffcategory'])."','".mysqli_real_escape_string($conn,$_POST['StaffMobile'])."','".mysqli_real_escape_string($conn,$_POST['StaffEmail'])."')";		
			 
			// print_r($insert);	
			$result = mysqli_query($conn,$insert);
			// exit;
			if($result){ $error = "New Staff Details Added Successfully! <script>window.location.reload(true); </script>"; echo $error; mysqli_close($conn); exit;}else{ $error = "ERROR: Please Try Another."; echo $error; mysqli_close($conn); exit;}

}


// UPDATE STAFF
if($_POST['formtype'] == "updatestaff"){
	
if($_POST['StaffName'] == "" || $_POST['StaffName'] == " " || $_POST['StaffName'] == "  " ){
$error = "ERROR: Please enter Staff Name!"; echo $error; exit;}
elseif($_POST['staffcategory'] == "" || $_POST['staffcategory'] == " " || $_POST['staffcategory'] == "  " ){
$error = "ERROR: Please select Staff Category!"; echo $error; exit;}
elseif($_POST['StaffMobile'] == "" || $_POST['StaffMobile'] == " " || $_POST['StaffMobile'] == "  " ){
$error = "ERROR: Please enter Mobile Number!"; echo $error; exit;}
elseif(!is_numeric($_POST['StaffMobile'])){
$error = "ERROR: Please enter Mobile Number in Numeric!"; echo $error; exit;}
elseif(strlen($_POST['StaffMobile']) != 10) {
$error = "ERROR: Please enter valid Mobile Number!"; echo $error; exit;}
elseif($_POST['StaffEmail'] == "" || $_POST['StaffEmail'] == " " || $_POST['StaffEmail'] == "  " ){
$error = "ERROR: Please enter Staff's Email!"; echo $error; exit;}
elseif(!filter_var($_POST['StaffEmail'], FILTER_VALIDATE_EMAIL) ){
$error = "ERROR: Please enter valid Email!"; echo $error; exit;
}
			$query="update `staffdetails` set `StaffName` = '".mysqli_real_escape_string($conn,$_POST['StaffName'])."',`StaffCategory` = '".mysqli_real_escape_string($conn,$_POST['staffcategory'])."',`StaffMobile` = '".mysqli_real_escape_string($conn,$_POST['StaffMobile'])."',`StaffEmail` = '".mysqli_real_escape_string($conn,$_POST['StaffEmail'])."' WHERE StaffId=".mysqli_real_escape_string($conn,$_POST['staffid']).";";
			$result = mysqli_query($conn,$query);
			if($result){ $error = "Staff details Updated Successfully!"; echo $error; mysqli_close($conn); exit;}else{ $error = "ERROR: Please Try Another."; echo $error; mysqli_close($conn); exit;}
}


// show project report
if($_POST['formtype'] == "showprojectsreport"){
if($_POST['selectdept'] == "" || $_POST['selectdept'] == " " || $_POST['selectdept'] == "  " ){
$error = "ERROR: Please select Depratment!"; echo $error; exit;
}elseif($_POST['selectsemester'] == "" || $_POST['selectsemester'] == " " || $_POST['selectsemester'] == "  " ){
$error = "ERROR: Please select Semester!"; echo $error; exit;}		
elseif($_POST['selectclass'] == "" || $_POST['selectclass'] == " " || $_POST['selectclass'] == "  " ){
$error = "ERROR: Please select Class!"; echo $error; exit;}		
	
	$sql=" SELECT * from projects WHERE DeptId=".$_POST['selectdept']." AND SemesterId=".$_POST['selectsemester']." AND ClassId=".$_POST['selectclass']." ORDER BY ProjectId ASC";
			//print_r($sql);
			 $result = mysqli_query($conn,$sql);
			if(mysqli_num_rows($result)>0){ $i=1;
?>
  <table class="table table-striped table-hover " border="1">
  <thead>
    <tr class="info">
      <th > </th>
      <th >PROJECT TITLE</th>
     <th >VIEW PROJECT REPORT</th>
    </tr>
  </thead>
  <tbody>
  <? 
 while ($ListData=mysqli_fetch_array($result)){ 
 ?>
  <tr>
      <td>&nbsp;<?=$i;?></td>
      <td><?=$ListData['ProjectTitle'];?></td>
      <td><a href="../projects/<?=$ListData['ProjectFileName'];?>" target="_blank">Click to view Project Report</a></td>
	 
    </tr>

<?    $i= $i+1; }  
 echo "</tbody></table>";
}else{ echo "<center><font color='blue'><b>NO RESULTS FOUND !</b></font>!</center></td></tr>"; } mysqli_close($conn); 
}


// show results
if($_POST['formtype'] == "showresults"){
if($_POST['selectdept'] == "" || $_POST['selectdept'] == " " || $_POST['selectdept'] == "  " ){
$error = "ERROR: Please select Depratment!"; echo $error; exit;
}elseif($_POST['selectsemester'] == "" || $_POST['selectsemester'] == " " || $_POST['selectsemester'] == "  " ){
$error = "ERROR: Please select Semester!"; echo $error; exit;}		
elseif($_POST['selectclass'] == "" || $_POST['selectclass'] == " " || $_POST['selectclass'] == "  " ){
$error = "ERROR: Please select Class!"; echo $error; exit;}		
	
	$sql=" SELECT * from reports WHERE DeptId=".$_POST['selectdept']." AND SemesterId=".$_POST['selectsemester']." AND ClassId=".$_POST['selectclass']." ORDER BY ReportId ASC";
			//print_r($sql);
			 $result = mysqli_query($conn,$sql);
			if(mysqli_num_rows($result)>0){ $i=1;
?>
  <table class="table table-striped table-hover " border="1">
  <thead>
    <tr class="info">
      <th > </th>
      <th >STUDENT ROLL NO.</th>
     <th >VIEW REPORT/RESULTS</th>
    </tr>
  </thead>
  <tbody>
  <? 
 while ($ListData=mysqli_fetch_array($result)){ 
 ?>
  <tr>
      <td>&nbsp;<?=$i;?></td>
      <td><?=$ListData['SRollNum'];?></td>
      <td><a href="../reports/<?=$ListData['ReportFileName'];?>" target="_blank">Click to view Student Report</a></td>
	 
    </tr>

<?    $i= $i+1; }  
 echo "</tbody></table>";
}else{ echo "<center><font color='blue'><b>NO RESULTS FOUND !</b></font>!</center></td></tr>"; } mysqli_close($conn); 
}

?>
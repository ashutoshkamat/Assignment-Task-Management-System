<?php

$from_angular = json_decode(file_get_contents('php://input'));
$department=$from_angular->department;
$subject=$from_angular->subject;
$assignmentno = $from_angular->Assignment_no;
$sem=$from_angular->sem;
$roll=$from_angular->roll;
$filedata=$from_angular->filedata;
$division=$from_angular->division;
$batch=$from_angular->batch;
$subpart=$from_angular->subpart;
$con = new mysqli("localhost","root","root","assignments_submitted");
$query = "call checksubmissiondate('".$subject."',".$assignmentno.",'".$subpart."')";
$result = $con->query($query);
$res=$result->fetch_assoc();
if($res["res"]=="0")
{
	$path="C:\\xampp\\htdocs\\DBMS Mini\\Submissions\\".$department."\\".$subject."\\".$roll;
	if (!is_dir($path)) {
    	mkdir($path, 0777, true);
	}         	

	if($subpart=="N")
	{
			$filename=$path."\\Assignment".$assignmentno.".txt";

	}
	else
	{
			$filename=$path."\\Assignment".$assignmentno.$subpart.".txt";
	}

	$assignmentfile = fopen($filename, "a") or die("Unable to open file");
	fwrite($assignmentfile, $filedata);
	fclose($assignmentfile);
	$con->close();
	$con = new mysqli("localhost","root","root","assignments_submitted");
	$query = "insert into ".$subject." values(".$roll.",'".$division."','".$batch."',".$assignmentno.",'".$subpart."',curdate(),'wrongmark')";
	$result = $con->query($query) or die($con->error);
	$op= "";
	if($con->connect_error)
	{
		die("Connection failed");
	}

		echo "Added successfully";
}
else
{
	echo '{"error" : "1"}';
}
$con->close();




?>

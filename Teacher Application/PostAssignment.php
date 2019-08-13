<?php

$from_angular = json_decode(file_get_contents('php://input'));
$assignmentno = $from_angular->Assignmentno;
$subject= $from_angular->subject;
$day=$from_angular->day;
$month=$from_angular->month;
$year=$from_angular->year;
$subpart=$from_angular->subpart;
$title='';
$submissiondate=$year."-".$month."-".$day;


if(checkdate($month, $day, $year))
{
	if(date("Y-m-d")>$submissiondate) {die("Invalid/Expired date");}
	$con = new mysqli("localhost","root","root","draftdb");
	$query = "select title from ".$subject." where assignno=".$assignmentno." and subpart='".$subpart."'";
	$result = $con->query($query);

if($con->connect_error)
{
	die("Connection failed");
}
if($result->num_rows >0)
{
	while($res=$result->fetch_assoc())
	{
		$title=$res['title'];
	}
	$con->close();
}


	$con = new mysqli("localhost","root","root","submissions_given");
	$query = "insert into ".$subject." values(".$assignmentno.",'".$subpart."','".$title."','".$submissiondate."')";
	$result = $con->query($query);
	$op= "";
	if($con->connect_error)
	{
		die("Connection failed");
	}	

	echo "Posted successfully";
	$con->close();
}
else
{
	echo "Invalid/Expired date";
}
?>
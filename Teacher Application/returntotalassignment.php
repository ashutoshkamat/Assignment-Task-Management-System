<?php

$from_angular = json_decode(file_get_contents('php://input'));
$department = $from_angular->department;
$subject = $from_angular->subject;

$con = new mysqli("localhost","root","root","draftdb");
$query = "select max(assignno) as maxcount from ".$subject;
$result = $con->query($query);
$op= "";
if($con->connect_error)
{
	die("Connection failed");
}
	$res=$result->fetch_assoc();
	
	if(is_null($res["maxcount"]))
	{
		echo "0";
	}
	else
	{
	$query="select subpart from ".$subject." where assignno=".$res["maxcount"];
	$result = $con->query($query);
	$res1=$result->fetch_assoc();
	if($res1["subpart"]=="N")
	{
		echo "0".$res["maxcount"];
	}
	else
	{
		echo "1".$res["maxcount"];
	}
	}
$con->close();

?>
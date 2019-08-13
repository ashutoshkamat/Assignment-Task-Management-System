<?php

$from_angular = json_decode(file_get_contents('php://input'));
$department = $from_angular->department;
$subject = $from_angular->subject;
$con = new mysqli("localhost","root","root","submissions_given");
$query = "select * from ".$subject." order by submission_date";
$result = $con->query($query);
$op= "";
if($con->connect_error)
{
	die("Connection failed");
}
if($result->num_rows >0)
{
	while($res = $result->fetch_assoc())
	{
		if($op != "")
		{
			$op.=",";
		}
		$op.='{"Assignment_no":"'.$res["assignno"].'",';
		if($res["subpart"]=="N")
		{
			$op.='"subpart":"-",';
		}
		else
			$op.='"subpart":"'.$res["subpart"].'",';

		$op.='"Assignment_title":"'.$res["title"].'",';
		$op.='"submission_date":"'.$res["submission_date"].'"}';
		
	}

	
	$op = '{"records":['.$op.']}';
	echo $op;

}
$con->close();

?>
<?php

$from_angular = json_decode(file_get_contents('php://input'));
$department = $from_angular->department;
$subject = $from_angular->subject;
$con = new mysqli("localhost","root","root","draftdb");
$query = "select * from ".$subject;
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
		$op.='"last_updated":"'.$res["lastupdateby"].'"}';
		
	}

	
	$op = '{"records":['.$op.']}';
	echo $op;

}
$con->close();

?>
<?php

$from_angular = json_decode(file_get_contents('php://input'));
$subject=$from_angular->subject;
$assignno=$from_angular->assignno;
$subpart=$from_angular->subpart;
$division=$from_angular->division;
$batch=$from_angular->batch;
$submitted_by=$from_angular->submitted_by;
$op='';
$con = new mysqli("localhost","root","root","assignments_submitted");

if($assignno=='' and $subpart=='' and $division=='' and $batch=='' and $submitted_by=='')
{
		$query="select * from ".$subject;

}
elseif($submitted_by !="" and $assignno=='' and $subpart=='' and $division=='' and $batch=='')
{
		
		$query="select * from ".$subject." where submitted_by='".$submitted_by."'";	
}
elseif ($assignno !="" and $subpart !="" and $division !="" and $batch !="" and $submitted_by =="") 
{
			
		$query="select * from ".$subject." where assignno=".$assignno." and subpart='".$subpart."' and division='".$division."' and batch='".$batch."'";
}
else
{
	die('{"error": "2"}');
}

$result=$con->query($query);

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
		$op.='{"Roll_number":"'.$res["submitted_by"].'",';
		$op.='"Division":"'.$res["division"].'",';
		$op.='"Batch":"'.$res["batch"].'",';
		$op.='"Assignment_no":"'.$res["assignno"].'",';
		$op.='"Subpart":"'.$res["subpart"].'",';
		$op.='"ischecked":"'.$res["ischecked"].'",';
		$op.='"submitted_on":"'.$res["submitted_on"].'"}';
	}
	$op='{"records":['.$op.']}';

}	
else
{
	$op='{"error": "1"}';
}	
echo $op;


$con->close();

?>

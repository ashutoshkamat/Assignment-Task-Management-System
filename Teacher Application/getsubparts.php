<?php
$from_angular = json_decode(file_get_contents('php://input'));

$subject=$from_angular->subject;
$assignno=$from_angular->Assignmentnumber;
$con = new mysqli("localhost","root","root","submissions_given");
$query = "select subpart from ".$subject." where assignno=".$assignno."";
$result = $con->query($query);
$op='';
if($con->connect_error)
{
	die("Connection failed");
}
if($result->num_rows >0)
{
	while($res = $result->fetch_assoc())
	{
		if($op !='')
			$op.=',';
		$op.='{"subpart":"'.$res["subpart"].'"}';
		
	}

	$op='{"records":['.$op.']}';
	echo $op;

}
else
{
	echo 'ERROR !';
}
$con->close();

?>
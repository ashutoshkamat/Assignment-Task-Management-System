<?php
$from_angular = json_decode(file_get_contents('php://input'));
$sem = $from_angular->sem;
$department=$from_angular->department;

$con = new mysqli("localhost","root","root","subjectdb");
$query = "select * from ".$department." where sem= ".$sem;
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
		$op.='{"subj_name":"'.$res["subj_name"].'"}';
		
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
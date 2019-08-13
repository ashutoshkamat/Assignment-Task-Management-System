<?php
$from_angular = json_decode(file_get_contents('php://input'));
$id = $from_angular->id;
$department=$from_angular->department;
$subject=$from_angular->subject;
$con = new mysqli("localhost","root","root","teacherdb");
$query = "select batch from ".$department." where id= ".$id." and subject='".$subject."'";
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
		$op.='{"bat_name":"'.$res["batch"].'"}';
		
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
<?php
$from_angular = json_decode(file_get_contents('php://input'));

$subject=$from_angular->subject;

$con = new mysqli("localhost","root","root","submissions_given");
$query = "select assignno from ".$subject;
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
		$op.='{"assignno":"'.$res["assignno"].'"}';
		
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
<?php

$from_angular = json_decode(file_get_contents('php://input'));
$id=$from_angular->id;
$password=$from_angular->password;
$con = new mysqli("localhost","root","root","teacherdb");
$query = "select * from teacher where id= ".$id." and password='".$password."'";
$result = $con->query($query);
$department="";
$subjop='';
	
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
		$op.='{"name":"'.$res["name"].'",';
		$department=$res["department"];
		$op.='"department":"'.$department.'"';
	
	
	}

	$query="select * from ".$department." where id=".$id;
	$result = $con->query($query);
	$op.=',"subjects": [';
	if($result->num_rows >0)
	{
		while($res=$result->fetch_assoc())
		{
			if($subjop != "")
			{
					$subjop.=",";
			}
			$subjop.='{"subject_name":"'.$res["subject"].'"}';
		}

		$op.=$subjop.']}';

	}


}
else
{
	$op='{"error": "1"}';
}

	echo $op;

$con->close();

?>
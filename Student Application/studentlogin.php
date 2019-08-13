<?php
$from_angular = json_decode(file_get_contents('php://input'));
$rollnumber = $from_angular->roll;
$password=$from_angular->password;
$con = new mysqli("localhost","root","root","studentsdb");
$query = "select * from students where rollnumber= ".$rollnumber." and password='".$password."'";
$result = $con->query($query);
$op='';
$department='';
if($con->connect_error)
{
	die("Connection failed");
}
if($result->num_rows >0)
{
		$res = $result->fetch_assoc();
	
		$op.='{"name":"'.$res["name"].'",';
		$op.='"department":"'.$res["department"].'",';
		$department=$res["department"];
		$query = "select * from ".$res["department"]." where roll= ".$rollnumber;
		$result = $con->query($query);


		if($con->connect_error)
		{
				die("Connection failed");
		}
		if($result->num_rows >0)
		{
				$res = $result->fetch_assoc();
				$op.='"division":"'.$res["division"].'",';
				$op.='"sem": "'.$res["sem"].'",';
		}


		$con = new mysqli("localhost","root","root","batchdb");
		$query = "select batch from ".$department." where sem= ".$res["sem"]." and division='".$res["division"]."' and start_roll <=".$rollnumber." and end_roll >=".$rollnumber;
		$result = $con->query($query);

		if($con->connect_error)
		{
				die("Connection failed");
		}
		if($result->num_rows >0)
		{	

				$res = $result->fetch_assoc();
				$op.='"batch": "'.$res["batch"].'"}';
		
		}
	

	echo $op;

}
else
{
	echo '{"error": "1"}';
}
$con->close();

?>
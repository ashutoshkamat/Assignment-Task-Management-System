<?php

$from_angular = json_decode(file_get_contents('php://input'));
$assignmentno = $from_angular->assignmentno;
$department=$from_angular->department;
$subject=$from_angular->subject;
$subpart=$from_angular->subpart;
$roll=$from_angular->roll;
if($subpart=="N")
{
	$filename="C:\\xampp\\htdocs\\DBMS Mini\\Assignments\\".$department."\\".$subject."\\\\Assignment".$assignmentno.".txt";

}
else
{
	$filename="C:\\xampp\\htdocs\\DBMS Mini\\Assignments\\".$department."\\".$subject."\\\\Assignment".$assignmentno.$subpart.".txt";
}
$assignmentfile = fopen($filename,'r') or die ("unable to open file"); 
$op="";
$getdata='';
$part='';
while(!feof($assignmentfile))
{
	
	$getdata=fgets($assignmentfile);
	
	rtrim($getdata);	
	$op.=$getdata;
}
if($subpart=="N")
	$path="C:\\xampp\\htdocs\\DBMS Mini\\Submissions\\".$department."\\".$subject."\\".$roll."\\Assignment".$assignmentno.".txt";
else
	$path="C:\\xampp\\htdocs\\DBMS Mini\\\\Submissions\\".$department."\\".$subject."\\".$roll."\\Assignment".$assignmentno.$subpart.".txt";

if(file_exists($path))
{
	$op='1'.$op;
}
else
	{
		$con = new mysqli("localhost","root","root","assignments_submitted");
		$query = "call checksubmissiondate('".$subject."',".$assignmentno.",'".$subpart."')";
		$result = $con->query($query) or die($con->error);
		$res = $result->fetch_assoc();
		if($res["res"]==0)
		{
			$op='0'.$op;
		}
		else
		{
			$op='2'.$op;
		}
}
echo $op;


?>
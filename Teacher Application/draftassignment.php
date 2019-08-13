<?php

$from_angular = json_decode(file_get_contents('php://input'));
$assignmentno = $from_angular->Assignmentno;
$department= $from_angular->department;
$subject= $from_angular->subject;
$title=$from_angular->title;
$staffname=$from_angular->staffname;
$theory=$from_angular->Theory;
$FAQ=$from_angular->FAQ;
$subpart=$from_angular->subpart;
$outcome=$from_angular->outcome;
$conclusion=$from_angular->conclusion;

$path="C:\\xampp\\htdocs\\DBMS Mini\\Assignments\\".$department."\\".$subject;
if (!is_dir($path)) {
    mkdir($path, 0777, true);
}         	

if($subpart=="N")
$filename=$path."\\Assignment".$assignmentno.".txt";
else
$filename=$path."\\Assignment".$assignmentno.$subpart.".txt";
if(file_exists($filename))
{
	if(!unlink($filename))
		echo "failure";
}

$assignmentfile = fopen($filename, "a") or die("Unable to open file");
fwrite($assignmentfile, '{"Title" : ');
fwrite($assignmentfile, '"'.$title."\",\n");
fwrite($assignmentfile, '"Aim" : ');
fwrite($assignmentfile, '"'.$from_angular->aim."\",\n");
fwrite($assignmentfile, '"Objective" : ');
fwrite($assignmentfile, '"'.$from_angular->objective."\",\n");
fwrite($assignmentfile, '"FAQ":');
fwrite($assignmentfile, $FAQ.",\n");
fwrite($assignmentfile, '"Theory":');
fwrite($assignmentfile, $theory.",\n");

fwrite($assignmentfile, '"Conclusion":');
fwrite($assignmentfile, '"'.$conclusion."\",\n");
fwrite($assignmentfile, '"Outcome":');
fwrite($assignmentfile, '"'.$outcome."\"}\n");


$con = new mysqli("localhost","root","root","draftdb");
$query="select * from ".$subject." where assignno=".$assignmentno." and subpart='".$subpart."'";
$result=$con->query($query);
if($result->num_rows >0)
{
	$query="update ".$subject." set lastupdateby='".$staffname."', title='".$title."' where assignno=".$assignmentno." and subpart='".$subpart."'";
}
else
{
	$query = "insert into ".$subject." values(".$assignmentno.",'".$subpart."','".$title."','".$staffname."')";
}
$result = $con->query($query);
$op= "";
if($con->connect_error)
{
	die("Connection failed");
}

	echo "Added successfully";
$con->close();

?>
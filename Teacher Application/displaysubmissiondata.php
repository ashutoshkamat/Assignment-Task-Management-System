<?php

$from_angular = json_decode(file_get_contents('php://input'));
$department=$from_angular->department;
$subject=$from_angular->subject;
$assignmentno = $from_angular->assignmentno;
$roll=$from_angular->roll;
$subpart=$from_angular->subpart;
$op='';
$getdata='';

$path="C:\\xampp\\htdocs\\DBMS Mini\\Submissions\\".$department."\\".$subject."\\".$roll;
if (!is_dir($path)) {
    mkdir($path, 0777, true);
}         	

if($subpart=="N")
{
		$filename=$path."\\Assignment".$assignmentno.".txt";

}
else
{
		$filename=$path."\\Assignment".$assignmentno.$subpart.".txt";
}

$submissionfile = fopen($filename,'r') or die ("unable to open file"); 


while(!feof($submissionfile))
{
	$getdata=fgets($submissionfile);
	$op.=$getdata."<br>";
}

fclose($submissionfile);

echo $op;


?>

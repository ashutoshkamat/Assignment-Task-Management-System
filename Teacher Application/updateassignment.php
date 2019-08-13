<?php

$from_angular = json_decode(file_get_contents('php://input'));
$assignmentno = $from_angular->assignmentno;
$department=$from_angular->department;
$subject=$from_angular->subject;
$subpart=$from_angular->subpart;

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
		
	$op.=$getdata;
}

fclose($assignmentfile);
echo $op;

?>
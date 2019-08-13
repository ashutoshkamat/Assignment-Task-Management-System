<?php

$from_angular = json_decode(file_get_contents('php://input'));
$subject=$from_angular->subject;
$assignmentno = $from_angular->assignmentno;
$roll=$from_angular->roll;
$subpart=$from_angular->subpart;

$con = new mysqli("localhost","root","root","assignments_submitted");
$query = "call checkassignment('".$subject."',".$roll.",".$assignmentno.",'".$subpart."')";
$result = $con->query($query);
?>

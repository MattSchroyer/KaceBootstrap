<?php
#start RT queries
#for coming up with the total for today, average, and max
$currentlyOpen="";
include_once('includes/config.php');

$theDate = date("Y-m-d");
$theYear = date("Y");

$query = "select COUNT(NAME) as counted from HD_TICKET Inner Join HD_STATUS on HD_STATUS.ID = HD_TICKET.HD_STATUS_ID
where (HD_STATUS.NAME not like '%Spam%')
AND (HD_STATUS.NAME not like '%Server Status Report%')
AND (HD_STATUS.STATE not like '%Closed%')
order by counted desc";

$result = mysqli_query($dbh, $query);
$num = mysqli_num_rows($result);
$i = 0;

while ($i < $num)
{
	$currentlyOpen = mysqli_result($result,$i,"counted");
	#$name = mysql_result($result,$i,"NAME");
	$i++;
}

// So far, only called from the Service Desk
echo "<h2>Service Desk Dashboard</h2><span class='label label-success'>Currently open = $currentlyOpen</span>";
?>

<?


#edit these lines below
$queue1Name="Website Updates";
$queue1Number="9";

$queue2Name="System Builds";
$queue2Number="8";


#mainQueueNumber and mainQueueName are set within config file
#end edit




$xAxis="";
$yAxis="";

$yAxis1="0,";

$yAxis2="";



$dataString="";

include ('includes/config.php');

$query1 = "
SELECT count(HD_TICKET.ID) as total,
HD_STATUS.NAME AS STATUS,
month(HD_TICKET.TIME_CLOSED) as month,
YEAR( HD_TICKET.TIME_CLOSED)as year
FROM HD_TICKET
JOIN HD_STATUS ON (HD_STATUS.ID = HD_TICKET.HD_STATUS_ID)
WHERE (HD_TICKET.HD_QUEUE_ID = $queue1Number)
AND ((HD_STATUS.NAME like '%closed%')
AND (HD_STATUS.NAME not like '%Spam%')
AND (HD_STATUS.NAME not like '%Server Status Report%')
)
group by    month(HD_TICKET.TIME_CLOSED)
";


 $result1 = mysql_query($query1);
 $num = mysql_numrows($result1);
 $i = 0;
 while ($i < $num)
        {
        $total = mysql_result($result1,$i,"total");
        $month = mysql_result($result1,$i,"month");
        $year = mysql_result($result1,$i,"year");

        $total = stripslashes($total);
        $month = stripslashes($month);
        $year = stripslashes($year);


#$xAxis.="'$month-$year', ";
$yAxis.="$total, ";

$i++;

}

#$xAxis=substr($xAxis,0,-2);
$yAxis=substr($yAxis,0,-2);
#echo $yAxis;





###########
$i="0";
$query1 = "
SELECT count(HD_TICKET.ID) as total,
HD_STATUS.NAME AS STATUS,
month(HD_TICKET.TIME_CLOSED) as month,
YEAR( HD_TICKET.TIME_CLOSED)as year
FROM HD_TICKET
JOIN HD_STATUS ON (HD_STATUS.ID = HD_TICKET.HD_STATUS_ID)
WHERE (HD_TICKET.HD_QUEUE_ID = $queue2Number)
AND ((HD_STATUS.NAME like '%closed%')
AND (HD_STATUS.NAME not like '%Spam%')
AND (HD_STATUS.NAME not like '%Server Status Report%')
)
group by    month(HD_TICKET.TIME_CLOSED)
";


 $result1 = mysql_query($query1);
 $num = mysql_numrows($result1);
 $i = 0;
 while ($i < $num)
        {
        $total = mysql_result($result1,$i,"total");
        $month = mysql_result($result1,$i,"month");
        $year = mysql_result($result1,$i,"year");

        $total = stripslashes($total);
        $month = stripslashes($month);
        $year = stripslashes($year);



$yAxis1.="$total, ";

$i++;

}


$yAxis1=substr($yAxis1,0,-2);



###########
$i="0";
$query1 = "
SELECT count(HD_TICKET.ID) as total,
HD_STATUS.NAME AS STATUS,
month(HD_TICKET.TIME_CLOSED) as month,
YEAR( HD_TICKET.TIME_CLOSED)as year
FROM HD_TICKET
JOIN HD_STATUS ON (HD_STATUS.ID = HD_TICKET.HD_STATUS_ID)
WHERE (HD_TICKET.HD_QUEUE_ID = $mainQueue)
AND ((HD_STATUS.NAME like '%closed%')
AND (HD_STATUS.NAME not like '%Spam%')
AND (HD_STATUS.NAME not like '%Server Status Report%')
)
group by    month(HD_TICKET.TIME_CLOSED)
";


 $result1 = mysql_query($query1);
 $num = mysql_numrows($result1);
 $i = 0;
 while ($i < $num)
        {
        $total = mysql_result($result1,$i,"total");
        $month = mysql_result($result1,$i,"month");
        $year = mysql_result($result1,$i,"year");

        $total = stripslashes($total);
        $month = stripslashes($month);
        $year = stripslashes($year);


$xAxis.="'$month-$year', ";
$yAxis2.="$total, ";

$i++;

}

$xAxis=substr($xAxis,0,-2);
$yAxis2=substr($yAxis2,0,-2);



?>



<!DOCTYPE HTML>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<title>Tickets closed per Queue</title>

		<script type="text/javascript" src="includes/js/jquery.min.js"></script>
		<script type="text/javascript">
$(function () {
    var chart;
    $(document).ready(function() {
        chart = new Highcharts.Chart({
            chart: {
                renderTo: 'container',
                type: 'line',
                marginRight: 130,
                marginBottom: 25
		
            },
            title: {
                text: 'Tickets closed per Queue',
                x: -20 //center
            },
            subtitle: {
                text: 'Source: Kace.westphal.drexel.edu',
                x: -20
            },
            xAxis: {
                categories: [<? echo $xAxis ?>]
            },
            yAxis: {
                title: {
                    text: 'Tickets'
                },
                plotLines: [{
                    value: 0,
                    width: 1,
                    color: '#808080'
                }]
            },
            tooltip: {
                crosshairs: true,
		
		formatter: function() {
                        return '<b>'+ this.series.name +'</b><br/>'+
                        this.x +': '+ this.y +' closed';
                }
            },
            legend: {
                layout: 'vertical',
                align: 'right',
                verticalAlign: 'top',
                x: -10,
                y: 100,
                borderWidth: 0
            },
            series: [{
                name: '<? echo $queue1Name ?>',
                data: [<? echo $yAxis ?>]
            }, {
                name: '<? echo $queue2Name ?>',
                data: [<? echo $yAxis1 ?>]
            }, {
                name: '<? echo $mainQueueName ?>',
                data: [<? echo $yAxis2 ?>]
            }]
        });
    });
    
});
		</script>
	</head>
	<body>
<script src="includes/js/highcharts.js"></script>
<script src="includes/js/exporting.js"></script>

<div id="container" style="min-width: 400px; height: 400px; margin: 0 auto"></div>

	</body>
</html>

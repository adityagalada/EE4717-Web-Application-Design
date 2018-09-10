<?php
// Database credentials
@ $db = new mysqli('localhost', 'f32ee', 'f32ee', 'f32ee');
  if (mysqli_connect_errno()) {
  echo 'Error: Could not connect to database.  Please try again later.';
  exit;
  }
   $query="select * from test order by time desc  limit 30";
   $result = $db->query($query);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <style>
  body
  {background-color: #EEE;}
  </style>
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script type="text/javascript">
google.charts.load('current', {'packages':['corechart']});
google.charts.setOnLoadCallback(drawChart);



function drawChart() {

  var data1 = new google.visualization.DataTable();
  data1.addColumn('date', 'Date');
  data1.addColumn('number', 'Sales');

  data1.addRows([
    <?php
    if($result->num_rows > 0){
        while($row = $result->fetch_assoc()){
          echo "[new Date('".$row['time']."'), ".$row['value']."],";
        }
    }
    ?>


  ]);


  var options1 = {
    title: 'Sales by Movie Date',
    width: 800,
    height: 500,
    hAxis: {
   format: 'MMM dd, yyyy, hh : mm :ss',
      gridlines: {count: 15}
    },
    vAxis: {
      gridlines: {color: 'none'},
      minValue: 0
    },
             backgroundColor: { fill:'transparent' }

  };
  var chart2 = new google.visualization.LineChart(document.getElementById('chart_div'));
  chart2.draw(data1, options1);

}

setTimeout(function(){
   window.location.reload(1);
}, 10000);


</script>
</head>
<body>
<div id="chart_div"></div>
</body>
</html>

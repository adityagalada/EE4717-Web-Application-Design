<script type="text/javascript">
google.charts.load('current', {'packages':['corechart']});
google.charts.setOnLoadCallback(drawChart);



function drawChart() {

    var data = google.visualization.arrayToDataTable([
      ['Movie', 'Sales'],
      <?php
      if($result->num_rows > 0){
          while($row = $result->fetch_assoc()){
            echo "['".$row['movie_title']."', ".$row['movie_revenue']."],";
          }
      }
      ?>
    ]);

    var options = {
        title: 'Most Popular Movies',
        width: 800,
        height: 500,
        is3D: true,
         sliceVisibilityThreshold: .01,
         backgroundColor: { fill:'transparent' },
         slices:{0:{offset:0.1}}
    };

    var chart = new google.visualization.PieChart(document.getElementById('piechart'));

    chart.draw(data, options);




  var data1 = new google.visualization.DataTable();
  data1.addColumn('date', 'Date');
  data1.addColumn('number', 'Sales');

  data1.addRows([
    <?php
    if($result1->num_rows > 0){
        while($row = $result1->fetch_assoc()){
          echo "[new Date('".$row['showtime_date']."'), ".$row['movie_revenue']."],";
        }
    }
    ?>


  ]);


  var options1 = {
    title: 'Sales by Movie Date',
    width: 900,
    height: 500,
    hAxis: {
   format: 'MMM dd, yyyy',
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

  var data2 = new google.visualization.DataTable();
  data2.addColumn('date', 'Date');
  data2.addColumn('number', 'Sales');

  data2.addRows([
    <?php
    if($result2->num_rows > 0){
        while($row = $result2->fetch_assoc()){
          echo "[new Date('".$row['booking_date']."'), ".$row['movie_revenue']."],";
        }
    }
    ?>


  ]);


  var options2 = {
    title: 'Sales by Booking Date',
    width: 900,
    height: 500,
    hAxis: {
   format: 'MMM dd, yyyy',
      gridlines: {count: 15}
    },
    vAxis: {
      gridlines: {color: 'none'},
      minValue: 0
    },
             backgroundColor: { fill:'transparent' }
  };
  var chart2 = new google.visualization.LineChart(document.getElementById('chart1_div'));
  chart2.draw(data2, options2);

}




</script>

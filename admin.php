  <?php
  session_start();
  ?>
  <!DOCTYPE html>
  <html>
  <head>
  <title>Admin</title>
  <link rel="stylesheet" href="newer_style.css">
  <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Ubuntu">
  <link rel="shortcut icon" href="favicon.ico" type="image/x-icon">
  <script>
  var pass = "adminpass"
  while(prompt("Enter admin password: ") != pass){
  }
  </script>
  <style>
  .admin_actions
  {min-height: 595px;}
  table {
      border-collapse: collapse;
      width: 100%;
  }

  th, td {
      padding: 8px;
  }

  tr:nth-child(even){background-color: #f2f2f2}

  th {
        text-align: center;
      background-color: #555;
      color: white;
      font-size: 1.4em;
  }
  .attribute
  {
    font-size: 1.2em;
    font-weight: bold;
    text-align: center;
        width:50%;
  }
  .amount
  {font-size: 1.2em;
  font-family: monospace;
  text-align: right;
      width:50%;}
  tr:hover
  {
  background-color: #aaa;
  }
  @media screen and (min-width: 1100px) {
    .charts_div
    {
  }
}

  </style>;
  </head>
  <body>

    <ul>
      <li><span id="title_djc">&nbsp Deja View Cinemas &nbsp</span><li>
    <li><a onclick="show_admin_action('dashboard')">Dashboard</a></li>
  <li><a onclick="show_admin_action('sales_report')">Sales Report</a></li>
    <li><a onclick="show_admin_action('movie_crud_operations')">Movies</a></li>
  <li><a onclick="show_admin_action('showtime_crud_operations')">Showtimes</a></li>
  <li><a onclick="show_admin_action('group_booking_queries')">Group Booking Queries</a></li>
    <li><a onclick="show_admin_action('charts')">Charts</a></li>
    </ul>

  <img src  ="Images\admin.png" class = "head">


  <?php

  @ $db = new mysqli('localhost', 'f32ee', 'f32ee', 'f32ee');
    if (mysqli_connect_errno()) {
    echo 'Error: Could not connect to database.  Please try again later.';
    exit;
    }
    $query = 'select count(movie_code) as no_of_movies from movie_detail';
    $result = $db->query($query);
    $row = $result->fetch_assoc();
    $no_of_movies = $row[no_of_movies];

    $today = date("Y-m-d");
    $query = 'select sum(amount) as revenue_today from transactions where booking_time like "'.$today.'%"';
    $result = $db->query($query);
    $row = $result->fetch_assoc();
    $revenue_today = $row[revenue_today];

    $query = 'select count(username) as no_of_users from users';
    $result = $db->query($query);
    $row = $result->fetch_assoc();
    $no_of_users = $row[no_of_users];

    $query = 'select count(*) as num_query from group_booking where movie_date >"'.date("Y-m-d H:i:s").'";';
    $result = $db->query($query);
    $row = $result->fetch_assoc();
    $num_query = $row[num_query];
   ?>

  <div class="admin_actions" id="dashboard">
  <div class="wrapper">
    <h1>Dashboard</h1>
    <table border="1">
   <tr>
    <td>Number of Movies Currently Playing</td><td><?php echo $no_of_movies ?></td>
   </tr>
   <tr>
    <td>Revenue for today</td>
    <td>S$<?php echo number_format((float)$revenue_today, 2, '.', '') ?></td>
  </tr>
    <tr>
      <td>Number of registered users</td><td><?php echo $no_of_users ?></td>
    </tr>
    <tr>
    <td>Future group booking queries</td> <td> <?php echo $num_query ?></td>
  </tr>
  </table>
  </div>
  </div>

  <div class="admin_actions" id="sales_report">
  <div class="wrapper">
    <h1>Sales Report</h1>
  <table border=1>
    <tr>
      <th>Movie</th>
      <th>Total Revenue</th>
    </tr>
    <?php
       $query="select sum(amount) as movie_revenue, movie_title from transactions group by movie_title order by movie_revenue desc";
       $result = $db->query($query);
       $num_results = $result->num_rows;
       for ($i=0; $i <$num_results; $i++)
       {
       $row = $result->fetch_assoc();
       echo '<tr>';
       echo '<td class = "attribute">'.$row[movie_title].'</td>';
       echo '<td class = "amount">S$'.number_format((float)$row[movie_revenue], 2, '.', '').'</td>';
       echo '</tr>';
       }
       echo '</table>';
       ?>

       <br><br>
       <table border=1>
       <tr>
       <th>Booking Date</th>
       <th>Total Revenue</th>
     </tr>
     <?php
        $query="select sum(amount) as movie_revenue, DATE(booking_time) as booking_date from transactions group by DATE(booking_time) order by booking_date desc";
        $result = $db->query($query);
        $num_results = $result->num_rows;
        for ($i=0; $i <$num_results; $i++)
        {
        $row = $result->fetch_assoc();
        echo '<tr>';
        echo '<td class = "attribute">'.$row[booking_date].'</td>';
        echo '<td class = "amount">S$'.number_format((float)$row[movie_revenue], 2, '.', '').'</td>';
        echo '</tr>';
        }
        echo '</table>';
        ?>

        <br><br>
        <table border=1>
        <tr>
        <th>Movie Date</th>
        <th>Total Revenue</th>
      </tr>
      <?php
         $query="select sum(amount) as movie_revenue, DATE(showtime) as showtime_date from transactions join showtimes on transactions.showtime_id = showtimes.showtime_id group by showtime_date order by movie_revenue desc";
         $result = $db->query($query);
         $num_results = $result->num_rows;
         for ($i=0; $i <$num_results; $i++)
         {
         $row = $result->fetch_assoc();
         echo '<tr>';
         echo '<td class = "attribute">'.$row[showtime_date].'</td>';
         echo '<td class = "amount">S$'.number_format((float)$row[movie_revenue], 2, '.', '').'</td>';
         echo '</tr>';
         }
         echo '</table>';
         ?>
  </div>
  </div>

  <div class="admin_actions" id="movie_crud_operations">
  <div class="wrapper" id="add_movie_wrapper">
    <h1>Add A Movie</h1>
    <form action="admin_action.php" method="post">
    <input type="text" name="form_id" value="add_movie" style="display:none">
    <label class = "inputs_label">Movie Name : </label>
    <input type="text" id="mname" name="movie_name" class="inputs">

    <label class = "inputs_label">Movie Synopsis : </label>
    <textarea class="inputs" id="msynopsis" name="movie_synopsis"></textarea>

    <label class = "inputs_label">Poster Image URL : </label>
    <input type="text" id="mimgurl" name="movie_image_url" class="inputs">

    <label class = "inputs_label">Wide Image URL : </label>
    <input type="text" id="mwimgurl" name="movie_wide_image_url" class="inputs">

    <label class = "inputs_label">Trailer URL : </label>
    <input type="text" id="mtrailerurl" name="movie_trailer_url" class="inputs">

    <label class = "inputs_label">Release Date : </label>
    <input type="text" id="mreleasedate" name="movie_release_date" class="inputs">

    <label class = "inputs_label">Director : </label>
    <input type="text" id="mdirector" name="movie_director" class="inputs">

    <label class = "inputs_label">Cast : </label>
    <input type="text" id="mcast" name="movie_cast" class="inputs">

    <label class = "inputs_label">Genre : </label>
    <input type="text" id="mgenre" name="movie_genre" class="inputs">

    <label class = "inputs_label">Duration : </label>
    <input type="number" id="mduration" name="movie_duration" class="inputs">

    <label class = "inputs_label">Rating : </label>
    <input type="text" id="mrating" name="movie_rating" class="inputs">

    <label class = "inputs_label">Language : </label>
    <input type="text" id="mlanguage" name="movie_language" class="inputs">

    <label class = "inputs_label">Confirm : </label>
    <input type="submit" class="inputs" value ="Add Movie">
    </form>
  </div>

  <div class="wrapper">
    <h1>Delete a Movie</h1>
    <?php   @ $db = new mysqli('localhost', 'f32ee', 'f32ee', 'f32ee');
       if (mysqli_connect_errno()) {
       echo 'Error: Could not connect to database.  Please try again later.';
       exit;
       }
       $query="select * from movie_detail";
       $result = $db->query($query);
       $num_results = $result->num_rows;
       echo '  <form action="admin_action.php" method="post">';
       echo '<label class = "inputs_label">Select Movie : </label>';
       echo '<input type="text" name="form_id" value="delete_movie" style="display:none">';

       echo '<select name="movie_delete" class="inputs" >';
       for ($i=0; $i <$num_results; $i++) {
       $row = $result->fetch_assoc();
       echo '<option class="inputs" value="'.$row[movie_code].'">'.$row[movie_title].'</option>';
       }
       echo '</select><br>';
       echo '<label class = "inputs_label">Confirm : </label>';
       echo '<input type ="submit" class="inputs" value="Delete Movie">';
       echo '</form>';
       ?>
  </div>

  <div class="wrapper">

  <h1>Edit Movie Detail</h1>

  <?php   @ $db = new mysqli('localhost', 'f32ee', 'f32ee', 'f32ee');
     if (mysqli_connect_errno()) {
     echo 'Error: Could not connect to database.  Please try again later.';
     exit;
     }
     $query="select * from movie_detail";
     $result = $db->query($query);
     $num_results = $result->num_rows;
     echo '<label class = "inputs_label">Select Movie : </label>';
     echo '<select name="movie_delete" id="movie_delete" class="inputs" onchange="showmovie(this)">';
     for ($i=0; $i <$num_results; $i++) {
       $row = $result->fetch_assoc();
       echo '<option class="inputs" value="m'.$row[movie_code].'">'.$row[movie_title].'</option>';
     }
     echo '</select>';
     $query="select * from movie_detail";
     $result = $db->query($query);
     $num_results = $result->num_rows;
     for ($i=0; $i <$num_results; $i++)
     {
     $row = $result->fetch_assoc();
        echo '<div id="m'.$row[movie_code].'" style ="display:none;" class="edit_movies">';
        echo '<form action="admin_action.php" method="post">';
        echo '<input type="text" name="form_id" value="edit_movie" style="display:none">';
        echo '<input type="text" name="movie_code" value="'.$row[movie_code].'" style="display:none">';
        echo '<label class = "inputs_label">Movie Name : </label>';
        echo '<input type="text" name="movie_name" class="inputs" value ="'.$row['movie_title'].'">';

        echo '<label class = "inputs_label">Movie Synopsis : </label>';
        echo '<textarea class="inputs" name= "movie_synopsis">'.$row['synopsis'].'</textarea>';

        echo '<label class = "inputs_label">Poster Image URL : </label>';
        echo '<input type="text" name="movie_image_url" class="inputs" value ="'.$row['image_url'].'">';

        echo '<label class = "inputs_label">Wide Image URL : </label>';
        echo '<input type="text" name="movie_wide_image_url" class="inputs" value ="'.$row['image_wide_url'].'">';

        echo '<label class = "inputs_label">Trailer URL : </label>';
        echo '<input type="text" name="movie_trailer_url" class="inputs" value ="'.$row['trailer_url'].'">';

        echo '<label class = "inputs_label">Release Date : </label>';
        echo '<input type="text" name="movie_release_date" class="inputs" value ="'.$row['release_date'].'">';

        echo '<label class = "inputs_label">Director : </label>';
        echo '<input type="text" name="movie_director" class="inputs" value ="'.$row['director'].'">';

        echo '<label class = "inputs_label">Cast : </label>';
        echo '<input type="text" name="movie_cast" class="inputs" value ="'.$row['cast'].'">';

        echo '<label class = "inputs_label">Genre : </label>';
        echo '<input type="text" name="movie_genre" class="inputs" value ="'.$row['genre'].'">';

        echo '<label class = "inputs_label">Duration : </label>';
        echo '<input type="text" name="movie_duration" class="inputs" value ="'.$row['duration'].'">';

        echo '<label class = "inputs_label">Rating : </label>';
        echo '<input type="text" name="movie_rating" class="inputs" value ="'.$row['rating'].'">';

        echo '<label class = "inputs_label">Language : </label>';
        echo '<input type="text" name="movie_language" class="inputs" value ="'.$row['language'].'">';

        echo  '<label class = "inputs_label">Confirm : </label>';
        echo '<input type="submit" class="inputs">';
        echo '</form>';
        echo '<br>';
        echo '</div>';
      }
     ?>
  </div>
  </div>

  <div class="admin_actions" id="showtime_crud_operations">
  <div class="wrapper">
    <h1>Add A Showtime</h1>
    <?php  if (mysqli_connect_errno()) {
    echo 'Error: Could not connect to database.  Please try again later.';
    exit;
    }
    echo '<form action="admin_action.php" method="post">';
    echo '<label class = "inputs_label">Select Movie : </label>';
    echo '<input type="text" name="form_id" value="add_showtime" style="display:none">';

    $query="select * from movie_detail";
    $result = $db->query($query);
    $num_results = $result->num_rows;
    echo '<select name="add_showtime_movie" class="inputs" >';
    for ($i=0; $i <$num_results; $i++) {
    $row = $result->fetch_assoc();
    echo '<option class="inputs" value="'.$row[movie_code].'">'.$row[movie_title].'</option>';
    }
    echo '</select>';

    echo '<label class = "inputs_label">Select Screen : </label>';
    $query="select * from screen";
    $result = $db->query($query);
    $num_results = $result->num_rows;
    echo '<select name="add_showtime_screen" class="inputs" >';
    for ($i=0; $i <$num_results; $i++) {
    $row = $result->fetch_assoc();
    echo '<option class="inputs" value="'.$row[screen_id].'">'.$row[name].'</option>';
    }
    echo '</select>';

   echo '<label class = "inputs_label">Enter Showtime : </label>';
   echo '<input class="inputs" type ="datetime-local" name="showtime">';
  echo   '<label class = "inputs_label">Confirm : </label>';
    echo '<br><input type ="submit" class="inputs" value="Add Showtime">';
    echo '</form>';
       ?>
  </div>

  <div class="wrapper">
    <h1>Delete a Showtime</h1>
    <form action="admin_action.php" method="post">
      <input type="text" name="form_id" value="delete_showtime" style="display:none">
      <table border=1>
        <tr>
      <th>Select</th>
      <th>Time</th>
      <th>Movie</th>
      <th>Auditorium</th>
    </tr>
    <?php   @ $db = new mysqli('localhost', 'f32ee', 'f32ee', 'f32ee');
       if (mysqli_connect_errno()) {
       echo 'Error: Could not connect to database.  Please try again later.';
       exit;
       }
       $query="select * from movie_detail";
       $query="SELECT * FROM showtimes a JOIN movie_detail b ON a.movie_code = b.movie_code JOIN screen c ON a.screen_id = c.screen_id;";
       $result = $db->query($query);
       $num_results = $result->num_rows;
       for ($i=0; $i <$num_results; $i++)
       {
         $row = $result->fetch_assoc();
         echo '<tr>';
         echo '<td align="center"><input type="radio" name="showtime_delete" value="'.$row[showtime_id].'"></td>';
         echo '<td>'.$row[showtime].'</td>';
         echo '<td>'.$row[movie_title].'</td>';
         echo '<td>'.$row[name].'</td>';
         echo '</tr>';
       }
       echo '</table>';
       ?>
       <label class = "inputs_label">Confirm : </label>
      <input type="submit" value="Delete Showtime" class="inputs">
     </form>
  </div>

  <div class="wrapper">
    <h1>Update Price</h1>
    <?php   @ $db = new mysqli('localhost', 'f32ee', 'f32ee', 'f32ee');
       if (mysqli_connect_errno()) {
       echo 'Error: Could not connect to database.  Please try again later.';
       exit;
       }
       $query="select * from movie_detail";
       $result = $db->query($query);


       echo '  <form action="admin_action.php" method="post">';
       echo '<input type="text" name="form_id" value="edit_price" style="display:none">';

        $row=$result->fetch_assoc();
        echo '<label class = "inputs_label">Weekday Price : </label>';
        echo '<input type="text" name="wkday_price" class="inputs" value ="'.$row['price'].'">';

        $row=$result->fetch_assoc();
        echo '<label class = "inputs_label">Weekend Price : </label>';
        echo '<input type="text" name="wkend_price" class="inputs" value ="'.$row['price'].'">';

        echo '<label class = "inputs_label">Confirm : </label><input type="submit" class="inputs">';
        echo '</form>';
        echo '<br>';
        echo '</div>';

       ?>
  </div>
  </div>
  <div class="admin_actions" id="group_booking_queries">
  <div class="wrapper">
    <h1>Group Booking Queries</h1>
    <?php
    @ $db = new mysqli('localhost', 'f32ee', 'f32ee', 'f32ee');
       if (mysqli_connect_errno()) {
       echo 'Error: Could not connect to database.  Please try again later.';
       exit;
       }
       $query="select * from group_booking";
       $result = $db->query($query);
       $num_results = $result->num_rows;
       echo '<table border=1 id="grp_bk_table">';
       echo '<tr><th>First Name</th><th>Last Name</th><th>Phone</th>
       <th>Email</th><th>Date</th><th>Time</th><th>Movie</th><th>Seats</th><th>Comment</th></tr>';
       for($i=0;$i<$num_results;$i++)
       {
         $row=$result->fetch_assoc();
        echo '<tr>';
        echo '<td>'.$row['first_name'].'</td>';
        echo '<td>'.$row['last_name'].'</td>';
        echo '<td>'.$row['phone_number'].'</td>';
        echo '<td>'.$row['email_id'].'</td>';
        echo '<td>'.$row['movie_date'].'</td>';
        echo '<td>'.$row['movie_time'].'</td>';
        echo '<td>'.$row['movie_title'].'</td>';
        echo '<td>'.$row['seats_required'].'</td>';
        echo '<td>'.$row['customer_comments'].'</td>';
        echo '</tr>';
       }
       echo '</table>';
  ?>
  </div>
  </div>
    <div class="admin_actions" id="charts">
      <div class="wrapper">
        <h3>Movies By Revenue</h3>
          <div id="piechart" class ="charts_div"></div>
      </div>
      <div class="wrapper">
          <div id="chart_div" class ="charts_div"></div>
      </div>
      <div class="wrapper">
          <div id="chart1_div" class ="charts_div"></div>
      </div>
</div>
    </div>
  <div id="foot">
    Welcome Administrator
    <br><br>
    Copyright &copy 2017 Deja View Cinemas
  </div>
  </body>
  <?php
  // Database credentials
  @ $db = new mysqli('localhost', 'f32ee', 'f32ee', 'f32ee');
    if (mysqli_connect_errno()) {
    echo 'Error: Could not connect to database.  Please try again later.';
    exit;
    }
     $query="select sum(amount) as movie_revenue, movie_title from transactions group by movie_title order by movie_revenue desc";
     $result = $db->query($query);

     $query="select sum(amount) as movie_revenue, DATE(showtime) as showtime_date from transactions join showtimes on transactions.showtime_id = showtimes.showtime_id group by showtime_date order by showtime_date desc";
     $result1 = $db->query($query);

     $query="select sum(amount) as movie_revenue, DATE(booking_time) as booking_date from transactions group by DATE(booking_time) order by booking_date desc";
     $result2 = $db->query($query);

  ?>
  <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
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
          width:1000,
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
      width:1000,
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
      width:1000,
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
  <script>

  var tmp=document.getElementsByClassName('admin_actions');
  for (var i=1;i<tmp.length;i++)
  {
      tmp[i].style.display="none";
  }
  function showmovie (x)
  {
    var tmp=document.getElementsByClassName('edit_movies');
    for (var i=0;i<x.length;i++)
    {
      tmp[i].style.display="none";
    }
    document.getElementById(x.value).style.display="block";
    }

    function show_admin_action (x)
    {
      var tmp=document.getElementsByClassName('admin_actions');
      for (var i=0;i<tmp.length;i++)
      {
        if(tmp[i].id == x)
        {  tmp[i].style.display="block";}
        else {
          tmp[i].style.display="none";
        }
      }
  }
  </script>
  </html>

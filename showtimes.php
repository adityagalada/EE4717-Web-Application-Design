<?php
// Start the session
session_start();
?>
<!DOCTYPE html>
<html>
  <title>Deja View</title>
  <link rel="stylesheet" href="newer_style.css">
  <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Ubuntu">
  <link rel="shortcut icon" href="favicon.ico" type="image/x-icon">
</head>
<body>
  <ul>
    <li><span id="title_djc">&nbsp Deja View Cinemas &nbsp</span></li>
      <li><a href="index.html">Home</a></li>
      <li><a href="movies.php">Movies</a></li>
    <li><a class="active" href="showtimes.php">Showtimes</a></li>
    <li><a href="group_booking.php">Group Booking</a></li>
  <li class="login_link" id="login_id"><a href="#" onclick="login()">
    <?php
    if(isset($_SESSION['valid_user']))
      echo 'Welcome, '.$_SESSION['valid_user'];
    else
      echo 'Login';
    ?></a></li>
  </ul>

<img src  ="Images\showtimes.png" class = "head">
<iframe id="portal" src="authmain.php" height="265px" width="350px"></iframe>
<script>
    function login(){

      if(document.getElementById("portal").style.visibility == "hidden"){
        document.getElementById("portal").style.visibility = "visible";
        document.getElementById("login_id").style.backgroundColor = "#111";
      }
      else{
        document.getElementById("portal").style.visibility = "hidden";
        document.getElementById("login_id").style.backgroundColor = "#333";
      }
    }
  </script>
  <?php
    $print_date_value = array();
     $d = strtotime("today");
      for ($i=0;$i<7;$i++)
      {$your_date = strtotime($i." day", $d);
      $print_date_value[$i] = date("Y-m-d", $your_date);
      $print_date_label[$i] = date("D, d M", $your_date);
    }
    ?>
<div class="page">
<div class="wrapper">
<style>

/* Style the tab */
div.tab {
    overflow: hidden;
    border: 1px solid #ccc;
    background-color: #f1f1f1;
}

/* Style the buttons inside the tab */
div.tab button {
    background-color: inherit;
    float: left;
    border: none;
    outline: none;
    cursor: pointer;
    padding: 16px 31px;
    transition: 0.3s;
    font-size: 15px;
    font-weight: bolder;
}

/* Change background color of buttons on hover */
div.tab button:hover {
    background-color: #ddd;
}

/* Create an active/current tablink class */
div.tab button.active {
    background-color: #aaa;
}

/* Style the tab content */
.tabcontent {
    display: none;
    padding: 6px 12px;
    border-top: none;
}

.progress {
    display: inline-block;
    margin: 3px;
    padding: 0;
    background-color: #42f47d;
    border: 0;
    height: 2.5px;
}
</style>
<p style="text-align:center; font-size:1.25em;">Filter by Date</p>

<div class="tab">
<?php
  for($i=0;$i<7;$i++)
{  echo   '<button class="tablinks" onclick="showDate(event,'."'".$print_date_value[$i]."')".'">'.$print_date_label[$i].'</button>';}
  ?>
</div>
</div>

<?php
    @ $db = new mysqli('localhost', 'f32ee', 'f32ee', 'f32ee');

    if (mysqli_connect_errno()) {
       echo 'Error: Could not connect to database.  Please try again later.';
       exit;
    }


    for($k=0;$k<7;$k++){
          echo '<div class= "tabcontent" id = "'.$print_date_value[$k].'">';

          $query3 = "select * from showtimes where showtime like '".$print_date_value[$k]."%'";
          $result3 = $db->query($query3);

          $num_results3 = $result3->num_rows;

          if($num_results3==0){
            echo '<div class = "wrapper">';
            echo '<center>Schedule not out yet.</center>';
            echo '</div>';
          }

        $query = "select * from movie_detail";
        $result = $db->query($query);

        $num_results = $result->num_rows;
        for ($i=0; $i <$num_results; $i++) {
          $row = $result->fetch_assoc();
          $movie_code = $row[movie_code];

          $query2 = "select * from showtimes where movie_code=".$movie_code." and showtime like '".$print_date_value[$k]."%' order by showtime";
          $result2 = $db->query($query2);

          $num_results2 = $result2->num_rows;

          if($num_results2){
                    echo '<div class = "wrapper">';
                    echo '<div class = "movie">';
                    echo     '<a class="movie_name" href=movie_detail.php?movie='.$row[movie_code].'>'.$row[movie_title].'</a><br>';
                    echo     '<span class="language">'.$row[language].'</span>&nbsp';
                    echo     '<span class="rating">'.$row[rating].'</span>&nbsp';
                    echo     '<span class="duration">'.$row[duration].'min</span><br>';
                    echo     '<span class="genre">'.$row[genre].'</span>';
                    echo '</div>';
                    echo '<div class="timings">';

                      for($j=0; $j <$num_results2; $j++) {

                        $row2 = $result2->fetch_assoc();

                        $query3 = "select count(seat_id) as no_of_seats_booked, no_of_seats from seat_reserved join screen on seat_reserved.screen_id = screen.screen_id where paid=1 and showtime_id=".$row2[showtime_id];
                        $result3 = $db->query($query3);
                        $row3 = $result3->fetch_assoc();

                        $percent_full = $row3[no_of_seats_booked]*100/$row3[no_of_seats];
                        $progress_bar = $percent_full*85/100;

                        if($percent_full>=80)
                          $color = '#FF0000';
                        else if($percent_full>=50)
                          $color = '#FF7E28';
                        else
                          $color = '#427AA8';

                        $now = time();
                        $time_now = date("H:i", $now);

                        if($k==0){
                          if(strcmp(substr($row2[showtime], -8, 5),$time_now)>0){
                            echo '<a class="showtime_button" style="border: solid '.$color.' 2px" href="seat_select.php?screen_id='.$row2[screen_id].'&showtime_id='.$row2[showtime_id].'"><hr class="progress" style="width: '.$progress_bar.'px"><font size="0.5">'.number_format((float)$percent_full, 1, '.', '').'%</font><br>'.substr($row2[showtime], -8, 5).'<br></a>';
                          }
                          else{
                            echo '<a class="showtime_button_disabled">'.substr($row2[showtime], -8, 5).'</a>';
                          }
                        }
                        else {
                          echo '<a class="showtime_button" style="border: solid '.$color.' 2px" href="seat_select.php?screen_id='.$row2[screen_id].'&showtime_id='.$row2[showtime_id].'"><hr class="progress" style="width: '.$progress_bar.'px"><font size="0.5">'.number_format((float)$percent_full, 1, '.', '').'%</font><br>'.substr($row2[showtime], -8, 5).'</a>';
                        }
                      }

                 echo '</div>';
              echo '</div>';
          }
        }
  echo '</div>';
  }

?>
</div>
<script>
function showDate(evt, tab_date_id) {
    var i, tabcontent, tablinks;
    tabcontent = document.getElementsByClassName("tabcontent");
    for (i = 0; i < tabcontent.length; i++) {
        tabcontent[i].style.display = "none";
    }
    tablinks = document.getElementsByClassName("tablinks");
    for (i = 0; i < tablinks.length; i++) {
        tablinks[i].className = tablinks[i].className.replace(" active", "");
    }
    document.getElementById(tab_date_id).style.display = "block";
    evt.currentTarget.className += " active";
}
</script>

</body>
<div id="foot">
   <a href="index.html#myBtn">FAQ</a>
   <a href="index.html#myBtn1">Location</a>
   <br><br>
   Copyright &copy 2017 Deja View Cinemas
</div>

</html>

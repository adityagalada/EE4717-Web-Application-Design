<?php session_start(); ?>
<!DOCTYPE html>
<html>
<head>
  <title>Deja View</title>
  <link rel="stylesheet" href="newer_style.css">
  <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Ubuntu">
  <link rel="shortcut icon" href="favicon.ico" type="image/x-icon">
</head>
<style>
.progress {
    display: inline-block;
    margin: 3px;
    padding: 0;
    background-color: #42f47d;
    border: 0;
    height: 2.5px;
}
</style>
<body>


  <ul>
  <li><span id="title_djc">&nbsp Deja View Cinemas &nbsp</span></li>
  <li><a href="index.html">Home</a></li>
    <li><a class="active" href="movies.php">Movies</a></li>
    <li><a href="showtimes.php">Showtimes</a></li>
    <li><a href="group_booking.php">Group Booking</a></li>
  <li class="login_link" id="login_id"><a href="#" onclick="login()">
    <?php
    if(isset($_SESSION['valid_user']))
      echo 'Welcome, '.$_SESSION['valid_user'];
    else
      echo 'Login';
    ?></a></li>
  </ul>
<img src  ="Images\now_showing.png" class = "head">
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
   <div class="page">
  <div class ="wrapper">

<?php
  $movie_code=$_GET['movie'];

  @ $db = new mysqli('localhost', 'f32ee', 'f32ee', 'f32ee');

  if (mysqli_connect_errno()) {
     echo 'Error: Could not connect to database.  Please try again later.';
     exit;
  }  $query = 'select * from movie_detail where movie_code ="'.$movie_code.'"';

  $result = $db->query($query);


     $row = $result->fetch_assoc();
     $titleStr=$row['movie_title'];
     $synposisStr=$row['synopsis'];
     $imgUrlStr=$row['image_wide_url'];
     $releaseDateStr=$row['release_date'];
     $directorStr=$row['director'];
     $castStr=$row['cast'];
     $genreStr=$row['genre'];
     $trailerUrl=$row['trailer_url'];
     $langStr=$row['language'];
     $duration=$row['duration'];
  $result->free();


    ?>

  <h1><center> <?php echo $titleStr ?> </center></h1>
  <img src=<?php echo $imgUrlStr?> alt="Movie Poster" class="image_large">

    <div class="description1">
      <hr>
    <span class ="detail_title">Synopsis</span><br><br>
    <?php echo $synposisStr ?>
    <br>
    <hr>
    <span class ="detail_title">Watch Trailer</span><br><br>

      <iframe id="trailer_iframe" src=<?php echo $trailerUrl ?> frameborder="0" allowfullscreen></iframe>
        <br>
        <hr>
  </div>
  <div class="description2">
<hr>
    <span class ="detail_title">Release Date</span><br>
        <div class ="detail">
    <?php echo $releaseDateStr ?>
  </div>
<hr>
    <span class ="detail_title">Director</span><br>
      <div class ="detail">
    <?php echo $directorStr ?>
  </div>
<hr>
    <span class ="detail_title">Cast</span><br>
      <div class ="detail">
    <?php echo $castStr ?>
  </div>
<hr>
    <span class ="detail_title">Genre</span><br>
<div class ="detail">
    <?php echo $genreStr ?>
  </div>
<hr>
<span class ="detail_title">Duration</span><br>
<div class ="detail">
<?php echo $duration." min" ?>
</div>
<hr>
    <span class ="detail_title">Language</span><br>
          <div class ="detail">
    <?php echo $langStr ?>
  </div>
  <hr>
  </div>

</div>
<div class="wrapper">
  <select id="movie_day" class="date_filter" onchange="showDiv(this)">
   <?php
   $d = strtotime("today");
   $print_date_value = array();
    for ($i=0;$i<7;$i++)
    {$your_date = strtotime($i." day", $d);
    $print_date_value[$i] = date("Y-m-d", $your_date);
    $print_date_label = date("D, d M", $your_date);
    echo '<option value = "'.$print_date_value[$i].'"';
    echo '>'.$print_date_label.'</option>';
  }
    ?>
  </select>
  <?php
  for($k=0;$k<7;$k++){
    $query2 = "select * from showtimes where movie_code=".$movie_code." and showtime like '".$print_date_value[$k]."%'";
    $result2 = $db->query($query2);

    $num_results2 = $result2->num_rows;
    if($k){
      echo '<div class="timings" id="'.$print_date_value[$k].'" style="display:none">';
    }
    else{
      echo '<div class="timings" id="'.$print_date_value[$k].'" style="display:block">';
    }

    if($num_results2){
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
    }
    else{
      echo '<div style="margin-top: 40px; margin-left: 100px;">Schedule not out yet.</div>';
    }

  echo '</div>';
  }
   ?>
</div>
<script type = "text/javascript">
  function showDiv(select){

    var x = document.getElementsByClassName("timings");
    for(var i=0; i<x.length; i++){
      x[i].style.display = "none"
    }
    document.getElementById(select.value).style.display = "block";

  }
</script>
</div>
<div id="foot">
   <a href="index.html#myBtn">FAQ</a>
   <a href="index.html#myBtn1">Location</a>
   <br><br>
   Copyright &copy 2017 Deja View Cinemas
</div>
</body>
</html>

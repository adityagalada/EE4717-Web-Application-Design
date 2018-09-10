<?php
// Start the session
session_start();
if(!isset($_SESSION['cart'])){
  $_SESSION['cart'] = array();
}
?>
<!DOCTYPE html>
<html>
<head>
  <title>Deja View</title>
  <link rel="stylesheet" href="newer_style.css">
  <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Ubuntu">
  <link rel="shortcut icon" href="favicon.ico" type="image/x-icon">
</head>
<body>

    <ul>
    <li><div id="title_djc">&nbsp Deja View Cinemas &nbsp</div><li>
  <li><a href="index.html">Home</a></li>
    <li><a href="movies.php">Movies</a></li>
    <li><a class="showtimes.php">Showtimes</a></li>
    <li><a href="group_booking.php">Corporate Booking</a></li>
  </ul>

<img src  ="Images\Confirmation.png" class = "head">
<div class="page">
      <?php

      $screen_id = $_POST['screen_id'];
      $showtime_id = $_POST['showtime_id'];
      $seat_id = $_POST['seat_id'];
      $user_name = $_SESSION['valid_user'];

      $no_of_seats = count($seat_id);
      $id = array($showtime_id, $screen_id);

      @ $db = new mysqli('localhost', 'f32ee', 'f32ee', 'f32ee');

      if (mysqli_connect_errno()) {
         echo 'Error: Could not connect to database.  Please try again later.';
         exit;
      }

      $query = "select movie_code, showtime from showtimes where showtime_id=".$showtime_id." and screen_id=".$screen_id;
      $result = $db->query($query);
      $row = $result->fetch_assoc();

      $query2 = "select movie_title from movie_detail where movie_code=".$row[movie_code];
      $result2 = $db->query($query2);
      $row2 = $result2->fetch_assoc();

      $query3 = "select name from screen where screen_id=".$screen_id;
      $result3 = $db->query($query3);
      $row3 = $result3->fetch_assoc();

      $showtime = substr($row[showtime], 0, -3);
      $movie_title = $row2[movie_title];
      $audi_name = $row3[name];

      $all_rows = "ZABCDEFGHJKLMNPQRSTUVWXYZ";

      $result->free();
      $result2->free();

      for($i=0; $i<$no_of_seats; $i++)
      {
        $row_seat = str_split($seat_id[$i]);

        if(count($row_seat) == 3){
          $row_alpha = $row_seat[0];
          $seat_no = $row_seat[1].$row_seat[2];
        }
        else{
          $row_alpha = $row_seat[0];
          $seat_no = $row_seat[1];
        }
        $row_no = strpos($all_rows, $row_alpha);

        $query = 'insert into seat_reserved values ("'.$user_name.'", '.$seat_no.', '.$showtime_id.', 1, '.$screen_id.', '.$row_no.', 0)';
        $db->query($query);

      }

      $array = explode(' ', $showtime, 2);
      $time = $array[1];
      $temp = strtotime($array[0]);
      $date = date("D, d M", $temp);

      $day = substr($date, 0, 3);
      if($day == 'Sat' || $day == 'Sun'){
        $day = 'weekend';
      }
      else {
        $day = 'weekday';
      }
      $query_price = 'select price from ticket_prices where price_name = "'.$day.'"';
      $result_price = $db->query($query_price);
      $row_price = $result_price->fetch_assoc();
      $ticket_price = $row_price[price];

      $total = $ticket_price*$no_of_seats;
       ?>


       <div class="wrapper">
       <div class="flex-container" style="flex-flow:wrap;">
       <?php
         echo '<div class="flex-item" style="width:600px; background-color:#AAA;">';
            echo '<div class="name">'.$movie_title.'<br></div>';
            echo '<img src= "Images\seat_icon.png" class="icon">';
              echo implode(", ", $seat_id).'<br>';
              echo '<img src= "Images\calendar.png" class="icon">';
              echo $date.'<br>';
              echo '<img src= "Images\time.png" class="icon">'.$time.'hrs<br>';
              echo '<img src= "Images\loc_icon.png" class="icon">';
              echo $audi_name.' Deja View NTU';
              echo '<span style="float:right;"><br>Total: S$'.number_format((float)$ticket_price, 2, '.', '').' x '.$no_of_seats.' = S$'.$total.'</span>';
           echo '</div>';
       ?>
       </div>
       </div>

<div class="buttondiv">
  <a class="browse" href="cart.php">Proceed To Cart</a>
</div>
<?php
$counter = count($_SESSION['cart']);
$_SESSION['cart'][$counter] = array($movie_title, $seat_id, $date, $time, $audi_name, $total, $id);
?>
</div>
<div id="foot">
   <a href="index.html#myBtn">FAQ</a>
   <a href="index.html#myBtn1">Location</a>
   <br><br>
   Copyright &copy 2017 Deja View Cinemas
</div>

</body>
</html>

<?php
// Start the session
session_start();
?>
<!DOCTYPE html>
<html>
<head>
  <title>Deja View</title>
  <link rel="stylesheet" href="newer_style.css">
  <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Ubuntu">
  <link rel="shortcut icon" href="favicon.ico" type="image/x-icon">
</head>
<style>
td {
  display: block;
  float: left;
  margin: 5px;
}
</style>
<body>
  <ul>
    <li><span id="title_djc">&nbsp Deja View Cinemas &nbsp</span></li>
  <li><a href="index.html">Home</a></li>
    <li><a href="movies.php">Movies</a></li>
    <li><a href="showtimes.php">Showtimes</a></li>
    <li><a href="group_booking.php">Corporate Booking</a></li>
  <li class="login_link" id="login_id"><a href="#" onclick="login()">
    <?php
    if(isset($_SESSION['valid_user']))
      echo 'Welcome, '.$_SESSION['valid_user'];
    else
      echo 'Login';
    ?></a></li>
  </ul>
  <img src  ="Images\seat_select.png" class = "head">

 <iframe id="portal" src="authmain.php" height="265px" width="350px"></iframe>
<div class="page">
<div class ="wrapper">
  <div class="description1">
    <label>Select the required number of Seats: &nbsp</label>
    <select size="1" name="no_seats" onchange="showDiv(this)">
      <option value="0" selected>Choose an option</option>
      <option value="1"> 1 </option>
      <option value="2"> 2 </option>
      <option value="3"> 3 </option>
      <option value="4"> 4 </option>
      <option value="5"> 5 </option>
      <option value="6"> 6 </option>
      <option value="7"> 7 </option>
      <option value="8"> 8 </option>
      <option value="9"> 9 </option>
      <option value="10"> 10 </option>
    </select>

   <div id="seat"  style="display:none;">
      <table cellspacing="0" cellpadding="0">
        <tbody id="tableBody">
        </tbody>
      </table>

      <?php
      $audi_no = $_GET['screen_id'];
      $showtime_id = $_GET['showtime_id'];

      if(!isset($_SESSION['valid_user'])){
        echo 'Yes';
        echo '<script type=text/javascript> document.getElementsByClassName("wrapper")[0].style.display = "none";';
        echo 'alert("Please login to Continue");';
        echo 'document.getElementById("portal").style.visibility = "visible";';
        echo 'document.getElementById("login_id").style.backgroundColor = "#111";</script>';
      }
      else {
        echo '<script type=text/javascript> document.getElementsByClassName("wrapper")[0].style.display = "block";</script>';
      }

      @ $db = new mysqli('localhost', 'f32ee', 'f32ee', 'f32ee');

      if (mysqli_connect_errno()) {
         echo 'Error: Could not connect to database.  Please try again later.';
         exit;
      }

      $query = "select * from screen where screen_id=".$audi_no;
      $result = $db->query($query);

      $row = $result->fetch_assoc();

      $audi_name = $row[name];
      $no_of_rows = $row[no_of_seats]/10;

      $query2 = "select row_id, seat_id from seat_reserved where screen_id=".$audi_no." and showtime_id=".$showtime_id;
      $result2 = $db->query($query2);

      $num_results2 = $result2->num_rows;
      $row2 = $result2->fetch_assoc();

      $reserved_seats = array(
        0 => array(
          0 => $row2[row_id],
          1 => $row2[seat_id]
            )
      );

      for($i=1; $i <$num_results2; $i++) {

        $row2 = $result2->fetch_assoc();

        $reserved_seats[] = array(
          0 => $row2[row_id],
          1 => $row2[seat_id]
        );

      }


      ?>

      <script type="text/javascript">var reserved_seats = <?php echo json_encode($reserved_seats); ?>;
      console.log(reserved_seats)</script>
      <script type="text/javascript">var no_of_rows = "<?= $no_of_rows ?>";</script>
      <script type = "text/javascript" src = "seats.js"></script>
    </div>
  </div>
  <div class="description2">
  <?php
    $query = "select * from showtimes where showtime_id=".$showtime_id;
    $result = $db->query($query);
    $row1 = $result->fetch_assoc();
    $query = "select * from movie_detail where movie_code=".$row1[movie_code];
    $result = $db->query($query);
    $row2 = $result->fetch_assoc();

    $showtime = $row1[showtime];
    $array = explode(' ', $showtime, 2);
    $time = $array[1];
    $temp = strtotime($array[0]);
    $date = date("D, d M", $temp);
  echo "<div style='float:left; padding-right:10px;'><img src=".$row2[image_url]." class ='image'></div>";
  echo '<h1><center>'.$row2[movie_title].'</center></h1>';
  echo "<h3>Screen: ".$audi_name."<br>".$date."<br>".substr($time, 0, -3)." hrs</h3>";
  echo '<div class="buttondiv" id="proceed_button" style="display: none">';
  echo '<a class="browse" onclick="sendForm('.$audi_no.','.$showtime_id.')">Proceed</a>';
  echo '</div>';


  ?>
    <div style="text-align: center; float: right; border: solid 1px #AAA; width: 33%">
      <b><font size="2">Legend : <br></b>
      <i>Available : &nbsp
      <img src="Images/seat.png" height="13px" width="13px"><br>
      Booked : &nbsp
      <img src="Images/seat_booked.png" height="13px" width="13px"></font></i>
    </div>
  </div>
</div>
</div>
</div>
<div id="foot">
   <a href="index.html#myBtn">FAQ</a>
   <a href="index.html#myBtn1">Location</a>
   <br><br>
   Copyright &copy 2017 Deja View Cinemas
</div>
</body>
</html>

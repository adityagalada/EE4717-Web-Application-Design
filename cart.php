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
<body>
<img src  ="Images\cart.png" class = "head">

<ul>
    <li><span id="title_djc" style="display:block;">&nbsp Deja View Cinemas &nbsp</span></li>
<li><a class="active" href="">Home</a></li>
<li><a href="movies.php">Movies</a></li>
<li><a href="showtimes.php">Showtimes</a></li>
<li><a href="group_booking.php">Group Booking</a></li>
</ul>
<div class="page">
<div class="wrapper">
<div class="flex-container" style="flex-flow:wrap;">
<?php
if(!empty($_POST)){
  $screen_id = $_POST['screen_id'];
  $showtime_id = $_POST['showtime_id'];
  $rem_id = $_POST['rem_id'];

  @ $db = new mysqli('localhost', 'f32ee', 'f32ee', 'f32ee');

  if (mysqli_connect_errno()) {
     echo 'Error: Could not connect to database.  Please try again later.';
     exit;
  }

  $n = count($_SESSION['cart']);
  for($i=0; $i<$n; $i++){
    if(!strcmp(implode(", ", $_SESSION['cart'][$i][6]), $rem_id))
    {
      unset($_SESSION['cart'][$i]);
      $_SESSION['cart'] = array_values($_SESSION['cart']);
      $query = 'delete from seat_reserved where screen_id='.$screen_id.' and showtime_id='.$showtime_id.' and paid=0';
      $db->query($query);
    }
  }

}

$_SESSION['cart'] = array_unique($_SESSION['cart'], SORT_REGULAR);
$n = count($_SESSION['cart']);
$id1 = implode(", ", $_SESSION['cart'][$n-1][6]);
for($i=0; $i<$n-1; $i++){
  $id_temp = implode(", ", $_SESSION['cart'][$i][6]);
  if(!strcmp($id1, $id_temp)){
    $_SESSION['cart'][$i][1] = array_merge($_SESSION['cart'][$i][1], $_SESSION['cart'][$n-1][1]);
    $_SESSION['cart'][$i][5] = $_SESSION['cart'][$i][5] + $_SESSION['cart'][$n-1][5];
    unset($_SESSION['cart'][$n-1]);
    $_SESSION['cart'] = array_values($_SESSION['cart']);
  }
}
$n = count($_SESSION['cart']);

for($i=0; $i<$n; $i++){
  $id = implode(", ", $_SESSION['cart'][$i][6]);
  echo '<div id="'.$id.'" class="flex-item" style="width:450px; background-color:#AAA;">';
    echo '<span class="close" onclick="remove(this)">x</span>';
     echo '<div class="name">'.$_SESSION['cart'][$i][0].'<br></div>';
     echo '<img src= "Images\seat_icon.png" class="icon">';
       echo implode(", ", $_SESSION['cart'][$i][1]).'<br>';
       echo '<img src= "Images\calendar.png" class="icon">';
       echo $_SESSION['cart'][$i][2].'<br>';
       echo '<img src= "Images\time.png" class="icon">'.$_SESSION['cart'][$i][3].'hrs<br>';
       echo '<img src= "Images\loc_icon.png" class="icon">';
       echo $_SESSION['cart'][$i][4].' Deja View NTU';
       echo '<span class="final_amt">Total: S$'.number_format((float)$_SESSION['cart'][$i][5], 2, '.', '').'</span>';
    echo '</div>';
}
?>
</div>
</div>

<div class="wrapper">
  <?php
  $n = count($_SESSION['cart']);
  $total = 0;
  for($i=0; $i<$n; $i++){
    $total += $_SESSION['cart'][$i][5];
  }
  $booking_fee = 1.5;
  $total += $booking_fee;

  echo '<center><b>Total Amount Due: S$ '.number_format((float)$total, 2, '.', '').'</b>';
  echo '<br><font size="2"><i> (including S$1.5 booking fee and GST) </i></font></center>';
  ?>
</div>


<div class="buttondiv">
<a class="browse" href="index.html">Continue Browsing</a>
<a class="browse" href="payment.php">Proceed to Payment</a>
</div>
</div>
<script type="text/javascript">
function remove(ele){
  var rem_id = ele.parentNode.id;
  var array = rem_id.split(', ');

  var form = document.createElement('form');
  form.setAttribute('method',"post");
  form.setAttribute('action',"cart.php");

  var showtime_id_form = document.createElement("input");
  showtime_id_form.setAttribute('type',"number");
  showtime_id_form.setAttribute('name','showtime_id');
  showtime_id_form.setAttribute('value',array[0]);

  var screen_id_form = document.createElement("input");
  screen_id_form.setAttribute('type',"number");
  screen_id_form.setAttribute('name','screen_id');
  screen_id_form.setAttribute('value',array[1]);

  var rem_id_form = document.createElement("input");
  rem_id_form.setAttribute('type',"text");
  rem_id_form.setAttribute('name','rem_id');
  rem_id_form.setAttribute('value',rem_id);

  form.appendChild(showtime_id_form);
  form.appendChild(screen_id_form);
  form.appendChild(rem_id_form);

  document.body.appendChild(form);
  form.submit();
}

</script>
<div id="foot">
   <a href="index.html#myBtn">FAQ</a>
   <a href="index.html#myBtn1">Location</a>
   <br><br>
   Copyright &copy 2017 Deja View Cinemas
</div>
</body>
</html>

<?php session_start(); ?>
<!DOCTYPE html>
<html>
<head>
<title>Thank You</title>
<link rel="stylesheet" href="newer_style.css">
<link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Ubuntu">
<link rel="shortcut icon" href="favicon.ico" type="image/x-icon">
</head>
<body>

  <ul>
    <li><span id="title_djc">&nbsp Deja View Cinemas &nbsp</span><li>
  <li><a href="index.html">Home</a></li>
    <li><a href="movies.php">Movies</a></li>
    <li><a href="showtimes.php">Showtimes</a></li>
        <li><a href="group_booking.php">Group Booking</a></li>
  </ul>

<img src  ="Images\thanks.png" class = "head">
<div class="page">
<div class="wrapper">

<?php
if(isset($_SESSION['valid_user']))
{
  @ $db = new mysqli('localhost', 'f32ee', 'f32ee', 'f32ee');

  if (mysqli_connect_errno()) {
     echo 'Error: Could not connect to database.  Please try again later.';
     exit;
  }


  $name=$_POST['customer_full_name'];
  $pno=$_POST['customer_phone_number'];
  $email=$_POST['customer_email_id'];
  $total=$_POST['total'];

  $query = 'update seat_reserved set paid=1 where username like "'.$_SESSION['valid_user'].'";';
  $db->query($query);

  $query = 'select count(distinct transaction_id) as no_of_transactions from transactions';
  $result = $db->query($query);
  $row = $result->fetch_assoc();
  $transaction_id = $row[no_of_transactions]+1;
  $booking_fee = 1.5;

  $n = count($_SESSION['cart']);
  for($i=0; $i<$n; $i++){
    $movie_title = $_SESSION['cart'][$i][0];
    $booking_time = date('Y-m-d H:i:s');
    $showtime_id = $_SESSION['cart'][$i][6][0];
    $amount = $_SESSION['cart'][$i][5];

    $query = 'insert into transactions values ('.$transaction_id.', '.$showtime_id.', "'.$booking_time.'", '.$amount.', "'.$movie_title.'")';
    $db->query($query);
  }

  $query = 'insert into transactions values ('.$transaction_id.', 0, "'.$booking_time.'", '.$booking_fee.', "Booking Fee")';
  $db->query($query);


//sending the email
$to      = 'f32ee@localhost';
$subject = 'Booking Confirmation';
$message = 'Hello Dear '.$_SESSION['valid_user'].",\r\n";
$message .= 'Thank You for making the following booking with us'."\r\n";
$message.="----------------------------------------------------------------\r\n";
$n = count($_SESSION['cart']);

for($i=0; $i<$n; $i++){
  $id = implode(", ", $_SESSION['cart'][$i][6]);

     $message.= str_pad('Movie Name',12," ").' : '.$_SESSION['cart'][$i][0]."\r\n";
    $message.= str_pad('Seats',12," ").' : '.implode(",",$_SESSION['cart'][$i][1])."\r\n";
       $message.= str_pad('Date',12," ").' : '.$_SESSION['cart'][$i][2]."\r\n";
       $message.= str_pad('Showtime',12," ").' : '.$_SESSION['cart'][$i][3]." hrs \r\n";
       $message.= str_pad('Screen',12," ").' : '.$_SESSION['cart'][$i][4]." Deja View NTU \r\n";
       $message.= str_pad('Total',12," ").' : $'.number_format((float)$_SESSION['cart'][$i][5], 2, '.', '')."\r\n\r\n";
       $message.="----------------------------------------------------------------\r\n";
}
$message.= "Booking Charge : $1.5 \r\n";
$message.= 'Total Bill Amount : $'.$total;


$headers = 'From: f32ee@localhost' . "\r\n" .
    'Reply-To: f32ee@localhost' . "\r\n" .
    'X-Mailer: PHP/' . phpversion();

mail($to, $subject, $message, $headers,'-ff32ee@localhost');

  unset($_SESSION['cart']);
  unset($_SESSION['valid_user']);
  session_destroy();
}
?>

<p style="text-align: center"><?php echo $name ?>, thank you for choosing Deja View Cinemas <br>
  Your booking details have been forwarded to <u><?php echo $email ?></u><br>
  Enjoy the superior movie experience at Deja View. We hope to service
  you again in the future.
</p>

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

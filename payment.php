<?php session_start(); ?>
<!DOCTYPE html>
<html>
<head>
<title>Payment</title>
<link rel="stylesheet" href="newer_style.css">
<link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Ubuntu">
<link rel="shortcut icon" href="favicon.ico" type="image/x-icon">
<script type = "text/javascript" src = "payment.js"></script>
</head>
<body>

  <ul>
      <li><span id="title_djc" style="display:block;">&nbsp Deja View Cinemas &nbsp</span></li>
  <li><a href="index.html">Home</a></li>
    <li><a href="movies.php">Movies</a></li>
    <li><a href="showtimes.php">Showtimes</a></li>
    <li><a href="group_bookings.php" >Group Booking</a></li>
  </ul>

<img src  ="Images\Payment.png" class = "head">

<div class="wrapper">
  <?php
  $n = count($_SESSION['cart']);
  $total = 0;
  for($i=0; $i<$n; $i++){
    $total += $_SESSION['cart'][$i][5];
  }
  $booking_fee = 1.5;
  $total += $booking_fee;
  echo '<font size="5"><center><b>Total Amount Due: S$ '.number_format((float)$total, 2, '.', '').'</b></center></font>';
  ?>
</div>

<div class="wrapper">
  <form action="payment_action.php" method="post">
<br>
<label class="inputs_label">Name :</label>

    <input type="text" id="name" name="customer_full_name" maxlength="30" oninput="checkName()" placeholder="Your full name.." required class="inputs">
    <span class='inputs_check' id='name_marker'></span>
    <br>
<label class ="inputs_label">Contact Number :</label>
  <input type="text" id="pno" name="customer_phone_number" maxlength="13" oninput="checkPhone()" placeholder="+65-XXXX-XXXX" required class="inputs">
  <span class='inputs_check' id='phone_marker'></span>
<br>
  <label class="inputs_label">Email Address :</label>
<input type="text" id="email" name="customer_email_id" maxlength="30" oninput="checkEmail()" placeholder="Your Email Address" required class ="inputs">
<span class='inputs_check' id='email_marker'></span>
<br>
<label class="inputs_label">Card Type :</label>
<select id="card" name="card_type" oninput="check_type(this)" required class="inputs">
      <option value="0">Select your card type</option>
      <option value="1">VISA</option>
      <option value="2">MASTERCARD</option>
      <option value="3">AMERICAN EXPRESS</option>
    </select>
    <span class='inputs_check' id='card_type_marker'></span>
<br>
<label class="inputs_label">Credit Card Number :</label>
<input type="text" id="ccno" name="credit_card_no" placeholder="XXXX-XXXX-XXXX-XXXX" oninput="cardValidate()" required class="inputs">
<span class='inputs_check' id='card_marker'></span>
<br>
<label class="inputs_label">CVV :</label>
<input type="password" maxlength="3" id="cvv" name="CVV" oninput="cvv_validate()" required class="inputs">
<span class='inputs_check' id='cvv_marker'></span>
<br>
<label class="inputs_label">Expiration Month :</label>
    <select id = "expm" name="cc_expiry_month" required class="inputs">
        <option value="0"> MM </option>
        <option value="01">January</option>
        <option value="02">February </option>
        <option value="03">March</option>
        <option value="04">April</option>
        <option value="05">May</option>
        <option value="06">June</option>
        <option value="07">July</option>
        <option value="08">August</option>
        <option value="09">September</option>
        <option value="10">October</option>
        <option value="11">November</option>
        <option value="12">December</option>
    </select>
<span class='inputs_check' id='month_marker'></span>
    <br>
    <label class="inputs_label">Expiration Year :</label>
    <select id="expy" name="cc_expiry_month" required class="inputs">
        <option value="0"> YYYY </option>
        <option value="2017"> 2017</option>
        <option value="2018"> 2018</option>
        <option value="2019"> 2019</option>
        <option value="2020"> 2020</option>
        <option value="2021"> 2021</option>
    </select>
    <span class='inputs_check' id='year_marker'></span>
    <input style="display:none" name="total" value=<?php echo $total ?>>
  <label class="inputs_label"> Pay :</label>
  <div id="submit_button" onmouseover="check_all()">
    <input type="submit" value="Submit" class="inputs">
  </div>
  <br><p id="submit_fail" style="padding-left:400px; color : red; font-weight:bold;"></p>
  </form>
</div>
<div id="foot">
   <a href="index.html#myBtn">FAQ</a>
   <a href="index.html#myBtn1">Location</a>
   <br><br>
   Copyright &copy 2017 Deja View Cinemas
</div>
</body>
</html>

<?php session_start(); ?>
<!DOCTYPE html>
<html>

<head>
    <title>Group Booking</title>
    <link rel="stylesheet" href="newer_style.css">
    <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Ubuntu">
    <link rel="shortcut icon" href="favicon.ico" type="image/x-icon">
</head>
<script src="group_booking_validate.js">
</script>

<body>
    <ul>
        <li><span id="title_djc">&nbsp Deja View Cinemas &nbsp</span></li>
                <li><a href="index.html">Home</a></li>
                <li><a href="movies.php">Movies</a></li>
                <li><a href="showtimes.php">Showtimes</a></li>
                <li><a class="active" href="group_booking.php">Group Booking</a></li>
                <li class="login_link" id="login_id"><a href="#" onclick="login()">
                <?php
       if(isset($_SESSION['valid_user']))
         echo 'Welcome, '.$_SESSION['valid_user'];
       else
         echo 'Login';
                  ?></a></li>
    </ul>
    <img src="Images\group_booking.png" class="head">
    <iframe id="portal" src="authmain.php" height="265px" width="350px"></iframe>
    <script>
        function login() {

            if (document.getElementById("portal").style.visibility == "hidden") {
                document.getElementById("portal").style.visibility = "visible";
                document.getElementById("login_id").style.backgroundColor = "#111";
            } else {
                document.getElementById("portal").style.visibility = "hidden";
                document.getElementById("login_id").style.backgroundColor = "#333";
            }
        }
    </script>
    <div class="wrapper">
        <h1>
            <center>Booking Instructions</center>
        </h1>
        <hr>
        <p style="margin-left:100px;margin-right:100px; font-size:1.25em; text-align:justify">To make a group booking please fill up the following form. Our sales team will get in touch with you shortly. Kindly provide all possible details so that we can cater to your needs as closely as possible.</p>
    </div>
    <div class="wrapper">
        <h1>
            <center>Booking Form</center>
        </h1>
        <form action="grpform_action.php" method="post">

            <hr>
            <br>
            <p class="high">Contact Information</p><br>
            <label class="inputs_label">First Name : </label>
            <input type="text" id="fname" name="customer_first_name" placeholder="Your first name.." class="inputs" oninput="validate_fname()">
            <span class='inputs_check' id='fname_marker'></span>
            <label class="inputs_label">Last Name : </label>
            <input type="text" id="lname" name="customer_last_name" placeholder="Your last name.." class="inputs" oninput="validate_lname()">
            <span class='inputs_check' id='lname_marker'></span>
            <br>
            <label class="inputs_label">Contact Number : </label>
            <input type="text" id="pno" name="customer_contact_number" placeholder="+65-XXXX-XXXX" class="inputs" onchange="validate_phone()">
            <span class='inputs_check' id='phone_marker'></span>
            <br>
            <label class="inputs_label">Email Address : </label>
            <input type="text" id="email" name="customer_email_id" placeholder="Your Email Address" class="inputs" oninput="validate_email()">
            <span class='inputs_check' id='email_marker'></span>
            <br>
            <p class="high">Booking Information</p>

            <label class="inputs_label">Date : </label>
            <input type="date" id="date" name="movie_date" class="inputs" onchange="validate_date()">
            <span class='inputs_check' id='date_marker'></span>
            <br>
            <label class="inputs_label">Time : </label>
            <select id="time" name="movie_time" class="inputs">
               <option>Select time of the day</option>
               <option value="morning">Morning</option>
               <option value="afternoon">Afternoon</option>
               <option value="evening">Evening</option>
               <option value="night">Night</option>
            </select>
            <br>
            <label class="inputs_label">Movie Title : </label>
            <select id="movie_title" name="movie_title" class="inputs">
               <option>Select movie</option>
            <?php   @ $db = new mysqli('localhost', 'f32ee', 'f32ee', 'f32ee');
               if (mysqli_connect_errno()) {
               echo 'Error: Could not connect to database.  Please try again later.';
               exit;
               }
               $query="select * from movie_detail";
               $result = $db->query($query);
               $num_results = $result->num_rows;
               for ($i=0; $i <$num_results; $i++) {
               $row = $result->fetch_assoc();
               echo '<option value="'.$row[movie_code].'">'.$row[movie_title].'</option>';
               }
               ?>
            </select>
            <br>
            <label class="inputs_label">Number of Seats : </label>
            <input type="number" id="seats" name="seats_required" min="10" max="100" class="inputs" onchange="validate_seats()">
            <span class='inputs_check' id='seats_marker'></span>
            <br>
            <label class="inputs_label">Addtional Remarks : </label>
            <textarea name="customer_comments" maxlength="256" id="remarks" rows="3" class="inputs" placeholder="Let us know if you have any special requests. (Max : 255 characters)"></textarea>
            <label class="inputs_label">Confirm : </label>
            <div id = "submit_button" onmouseover = "check_all()">
              <input type="submit" value="Submit" class="inputs">
            </div>
            <br><p id="submit_fail" style="padding-left:400px; color : red; font-weight:bold;"></p>
        </form>
    </div>
    <div id="foot">
        <a href="index.html#myBtn">FAQ</a>
        <a href="index.html#myBtn1">Location</a>
        <br><br> Copyright &copy 2017 Deja View Cinemas
    </div>
</body>

</html>

<?php
  $fname=$_POST['customer_first_name'];
  $lname=$_POST['customer_last_name'];
  $cno=$_POST['customer_contact_number'];
  $email=$_POST['customer_email_id'];
  $mdate=$_POST['movie_date'];
  $mtime=$_POST['movie_time'];
  $mtitle=$_POST['movie_title'];
  $seats=$_POST['seats_required'];
  $comment=$_POST['customer_comments'];


  @ $db = new mysqli('localhost', 'f32ee', 'f32ee', 'f32ee');

  if (mysqli_connect_errno()) {
     echo "Error: Could not connect to database.  Please try again later.";
     exit;
  }

  $query = 'insert into group_booking values("'.$fname.'","'.$lname.'","'.$cno.'","'.$email.'","'.$mdate.'","'.$mtime.'","'.$mtitle.'","'.$seats.'","'.$comment.'");';
  echo $query;
  $result= $db->query($query);


  if ($result) {
    echo "<script type='text/javascript'>alert(\"We have recieved your request.\");window.location.assign(\"index\.html\");</script>";
  } else {
  echo "<script type='text/javascript'>alert(\"Error occurred\");window.location.assign(\"group_booking\.php\");</script>";
  }
  $db->close();
?>

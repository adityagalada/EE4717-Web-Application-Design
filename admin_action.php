<?php
var_dump($_POST);
if($_POST['form_id']=='add_movie')
 {
   @ $db = new mysqli('localhost', 'f32ee', 'f32ee', 'f32ee');

   if (mysqli_connect_errno()) {
      echo 'Error: Could not connect to database.  Please try again later.';
      exit;
      }
   $query = "select max(movie_code) from movie_detail";
   $result = $db->query($query);
  $row = $result->fetch_assoc();
  $movie_code = $row["max(movie_code)"]+1;

  $query='insert into movie_detail values ( "';
  $query.= $movie_code.'" , "';
  $query.= $_POST['movie_name'].'" , "';
  $query.=$_POST['movie_synopsis'].'" , "';
  $query.=$_POST['movie_image_url'].'" , "';
  $query.=$_POST['movie_wide_image_url'].'" , "';
  $query.=$_POST['movie_trailer_url'].'" , "';
  $query.=$_POST['movie_release_date'].'" , "';
  $query.=$_POST['movie_director'].'" , "';
  $query.=$_POST['movie_cast'].'" , "';
  $query.=$_POST['movie_genre'].'" , "';
  $query.=$_POST['movie_duration'].'" , "';
  $query.=$_POST['movie_rating'].'" , "';
  $query.=$_POST['movie_language'].'")';

  $result = $db->query($query);

  echo '<script>alert("Movie Sucessfully Added to Database");
  window.top.location.href="admin.php";</script>';

   }
 else if($_POST['form_id']=='edit_movie')
 {
  @ $db = new mysqli('localhost', 'f32ee', 'f32ee', 'f32ee');

  if (mysqli_connect_errno()) {
     echo 'Error: Could not connect to database.  Please try again later.';
     exit;
     }

$query='update movie_detail set ';
$query.='movie_title = "'.$_POST['movie_name'].'" , ';
$query.='synopsis = "'.$_POST['movie_synopsis'].'" , ';
$query.='image_url = "'.$_POST['movie_image_url'].'" , ';
$query.='image_wide_url = "'.$_POST['movie_wide_image_url'].'" , ';
$query.='trailer_url = "'.$_POST['movie_trailer_url'].'" , ';
$query.='release_date = "'.$_POST['movie_release_date'].'" , ';
$query.='director = "'.$_POST['movie_director'].'" , ';
$query.='cast = "'.$_POST['movie_cast'].'" , ';
$query.='genre = "'.$_POST['movie_genre'].'" , ';
$query.='duration = "'.$_POST['movie_duration'].'" , ';
$query.='rating = "'.$_POST['movie_rating'].'" , ';
$query.='language = "'.$_POST['movie_language'].'" ';
$query.= 'WHERE movie_code = '.$_POST['movie_code'];
$result = $db->query($query);
 echo '<script>alert("Movie Updated Sucessfully"); window.top.location.href="admin.php";</script>';
}

else if($_POST['form_id']=='delete_movie')
 {
   @ $db = new mysqli('localhost', 'f32ee', 'f32ee', 'f32ee');

   if (mysqli_connect_errno()) {
      echo 'Error: Could not connect to database.  Please try again later.';
      exit;
      }
   $query = "delete from movie_detail where movie_code = ".$_POST['movie_delete'];
   $result = $db->query($query);
   $query = "delete from showtimes where movie_code = ".$_POST['movie_delete'];
      $result = $db->query($query);
      echo '<script>alert("Deleted movie and all its showtimes"); window.top.location.href="admin.php";</script>';
}

else if($_POST['form_id']=='edit_price')
 {
   @ $db = new mysqli('localhost', 'f32ee', 'f32ee', 'f32ee');

   if (mysqli_connect_errno()) {
      echo 'Error: Could not connect to database.  Please try again later.';
      exit;
      }
   $query = "update ticket_prices set price = ".$_POST['wkday_price']." where price_name = 'weekday'";
   $result = $db->query($query);
   echo $query;
   $query = "update ticket_prices set price = ".$_POST['wkend_price']." where price_name = 'weekend'";
   $result = $db->query($query);
  echo '<script>alert("Updated Prices in the database"); window.top.location.href="admin.php";</script>';
}
else if($_POST['form_id']=='add_showtime')
{
  @ $db = new mysqli('localhost', 'f32ee', 'f32ee', 'f32ee');

  if (mysqli_connect_errno()) {
     echo 'Error: Could not connect to database.  Please try again later.';
     exit;
     }


 $query = "select max(showtime_id) from showtimes";
 $result = $db->query($query);
 $row = $result->fetch_assoc();
 $showtime_id = $row["max(showtime_id)"]+1;
 $showtime = str_replace("T"," ",$_POST['showtime']);

//  find previous movie
//  $query='SELECT * FROM showtimes a JOIN movie_detail b ON a.movie_code = b.movie_code and a.screen_id = '.$_POST['add_showtime_screen'].' and a.showtime <="'.$showtime.'" order by showtime desc';
// echo $query;
// $result = $db->query($query);
// $row = $result->fetch_assoc();
// echo $row['duration'];
// $prev_start = strtotime(row['showtime']);
// $prev_end = date("Y-m-d H:i",strtotime("+".$row['duration']."minutes",$prev_start));
// $this_start = strtotime($showtime);
//
// // find next movie
// $query='SELECT * FROM showtimes a JOIN movie_detail b ON a.movie_code = b.movie_code and a.screen_id = '.$_POST['add_showtime_screen'].' and a.showtime >="'.$showtime.'" order by showtime';

 $query='insert into showtimes values ( "';
 $query.= $showtime_id.'" , "';
 $query.= $showtime.'" , "';
 $query.=$_POST['add_showtime_screen'].'" , "';
 $query.=$_POST['add_showtime_movie'].'")';

 $result = $db->query($query);

 echo '<script>alert("showtime sucessfully Added to Database");
 window.top.location.href="admin.php";</script>';
}
else if($_POST['form_id']=='delete_showtime')
{
  @ $db = new mysqli('localhost', 'f32ee', 'f32ee', 'f32ee');

  if (mysqli_connect_errno()) {
     echo 'Error: Could not connect to database.  Please try again later.';
     exit;
     }

 $query = 'delete from showtimes where showtime_id= "'.$_POST['showtime_delete'].'"';
 $result = $db->query($query);

 echo '<script>alert("showtime sucessfully deleted");
 window.top.location.href="admin.php";</script>';
}
?>

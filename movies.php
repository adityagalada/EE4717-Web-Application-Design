<?php session_start();?>
<!DOCTYPE html>
<html>
  <head>
    <title>Deja View
    </title>
    <link rel="stylesheet" href="newer_style.css">
    <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Ubuntu">
    <link rel="shortcut icon" href="favicon.ico" type="image/x-icon">
  </head>
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

  <body>
    <img src  ="Images\now_showing.png" class = "head">

    <iframe id="portal" src="authmain.php" height="240px" width="350px"></iframe>
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
      <div class="selection">
        <form action="filter.php" method="post">
          <select name="language" id="movie_language" class="movie_filters">
            <option value="*" class="movie_filters">Select Language
            </option>
            <option value="English">English
            </option>
            <option value="Mandarin">Mandarin
            </option>
            <option value="Hindi">Hindi
            </option>
            <option value="Tamil">Tamil
            </option>
          </select>
          <select id="movie_genre" class="movie_filters" name="genre">
            <option value="*">Select Genre
            </option>
            <option value="Action">Action
            </option>
            <option value="Animation">Animation
            </option>
            <option value="Comedy">Comedy
            </option>
            <option value="Drama">Drama
            </option>
            <option value="Horror">Horror
            </option>
            <option value="Thriller">Thriller
            </option>
          </select>
          <select id="movie_rating" class="movie_filters" name="rating">
            <option value="*">Select Rating
            </option>
            <option value="PG13">PG13
            </option>
            <option value="NC16">NC16
            </option>
            <option value="M18">M18
            </option>
            <option value="R21">R21
            </option>
          </select>
          <input type="submit" class="movie_filters" value="Search">
        </form>
      </div>
      <hr>
      <?php
@ $db = new mysqli('localhost', 'f32ee', 'f32ee', 'f32ee');
if (mysqli_connect_errno()) {
echo 'Error: Could not connect to database.  Please try again later.';
exit;
}
if (!isset($_COOKIE["filter_query"]))
{$query = "select * from movie_detail";
setcookie("filter_genre", "*", time() + (300), "/");
setcookie("filter_rating", "*", time() + (300), "/");
setcookie("filter_language", "*", time() + (300), "/");
}
else {
$query=$_COOKIE["filter_query"];
}
$result = $db->query($query);
$num_results = $result->num_rows;
if($num_results==0)
{echo '<center>No results found.</center>';}
for ($i=0; $i <$num_results; $i++) {
$row = $result->fetch_assoc();
echo '<a href=movie_detail.php?movie='.$row[movie_code].'>';
echo '<div class="container">';
echo '<img src='.$row[image_url].' alt="Avatar" class="image">';
echo'   <div class="overlay">';
echo '<div class="text">';
echo '<span class="title">'.$row[movie_title].'</span><br>';
echo '<span class="language">'.$row[language].'</span><br>';
echo '<span class="rating">'.$row[rating].'</span><br>';
echo '<span class="duration">'.$row[duration].' min</span><br>';
echo '</div>
</div>
</div></a>';
}
?>
    </div>
  </div>

  </body>
  <div id="foot">
     <a href="index.html#myBtn">FAQ</a>
     <a href="index.html#myBtn1">Location</a>
     <br><br>
     Copyright &copy 2017 Deja View Cinemas
  </div>
  <script type="text/javascript">
    document.getElementById('movie_rating').value=<?php echo '"'.$_COOKIE["filter_rating"].'"' ?>;
    document.getElementById('movie_genre').value=<?php echo '"'.$_COOKIE["filter_genre"].'"' ?>;
    document.getElementById('movie_language').value=<?php echo '"'.$_COOKIE["filter_language"].'"' ?>;
  </script>
</html>

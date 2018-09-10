<?php //authmain.php
include "dbconnect.php";
session_start();

if($_POST['form_id']=="logout") {
  if(isset($_SESSION['cart'])){
    unset($_SESSION['cart']);
    $query_del = 'delete from seat_reserved where username="'.$_SESSION['valid_user'].'" and paid=0';
    $dbcnx->query($query_del);
  }
  unset($_SESSION['valid_user']);
  session_destroy();
  echo '<script type=text/javascript>window.top.location.reload(); </script> ';
  header('Location : authmain.php');
}
else if($_POST['form_id']=="register")
{  if (isset($_POST['submit'])) {
	   if (empty($_POST['username']) || empty ($_POST['password'])
		   || empty ($_POST['password2']) ) {
	        echo "All records to be filled in";}
	       }
$username = $_POST['username'];
$password = $_POST['password'];
$password2 = $_POST['password2'];

// echo ("$username" . "<br />". "$password2" . "<br />");
if ($password != $password2) {
	echo "Sorry passwords do not match";
	exit;
	}
$password = md5($password);
// echo $password;
$sql = "INSERT INTO users (username, password)
		VALUES ('$username', '$password')";
//	echo "<br>". $sql. "<br>";
$result = $dbcnx->query($sql);

}
else if($_POST['form_id']=="login")
  {  if (isset($_POST['userid']) && isset($_POST['password']))
    {
      // if the user has just tried to log in
      $userid = $_POST['userid'];
      $password = $_POST['password'];

    $password = md5($password);
      $query = 'select * from users '
               ."where username='$userid' "
               ." and password='$password'";
    // echo "<br>" .$query. "<br>";
      $result2 = $dbcnx->query($query);
      if ($result2->num_rows >0 )
      {
        // if they are in the database register the user id
        $_SESSION['valid_user'] = $userid;
          echo '<script type=text/javascript>window.top.location.reload(); </script> ';
      }
      $dbcnx->close();
    }
}
?>

<html>
  <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Ubuntu">
<style>
body{
  background-color: #111;
  color: #EEE;
  font-family: Ubuntu;
}
button, input[type=submit] {
  background-color: #AAA;
  display: inline-block;
  margin: 5px;
  margin-top: 10px;
  color: black;
  cursor: pointer;
}

button:hover, input[type=submit]:hover {
  background-color: #45a049;
}
td
{text-align: right;}
</style>
<body>
  <center>
<h2>Deja View Account</h2>
<?php
  if(isset($result)){
    if (!$result)
    echo "Your query failed.";
    else
      echo "Welcome ". $username . ". You are now registered";
        echo '<form method="post" action="authmain.php">';
      echo '<input type="submit" value="Back To Login">';
      echo '</form>';
  }
  else if (isset($_SESSION['valid_user']))
  {
    echo 'You are logged in as: '.$_SESSION['valid_user'].' <br />';
    echo '<button onclick="cart()";>View Cart</button> &nbsp ';
    echo '<form method="post" action="authmain.php">';
    echo '<input type="text" name="form_id" value="logout" style="display:none">';
    echo '<input type="submit" value="Logout">';
    echo '</form>';
  }
  else
  {
    if (isset($userid))
    {
      // if they've tried and failed to log in
      echo 'Could not log you in.<br />';
    }
    else
    {
      // they have not tried to log in yet or have logged out
      echo 'You are not logged in.<br><br>';
    }
    echo '<input type="radio" name="account_option" id="sign_up" onchange="display()"> Sign Up  ';
    echo '<input type="radio" name="account_option" id="log_in" onchange="display()"> Login <br>';
    // provide form to log in
    echo '<form method="post" action="authmain.php">';
    echo '<input type="text" name ="form_id" value="login" style="display:none">';
    echo '<table id="login_table" style="display: none">';
    echo '<tr><td>Username : </td>';
    echo '<td><input type="text" name="userid"></td></tr>';
    echo '<tr><td>Password : </td>';
    echo '<td><input type="password" name="password"></td></tr>';
    echo '<tr><td colspan="2" align="center">';
    echo '<input type="submit" value="Log in"></td></tr>';
    echo '</table></form>';

    // provide form to reg
    echo '<form method="post" action="authmain.php">';
    echo '<input type="text" name ="form_id" value="register" style="display:none">';
    echo '<table id="signup_table" style="display: none">';
    echo '<tr><td>Username : </td>';
    echo '<td><input type="text" name="username"></td></tr>';
    echo '<tr><td>Password : </td>';
    echo '<td><input type="password" name="password"></td></tr>';
    echo '<tr><td>Password : </td>';
    echo '<td><input type="password" name="password2"></td></tr>';
    echo '<tr><td colspan="2" align="center">';
    echo '<input type="submit" value="Sign up"></td></tr>';
    echo '</table></form>';
  }
?>
</body>
</center>
<script type="text/javascript">
  function display(){
    if (document.getElementById("sign_up").checked){
      document.getElementById("signup_table").style.display="inline-block";
      document.getElementById("login_table").style.display="none";
    }
    else if(document.getElementById("log_in").checked){
      document.getElementById("signup_table").style.display="none";
      document.getElementById("login_table").style.display="inline-block";
    }
  }

  function cart()
  {top.window.location.href="cart.php";}
</script>
</html>

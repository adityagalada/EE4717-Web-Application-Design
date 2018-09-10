<?php
@ $db = new mysqli('localhost', 'f32ee', 'f32ee', 'f32ee');
  if (mysqli_connect_errno()) {
  echo 'Error: Could not connect to database.  Please try again later.';
  exit;
  }
   $query="insert into test values (now(),".mt_rand(0,10).")";
   echo $query;
   $db->query($query);
?>

<script>
setTimeout(function(){
   window.location.reload(1);
}, 100);
</script>

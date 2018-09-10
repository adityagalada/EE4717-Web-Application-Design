
<?php
$flag = 0;
$query = 'select * from movie_detail where ';

if ($_POST["genre"] != "*")
{
	$flag = $flag + 1;
	$query.= ' genre like "%' . $_POST["genre"] . '%"';
}

$cookie_name = "filter_genre";
$cookie_value = $_POST["genre"];
setcookie($cookie_name, $cookie_value, time() + (300) , "/"); // 86400 = 1 day

if ($_POST["rating"] != "*")
{
	if ($flag > 0)
	{
		$query.= ' and ';
	}

	// echo $_POST["genre"];

	$query.= ' rating like "' . $_POST["rating"] . '"';
	$flag = $flag + 1;
}

$cookie_name = "filter_rating";
$cookie_value = $_POST["rating"];
setcookie($cookie_name, $cookie_value, time() + (300) , "/"); // 86400 = 1 day

if ($_POST["language"] != "*")
{
	if ($flag > 0)
	{
		$query.= ' and ';
	}

	// echo $_POST["genre"];

	$query.= ' language like "' . $_POST["language"] . '"';
	$flag = $flag + 1;
}

$cookie_name = "filter_language";
$cookie_value = $_POST["language"];
setcookie($cookie_name, $cookie_value, time() + (300) , "/"); // 86400 = 1 day

if ($flag == 0)
{
	$query.= '1';
}

$query.= ';';
echo $query;
$cookie_name = "filter_query";
$cookie_value = $query;
setcookie($cookie_name, $cookie_value, time() + (30) , "/"); // 86400 = 1 day
header('Location: ' . 'movies.php');
?>

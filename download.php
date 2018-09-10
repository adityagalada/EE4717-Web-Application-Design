<?php
$filename = "toy_csv.csv";
$fp = fopen('php://output', 'w');

$query = "SELECT COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS AND TABLE_NAME='showtimes'";
$result = mysql_query($query);
while ($row = mysql_fetch_row($result)) {
	$header[] = $row[0];
}
header('Content-type: application/csv');
header('Content-Disposition: attachment; filename='.$filename);
fputcsv($fp, $header);

$num_column = count($header);
$query = "SELECT * FROM showtimes";
$result = mysql_query($query);
while($row = mysql_fetch_row($result)) {
	fputcsv($fp, $row);
}
exit;
?>

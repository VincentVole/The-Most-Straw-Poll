#!/usr/local/bin/php -d display_errors=STDOUT 
<?php print '<?xml version = "1.0" encoding="utf-8"?> ';
	print "\n";
print '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN"';
print "\n";
print '"http://www.w3.org/TR/xhtml1/DTD/xhtml11.dtd">';
print "\n";
?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="application/xhtml+xml; charset=utf-8"/>
<title>Poll</title>
<link rel="stylesheet" type="text/css" href="strawpoll.css"/>
</head>
<body>
<div id="logo"><h1 id="home"><a href='http://pic.ucla.edu/~ureshineko/final_project/strawpoll.html'>The Most Straw Poll</a></h1></div>
<div id="container">

<?php

try{
	$db = new SQLite3('strawpoll.db');
}
catch (Expection $exception){
	echo '<p>There was an error connecting to the database!</p>';

    if ($db)
    {
        echo $exception->getMessage();
    }
}

$table = "poll_" . $_GET["id"];
$sql = "PRAGMA table_info($table)";
$result = $db -> query($sql);
$result_ar = [];

print "<h2>" . $result -> fetchArray()[1] . "</h1>";

while ( $record = $result -> fetchArray()) {
	$sql_2 = "SELECT [" . $record[1] . "] FROM " . $table;
	$result_2 = $db -> query($sql_2) -> fetchArray()[0];
	array_push($result_ar, $record[1], $result_2);
	$max_votes += $result_2;
	//print '<div class="result_bar">' . $record[1] . ": " . $result_2 . "</div>";
}

for ($i=0; $i < sizeof($result_ar)/2; $i++) { 
	if($result_ar[($i * 2) + 1] == 1){
		print '<div>' . $result_ar[$i * 2] . ": " . $result_ar[($i * 2) + 1] . " vote</div>";
	}
	else {
		print '<div>' . $result_ar[$i * 2] . ": " . $result_ar[($i * 2) + 1] . " votes</div>";
	}
	
	print '<div class="result_bar" style="width:' . $result_ar[($i * 2) + 1]/$max_votes * 100 . '%;"></div>';
}




?>
</div>

</body>
</html>

#!/usr/local/bin/php -d display_errors=STDOUT 
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
if(empty($_COOKIE["poll_" . $_GET["id"]]) && isset($_GET["poll"]) && isset($_GET["id"])){
	

	$sql = "SELECT [" . $_GET["poll"] . "] FROM poll_" . $_GET["id"];

	$current_vote = $db -> query($sql) -> fetchArray()[0];
	$current_vote++;

	$sql = "UPDATE poll_" . $_GET["id"] . " SET [" . $_GET["poll"] . '] = "' . $current_vote . '"';
	$result = $db -> query($sql);
	setcookie("poll_" . $_GET["id"], "voted");
	$first_time = true;
}

print '<?xml version = "1.0" encoding="utf-8"?> ';
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
if(empty($_GET["poll"])){
	$table = "poll_" . $_GET["id"];

	$sql = "PRAGMA table_info($table)";

	$result = $db -> query($sql);

	print "<h2>" . $result -> fetchArray()[1] . "</h2>";
	print '<form action="#" method="get">';
	print "<p>";

	while ( $record = $result -> fetchArray()) {
		print '<input type="radio" name="poll" value="' . $record[1] . '" id="' . $record[1] . '"/>';
		print '<label for="' . $record[1] . '">' . $record[1] . "</label>";
		print "<br/>";
	}

	print "</p>";

	print '<button id="vote">Submit</button>';

	print '<input id="id_pass" type="radio" name="id" checked="true" value="' . $_GET["id"] . '"/>';

	print "<br/>";

	print "<p>Share this poll with friends!</p>";

	print '<p>Link: <a href="http://pic.ucla.edu/~ureshineko/final_project/poll.php?id=' . $_GET["id"] . '">http://pic.ucla.edu/~ureshineko/final_project/poll.php?id=' . $_GET["id"] . "</a></p>";
}
elseif ($_COOKIE["poll_" . $_GET["id"]] = "voted" && empty($first_time)) {
	print "<p>You cannot vote on a poll twice.</p>";
}
elseif (isset($_GET["poll"]) && isset($_GET["id"])) {
	/*
	$sql = "SELECT " . $_GET["poll"] . " FROM poll_" . $_GET["id"];

	$current_vote = $db -> query($sql) -> fetchArray()[0];
	$current_vote++;

	$sql = "UPDATE poll_" . $_GET["id"] . " SET [" . $_GET["poll"] . '] = "' . $current_vote . '"';
	$result = $db -> query($sql);
	*/
	print '<p>Poll results available at: <a href="http://pic.ucla.edu/~ureshineko/final_project/result.php?id=' .  $_GET["id"] . '">http://pic.ucla.edu/~ureshineko/final_project/result.php?id=' . $_GET["id"] . '</a></p>';


}

?>


	
</div>



</body>
</html>

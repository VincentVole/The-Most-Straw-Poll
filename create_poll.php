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

$sql = "SELECT id FROM poll_id";

$poll_id_ar = [];

$result = $db -> query($sql);
while ( $record = $result -> fetchArray()) {
	array_push($poll_id_ar, $record["id"]);
}

$poll_id = sizeof($poll_id_ar);
$poll_id++;
$poll_name = "poll_" . $poll_id;

$sql = "CREATE TABLE IF NOT EXISTS $poll_name(";

for ($i=0; $i < sizeof($_GET); $i++) { 
	$field = $_GET["field$i"];
	$sql .= "[" . $field . "]" .  " int(9)";
	if ($i < sizeof($_GET) - 1) {
		$sql .= ", ";
	}
}

$sql  .= ");";

$result = $db -> query($sql);
//print $sql;

$sql = "INSERT INTO poll_id(id) values($poll_id)";

$result = $db -> query($sql);

$sql = "INSERT INTO $poll_name(";
for ($i=0; $i < sizeof($_GET); $i++) { 
	if($i != 0){
		$field = $_GET["field$i"];
		$sql .= "[" . $field . "]";
		if ($i < sizeof($_GET) - 1) {
			$sql .= ", ";
		}
	}
}
$sql .= ") VALUES (";
for ($i=0; $i < sizeof($_GET) - 1; $i++) { 
	$sql .= "0";
	if ($i < sizeof($_GET) - 2) {
		$sql .= ", ";
	}
}
$sql .= ")";

$result = $db -> query($sql);


print $poll_id;



/*										EXTRACTING FIELDNAMES FROM A TABLE
$sql = "PRAGMA table_info(poll_1)";

$result = $db -> query($sql);
$field_names_str = "";
while ( $record = $result -> fetchArray()) {
	$field_names_str .= $record[1];
}

print $field_names_str;
*/

?>
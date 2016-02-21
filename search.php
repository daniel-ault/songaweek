

<?php

echo $_POST["search"];
echo "<br>\r\n";

$conn = connect_database();

# search artists

$query = "SELECT * FROM artists WHERE name LIKE \"%{$_POST["search"]}%\";";
$result = $conn->query($query);

$items;


if ($result->num_rows > 0) {
	while ($row = $result->fetch_assoc()) {
		$items[] =  array(create_link($row["name"], "/profile/{$row["id"]}"));
	}
}
else {
	$items[] = array('No results found :(');
}

create_table(array("Artists"), $items);



#search songs

unset($items);

$query = "SELECT * FROM songs WHERE title LIKE \"%{$_POST["search"]}%\";";
$result = $conn->query($query);

if ($result->num_rows > 0) {
	while ($row = $result->fetch_assoc()) {	
		$items[] = array( create_link($row["title"], $row["url"]));
	}
}
else {
	$items[] = array('No results found :(');
}

create_table(array("Submissions"), $items);


$conn->close();


?>

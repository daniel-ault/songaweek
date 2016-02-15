

<?php

echo $_POST["search"];
echo "<br>\r\n";

$conn = connect_database();

# search artists

echo "<h2>Artists</h2>\r\n";


$query = "SELECT * FROM artists WHERE name LIKE \"%{$_POST["search"]}%\";";
$result = $conn->query($query);

echo "<ul>\r\n";

if ($result->num_rows > 0) {
	while ($row = $result->fetch_assoc()) {
		echo "<li>\r\n";
		echo create_link($row["name"], "/profile/{$row["id"]}") . "\r\n";
		echo "</li>\r\n";
	}
}
else {
	echo 'No results found :(';
}

echo "</ul>\r\n";


#search songs

echo "<h2>Submissions</h2>\r\n";

$query = "SELECT * FROM songs WHERE title LIKE \"%{$_POST["search"]}%\";";
$result = $conn->query($query);

echo "<ul>\r\n";

if ($result->num_rows > 0) {
	while ($row = $result->fetch_assoc()) {	
		echo "<li>\r\n";
		echo create_link($row["title"], $row["url"]) . "\r\n";
		echo "</li>\r\n";
	}
}
else {
	echo 'No results found :(';
}

echo "</ul>\r\n";

$conn->close();


?>

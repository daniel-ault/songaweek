<?php

$conn = connect_database(); 

$query = "SELECT name FROM artists WHERE id={$_GET["id"]};";
$result = $conn->query($query);
$info = $result->fetch_assoc();

echo '<h2>';
echo $info["name"];
echo '</h2>';


#$query = "SELECT * FROM artists WHERE id={$_GET["id"]};";
$query = <<<EOT
SELECT name, url
FROM accounts
INNER JOIN supported_sites
ON site_id=supported_sites.id
WHERE artist_id={$_GET["id"]};
EOT;

$result = $conn->query($query);

echo "<p>\r\n";
while ($row = $result->fetch_assoc()) {
	echo create_link($row["name"], $row["url"]);
	echo "<br>\r\n";
}

echo "</p>\r\n";


$query = "SELECT * FROM songs WHERE artist_id={$_GET["id"]};";
$result = $conn->query($query);

echo "<h3>Submissions</h3>";

echo '<p>';
while ($row = $result->fetch_assoc()) {
	$title = $row["title"];
	if (strlen($title) == 0)	
		$title = $row["url"];
	echo create_link($title, $row["url"]);
	echo "<br>\r\n";
}
echo '</p>';


$conn->close();


?>

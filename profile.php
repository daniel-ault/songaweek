<?php

$conn = connect_database(); 

$query = "SELECT name FROM artists WHERE id={$_GET["id"]};";
$result = $conn->query($query);
$info = $result->fetch_assoc();




#$query = "SELECT * FROM artists WHERE id={$_GET["id"]};";
$query = <<<EOT
SELECT name, url
FROM accounts
INNER JOIN supported_sites
ON site_id=supported_sites.id
WHERE artist_id={$_GET["id"]};
EOT;

$result = $conn->query($query);

echo "<table class=\"table\">\r\n";
echo "<thead><th>" . $info["name"] . "</th></thead>\r\n";
echo "<tbody>\r\n";

while ($row = $result->fetch_assoc()) {
	echo "<tr><td>" . create_link($row["name"], $row["url"]) . "</td></tr>\r\n";
}
echo "</tbody>\r\n";

echo "</table>\r\n";


$query = "SELECT * FROM songs WHERE artist_id={$_GET["id"]};";
$result = $conn->query($query);

echo "<table class=\"table\">\r\n";
echo "<thead><th>Submissions</th></thead>\r\n";
echo "<tbody>\r\n";

while ($row = $result->fetch_assoc()) {
	$title = $row["title"];
	if (strlen($title) == 0)	
		$title = $row["url"];
	echo "<tr><td>" . create_link($title, $row["url"]) . "</td></tr>\r\n";
}
echo "</tbody>\r\n";
echo '</table>';


$conn->close();


?>

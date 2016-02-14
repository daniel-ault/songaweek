

<?php


$conn = connect_database();
$query = <<<EOT
SELECT artist_id, title, url, name 
FROM songs
INNER JOIN artists
ON songs.artist_id = artists.id 
ORDER BY RAND() LIMIT 1;
EOT;

$result = $conn->query($query)->fetch_assoc();

echo create_link($result["name"], "/profile/{$result["artist_id"]}");
echo "<br>\r\n";
echo create_link($result["title"], $result["url"]);

'
foreach($result->fetch_assoc() as $item) {
	echo "$item <br>";
}
';

#print_r($result->fetch_assoc());

$conn->close();


?>



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

$head_artist = array("Artist");
$item_artist[] = array(create_link($result["name"], "/profile/{$result["artist_id"]}"));

create_table($head_artist, $item_artist);


$head_songs = array("Submissions");
$item_songs[] = array(create_link($result["title"], $result["url"]));

create_table($head_songs, $item_songs);

'
foreach($result->fetch_assoc() as $item) {
	echo "$item <br>";
}
';

#print_r($result->fetch_assoc());

$conn->close();


?>

<?php

$conn = connect_database(); 

$query = "SELECT * FROM artists WHERE id={$_GET["id"]};";

$result = $conn->query($query);

$info = $result->fetch_assoc();

echo '<h2>';
echo $info["name"];
echo '</h2>';

echo '<p>';
if ($info["youtube"])
	echo create_link("Youtube", $info["youtube"]);
echo '<br>';
if ($info ["soundcloud"]) 
	echo create_link("Soundcloud", $info["soundcloud"]);
echo '</p>';


$query = "SELECT * FROM songs WHERE artist_id={$_GET["id"]};";
$result = $conn->query($query);

echo "<h3>Songs</h3>";

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


<!--
Sort by: <br>
<a class="btn btn-primary btn-large" href="title">Title</a>
<a class="btn btn-primary btn-large" href="artist">Artist</a>
<a class="btn btn-primary btn-large" href="week">Week</a>
<br>
-->

<?php

$conn = connect_database();
$sort = "";
if ($_GET["sort"] == "title") 
	$sort = "ORDER BY title ";
else if ($_GET["sort"] == "artist") 
	$sort = "ORDER BY name";
else if ($_GET["sort"] == "week") 
	$sort = "ORDER BY week, title";
	
$query = "SELECT title, week, url, name, artist_id FROM songs INNER JOIN artists ON songs.artist_id = artists.id $sort;";
$result = $conn->query($query);

$song_head = "Submission";
$artist_head = "Artist";
$week_head = "Week";

$down_arrow = "&#x25BE";

if ($_GET["sort"] == "title")
	$song_head = $song_head . $down_arrow;
if ($_GET["sort"] == "artist")
	$artist_head = $artist_head . $down_arrow;
if ($_GET["sort"] == "week")
	$week_head = $week_head . $down_arrow;

#echo '<ul>';
echo <<<EOT
<table class="table">
	<thead>
		<tr>
			<th><a href="/songs/title">$song_head</a></th>
			<th><a href="/songs/artist">$artist_head</a></th>
			<th><a href="/songs/week">$week_head</a></th>
		</tr>
	</thead>
	<tbody>
EOT;


while ($row = $result->fetch_assoc()) {
	$title = $row["title"];
	if (strlen($title) == 0)	$title = $row["url"];
	$week = $row["week"];
	$artist = $row["name"];
	$artist_id = $row["artist_id"];
	$url = $row["url"];

	echo <<<EOT
		<tr>
			<td><a href="$url">$title</a></td>
			<td><a href="/profile/$artist_id">$artist</a></td>
			<td>$week</td>
		<tr>
EOT;
	#echo "<b>" . create_link($title, $row["url"]). "</b>";
	#echo "<br>\r\n";
}

echo <<<EOT
	</tbody>
</table>
EOT;

#echo '</ul>';


$conn->close();

?>

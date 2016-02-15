
<!--
Sort by: <br>
<a class="btn btn-primary btn-large" href="title">Title</a>
<a class="btn btn-primary btn-large" href="artist">Artist</a>
<a class="btn btn-primary btn-large" href="week">Week</a>
<br>
-->

<?php


$song_head = "Submission";
$artist_head = "Artist";
$week_head = "Week";
$site_head = "Site";

$down_arrow = "&#x25BE";

if ($_GET["sort"] == "title")
	$song_head = $song_head . $down_arrow;
if ($_GET["sort"] == "artist")
	$artist_head = $artist_head . $down_arrow;
if ($_GET["sort"] == "week")
	$week_head = $week_head . $down_arrow;
if ($_GET["sort"] == "site")
	$site_head = $site_head . $down_arrow;

#echo '<ul>';
echo <<<EOT
<table class="table">
	<thead>
		<tr>
			<th><a href="/songs/title">$song_head</a></th>
			<th><a href="/songs/artist">$artist_head</a></th>
			<th><a href="/songs/week">$week_head</a></th>
			<th><a href="/songs/site">$site_head</a></th>
		</tr>
	</thead>
	<tbody>
EOT;


$conn = connect_database();

$sort = "";
if ($_GET["sort"] == "title") 
	$sort = "ORDER BY title ";
else if ($_GET["sort"] == "artist") 
	$sort = "ORDER BY artist_name";
else if ($_GET["sort"] == "week") 
	$sort = "ORDER BY week, title";
else if ($_GET["sort"] == "site")
	$sort = "ORDER BY site_name, title";

$query = <<<EOT
SELECT title, week, url, artist_id, artists.name AS artist_name, supported_sites.name AS site_name
FROM songs 
INNER JOIN artists 
ON songs.artist_id = artists.id 
INNER JOIN supported_sites
ON songs.site_id = supported_sites.id
$sort;
EOT;

$result = $conn->query($query);

echo $conn->error;

while ($row = $result->fetch_assoc()) {
	$title = $row["title"];
	if (strlen($title) == 0)	$title = $row["url"];
	$week = $row["week"];
	$artist = $row["artist_name"];
	$artist_id = $row["artist_id"];
	$url = $row["url"];
	$site = $row["site_name"];

	echo <<<EOT
		<tr>
			<td><a href="$url">$title</a></td>
			<td><a href="/profile/$artist_id">$artist</a></td>
			<td>$week</td>
			<td>$site</td>
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

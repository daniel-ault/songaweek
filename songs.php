DEV BRANCH

<?php

$conn = connect_database();

$song_head = "Submission";
$artist_head = "Artist";
$week_head = "Week";
$site_head = "Site";

$down_arrow = "&#x25BE";

if (!isset($_GET["sort"])) {
	$_GET["sort"] = "none";
}

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
		<!---	<th><a href="/songs/site">$site_head</a></th>-->
		</tr>
	</thead>
	<tbody>
EOT;

$site_id;
if (isset($_GET["filter"]) and $_GET["sort"] == "site") {
	$query = "SELECT id FROM supported_sites WHERE name='{$_GET["filter"]}';";
	$result = $conn->query($query);
	$site_id = $result->fetch_assoc()["id"];
}

$sort = "";
if ($_GET["sort"] == "title") 
	$sort = "ORDER BY title ";
else if ($_GET["sort"] == "artist") 
	$sort = "ORDER BY artist_name";
else if ($_GET["sort"] == "week") { 
	$sort = "ORDER BY week, title";
	if (isset($_GET["filter"]))
		$sort = "WHERE week={$_GET["filter"]} " . $sort;
}
else if ($_GET["sort"] == "site") {
	$sort = "ORDER BY site_name, title";
	if (isset($_GET["filter"]))
		$sort = "WHERE site_id=$site_id " . $sort;
}

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
	if (strlen($title) == 0)	$title = "Error: title not found";
	$week = $row["week"];
	$artist = $row["artist_name"];
	$artist_id = $row["artist_id"];
	$url = $row["url"];
	$site = $row["site_name"];

	echo <<<EOT
		<tr>
			<td class="submission"><a href="$url">$title</a></td>
			<td><a href="/profile/$artist_id">$artist</a></td>
			<td>$week</td>
		<!---	<td>$site</td>-->
		</tr>
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

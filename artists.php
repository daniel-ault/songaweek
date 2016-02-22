<?php

$conn = connect_database();
$query = "SELECT * FROM artists ORDER BY name;";
$result = $conn->query($query);

echo <<<EOT
<table class="table">
	<thead>
		<th>Artists</th>
	</thead>
	<tbody>

EOT;


while ($row = $result->fetch_assoc()) {
	echo "			<tr><td>" . create_link($row["name"], "/profile/{$row["id"]}");
	echo "</td></tr>\r\n";
}

echo <<<EOT
	</tbody>
</table>
EOT;



$conn->close();

?>

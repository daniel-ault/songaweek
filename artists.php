<?php

$conn = connect_database();
$query = "SELECT * FROM artists ORDER BY name;";
$result = $conn->query($query);


while ($row = $result->fetch_assoc()) {
	echo "<b>" . create_link($row["name"], "/profile/{$row["id"]}") . "</b>";
	echo "<br>\r\n";
}



$conn->close();

?>

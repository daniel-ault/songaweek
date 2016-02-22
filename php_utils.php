<?php

function create_link($text, $url) {
	return "<a href=\"{$url}\">{$text}</a>";
}

function connect_database() {
	$hostname = 'localhost';
	$username = 'php';
	$password = '';
	$database = 'saw';

	$conn = new mysqli($hostname, $username, $password, $database);

	if ($conn->connect_error) {
		die("Connection Error: " . $conn->connect_error);
	}

	return $conn;
}

function endswith($string, $test) {
	$strlen = strlen($string);
	$testlen = strlen($test);
	if ($testlen > $strlen) return false;
	
	return substr_compare($string, $test, $strlen-$testlen, $testlen) === 0;
} 

function strip_end_slash($string) {
	if (endswith($string, "/")) {
		return substr($string, 0, strlen($string)-1);
	}
	else return $string;
}


# $items variable must be a two-dimensional array where the first column
# is the text and the second column is the urls each item links to
#
# Button types:
# btn-default
# btn-primary
# btn-success
# btn-info
# btn-warning
# btn-danger
# btn-link
function create_drop_list($title, $items, $btn_type) {
	
	echo <<<EOT
<div class="btn-group">
	<button 
			class="btn $btn_type btn-dropdown" 
			type="button" data-toggle="dropdown">
		$title
	<span class="caret"></span></button>
	<ul class="dropdown-menu">

EOT;

	foreach($items as $item) {
		echo "		<li><a href=\"{$item["url"]}\">{$item["text"]}</a></li>\r\n";
	}

	echo <<<EOT
	</ul>
</div>
EOT;
}

function create_week_drop_list($title, $max_week, $btn_type) {
	$items[] = array("text"=>"All weeks", "url"=>"/songs/week/");
	for ($i=1; $i<=$max_week; $i++) {
		$items[] = array("text"=>$i, "url"=>"/songs/week/$i");
	}

	create_drop_list($title, $items, $btn_type);
}


function create_site_drop_list($title, $btn_type) {
	$conn = connect_database();
	$query = "SELECT name FROM supported_sites;";
	$result = $conn->query($query);

	$items[] = array("text"=>"All sites", "url"=>"/songs/site");

	while ($row = $result->fetch_assoc()) {
		$url = "/songs/site/" . strtolower(trim($row["name"]));
		$items[] = array("text"=>$row["name"], "url"=>$url);
	}
	
	create_drop_list($title, $items, $btn_type);
	
	$conn->close();
}

function create_filter_drop_lists() {
	$conn = connect_database();
	
	$query = "SELECT MAX(week) AS max_week FROM songs;";
	$result = $conn->query($query);
	
	$max_week = $result->fetch_assoc()["max_week"];
	$button_week_title = "Filter by week";
	$button_site_title = "Filter by site";
	
	
	if (isset($_GET["filter"]) and $_GET["sort"] == "week")
		$button_week_title = "Week {$_GET["filter"]}";
	if (isset($_GET["filter"]) and $_GET["sort"] == "site")
		$button_site_title = $_GET["filter"];

	$btn_type = "btn-primary dropdown-menu-right";
	#$btn_type = "btn-primary";

	echo "<div class=\"btn-group pull-right\">\r\n";
	create_week_drop_list($button_week_title, $max_week, $btn_type);
	create_site_drop_list($button_site_title, $btn_type);
	echo "</div>\r\n";

	$conn->close();
}


function create_table($head, $rows) {
	echo <<<EOT
	<table class="table">
		<thead>
			<tr>

EOT;
	
	foreach($head as $item) {
		echo <<<EOT
				<th>$item</th>
EOT;
	}

	echo <<<EOT
			</tr>
		</thead>
		<tbody>

EOT;

	foreach($rows as $row) {
		echo "			<tr>";
		foreach($row as $item) {
			echo "				<td>$item</td>";
		}
		echo "			</tr>";
	}

	echo <<<EOT
		</tbody>
	</table>
EOT;
}

?>

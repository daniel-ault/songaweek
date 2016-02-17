LOOK IT WORKED
<br>

<p>

<?php

echo create_link("Artists", "/artists/");
echo "<br>\r\n";
echo create_link("Submissions", "/songs/");
echo "<br>\r\n";

$test[] = array();

for ($i=1; $i<=10; $i++) {
	array_push($test, array("test"=>$i, "test2"=>($i+7)));
}

foreach($test as $i) {
	echo $i["test"].'<br>';
	echo $i["test2"].'<br>';
}

?>



</p>

<p>

<?php

echo create_link("Artists", "/artists/");
echo "<br>\r\n";
echo create_link("Submissions", "/songs/");
echo "<br>\r\n";

for ($i=0; $i<1000; $i++) {
	echo 'test<br>';
}

?>

<a href="/" class="btn btn-info" role="button">Link Button</a>
<button type="button" class="btn btn-info"><a href="/">Button</a></button>


</p>

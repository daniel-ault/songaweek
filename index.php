<!DOCTYPE html>
<html lang="en">

<?php include 'head.php'?>
  

<body>

<div class="container-fluid">
	<div class="row">
		<div class="col-md-12">
			<?php include 'navbar.php'?>
			<div class="jumbotron">
				<?php
					if (!empty($_GET["page"])) {
						$page = $_GET["page"];
						$page = strip_end_slash($page);
						include "$page.php";
					}
					else {
						include "main.php";
					}
				?>
				<p>
					<!--
					<a class="btn btn-primary btn-large" href="#">Learn more</a>
					-->
				</p>
			</div>
		</div>
	</div>
</div>

    <script src="../../js/jquery.min.js"></script>
    <script src="../../js/bootstrap.min.js"></script>
    <script src="../../js/scripts.js"></script>
  </body>
</html>

<nav class="navbar navbar-default" role="navigation">
	<div class="navbar-header">
		 
		<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
			 <span class="sr-only">Toggle navigation</span><span class="icon-bar"></span><span class="icon-bar"></span><span class="icon-bar"></span>
		</button> <a class="navbar-brand" href="http://www.songaweek2016.com">Home</a>
	</div>
	
	<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
		<ul class="nav navbar-nav">
			
			<?php   
				if ($_GET["page"] == "songs")
					echo '<li class="active">';
				else
					echo '<li>';
			?>
				<a href="/songs/week">Submissions</a>
			</li>
			
			<?php   
				if ($_GET["page"] == "artists")
					echo '<li class="active">';
				else
					echo '<li>';
			?>	
				<a href="/artists/">Artists</a>
			</li>

			<?php   
				if ($_GET["page"] == "shuffle")
					echo '<li class="active">';
				else
					echo '<li>';
			?>
				<a href="/shuffle">Random Submission</a>
			</li>
			<!--
			<li class="dropdown">
				 <a href="#" class="dropdown-toggle" data-toggle="dropdown">Dropdown<strong class="caret"></strong></a>
				<ul class="dropdown-menu">
					<li>
						<a href="#">Action</a>
					</li>
					<li>
						<a href="#">Another action</a>
					</li>
					<li>
						<a href="#">Something else here</a>
					</li>
					<li class="divider">
					</li>
					<li>
						<a href="#">Separated link</a>
					</li>
					<li class="divider">
					</li>
					<li>
						<a href="#">One more separated link</a>
					</li>
				</ul>
			</li>
			
		</ul>
		-->

		
		<form class="navbar-form navbar-left" action="/search" method="post">
			<div class="form-group">
				<input type="text" class="form-control" name="search">
			</div> 
			<button type="submit" class="btn btnText">
				Search
			</button>
		</form>

		<?php 
			if ($_GET["page"] == "songs")
				create_filter_drop_lists();
		?>

		<!--
		<ul class="nav navbar-nav navbar-right">
			<li>
				<a href="#">Link</a>
			</li>
			<li class="dropdown">
				 <a href="#" class="dropdown-toggle" data-toggle="dropdown">Dropdown<strong class="caret"></strong></a>
				<ul class="dropdown-menu">
					<li>
						<a href="#">Action</a>
					</li>
					<li>
						<a href="#">Another action</a>
					</li>
					<li>
						<a href="#">Something else here</a>
					</li>
					<li class="divider">
					</li>
					<li>
						<a href="#">Separated link</a>
					</li>
				</ul>
			</li>
		</ul>
		-->
	</div>
	
</nav>

<!DOCTYPE html>
<html lang="en">

<?php include 'head.php'?>
  

<body>

<?php include 'navbar.php'?>
<div class="main wrapper clearfix">
	<div class="row">
		<div class="col-md-12">
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


<footer class="pageFooter">
    <div class="wrapper clearfix">
        <div class="responsivecolumns columns-two-50-50">
           <div class="column columns-two-left">
                <div id="page-zones__template-widgets__content-footercolumn1content1" class="widget content " data-widget-type="content" data-uniqueid="page-zones__template-widgets__content-footercolumn1content1">
      <div class="bk-content-text js-text-content wysihtml-editor-content">
                <h3>Subscribe:</h3>
                </div>

    
</div>


                <div id="page-zones__template-widgets__profile-footercolumn2profileaddress" class="widget profile " data-widget-type="profile" data-uniqueid="page-zones__template-widgets__profile-footercolumn2profileaddress">
  











<form action="" method="post" class="js-form">
  <fieldset>
    <div class="form-group"> 
      <label for="profileform-email">Your email:</label>
      <input type="email" class="email js-email" placeholder="Type your email" id="profileform-email" name="profileform-email">

      <button class="btn btnText  " type="submit" >Sign me up!</button>
    </div>
  </fieldset>
</form>



</div>


           </div>
           <div class="column columns-two-right">
                <div id="page-zones__template-widgets__content-footercolumn2content1" class="widget content " data-widget-type="content" data-uniqueid="page-zones__template-widgets__content-footercolumn2content1">
      <div class="bk-content-text js-text-content wysihtml-editor-content">
                <h3>Connect:</h3>
                </div>

    
</div>


                <div id="page-zones__template-widgets__profile-footercolumn2socialicons" class="widget profile " data-widget-type="profile" data-uniqueid="page-zones__template-widgets__profile-footercolumn2socialicons">
  













<div class='bk-profile-socialicons'>
    <!-- linkedIn -->
              
    <!-- Twitter -->
        <span class="bk-socialicons-twitter">
      <a href="https://twitter.com/www.twitter.com/songaweek2016" target="_blank">Twitter</a>
    </span>
    
    <!-- Facebook -->
        <span class="bk-socialicons-facebook">
      <a href="http://www.facebook/com/groups/songaweek2016" target="_blank">Facebook</a>
    </span>
    
    <!-- Rss -->
              
      <!-- Google+ -->
        <span class="bk-socialicons-googleplus">
      <a href="https://plus.google.com/114980795991483587673" target="_blank">Google+</a>
    </span>
    
    <!-- youtube -->
        <span class="bk-socialicons-youtube">
      <a href="https://www.youtube.com/channel/UC8-7e8KrvnxNsuEPuJpRJvw" target="_blank">Youtube</a>
    </span>
    
    
</div>

</div>


           </div>
        </div>
    </div>
</footer>

    <script src="../../js/jquery.min.js"></script>
    <script src="../../js/bootstrap.min.js"></script>
    <script src="../../js/scripts.js"></script>
  </body>
</html>

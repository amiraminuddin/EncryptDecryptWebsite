<?php
session_start();
?>
<!DOCTYPE HTML>
<html>
<?php

include ('./includes_css/header.html');
?>	
        <!-- insert the page content here -->
	<div id="site_content">
        <h1 >hai <?php echo "". $_SESSION["user"].""; ?></h1>
        <h3 >welcome.</h3>
        </div>
<?php
include ('./includes_css/footer.html');
?>       
</html>
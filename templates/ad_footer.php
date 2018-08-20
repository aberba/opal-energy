<?php
global $js, $Settings;

?>
   <footer id="footer">
       <p>&copy; <?php echo $Settings->site_name(). " ".date("Y", time()); ?></p>
   </footer>
</article>

<!-- JS Files -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
<script>
window.jQuery || document.write("<script src='js\/jquery-1.11.0.min.js'><\/script>");
</script>

<script type="text/javascript" src="js/cms_general.js"></script>
<script type="text/javascript" src="http://cdnjs.cloudflare.com/ajax/libs/jquery-timeago/1.4.0/jquery.timeago.min.js"></script>
<script type="text/javascript">
	  setTimeout(function() {
	  	 jQuery.timeago || document.write('<script src="js\/jquery.timeago.min.js"><\/script>');
	  }, 3000);
</script>
<script src="js/jquery.timeago.min.js"></script>

<!-- HTML% Shiv & Modernizr -->
 <!--[if lt IE 9]>
    <script src="http://html5shiv.googlecode.com/svn/trunk/html5-els.js"></script>
 <![endif]-->

<script type="text/javascript" src="js/<?php echo @$js; ?>"></script>

</body>
</html>

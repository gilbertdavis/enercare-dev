<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
  "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="<?php print $language->language ?>" lang="<?php print $language->language ?>" dir="<?php print $language->dir ?>">
  <head>
    
    <title><?php print $head_title; ?></title>
    <?php print $head; ?>
    <?php print $styles; ?>
    <!--[if lte IE 6]><style type="text/css" media="all">@import "<?php print $base_path . path_to_theme() ?>/css/ie6.css"</style><![endif]-->
    <!--[if IE 7]><style type="text/css" media="all">@import "<?php print $base_path . path_to_theme() ?>/css/ie7.css"</style><![endif]-->
    <?php print $scripts; ?>
  </head>

  <body class="<?php print $body_classes; ?>">
    <div id="skip"><a href="#content">Skip to Content</a> <a href="#navigation">Skip to Navigation</a></div>  
<div id="page" class="<?php print $classes; ?>"<?php print $attributes; ?>>

  <div id="header">
	   <img src="<?php print path_to_theme(); ?>/images/logo.gif" alt="EnerCare Inc." id="logo" />
	   <a href="#" id="login"><img src="<?php print path_to_theme(); ?>/images/login.gif" alt="Log in to my Account" /></a>
	   <form id="search">
	     <input type="text" />
	     <input type="submit" class="submit" value="" />
	   </form>
	   <ul id="sub-nav">
	     <li><a href="#">About Us</a></li>
	     <li><a href="#">News</a></li>
	     <li><a href="#">Customer Service</a></li>
	     <li><a href="#">Investors</a></li>
	     <li><a href="#">Contact Us</a></li>
	   </ul>
	   <div id="nav">
	     <div id="solutions">
	       <a href="#"><img src="<?php print path_to_theme(); ?>/images/enercare-solutions.gif" alt="EnerCare Solutions" /></a>
	       <ul>
	         <li><a href="#">Water Heater</a></li>
	         <li><a href="#">Furnace</a></li>
	         <li><a href="#">Air Conditioner</a></li>
	       </ul>
	     </div>
	     <div id="connections">
	       <a href="#"><img src="<?php print path_to_theme(); ?>/images/enercare-connections.gif" alt="EnerCare Connections" /></a>
	       <ul>
	         <li><a href="#">Sub-Metering</a></li>
	       </ul>
	     </div>
	   </div>
	 </div>
	 <div id="content">
	   <div id="banner">
	     <?php print $banner_block; ?>
	   </div>
	   <div id="help-me">
	     <?php print $help_me_block; ?>
	   </div>
	   <div class="box">
	     <?php print $feature_one_block; ?>
	   </div>
	   <div class="box">
	     <?php print $feature_two_block; ?>
	   </div>
	   <div id="offer">
	     <?php print $offer_block; ?>
	   </div>
	 </div>
	 <div id="footer">
	   <ul>
	     <li><a href="#">Privacy Policy</a></li>
	     <li><a href="#">Terms &amp; Conditions</a></li>
	     <li><a href="#">Disclaimer</a></li>
	     <li><a href="#">Careers</a></li>
	   </ul>
	 </div>

</div> <!-- /page -->
    <?php print $closure; ?>
  </body>
</html>
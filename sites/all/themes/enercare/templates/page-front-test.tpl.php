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
	   <img src="<?php print $base_path . path_to_theme(); ?>/images/logo.gif" alt="EnerCare Inc." id="logo" />
	   <a href="#" id="login"><img src="<?php print $base_path . path_to_theme(); ?>/images/login.gif" alt="Log in to my Account" /></a>
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
	     <div id="menu">
	       <?php print $menu; ?>
	     </div>
	     <div style="clear:both;"></div>
	     <div id="solutions">
	       <ul>
	         <li><a href="#">Water Heater</a></li>
	         <li><a href="#">Furnace</a></li>
	         <li><a href="#">Air Conditioner</a></li>
	       </ul>
	     </div>
	     <div id="connections">
	       <ul>
	         <li><a href="#">Sub-Metering</a></li>
	       </ul>
	     </div>
	   </div>
	 </div>
	 <div style="clear:both;"></div>
	 <div id="content">
        <div id="content-inner" class="inner column center">

          <?php if ($content_top): ?>
            <div id="content-top">
              <?php print $content_top; ?>
            </div> <!-- /#content-top -->
          <?php endif; ?>

          <?php if ($breadcrumb || $title || $mission || $messages || $help || $tabs): ?>
            <div id="content-header">

              <?php print $breadcrumb; ?>

              <?php if ($title): ?>
                <h1 class="title"><?php print $title; ?></h1>
              <?php endif; ?>

              <?php if ($mission): ?>
                <div id="mission"><?php print $mission; ?></div>
              <?php endif; ?>

              <?php print $messages; ?>

              <?php print $help; ?> 

              <?php if ($tabs): ?>
                <div class="tabs"><?php print $tabs; ?></div>
              <?php endif; ?>

            </div> <!-- /#content-header -->
          <?php endif; ?>

          <div id="content-area">
            <?php print $content; ?>
          </div> <!-- /#content-area -->

          <?php print $feed_icons; ?>

          <?php if ($content_bottom): ?>
            <div id="content-bottom">
              <?php print $content_bottom; ?>
            </div><!-- /#content-bottom -->
          <?php endif; ?>

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
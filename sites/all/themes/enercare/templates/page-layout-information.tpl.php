<?php function callback($buffer, $node) {
$strings = '';
while ($token_start = strpos($buffer, '%%')) {
  $token_end = strpos($buffer, '%%', $token_start + 1);
  $whole_token = substr($buffer, $token_start, ($token_end - $token_start) + 2);
  $token = str_replace('%', '', $whole_token);
  switch ($token) {
    case 'header_image':
      $image = $node->{'field_'.$token};
      $link = $node->field_header_image_link[0]['value'];
      $string = '<img src="/'.$image[0]['filepath'].'" alt="" />';
      if ($link) {
      	if (strpos($link, 'enercare.ca')) {
      		$string = '<a href="'.$link.'">'.$string.'</a>';
	     	} else {
        	$string = '<a href="'.$link.'" target="_blank">'.$string.'</a>';    	
      	}
      }
      $buffer = str_replace($whole_token, $string, $buffer);
      break;
    case 'title':
      $buffer = str_replace($whole_token, $node->title, $buffer);
      break;
  }
  $strings .= $image . 'xx' . $whole_token . '::' . $token . '<br />';
} 

return $buffer;
}
$bc = drupal_get_breadcrumb();
$parent = $bc[1];
jquery_ui_add('ui.accordion');
ob_start(); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
  "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="<?php print $language->language ?>" lang="<?php print $language->language ?>" dir="<?php print $language->dir ?>">
  <head>
  	<!-- <?php print_r(drupal_get_breadcrumb()); ?> 
  	<?php echo array_search('<a href="/solutions">EnerCare Solutions</a>', drupal_get_breadcrumb()); ?>
  	-->
    <title><?php print $head_title; ?></title>
    <?php print $head; ?>
    <?php print $styles; ?>
    <!--[if lte IE 6]><style type="text/css" media="all">@import "<?php print $base_path . path_to_theme() ?>/css/ie6.css"</style><![endif]-->
    <!--[if IE 7]><style type="text/css" media="all">@import "<?php print $base_path . path_to_theme() ?>/css/ie7.css"</style><![endif]-->
    
<script type="text/javascript" src="/sites/all/libraries/ckeditor/ckeditor.js"></script> 
    <?php print $scripts; ?>
    <!--[if gte IE 7]>
<style>
#content, .connections.not-front #content, .solutions.not-front #content { padding-top: 10px; }
</style>
<![endif]-->
  </head>

  <body id="top" class="<?php print $body_classes; ?>">
    <div id="skip"><a href="#content">Skip to Content</a> <a href="#navigation">Skip to Navigation</a></div>  
<div id="page" class="<?php print $classes; ?>"<?php print $attributes; ?>>
  <div id="header" class="clearfix">
	   <a id="logo" href="/">EnerCare Inc.</a>
       <div id="ticker" class="clearfix">
        	<a href="http://tmx.quotemedia.com/quote.php?qm_symbol=ECI" target="_blank">
            <div id="StockQuotes">
                <div id="StockQuotesTSX">
                    <span class="StockQuotesTitle"><strong>TSX: <span style="font-size:27px;" class="green">ECI</span></strong></span>
                    <span class="StockQuotesChange"><img src="http://www.enercareinc.com/includes/stockdown.gif" width="10" height="10" border="0" /></span>
                    <span class="StockQuotesLastPrice"><strong><span style="font-size:14px;">9.15</span></strong></span><br/>
                    <span style="font-size:9px; padding-left:35px;">6/1/2012 3:59pm</span><br/>
                </div><!-- /StockQuotesTSX -->
            </div><!-- /StockQuotes -->
        	</a>
        </div><!-- /ticker -->
	   <div id="cwif"><?php echo $cwif;?></div>
	   
    <?php print $search_box; ?>
	   <div id="sub-nav">
	     <?php print theme('links', menu_navigation_links('menu-sub-navigation')); ?>
	   </div>
	   <div id="nav" class="clearfix">
         <?php print $menu; ?>
	   </div>
	 </div>
	 <div style="clear:both;"></div>
	 <div id="content">
	           <?php if ($tabs): ?>
                <div class="tabs"><?php print $tabs; ?></div>
              <?php endif; ?>
              <?php print $breadcrumb; ?>
        <div id="content-inner" class="inner column center">
              
          <?php if ($messages || $help): ?>
            <div id="content-header">

              <?php print $messages; ?>
              <?php print $help; ?> 


            </div> <!-- /#content-header -->
          <?php endif; ?>
          <h1><?php print $parent; ?></h1>
          <div id="secondary-links" class="<?php echo $menu_header; ?>">
            
            <?php print $secondary_menu ?>
            <!-- <?php if ($path == 'newsletters'): ?>
              <img src="<?php print $base_path . path_to_theme(); ?>/images/receive-enercare-updates.jpg" alt="Receive EnerCare Updates" />
            <?php endif; ?>
            
            <?php if ($path == 'sitemap'): ?>
              <img src="<?php print $base_path . path_to_theme(); ?>/images/site-map-menu-header.gif" alt="Site Map" />
            <?php endif; ?>
            <?php if ($section_subtitle): 
              print $section_subtitle;
            endif; ?> -->
            
          </div>
          <div id="content-area">

            <?php print $content; ?>
          </div> <!-- /#content-area -->

          </div>
        </div>
        
	 <div id="footer">

	   <?php print theme('links', menu_navigation_links('menu-footer-navigation')); ?>
	   <a href="#logo" class="dummy">RETURN TO TOP</a>
	 </div>
</div> <!-- /page -->
    <?php print $closure; ?>
  </body>
</html>
<?php 
$buffer = ob_get_contents();
ob_end_clean(); 
echo callback($buffer, $node);
?>

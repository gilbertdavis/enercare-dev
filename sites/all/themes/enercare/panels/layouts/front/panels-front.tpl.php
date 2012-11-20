<?php
// $Id: panels-twocol.tpl.php,v 1.1.2.1 2008/12/16 21:27:58 merlinofchaos Exp $
/**
 * @file
 * Template for a 2 column panel layout.
 *
 * This template provides a two column panel display layout, with
 * each column roughly equal in width.
 *
 * Variables:
 * - $id: An optional CSS id to use for the layout.
 * - $content: An array of content, each item in the array is keyed to one
 *   panel of the layout. This layout supports the following sections:
 *   - $content['left']: Content in the left column.
 *   - $content['right']: Content in the right column.
 */
$solutions = theme('nice_menus_tree', 'primary-Links', 489);
$connections = theme('nice_menus_tree', 'primary-Links', 490);
?>
<div class="panel-display clear-block" <?php if (!empty($css_id)) { print "id=\"$css_id\""; } ?>>
  <div id="front-content">
  	<div id="banner"><?php print $content['banner']; ?></div>
  	<div id="solutions-block">
			<div id="solutions-menu"><ul class="gigamenu menu"><li class="gigamenu-level-0"><a href="/solutions"><img src="/sites/all/themes/enercare/images2/solutions-menu.gif" alt="EnerCare Solutions" /></a><ul class="gigamenu menu"><?php print_r($solutions['content']); ?></ul></li></ul></div>
			<div class="submenu">
				<ul>
	         <li><a href="/content/water-heater-solutions">Water Heater</a></li>
	         <li><a href="/content/furnace-solutions">Furnace</a></li>
	         <li><a href="/content/air-conditioner-solutions">Air Conditioner</a></li>
	       </ul>
				</div>
			<?php print $content['solutions']; ?></div>
  	<div id="connections-block">
			<div id="connections-menu"><ul class="gigamenu menu"><li class="gigamenu-level-0"><a href="/connections"><img src="/sites/all/themes/enercare/images2/connections-menu.gif" alt="EnerCare Connections" /></a><ul class="gigamenu menu"><?php print_r($connections['content']); ?></ul></li></ul></div>
			<div class="submenu">
				<ul>
	         <li><a href="/content/sub-metering-overview">Electricity Sub-Metering</a></li>
	       </ul>
			</div>
			<?php print $content['connections']; ?></div>
  </div> 
  <div id="front-aside">
	 
  	<div id="offer-solutions"><?php print $content['offer_solutions']; ?></div>
  	<div id="offer-connections"><?php print $content['offer_connections']; ?></div>
  	<a href="/newsletters"><img src="/sites/all/themes/enercare/images2/newsletter.gif" alt="Sign Up for Newsletter" /></a>
  </div>
   
</div>

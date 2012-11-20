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
?>
<div class="panel-display panel-2col clear-block" <?php if (!empty($css_id)) { print "id=\"$css_id\""; } ?>>
  <div id="information-content">
    <div id="header-image">%%header_image%%</div>
    <div id="header-image-bottom"><div id="print-page"><?php print print_insert_link(); ?></div> <a href="javascript:;" class="changer" id="text_resize_decrease"><sup>-</sup>A</a><a href="javascript:;" class="changer" id="text_resize_increase"><sup>+</sup>A</a><div id="text_resize_clear"></div></div>
    <h1>%%title%%</h1>
    <div class="inside"><?php print $content['left']; ?></div>
  </div>

  <div id="information-aside">
    <div class="inside">
		<?php print $content['right']; ?>

    </div>
  </div>
</div>

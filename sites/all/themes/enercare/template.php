<?php
    
// Auto-rebuild the theme registry during theme development.
if (theme_get_setting('enercare_rebuild_registry')) {
  drupal_rebuild_theme_registry();
}

// Add Zen Tabs styles
if (theme_get_setting('enercare_zen_tabs')) {
  drupal_add_css( drupal_get_path('theme', 'enercare') .'/css/tabs.css', 'theme', 'screen');
}

/*
 *	 This function creates the body classes that are relative to each page
 *	
 *	@param $vars
 *	  A sequential array of variables to pass to the theme template.
 *	@param $hook
 *	  The name of the theme function being called ("page" in this case.)
 */

function enercare_preprocess_page(&$vars, $hook) {

  // Don't display empty help from node_help().
  if ($vars['help'] == "<div class=\"help\"><p></p>\n</div>") {
    $vars['help'] = '';
  }

  // Classes for body element. Allows advanced theming based on context
  // (home page, node of certain type, etc.)
  $body_classes = array($vars['body_classes']);
  if (user_access('administer blocks')) {
	  $body_classes[] = 'admin';
	}
	if (theme_get_setting('enercare_wireframe')) {
    $body_classes[] = 'with-wireframes'; // Optionally add the wireframes style.
  }
  if (!empty($vars['primary_links']) or !empty($vars['secondary_links'])) {
    $body_classes[] = 'with-navigation';
  }
  if (!empty($vars['secondary_links'])) {
    $body_classes[] = 'with-secondary';
  }
  if (module_exists('taxonomy') && $vars['node']->nid) {
    foreach (taxonomy_node_get_terms($vars['node']) as $term) {
    $body_classes[] = 'tax-' . eregi_replace('[^a-z0-9]', '-', $term->name);
    }
  }
  if (!$vars['is_front']) {
    // Add unique classes for each page and website section
    $path = drupal_get_path_alias($_GET['q']);
    list($section, ) = explode('/', $path, 2);
    $body_classes[] = enercare_id_safe('page-'. $path);
    $body_classes[] = enercare_id_safe('section-'. $section);
    $vars['path'] = $path;

    if (arg(0) == 'node') {
      if (arg(1) == 'add') {
        if ($section == 'node') {
          array_pop($body_classes); // Remove 'section-node'
        }
        $body_classes[] = 'section-node-add'; // Add 'section-node-add'
      }
      elseif (is_numeric(arg(1)) && (arg(2) == 'edit' || arg(2) == 'delete')) {
        if ($section == 'node') {
          array_pop($body_classes); // Remove 'section-node'
        }
        $body_classes[] = 'section-node-'. arg(2); // Add 'section-node-edit' or 'section-node-delete'
      }
    }
  }

  if ($vars['node']->type != "") {
      $vars['template_files'][] = "page-type-" . $vars['node']->type;
    }
  if ($vars['node']->nid != "") {
      $vars['template_files'][] = "page-node-" . $vars['node']->nid;
    }

  $panel_info = panels_node_load($vars['node']);
  $panel_display = panels_load_display($panel_info['panels_node']['did']);
  if ($panel_display) {
    $vars['template_files'][] = "page-layout-" . $panel_display->layout;
    $body_classes[] = $panel_display->layout;
  }

 
    $vars['primary_menu'] = menu_tree(variable_get('menu_primary_links_source', 'primary_links'));
	$menu_name = variable_get('menu_secondary_links_source', 'secondary_links');
  $menu_array = menu_tree_page_data($menu_name);
  
  $top_level_keys = array_keys($menu_array);
  $section = get_section_image();
  $vars['section_image'] = ($section) ? $section : 'enercare';
  foreach($top_level_keys as $current_key) {
  	$sub_menu_array = $menu_array[$current_key];
  	if($sub_menu_array['below'] && ($sub_menu_array['link']['in_active_trail'] || enercare_active_menu($sub_menu_array['link']['link_path'], 'path'))) {
    	$vars['secondary_menu_title'] = str_replace(' ', '-', strtolower($sub_menu_array['link']['link_title']));
    	$body_classes[] = str_replace('enercare-', '', $vars['secondary_menu_title']);
    	$vars['secondary_menu_linkpath'] = base_path().drupal_get_path_alias($sub_menu_array['link']['link_path']);
      $vars['secondary_menu'] = '<div class="secondary">' . menu_tree_output($sub_menu_array['below']) . '</div>';
  	}
  }
  if (empty($vars['secondary_menu'])) {
    $menu_array = menu_tree_page_data('menu-sub-navigation');
    $top_level_keys = array_keys($menu_array);
    $section = get_section_image();
    $vars['section_image'] = ($section) ? $section : 'enercare';
    foreach($top_level_keys as $current_key) {
  	  $sub_menu_array = $menu_array[$current_key];
  	  if($sub_menu_array['below'] && ($sub_menu_array['link']['in_active_trail'] || enercare_active_menu($sub_menu_array['link']['link_path'], 'path'))) {
    	  $vars['secondary_menu_title'] = str_replace(' ', '-', strtolower($sub_menu_array['link']['link_title']));
    	  $vars['secondary_menu_linkpath'] = base_path().drupal_get_path_alias($sub_menu_array['link']['link_path']);
        $vars['secondary_menu'] = '<div class="secondary">' . menu_tree_output($sub_menu_array['below']) . '</div>';
  	  }
    }
  }
  
  if (empty($vars['secondary_menu'])) {
    $menu_array = menu_tree_page_data('menu-sub-navigation');
    $top_level_keys = array_keys($menu_array);
    $section = get_section_image();
    $vars['section_image'] = ($section) ? $section : 'enercare';
    foreach($top_level_keys as $current_key) {
  	  $sub_menu_array = $menu_array[$current_key];
  	  if(($sub_menu_array['link']['in_active_trail'] || enercare_active_menu($sub_menu_array['link']['link_path'], 'path'))) {
    	  $vars['secondary_menu_title'] = str_replace(' ', '-', strtolower($sub_menu_array['link']['link_title']));
    	  $vars['secondary_menu_linkpath'] = base_path().drupal_get_path_alias($sub_menu_array['link']['link_path']);
    	  if ($sub_menu_array['below']) {
          $vars['secondary_menu'] = '<div class="secondary">' . menu_tree_output($sub_menu_array['below']) . '</div>';
        } else {
          if ($vars['secondary_menu_title'] == 'home') {
            $vars['secondary_menu'] = '';
          } else {
            $vars['secondary_menu'] = '<div class="secondary"></div>';
          }
        }
  	  }
    }
  }
  
    $vars['body_classes'] = implode(' ', $body_classes); // Concatenate with spaces
}

/*
 *	 This function creates the NODES classes, like 'node-unpublished' for nodes
 *	 that are not published, or 'node-mine' for node posted by the connected user...
 *	
 *	@param $vars
 *	  A sequential array of variables to pass to the theme template.
 *	@param $hook
 *	  The name of the theme function being called ("node" in this case.)
 */

function enercare_preprocess_node(&$vars, $hook) {
  // Special classes for nodes
  $classes = array('node');
  if ($vars['sticky']) {
    $classes[] = 'sticky';
  }
  // support for Skinr Module
  if (module_exists('skinr')) {
    $classes[] = $vars['skinr'];
  }
  if (!$vars['status']) {
    $classes[] = 'node-unpublished';
    $vars['unpublished'] = TRUE;
  }
  else {
    $vars['unpublished'] = FALSE;
  }
  if ($vars['uid'] && $vars['uid'] == $GLOBALS['user']->uid) {
    $classes[] = 'node-mine'; // Node is authored by current user.
  }
  if ($vars['teaser']) {
    $classes[] = 'node-teaser'; // Node is displayed as teaser.
  }
  $classes[] = 'clearfix';
  
  // Class for node type: "node-type-page", "node-type-story", "node-type-my-custom-type", etc.
  $classes[] = enercare_id_safe('node-type-' . $vars['type']);
  $vars['classes'] = implode(' ', $classes); // Concatenate with spaces
}

function enercare_preprocess_comment_wrapper(&$vars) {
  $classes = array();
  $classes[] = 'comment-wrapper';
  
  // Provide skinr support.
  if (module_exists('skinr')) {
    $classes[] = $vars['skinr'];
  }
  $vars['classes'] = implode(' ', $classes);
}


/*
 *	This function create the EDIT LINKS for blocks and menus blocks.
 *	When overing a block (except in IE6), some links appear to edit
 *	or configure the block. You can then edit the block, and once you are
 *	done, brought back to the first page.
 *
 * @param $vars
 *   A sequential array of variables to pass to the theme template.
 * @param $hook
 *   The name of the theme function being called ("block" in this case.)
 */ 

function enercare_blocks($region) {
  $output = '';
	
  if ($list = block_list($region)) {
    $blockcounter = 1;
    foreach ($list as $key => $block) {
      $block->is_last = ( $blockcounter == count($list) ? true : false );
      $blockcounter++;
      $output .= theme('block', $block);
    }
  }

  // Add any content assigned to this region through drupal_set_content() calls.
  $output .= drupal_get_content($region);

  return $output;
}

function enercare_preprocess_block(&$vars, $hook) {
    $block = $vars['block'];

    // special block classes
    $classes = array('block');
    $classes[] = enercare_id_safe('block-' . $vars['block']->module);
    $classes[] = enercare_id_safe('block-' . $vars['block']->region);
    $classes[] = enercare_id_safe('block-id-' . $vars['block']->bid);
    if ($vars['block']->is_last):
      $classes[] = 'last';
    endif; 
    $classes[] = 'clearfix';
    
    // support for Skinr Module
    if (module_exists('skinr')) {
      $classes[] = $vars['skinr'];
    }
    
    $vars['block_classes'] = implode(' ', $classes); // Concatenate with spaces

    if (theme_get_setting('enercare_block_editing') && user_access('administer blocks')) {
        // Display 'edit block' for custom blocks.
        if ($block->module == 'block') {
          $edit_links[] = l('<span>' . t('edit block') . '</span>', 'admin/build/block/configure/' . $block->module . '/' . $block->delta,
            array(
              'attributes' => array(
                'title' => t('edit the content of this block'),
                'class' => 'block-edit',
              ),
              'query' => drupal_get_destination(),
              'html' => TRUE,
            )
          );
        }
        // Display 'configure' for other blocks.
        else {
          $edit_links[] = l('<span>' . t('configure') . '</span>', 'admin/build/block/configure/' . $block->module . '/' . $block->delta,
            array(
              'attributes' => array(
                'title' => t('configure this block'),
                'class' => 'block-config',
              ),
              'query' => drupal_get_destination(),
              'html' => TRUE,
            )
          );
        }
        // Display 'edit menu' for Menu blocks.
        if (($block->module == 'menu' || ($block->module == 'user' && $block->delta == 1)) && user_access('administer menu')) {
          $menu_name = ($block->module == 'user') ? 'navigation' : $block->delta;
          $edit_links[] = l('<span>' . t('edit menu') . '</span>', 'admin/build/menu-customize/' . $menu_name,
            array(
              'attributes' => array(
                'title' => t('edit the menu that defines this block'),
                'class' => 'block-edit-menu',
              ),
              'query' => drupal_get_destination(),
              'html' => TRUE,
            )
          );
        }
        // Display 'edit menu' for Menu block blocks.
        elseif ($block->module == 'menu_block' && user_access('administer menu')) {
          list($menu_name, ) = split(':', variable_get("menu_block_{$block->delta}_parent", 'navigation:0'));
          $edit_links[] = l('<span>' . t('edit menu') . '</span>', 'admin/build/menu-customize/' . $menu_name,
            array(
              'attributes' => array(
                'title' => t('edit the menu that defines this block'),
                'class' => 'block-edit-menu',
              ),
              'query' => drupal_get_destination(),
              'html' => TRUE,
            )
          );
        }
        $vars['edit_links_array'] = $edit_links;
        $vars['edit_links'] = '<div class="edit">' . implode(' ', $edit_links) . '</div>';
      }
  }

/*
 * Override or insert PHPTemplate variables into the block templates.
 *
 *  @param $vars
 *    An array of variables to pass to the theme template.
 *  @param $hook
 *    The name of the template being rendered ("comment" in this case.)
 */

function enercare_preprocess_comment(&$vars, $hook) {
  // Add an "unpublished" flag.
  $vars['unpublished'] = ($vars['comment']->status == COMMENT_NOT_PUBLISHED);

  // If comment subjects are disabled, don't display them.
  if (variable_get('comment_subject_field_' . $vars['node']->type, 1) == 0) {
    $vars['title'] = '';
  }

  // Special classes for comments.
  $classes = array('comment');
  if ($vars['comment']->new) {
    $classes[] = 'comment-new';
  }
  $classes[] = $vars['status'];
  $classes[] = $vars['zebra'];
  if ($vars['id'] == 1) {
    $classes[] = 'first';
  }
  if ($vars['id'] == $vars['node']->comment_count) {
    $classes[] = 'last';
  }
  if ($vars['comment']->uid == 0) {
    // Comment is by an anonymous user.
    $classes[] = 'comment-by-anon';
  }
  else {
    if ($vars['comment']->uid == $vars['node']->uid) {
      // Comment is by the node author.
      $classes[] = 'comment-by-author';
    }
    if ($vars['comment']->uid == $GLOBALS['user']->uid) {
      // Comment was posted by current user.
      $classes[] = 'comment-mine';
    }
  }
  $vars['classes'] = implode(' ', $classes);
}

/* 	
 * 	Customize the PRIMARY and SECONDARY LINKS, to allow the admin tabs to work on all browsers
 * 	An implementation of theme_menu_item_link()
 * 	
 * 	@param $link
 * 	  array The menu item to render.
 * 	@return
 * 	  string The rendered menu item.
 */ 	

function enercare_menu_item_link($link) {
  
  $path = explode('#', $link_item['path'], 2);
$fragment = !empty($path[1]) ? $path[1] : NULL;
$path = $path[0];
if ($fragment) {
return l(
$item['title'],
$path,
!empty($item['description']) ? array('title' => $item['description']) : array(),
!empty($item['query']) ? $item['query'] : NULL,
$fragment,
FALSE,
FALSE
);
}
  if (substr($link['href'], 0, 4) == 'http') {
    return l($link['title'], $link['href'], isset($link['description']) ? array('title' => $link['description'], 'target' => '_blank') : array('target' => '_blank'));
  }
  else {
     if (empty($link['localized_options'])) {
    $link['localized_options'] = array();
  }

  // If an item is a LOCAL TASK, render it as a tab
  if ($link['type'] & MENU_IS_LOCAL_TASK) {
    $link['title'] = '<span class="tab">' . check_plain($link['title']) . '</span>';
    $link['localized_options']['html'] = TRUE;
  }

  return l($link['title'], $link['href'], $link['localized_options']);
  }
}


/*
 *  Duplicate of theme_menu_local_tasks() but adds clear-block to tabs.
 */

function enercare_menu_local_tasks() {
  $output = '';
  if ($primary = menu_primary_local_tasks()) {
    if(menu_secondary_local_tasks()) {
      $output .= '<ul class="tabs primary with-secondary clearfix">' . $primary . '</ul>';
    }
    else {
      $output .= '<ul class="tabs primary clearfix">' . $primary . '</ul>';
    }
  }
  if ($secondary = menu_secondary_local_tasks()) {
    $output .= '<ul class="tabs secondary clearfix">' . $secondary . '</ul>';
  }
  return $output;
}

/* 	
 * 	Add custom classes to menu item
 */	
	
function enercare_menu_item($link, $has_children, $menu = '', $in_active_trail = FALSE, $extra_class = NULL) {
  $class = ($menu ? 'expanded' : ($has_children ? 'collapsed' : 'leaf'));
  if (!empty($extra_class)) {
    $class .= ' '. $extra_class;
  }
  if ($in_active_trail) {
    $class .= ' active-trail';
  }
#New line added to get unique classes for each menu item
  $css_class = enercare_id_safe(str_replace(' ', '_', strip_tags($link)));
  return '<li class="'. $class . ' ' . $css_class . '">' . $link . $menu ."</li>\n";
}

/*	
 *	Converts a string to a suitable html ID attribute.
 *	
 *	 http://www.w3.org/TR/html4/struct/global.html#h-7.5.2 specifies what makes a
 *	 valid ID attribute in HTML. This function:
 *	
 *	- Ensure an ID starts with an alpha character by optionally adding an 'n'.
 *	- Replaces any character except A-Z, numbers, and underscores with dashes.
 *	- Converts entire string to lowercase.
 *	
 *	@param $string
 *	  The string
 *	@return
 *	  The converted string
 */	

function enercare_id_safe($string) {
  // Replace with dashes anything that isn't A-Z, numbers, dashes, or underscores.
  $string = strtolower(preg_replace('/[^a-zA-Z0-9_-]+/', '-', $string));
  // If the first character is not a-z, add 'n' in front.
  if (!ctype_lower($string{0})) { // Don't use ctype_alpha since its locale aware.
    $string = 'id'. $string;
  }
  return $string;
}

/**
* Return a themed breadcrumb trail.
*
* @param $breadcrumb
* An array containing the breadcrumb links.
* @return
* A string containing the breadcrumb output.
*/
function enercare_breadcrumb($breadcrumb) {
  // Determine if we are to display the breadcrumb.
  $show_breadcrumb = theme_get_setting('enercare_breadcrumb');
  if ($show_breadcrumb == 'yes' || $show_breadcrumb == 'admin' && arg(0) == 'admin') {

    // Optionally get rid of the homepage link.
    $show_breadcrumb_home = theme_get_setting('enercare_breadcrumb_home');
    if (!$show_breadcrumb_home) {
      array_shift($breadcrumb);
    }

    // Return the breadcrumb with separators.
    if (!empty($breadcrumb)) {
      $breadcrumb_separator = theme_get_setting('enercare_breadcrumb_separator');
      $trailing_separator = $title = '';
      if (theme_get_setting('enercare_breadcrumb_title')) {
        if ($title = drupal_get_title()) {
          $trailing_separator = $breadcrumb_separator;
        }
      }
      elseif (theme_get_setting('enercare_breadcrumb_trailing')) {
        $trailing_separator = $breadcrumb_separator;
      }
      return '<div class="breadcrumb">' . implode($breadcrumb_separator, $breadcrumb) . "$trailing_separator$title</div>";
    }
  }
  // Otherwise, return an empty string.
  return '';
}

function enercare_active_menu($link, $type='link') {
	// Get the link's URL (sadly, this function doesn't include the link object)
		if ($type == 'link') {
    $url_pattern = '/<a\s[^>]*href=\"([^\"]*)\"[^>]*>.*<\/a>/siU';

    preg_match($url_pattern, $link, $matches);
    $link_path = drupal_lookup_path('source',substr_replace($matches[1], '', 0, 1)); // remove first slash
    } else {
    	$link_path = $link;

    }
    $current_path = substr_replace($_SERVER['REQUEST_URI'], '', 0, 1);

    $contexts = context_get();
    if(!empty($contexts)) {
      $active_paths = array();
        foreach ($contexts['context'] as $context) {
          if (array_key_exists('menu', $context->reactions)) {
						if ($context->reactions['menu'] == '<front>') {
							$active_paths[] = '';
						} else {
            	$active_paths[] = $context->reactions['menu'];
            }
          }
        }

        foreach ($contexts['context'] as $context) {
        	if (array_key_exists('path', $context->conditions) && array_key_exists('menu', $context->reactions)) {
        		foreach ($context->conditions['path']['values'] as $condition) {
        			if (preg_match('|^'.$condition.'|si', $current_path)) {
        				if (in_array($link_path, $active_paths)) {
          				return true;
        				}
        			}
        		}
        	}
        }
			}
			return false;
}

function get_section_image() {
  // MENU - attempt to make a section link from a menu item, for this page
  // get active menu trail into an array
  $menu_items = menutrails_get_breadcrumbs();
  $section_name = strtolower(preg_replace('/\W/', '', strip_tags($menu_items[1])));
  if($section_name) {
    return $section_name;
  }
  // PATH - if we've not returned, we couldn't make a valid link from menu
  // let's try a path approach instead?
  if (module_exists('path')) { // dependency for drupal_get_path_alias

    $sections = array(); // an empty array to collect stuff in

    // get all the top level links in the primary nav (id of 2) into a array
    $primary_nav = menu_primary_links(1, 2);

    // iterate over the array and pull out the top level paths
    foreach ($primary_nav as $menu) {

      // get the first element of the aliased path for this menu item
      $path_element = explode('/', drupal_get_path_alias($menu['href']));

      // put the first chunk of each path onto an array
      $sections[] = $path_element[0];
    }

    // get the aliased path for the page we're on
    $section = explode('/', drupal_get_path_alias($_GET['q']));
    $section_name = $section[0];

    // if the path matches a nav item, create a section image
    if (in_array($section_name, $sections)) {
      return strtolower(preg_replace('/\W/', '', strip_tags($section_name)));
    }
  }
}


<?php

//$Id: menutree.pages.inc,v 1.1.2.3 2009/05/27 19:01:00 crell Exp $

/**
 * @file
 * User-facing page callbacks for the menutree module.
 *
 */


/**
 * Menu callback; Display a menu tree for a single specified menu.
 *
 * @param $menu
 *  The menu to display.
 */
function menutree_display_page($menu) {
  return menutree_display($menu, MENUTREE_TITLE_PAGE);
}

/**
 * Menu callback; Display a fully-expanded version of all flagged menus.
 *
 */
function menutree_display_all() {

  $trees = array();

  $menus = menu_get_menus();

  foreach ($menus as $menu_name => $menu_title) {

    $weight = trim(variable_get('menutree_all_weight_'. $menu_name, '<none>'));

    if (is_numeric($weight)) {
      $trees[$weight] = menutree_display(menu_load($menu_name), $menu_title);
    }

  }
  ksort($trees);

  return implode($trees);
}


/**
 * Display a fully-expanded version of the menu specified on the path
 *
 * @param $menu
 *  The menu to display.
 * @param $title_display
 *   How to handle the display of the title.  This is a bitmask that can take
 *   multiple values.
 *     - MENUTREE_TITLE_PAGE: Set the title of this menu as the page title.
 *     - MENUTREE_TITLE_BODY: Include the title of the menu in the body of the page.
 */
function menutree_display($menu, $title_display = MENUTREE_TITLE_PAGE) {

  $output = '';

  // The title could be displayed in various ways.
  $title = variable_get('menutree_title_'. $menu['menu_name'], '');
  if (!$title) {
    $title = $menu['title'];
  }
  $title = check_plain($title);

  if ($title_display & MENUTREE_TITLE_PAGE) {
    drupal_set_title($title);
  }

  // Output custom intro text.
  $intro = variable_get('menutree_intro_text_'. $menu['menu_name'], '');
  $description = '';
  if (!empty($intro)) {
    $description = check_markup($intro, FILTER_FORMAT_DEFAULT, FALSE);
  }

  $tree = menu_tree_output(menu_tree_all_data($menu['menu_name']));

  return theme('menutree_page', $title, $description, $tree);
}

/**
 * Theme the menutree.
 *
 * @param string $title
 *   The title of this tree, if any.
 * @param $description
 *   The descriptive intro text for this tree, if any.
 * @param $tree
 *   The pre-rendered menu tree itself.
 * @ingroup themeable
 */
function theme_menutree_page($title, $description, $tree) {

  $output = '';


  if ($description) {
    $output .= '<div class="menutree-description">'. $description ."</div>\n";
  }

  $output .= $tree;


  return  '<div class="menutree-page">' . $output . "</div>\n";
}

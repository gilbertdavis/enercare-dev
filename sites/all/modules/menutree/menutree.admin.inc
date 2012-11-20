<?php
// $Id: menutree.admin.inc,v 1.1.2.2 2009/05/27 19:01:00 crell Exp $

/**
 * @file
 * Administrative page callbacks for menutree module.
 */

/**
 * Form builder; Display menutree settings form.
 */
function menutree_settings() {
  $form = array();

  $form['menutree'] = array('#tree' => FALSE);

  // This really should be array_combine, but that's not PHP 4 compatible.
  $items = array_merge(array('<none>'), range(-10, 10));
  $weights = array();
  foreach ($items as $item) {
    $weights[$item] = $item;
  }

  $menus = menu_get_menus();
  foreach ($menus as $menu_name => $menu_title) {
    $open = trim(variable_get('menutree_title_'. $menu_name, '')
               . variable_get('menutree_intro_text_'. $menu_name, '')
               . str_replace('<none>', '', variable_get('menutree_all_weight_'. $menu_name, '<none>')));

    $form['menutree'][$menu_name] = array(
      '#type' => 'fieldset',
      '#title' => $menu_title,
      '#collapsible' => TRUE,
      '#collapsed' => ($open ? FALSE : TRUE),
      '#description' => t('The path <a href="@link">@path</a> will provide a complete tree of all menu items in this menu.  If you wish to set a custom title or header text, do so here.', array(
        '@link' => url('menutree/'. $menu_name),
        '@path' => 'menutree/'. $menu_name,
      )),
    );
    $form['menutree'][$menu_name]['menutree_title_'. $menu_name] = array(
      '#type' => 'textfield',
      '#title' => t('Page title'),
      '#default_value' => variable_get('menutree_title_'. $menu_name, ''),
      '#description' => t('A page title that is displayed instead of the root menu item title.'),
    );
    $form['menutree'][$menu_name]['menutree_intro_text_'. $menu_name] = array(
      '#type' => 'textarea',
      '#title' => t('Intro text'),
      '#default_value' => variable_get('menutree_intro_text_'. $menu_name, ''),
      '#resizable' => TRUE,
      '#description' => t('An intro text that is displayed below the page title.'),
    );
    $form['menutree'][$menu_name]['menutree_all_weight_'. $menu_name] = array(
      '#type' => 'select',
      '#title' => t('Order in main index'),
      '#options' => $weights,
      '#default_value' => variable_get('menutree_all_weight_'. $menu_name, '<none>'),
      '#description' => t('The path <a href="@link">@path</a> will provide multiple menu trees on a single page.  You can specify which and in what order here.  Set the weight to "&lt;none&gt;" to exclude this menu.', array(
        '@link' => url('menutree/all'),
        '@path' => 'menutree/all',
      )),
    );
  }

  return system_settings_form($form);
}


<?php
// $Id$

/**
 * @file
 * Provides the administration page for jQuery UI Loader.
 */
  
/**
 * Administration settings page
 */ 
function jquery_ui_loader_admin_settings_form() {
  $form = array();
  
  // List of jQuery UI widgets/effects to load.
  $form['script_files'] = array(
    '#type' => 'fieldset',
    '#title' => t('jQuery UI load settings'),
    '#collapsible' => FALSE,
  );

  $form['script_files']['jquery_ui_loader_filelist'] = array(
    '#type' => 'textarea',
    '#title' => t('Files to Load'),
    '#default_value' => variable_get('jquery_ui_loader_filelist', ''),
    '#description' => t('Enter one jQuery UI widget/effect per line, <strong>without</strong> the %js-ext javascript file extension. Example, %example. See the contents of the %jquery-dot-ui sub-directory in the %jquery-ui module folder for a list of available files that may be included, and see the <a href="@url">jQuery UI documentation</a> for details on how to use them. The required %ui-core file is automatically included, as is %effects-core if you include any effects files.', array('%js-ext' => '.js', '%example' => 'ui.draggable', '%jquery-dot-ui' => 'jquery.ui-X.X', '%jquery-ui' => 'jquery_ui', '@url' => 'http://ui.jquery.com/docs', '%ui-core' => 'ui.core', '%effects-core' => 'effects.core')),
    '#wysiwyg' => FALSE,
  );

  $form['script_files']['jquery_ui_loader_themelist'] = array(
    '#type' => 'textarea',
    '#title' => t('Theme files to Load'),
    '#default_value' => variable_get('jquery_ui_loader_themelist', 'default/ui.all.css'),
    '#description' => t('Enter the paths to the CSS files that make up the theme for the jQuery widgets/effects, each on a separate line. If you do not have a custom theme you can simply leave the default value. Note that each path is assumed relative to the jQuery UI theme folder in the jQuery UI module folder, example %theme-path.', array('%theme-path' => drupal_get_path('module', 'jquery_ui') . '/jquery.ui/themes/default/ui.all.css')),
    '#wysiwyg' => FALSE,
  );
  
  // Render the role overview.
  $form['role_vis_settings'] = array(
    '#type' => 'fieldset',
    '#title' => t('Role specific load settings'),
    '#collapsible' => TRUE,
  );

  $roles = user_roles();
  $role_options = array();
  foreach ($roles as $rid => $name) {
    $role_options[$rid] = $name;
  }
  
  $form['role_vis_settings']['jquery_ui_loader_roles'] = array(
    '#type' => 'checkboxes',
    '#title' => t('Load specified widgets/effects for specific roles'),
    '#default_value' => variable_get('jquery_ui_loader_roles', array()),
    '#options' => $role_options,
    '#description' => t('Load widgets/effects specified below only for the selected role(s). If none of the roles are selected, the widgets/effects will be loaded for all users.'),
  );
  
  // Page specific load configurations.
  $form['page_vis_settings'] = array(
    '#type' => 'fieldset',
    '#title' => t('Page specific load settings'),
    '#collapsible' => TRUE,
    '#collapsed' => TRUE,
  );
  
  $access = user_access('use PHP for jquery UI script visibility');
  $visibility = variable_get('jquery_ui_loader_visibility', 0);
  $pages = variable_get('jquery_ui_loader_pages', '');
  
  if ($visibility == 2 && !$access) {
    $form['page_vis_settings'] = array();
    $form['page_vis_settings']['jquery_ui_loader_visibility'] = array('#type' => 'value', '#value' => 2);
    $form['page_vis_settings']['jquery_ui_loader_pages'] = array('#type' => 'value', '#value' => $pages);
  }
  else {
    $options = array(t('Add to every page except the listed pages.'), t('Add to the listed pages only.'));
    $description = t("Enter one page per line as Drupal paths. The '*' character is a wildcard. Example paths are %blog for the blog page and %blog-wildcard for every personal blog. %front is the front page.", array('%blog' => 'blog', '%blog-wildcard' => 'blog/*', '%front' => '<front>'));

    if ($access) {
      $options[] = t('Add if the following PHP code returns <code>TRUE</code> (PHP-mode, experts only).');
      $description .= ' '. t('If the PHP-mode is chosen, enter PHP code between %php. Note that executing incorrect PHP-code can break your Drupal site.', array('%php' => '<?php ?>'));
    }

    $form['page_vis_settings']['jquery_ui_loader_visibility'] = array(
      '#type' => 'radios',
      '#title' => t('Load jQuery UI widgets/effects in specific pages'),
      '#options' => $options,
      '#default_value' => $visibility,
    );
    $form['page_vis_settings']['jquery_ui_loader_pages'] = array(
      '#type' => 'textarea',
      '#title' => t('Pages'),
      '#default_value' => $pages,
      '#description' => $description,
      '#wysiwyg' => FALSE,
    );
  }

  return system_settings_form($form);
} // function jquery_ui_loader_admin_settings_form

function jquery_ui_loader_admin_settings_form_validate($form, &$form_state) {
  // This is for the Newbie's who cannot read a text area description.
  if (stristr($form_state['values']['jquery_ui_loader_filelist'], '.js')) {
    form_set_error('jquery_ui_loader_filelist', t('Do not add the %js-ext file extension to the jQuery UI widgets/effects file names! The <em>jQuery UI</em> module, which jQuery UI Loader depends on, automatically appends the extension when adding the files during page load.', array('%js-ext' => '.js')));
  }

  // Trim some text area values.
  $form_state['values']['jquery_ui_loader_pages'] = trim($form_state['values']['jquery_ui_loader_pages']);
} // function jquery_ui_loader_admin_settings_form_validate

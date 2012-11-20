<?php
// $Id: emf.page.inc,v 1.4 2009/11/09 15:04:42 davyvandenbremt Exp $

/**
 * @file
 * Page callbacks.
 *
 * @author Davy Van Den Bremt
 */

function emf_page($list = NULL) {
  module_load_include('inc', 'emf', 'emf.form');
  
  // fetch form
  $form = emf_subscription_list_form(array(), $lid);

  // check if form is empty
  if (!empty($form)) {
    return drupal_get_form('emf_subscription_list_form', $lid);
  }
  else {
    drupal_set_message(t('You are not allowed to view this subscription form or are already subscribed to this list.'));
  }
}
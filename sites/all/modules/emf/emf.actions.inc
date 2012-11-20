<?php
// $Id: emf.actions.inc,v 1.2 2009/11/09 14:11:52 davyvandenbremt Exp $

/**
 * @file
 * Actions integration.
 *
 * @author Davy Van Den Bremt
 */

/**
 * Implementation of hook_action_info().
 */
function emf_action_info() {
  $info['emf_subscribe_action'] = array(
    'type' => 'system',
    'description' => t('Subscribe a user to certain EMF lists'),
    'configurable' => TRUE,
    'hooks' => array(
      'user' => array('view', 'insert', 'update', 'delete', 'login'),
    ),
  );

  $info['emf_unsubscribe_action'] = array(
    'type' => 'system',
    'description' => t('Unsubscribe a user from certain EMF lists'),
    'configurable' => TRUE,
    'hooks' => array(
      'user' => array('view', 'insert', 'update', 'delete', 'login'),
    ),
  );

  return $info;
}

function emf_subscribe_action_form($context) {
  $lists = emf_db_get_lists(TRUE);
  $options = array();
  foreach ($lists as $list) {
    $options[$list->lid] = $list->name_action_clean;
  }

  $form['lists'] = array(
    '#type' => 'checkboxes',
    '#title' => t('Lists'),
    '#description' => t('Select the lists for this action.'),
    '#options' => $options,
    '#default_value' => isset($context['lists']) ? $context['lists'] : array(),
    '#required' => TRUE,
  );
  return $form;
}

function emf_unsubscribe_action_form($context) {
  return emf_subscribe_action_form($context);
}

function emf_subscribe_action_submit($form, $form_state) {
  return array(
    'lists' => array_keys(array_filter($form_state['values']['lists']))
  );
}

function emf_unsubscribe_action_submit($form, $form_state) {
  return emf_subscribe_action_submit($form, $form_state);
}

function emf_subscribe_action($object, $context) {
  $account = emf_action_account($object, $context);

  foreach ($context['lists'] as $lid) {
    // parse fields
    $field_values = emf_helpers_parse_field_values($lid, $account);
    $mail = $field_values['mail'];
    unset($field_values['mail']);

    // subscribe user
    emf_helpers_subscribe($mail, $lid, $field_values);
  }
}

function emf_unsubscribe_action($object, $context) {
  $account = emf_action_account($object, $context);

  foreach ($context['lists'] as $lid) {
    // unsubscribe user
    emf_helpers_unsubscribe($account->mail, $lid);
  }
}

function emf_action_account($object, $context) {
  global $user;

  $account = $object;

  if (!isset($account)) {
    $account = $context['account'];
  }

  if (!isset($account)) {
    $account = $user;
  }

  return $account;
}
<?php
// $Id: twocol.inc,v 1.1.2.3 2010/06/22 15:54:25 merlinofchaos Exp $

// Plugin definition
$plugin = array(
  'title' => t('Information'),
  'category' => t('Miscellaneous'),
  'icon' => 'information.png',
  'theme' => 'panels_information',
  'css' => 'information.css',
  'panels' => array(
    'left' => t('Left side'),
    'right' => t('Right side')
  ),
);

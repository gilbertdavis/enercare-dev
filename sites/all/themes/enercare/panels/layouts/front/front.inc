<?php
// $Id: twocol.inc,v 1.1.2.3 2010/06/22 15:54:25 merlinofchaos Exp $

// Plugin definition
$plugin = array(
  'title' => t('Front Page'),
  'category' => t('Miscellaneous'),
  'icon' => 'front.png',
  'theme' => 'panels_front',
  'css' => 'front.css',
  'panels' => array(
    'banner' => t('Banner'),
    'solutions' => t('Solutions'),
		'connections' => t('Connections'),
		'notice' => t('Notice'),
		'offer_solutions' => t('Connections Offer'),
		'offer_connections' => t('Solutions Offer')
  ),
);

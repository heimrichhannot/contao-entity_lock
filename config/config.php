<?php

/**
* Backend modules
*/
$GLOBALS['BE_MOD']['accounts']['entity_lock'] = array(
	'tables' => array('tl_entity_lock'),
	'icon'   => 'system/modules/entity_lock/assets/img/icon.png'
);

/**
* Models
*/
$GLOBALS['TL_MODELS']['tl_entity_lock'] = '\HeimrichHannot\EntityLock\EntityLockModel';
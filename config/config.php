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

/**
 * Entity title fields
 */
$GLOBALS['TL_CONFIG']['entityLockEntityTitleFields'] = array(
	'tl_article' => array(
		'fields' => array('title', 'id'),
		'format' => '%s (ID:%s)',
		'queryField' => 'title',
	),
	'tl_calendar_events' => array(
		'fields' => array('title', 'id'),
		'format' => '%s (ID:%s)',
		'queryField' => 'title',
	),
	'tl_news' => array(
		'fields' => array('headline', 'id'),
		'format' => '%s (ID:%s)',
		'queryField' => 'headline',
	)
);
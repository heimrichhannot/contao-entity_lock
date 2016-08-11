<?php

$arrDca = &$GLOBALS['TL_DCA']['tl_module'];

/**
 * Subpalettes
 */
$arrDca['palettes']['__selector__'][] = 'addEntityLock';
$arrDca['palettes']['__selector__'][] = 'overrideLockIntervals';
$arrDca['palettes']['__selector__'][] = 'allowLockDeletion';

$arrDca['subpalettes']['addEntityLock'] = 'addEditorToLockMessage,overrideLockIntervals,allowLockDeletion,readOnlyOnLocked';
$arrDca['subpalettes']['overrideLockIntervals'] = 'lockIntervals';
$arrDca['subpalettes']['allowLockDeletion'] = 'lockDeletionNotification';

/**
 * Fields
 */
$arrFields = array(
	'addEntityLock' => array(
		'label'                   => &$GLOBALS['TL_LANG']['tl_module']['addEntityLock'],
		'exclude'                 => true,
		'inputType'               => 'checkbox',
		'eval'                    => array('submitOnChange' => true, 'tl_class' => 'w50 clr'),
		'sql'                     => "char(1) NOT NULL default ''"
	),
	'addEditorToLockMessage' => array(
		'label'                   => &$GLOBALS['TL_LANG']['tl_module']['addEditorToLockMessage'],
		'exclude'                 => true,
		'inputType'               => 'checkbox',
		'eval'                    => array('tl_class' => 'w50 clr'),
		'sql'                     => "char(1) NOT NULL default ''"
	),
	'overrideLockIntervals' => array(
		'label'                   => &$GLOBALS['TL_LANG']['tl_module']['overrideLockIntervals'],
		'exclude'                 => true,
		'inputType'               => 'checkbox',
		'eval'                    => array('submitOnChange' => true, 'tl_class' => 'w50 clr'),
		'sql'                     => "char(1) NOT NULL default ''"
	),
	'lockIntervals' => array(
		'label'                   => &$GLOBALS['TL_LANG']['tl_module']['lockIntervals'],
		'exclude'                 => true,
		'inputType' 		=> 'multiColumnWizard',
		'sql' => 'blob NULL',
		'eval' 			=> array
		(
			'tl_class' => 'long clr',
			'columnFields' => array
			(
				'table' => array
				(
					'label'            => &$GLOBALS['TL_LANG']['tl_module']['lockIntervals']['table'],
					'options_callback' => array('HeimrichHannot\Haste\Dca\General', 'getDataContainers'),
					'inputType'        => 'select',
					'eval'             => array('tl_class' => 'w50', 'includeBlankOption' => true,
												'chosen' => true, 'mandatory' => true, 'style' => 'width: 390px;')
				),
				'interval' => array
				(
					'label'     => &$GLOBALS['TL_LANG']['tl_module']['lockIntervals']['interval'],
					'exclude'   => true,
					'inputType' => 'timePeriod',
					'options'   => array('m', 'h', 'd'),
					'reference' => &$GLOBALS['TL_LANG']['MSC']['timePeriod'],
					'eval'      => array('mandatory' => true, 'tl_class' => 'w50')
				)
			)
		),
	),
	'allowLockDeletion' => array(
		'label'                   => &$GLOBALS['TL_LANG']['tl_module']['allowLockDeletion'],
		'exclude'                 => true,
		'inputType'               => 'checkbox',
		'eval'                    => array('submitOnChange' => true, 'tl_class' => 'w50'),
		'sql'                     => "char(1) NOT NULL default ''"
	),
	'lockDeletionNotification'           => array
	(
		'label'            => &$GLOBALS['TL_LANG']['tl_module']['lockDeletionNotification'],
		'exclude'          => true,
		'inputType'        => 'select',
		'options_callback' => array('tl_module_entity_lock', 'getNotificationMessagesAsOptions'),
		'eval'             => array('chosen' => true, 'tl_class' => 'w50', 'includeBlankOption' => true),
		'sql'              => "int(10) unsigned NOT NULL default '0'"
	),
	'readOnlyOnLocked' => array(
		'label'                   => &$GLOBALS['TL_LANG']['tl_module']['readOnlyOnLocked'],
		'exclude'                 => true,
		'inputType'               => 'checkbox',
		'eval'                    => array('tl_class' => 'w50'),
		'sql'                     => "char(1) NOT NULL default ''"
	),
);

$arrDca['fields'] = array_merge($arrFields, $arrDca['fields']);

class tl_module_entity_lock {
	public static function getNotificationMessagesAsOptions()
	{
		return \HeimrichHannot\Haste\Dca\Notification::getNotificationMessagesAsOptions(
			\HeimrichHannot\EntityLock\EntityLock::NOTIFICATION_TYPE_LOCK_DELETED);
	}
}
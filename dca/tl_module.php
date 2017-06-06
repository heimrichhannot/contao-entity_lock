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
$arrFields = [
    'addEntityLock' => [
        'label'                   => &$GLOBALS['TL_LANG']['tl_module']['addEntityLock'],
        'exclude'                 => true,
        'inputType'               => 'checkbox',
        'eval'                    => ['submitOnChange' => true, 'tl_class' => 'w50 clr'],
        'sql'                     => "char(1) NOT NULL default ''"
    ],
    'addEditorToLockMessage' => [
        'label'                   => &$GLOBALS['TL_LANG']['tl_module']['addEditorToLockMessage'],
        'exclude'                 => true,
        'inputType'               => 'checkbox',
        'eval'                    => ['tl_class' => 'w50 clr'],
        'sql'                     => "char(1) NOT NULL default ''"
    ],
    'overrideLockIntervals' => [
        'label'                   => &$GLOBALS['TL_LANG']['tl_module']['overrideLockIntervals'],
        'exclude'                 => true,
        'inputType'               => 'checkbox',
        'eval'                    => ['submitOnChange' => true, 'tl_class' => 'w50 clr'],
        'sql'                     => "char(1) NOT NULL default ''"
    ],
    'lockIntervals' => [
        'label'                   => &$GLOBALS['TL_LANG']['tl_module']['lockIntervals'],
        'exclude'                 => true,
        'inputType' 		=> 'multiColumnWizard',
        'sql' => 'blob NULL',
        'eval' 			=> [
			'tl_class' => 'long clr',
			'columnFields' => [
                'table' => [
                    'label'            => &$GLOBALS['TL_LANG']['tl_module']['lockIntervals']['table'],
                    'options_callback' => ['HeimrichHannot\Haste\Dca\General', 'getDataContainers'],
                    'inputType'        => 'select',
                    'eval'             => [
                        'tl_class' => 'w50', 'includeBlankOption' => true,
                        'chosen'   => true, 'mandatory' => true, 'style' => 'width: 390px;'
                    ]],
                'interval' => [
                    'label'     => &$GLOBALS['TL_LANG']['tl_module']['lockIntervals']['interval'],
                    'exclude'   => true,
                    'inputType' => 'timePeriod',
                    'options'   => ['m', 'h', 'd'],
                    'reference' => &$GLOBALS['TL_LANG']['MSC']['timePeriod'],
                    'eval'      => ['mandatory' => true, 'tl_class' => 'w50']]]],
    ],
    'allowLockDeletion' => [
        'label'                   => &$GLOBALS['TL_LANG']['tl_module']['allowLockDeletion'],
        'exclude'                 => true,
        'inputType'               => 'checkbox',
        'eval'                    => ['submitOnChange' => true, 'tl_class' => 'w50'],
        'sql'                     => "char(1) NOT NULL default ''"
    ],
    'lockDeletionNotification'           => [
        'label'            => &$GLOBALS['TL_LANG']['tl_module']['lockDeletionNotification'],
        'exclude'          => true,
        'inputType'        => 'select',
        'options_callback' => ['tl_module_entity_lock', 'getNotificationMessagesAsOptions'],
        'eval'             => ['chosen' => true, 'tl_class' => 'w50', 'includeBlankOption' => true],
        'sql'              => "int(10) unsigned NOT NULL default '0'"],
    'readOnlyOnLocked' => [
        'label'                   => &$GLOBALS['TL_LANG']['tl_module']['readOnlyOnLocked'],
        'exclude'                 => true,
        'inputType'               => 'checkbox',
        'eval'                    => ['tl_class' => 'w50'],
        'sql'                     => "char(1) NOT NULL default ''"
    ],
];

$arrDca['fields'] = array_merge($arrFields, $arrDca['fields']);

class tl_module_entity_lock {
	public static function getNotificationMessagesAsOptions()
	{
		return \HeimrichHannot\Haste\Dca\Notification::getNotificationMessagesAsOptions(
			\HeimrichHannot\EntityLock\EntityLock::NOTIFICATION_TYPE_LOCK_DELETED);
	}
}
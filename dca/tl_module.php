<?php

$arrDca = &$GLOBALS['TL_DCA']['tl_module'];

/**
 * Subpalettes
 */
$arrDca['palettes']['__selector__'][] = 'addEntityLock';
$arrDca['palettes']['__selector__'][] = 'overrideLockIntervals';

$arrDca['subpalettes']['addEntityLock'] = 'addEditorToLockMessage,overrideLockIntervals';
$arrDca['subpalettes']['overrideLockIntervals'] = 'lockIntervals';

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
	)
);

$arrDca['fields'] = array_merge($arrFields, $arrDca['fields']);
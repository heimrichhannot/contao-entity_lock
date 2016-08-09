<?php

$arrDca = &$GLOBALS['TL_DCA']['tl_settings'];

/**
 * Palettes
 */
$arrDca['palettes']['default'] .= '{locked_legend},lockExplanation,addLockIntervals,allowLockDeletion;';

/**
 * Selectors
 */
$arrDca['palettes']['__selector__'][] = 'addLockIntervals';
$arrDca['palettes']['__selector__'][] = 'allowLockDeletion';

/**
 * Subpalettes
 */
$arrDca['subpalettes']['addLockIntervals'] = 'lockIntervals';
$arrDca['subpalettes']['allowLockDeletion'] = 'lockDeletionPermissions';

/**
 * Fields
 */
$arrFields = array(
	'lockExplanation' => array
	(
		'inputType' => 'explanation',
		'eval'      => array(
			'text'     => &$GLOBALS['TL_LANG']['tl_settings']['lockExplanation'],
			'class'    => 'tl_info',
			'tl_class' => 'long clr'
		),
	),
	'addLockIntervals' => array(
		'label'                   => &$GLOBALS['TL_LANG']['tl_settings']['addLockIntervals'],
		'exclude'                 => true,
		'inputType'               => 'checkbox',
		'eval'                    => array('submitOnChange' => true, 'tl_class' => 'w50')
	),
	'lockIntervals' => array(
		'label'                   => &$GLOBALS['TL_LANG']['tl_settings']['lockIntervals'],
		'exclude'                 => true,
		'inputType' 		=> 'multiColumnWizard',
		'eval' 			=> array
		(
			'tl_class' => 'long clr',
			'columnFields' => array
			(
				'table' => array
				(
					'label'            => &$GLOBALS['TL_LANG']['tl_settings']['lockIntervals']['table'],
					'options_callback' => array('HeimrichHannot\Haste\Dca\General', 'getDataContainers'),
					'inputType'        => 'select',
					'eval'             => array('tl_class' => 'w50', 'includeBlankOption' => true,
												'chosen' => true, 'mandatory' => true, 'style' => 'width: 395px;')
				),
				'interval' => array
				(
					'label'     => &$GLOBALS['TL_LANG']['tl_settings']['lockIntervals']['interval'],
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
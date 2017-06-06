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
$arrFields = [
    'lockExplanation' => [
        'inputType' => 'explanation',
        'eval'      => [
			'text'     => &$GLOBALS['TL_LANG']['tl_settings']['lockExplanation'],
			'class'    => 'tl_info',
			'tl_class' => 'long clr'
        ],],
    'addLockIntervals' => [
		'label'                   => &$GLOBALS['TL_LANG']['tl_settings']['addLockIntervals'],
		'exclude'                 => true,
		'inputType'               => 'checkbox',
		'eval'                    => ['submitOnChange' => true, 'tl_class' => 'w50']
    ],
    'lockIntervals' => [
        'label'                   => &$GLOBALS['TL_LANG']['tl_settings']['lockIntervals'],
        'exclude'                 => true,
        'inputType' 		=> 'multiColumnWizard',
        'eval' 			=> [
			'tl_class' => 'long clr',
			'columnFields' => [
                'table' => [
                    'label'            => &$GLOBALS['TL_LANG']['tl_settings']['lockIntervals']['table'],
                    'options_callback' => ['HeimrichHannot\Haste\Dca\General', 'getDataContainers'],
                    'inputType'        => 'select',
                    'eval'             => [
                        'tl_class' => 'w50', 'includeBlankOption' => true,
                        'chosen'   => true, 'mandatory' => true, 'style' => 'width: 395px;'
                    ]],
                'interval' => [
                    'label'     => &$GLOBALS['TL_LANG']['tl_settings']['lockIntervals']['interval'],
                    'exclude'   => true,
                    'inputType' => 'timePeriod',
                    'options'   => ['m', 'h', 'd'],
                    'reference' => &$GLOBALS['TL_LANG']['MSC']['timePeriod'],
                    'eval'      => ['mandatory' => true, 'tl_class' => 'w50']]]],
    ]
];

$arrDca['fields'] = array_merge($arrFields, $arrDca['fields']);
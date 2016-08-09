<?php

$arrLang = &$GLOBALS['TL_LANG']['tl_settings'];

/**
 * Fields
 */
$arrLang['lockExplanation'] = 'The lock criteria defined here globally might be overridden in the frontend module used.';
$arrLang['addLockIntervals'] = array('Specify lock intervals', 'Choose this option if locks should be able to expire after some time.');
$arrLang['lockIntervals'] = array('Intervals', 'Specify separately for every table the date/time interval that the specific content should be locked in.');
$arrLang['lockIntervals']['table'] = 'Table';
$arrLang['lockIntervals']['interval'] = 'Interval';

/**
 * Legends
 */
$arrLang['locked_legend'] = 'Lock content';
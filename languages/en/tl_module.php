<?php

$arrLang = &$GLOBALS['TL_LANG']['tl_module'];

/**
 * Fields
 */
$arrLang['addEntityLock'] = ['Lock content while being edited', 'Choose this option if the content should be locked while being edited.'];
$arrLang['overrideLockIntervals'] = ['Override globally defined lock intervals', 'Choose this option, if you would like to override the globally defined lock intervals.'];
$arrLang['lockIntervals'] = ['Intervals', 'Specify separately for every table the date/time interval that the specific content should be locked in.'];
$arrLang['lockIntervals']['table'] = 'Table';
$arrLang['lockIntervals']['interval'] = 'Interval';
$arrLang['allowLockDeletion'] = ['Allow lock deletion', 'Choose this option if frontend users should be able to take records by deleting a the related lock.'];
$arrLang['lockDeletionNotification'] = ['Send notification to former editor', 'Choose this option if the former editor should get informed about the loss of his/her lock.'];
$arrLang['readOnlyOnLocked'] = ['Show locked records read-only', 'Choose this options if users which aren\'t the current editor should be able to read the record. Otherwise the record isn\'t rendered at all.'];

/**
 * Legends
 */
$arrLang['locked_legend'] = 'Lock content';
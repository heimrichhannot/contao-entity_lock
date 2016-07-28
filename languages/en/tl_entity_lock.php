<?php

$arrLang = &$GLOBALS['TL_LANG']['tl_entity_lock'];

/**
 * Fields
 */
$arrLang['title'] = array('Title', 'Type in the title here.');
$arrLang['tstamp'] = array('Change date', '');
$arrLang['parentTable'] = array('Parent table', 'Choose a parent table here.');
$arrLang['pid'] = array('Parent entity', 'Choose a parent entity here.');
$arrLang['editorType'] = array('Editor type', 'Please choose the type of editor.');
$arrLang['editorType'][\HeimrichHannot\EntityLock\EntityLock::EDITOR_TYPE_USER] = 'User (Backend)';
$arrLang['editorType'][\HeimrichHannot\EntityLock\EntityLock::EDITOR_TYPE_MEMBER] = 'Member (Frontend)';
$arrLang['editor'] = array('Editor', 'This field contains the editor in the moment of entity\'s locking.');
$arrLang['locked'] = array('Locked since', 'In this field the date/time of locking is stored.');


/**
 * Legends
 */
$arrLang['editor_legend'] = 'Editor';
$arrLang['entity_legend'] = 'Locked content';
$arrLang['lock_legend'] = 'Lock';

/**
 * Buttons
 */
$arrLang['new'] = array('New lock', 'Create lock');
$arrLang['edit'] = array('Edit lock', 'Edit lock ID %s');
$arrLang['copy'] = array('Copy lock', 'Copy lock ID %s');
$arrLang['delete'] = array('Delete lock', 'Delete lock ID %s');
$arrLang['show'] = array('Lock details', 'Show lock details ID %s');

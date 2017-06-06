<?php

$arrLang = &$GLOBALS['TL_LANG']['tl_entity_lock'];

/**
 * Fields
 */
$arrLang['title'] = ['Title', 'Type in the title here.'];
$arrLang['tstamp'] = ['Change date', ''];
$arrLang['parentTable'] = ['Parent table', 'Choose a parent table here.'];
$arrLang['pid'] = ['Parent entity', 'Choose a parent entity here.'];
$arrLang['editorType'] = ['Editor type', 'Please choose the type of editor.'];
$arrLang['editorType'][\HeimrichHannot\EntityLock\EntityLock::EDITOR_TYPE_USER] = 'User (Backend)';
$arrLang['editorType'][\HeimrichHannot\EntityLock\EntityLock::EDITOR_TYPE_MEMBER] = 'Member (Frontend)';
$arrLang['editor'] = ['Editor', 'This field contains the editor in the moment of entity\'s locking.'];
$arrLang['locked'] = ['Locked since', 'In this field the date/time of locking is stored.'];


/**
 * Legends
 */
$arrLang['editor_legend'] = 'Editor';
$arrLang['entity_legend'] = 'Locked content';
$arrLang['lock_legend'] = 'Lock';

/**
 * Buttons
 */
$arrLang['new'] = ['New lock', 'Create lock'];
$arrLang['edit'] = ['Edit lock', 'Edit lock ID %s'];
$arrLang['copy'] = ['Copy lock', 'Copy lock ID %s'];
$arrLang['delete'] = ['Delete lock', 'Delete lock ID %s'];
$arrLang['show'] = ['Lock details', 'Show lock details ID %s'];

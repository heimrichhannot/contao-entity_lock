<?php

$arrLang = &$GLOBALS['TL_LANG']['tl_entity_lock'];

/**
 * Fields
 */
$arrLang['title'] = array('Titel', 'Geben Sie hier bitte den Titel ein.');
$arrLang['tstamp'] = array('Änderungsdatum', '');
$arrLang['parentTable'] = array('Elterntabelle', 'Wählen Sie hier eine Elterntabelle aus.');
$arrLang['pid'] = array('Elternentität', 'Wählen Sie hier eine Elternentität aus.');
$arrLang['editorType'] = array('Bearbeitertyp', 'Wählen Sie hier den Typ des Bearbeiters aus.');
$arrLang['editorType'][\HeimrichHannot\EntityLock\EntityLock::EDITOR_TYPE_USER] = 'Benutzer (Backend)';
$arrLang['editorType'][\HeimrichHannot\EntityLock\EntityLock::EDITOR_TYPE_MEMBER] = 'Mitglied (Frontend)';
$arrLang['editor'] = array('Bearbeiter', 'Dieses Feld beinhaltet den Bearbeiter zum Sperrzeitpunkt.');
$arrLang['locked'] = array('Gesperrt seit', 'In diesem Feld wird gespeichert, seit wann der Inhalt gesperrt ist.');


/**
 * Legends
 */
$arrLang['editor_legend'] = 'Bearbeiter';
$arrLang['entity_legend'] = 'Gesperrter Inhalt';
$arrLang['lock_legend'] = 'Sperrung';

/**
 * Buttons
 */
$arrLang['new'] = array('Neue Sperrung', 'Sperrung erstellen');
$arrLang['edit'] = array('Sperrung bearbeiten', 'Sperrung ID %s bearbeiten');
$arrLang['copy'] = array('Sperrung duplizieren', 'Sperrung ID %s duplizieren');
$arrLang['delete'] = array('Sperrung löschen', 'Sperrung ID %s löschen');
$arrLang['show'] = array('Sperrung Details', 'Sperrung-Details ID %s anzeigen');

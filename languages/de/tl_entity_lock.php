<?php

$arrLang = &$GLOBALS['TL_LANG']['tl_entity_lock'];

/**
 * Fields
 */
$arrLang['title'] = ['Titel', 'Geben Sie hier bitte den Titel ein.'];
$arrLang['tstamp'] = ['Änderungsdatum', ''];
$arrLang['parentTable'] = ['Elterntabelle', 'Wählen Sie hier eine Elterntabelle aus.'];
$arrLang['pid'] = ['Elternentität', 'Wählen Sie hier eine Elternentität aus.'];
$arrLang['editorType'] = ['Bearbeitertyp', 'Wählen Sie hier den Typ des Bearbeiters aus.'];
$arrLang['editorType'][\HeimrichHannot\EntityLock\EntityLock::EDITOR_TYPE_USER] = 'Benutzer (Backend)';
$arrLang['editorType'][\HeimrichHannot\EntityLock\EntityLock::EDITOR_TYPE_MEMBER] = 'Mitglied (Frontend)';
$arrLang['editor'] = ['Bearbeiter', 'Dieses Feld beinhaltet den Bearbeiter zum Sperrzeitpunkt.'];
$arrLang['locked'] = ['Gesperrt seit', 'In diesem Feld wird gespeichert, seit wann der Inhalt gesperrt ist.'];


/**
 * Legends
 */
$arrLang['editor_legend'] = 'Bearbeiter';
$arrLang['entity_legend'] = 'Gesperrter Inhalt';
$arrLang['lock_legend'] = 'Sperrung';

/**
 * Buttons
 */
$arrLang['new'] = ['Neue Sperrung', 'Sperrung erstellen'];
$arrLang['edit'] = ['Sperrung bearbeiten', 'Sperrung ID %s bearbeiten'];
$arrLang['copy'] = ['Sperrung duplizieren', 'Sperrung ID %s duplizieren'];
$arrLang['delete'] = ['Sperrung löschen', 'Sperrung ID %s löschen'];
$arrLang['show'] = ['Sperrung Details', 'Sperrung-Details ID %s anzeigen'];

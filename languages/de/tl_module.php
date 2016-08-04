<?php

$arrLang = &$GLOBALS['TL_LANG']['tl_module'];

/**
 * Fields
 */
$arrLang['addEntityLock'] = array('Inhalte bei Bearbeitung sperren', 'Wählen Sie diese Option, wenn die Inhalte bei Bearbeitung gesperrt werden sollen.');
$arrLang['addEditorToLockMessage'] = array('Den aktuellen Bearbeiter zur Meldung hinzufügen', 'Wählen Sie diese Option, wenn die Meldung, die erscheint, wenn ein Datensatz aktuell gesperrt ist und ein andere Nutzer darauf zuzugreifen versucht, auch den Namen des aktuellen Bearbeiters enthalten soll.');
$arrLang['overrideLockIntervals'] = array('Global definierte Sperrungszeiträume überschreiben', 'Wählen Sie diese Option, wenn Sie die in den globalen Contao-Einstellungen definierten Sperrzeiträume überschreiben möchten.');
$arrLang['lockIntervals'] = array('Zeiträume', 'Legen Sie hier für jede Tabelle separat den Zeitraum fest, für den der entsprechende Inhalt bei Bearbeitung gesperrt werden soll.');
$arrLang['lockIntervals']['table'] = 'Tabelle';
$arrLang['lockIntervals']['interval'] = 'Intervall';

/**
 * Legends
 */
$arrLang['locked_legend'] = 'Inhalte sperren';
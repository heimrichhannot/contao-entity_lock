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
$arrLang['allowLockDeletion'] = array('Das Entfernen von Sperrungen erlauben', 'Wählen Sie diese Option, wenn Frontend-Nutzer die Möglichkeit haben sollen, Sperrungen zu entfernen.');
$arrLang['lockDeletionNotification'] = array('Benachrichtigung nach dem Entfernen der Sperrung senden', 'Wählen Sie diese Option, wenn der vorherige Bearbeiter über die Entfernung seiner Sperre informiert werden soll.');
$arrLang['readOnlyOnLocked'] = array('Gesperrte Datensätze im Lesemodus anzeigen', 'Wählen Sie diese Option, wenn gesperrte Datensätze für alle Frontend-Nutzer außer dem aktuellen Bearbeiter im Lesemodus angezeigt werden dürfen. Andernfalls wird der Datensatz gar nicht angezeigt.');

/**
 * Legends
 */
$arrLang['locked_legend'] = 'Inhalte sperren';
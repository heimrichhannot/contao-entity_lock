<?php

/**
* Backend modules
*/
$GLOBALS['BE_MOD']['accounts']['entity_lock'] = [
    'tables' => ['tl_entity_lock'],
    'icon'   => 'system/modules/entity_lock/assets/img/icon.png'
];

/**
* Models
*/
$GLOBALS['TL_MODELS']['tl_entity_lock'] = '\HeimrichHannot\EntityLock\EntityLockModel';

/**
 * Entity title fields
 */
$GLOBALS['TL_CONFIG']['entityLockEntityTitleFields'] = [
    'tl_article' => [
        'fields' => ['title', 'id'],
        'format' => '%s (ID:%s)',
        'queryField' => 'title',
    ],
    'tl_calendar_events' => [
        'fields' => ['title', 'id'],
        'format' => '%s (ID:%s)',
        'queryField' => 'title',
    ],
    'tl_news' => [
        'fields' => ['headline', 'id'],
        'format' => '%s (ID:%s)',
        'queryField' => 'headline',
    ]
];

/**
 * Notification Center Notification Types
 */
$arrLockDeleted = \HeimrichHannot\Haste\Dca\Notification::getNewNotificationTypeArray(true);
$arrLockDeleted = \HeimrichHannot\Haste\Dca\Notification::addFormHybridStyleEntityTokens('entity', $arrLockDeleted);
$arrLockDeleted = \HeimrichHannot\Haste\Dca\Notification::addFormHybridStyleEntityTokens('former_editor', $arrLockDeleted);
$arrLockDeleted['email_text'][] = 'salutation_former_editor';
$arrLockDeleted['email_html'][] = 'salutation_former_editor';

\HeimrichHannot\Haste\Dca\Notification::activateType(
	\HeimrichHannot\EntityLock\EntityLock::NOTIFICATION_TYPE_ENTITY_LOCK,
	\HeimrichHannot\EntityLock\EntityLock::NOTIFICATION_TYPE_LOCK_DELETED,
	$arrLockDeleted
);
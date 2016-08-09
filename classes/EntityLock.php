<?php

namespace HeimrichHannot\EntityLock;

use Haste\Util\Url;
use HeimrichHannot\FormHybrid\DC_Hybrid;
use HeimrichHannot\Haste\DateUtil;
use HeimrichHannot\NotificationCenterPlus\NotificationCenterPlus;
use HeimrichHannot\Submissions\SubmissionModel;
use NotificationCenter\Model\Message;

class EntityLock
{
	const DEFAULT_PALETTE = '{locked_legend},addEntityLock;';

	const EDITOR_TYPE_USER = 'user';
	const EDITOR_TYPE_MEMBER = 'member';

	const NOTIFICATION_TYPE_ENTITY_LOCK = 'entity_lock';
	const NOTIFICATION_TYPE_LOCK_DELETED = 'lock_deleted';

	const ACT_UNLOCK = 'unlock';

	public static function lockOnLoad(\DataContainer $objDc)
	{
		// frontend handling has to be done in the module since some core onload_callbacks cannot be run in frontend
		if (TL_MODE == 'BE' && ($intId = \Input::get('id')) && ($strTable = $objDc->table))
		{
			if (EntityLockModel::isLocked($strTable, $intId) === null)
			{
				EntityLockModel::create($strTable, $intId);
			}
		}
	}

	/**
	 * @param              $strTable
	 * @param \Module|null $objModule
	 *
	 * @return null|int Returns the lock interval in seconds or false if no interval is set
	 */
	public static function getLockIntervalInSeconds($strTable, \Module $objModule = null)
	{
		$arrLocks = array();

		if ($objModule !== null && $objModule->addEntityLock && $objModule->overrideLockIntervals)
		{
			$arrLocks = deserialize($objModule->lockIntervals, true);
		}
		else
		{
			if (\Config::get('addLockIntervals'))
			{
				$arrLocks = deserialize(\Config::get('lockIntervals'), true);
			}
		}

		if (!empty($arrLocks))
		{
			foreach ($arrLocks as $arrLock)
			{
				if ($arrLock['table'] == $strTable)
				{
					return DateUtil::getTimePeriodInSeconds($arrLock['interval']);
				}
			}
		}

		return null;
	}

	public static function generateErrorMessage($strTable, $intEntity, $objModule)
	{
		$objLock = EntityLockModel::findActiveLock($strTable, $intEntity, $objModule);
		$objEditor = EntityLockModel::getEditor($objLock->id);

		if ($objModule->addEditorToLockMessage && $objLock !== null && $objEditor !== null)
		{
			$strName = $objLock->editorType == EntityLock::EDITOR_TYPE_USER ? $objEditor->name : $objEditor->firstname . ' ' . $objEditor->lastname;
			$strMessage = sprintf($GLOBALS['TL_LANG']['MSC']['entity_lock']['entityLockedEditor'], $strName);
		}
		else
		{
			$strMessage = $GLOBALS['TL_LANG']['MSC']['entity_lock']['entityLocked'];
		}

		// HOOK: further customize the error message
		if (isset($GLOBALS['TL_HOOKS']['customizeLockErrorMessage']) && is_array($GLOBALS['TL_HOOKS']['customizeLockErrorMessage']))
		{
			foreach ($GLOBALS['TL_HOOKS']['customizeLockErrorMessage'] as $callback)
			{
				$objClass = \Controller::importStatic($callback[0]);
				$strMessage = $objClass->{$callback[1]}($strMessage, $objLock, $objEditor, $objModule);
			}
		}

		return $strMessage;
	}

	public static function generateUnlockForm($strTable, $objEntity, $objLock, $objModule, $arrTokens = array())
	{
		$objTemplate = new \FrontendTemplate('entity_lock_unlock_form');
		$objTemplate->action = Url::addQueryString('act=unlock', \Environment::get('uri'));
		$objTemplate->formId = 'entity_lock_unlock_' . $objModule->id;
		$objTemplate->lock = $objLock->id;

		// delete if preconditions are given - allow only for the current lock
		$blnIsSubmitted = (\Input::post('FORM_SUBMIT') == $objTemplate->formId);

		if ($blnIsSubmitted && \Input::get('act') == EntityLock::ACT_UNLOCK && $objLock->id == \Input::post('lock'))
		{
			$objFormerEditor = EntityLockModel::getEditor($objLock->id);

			if ($objLock->delete() && $objModule->lockDeletionNotification)
			{
				static::sendLockDeletionNotification($objModule->lockDeletionNotification,
					$strTable, $objEntity, $objFormerEditor, $arrTokens);
			}

			\Controller::redirect(Url::removeQueryString(array('act')), $objTemplate->action);
		}

		return $objTemplate->parse();
	}

	public static function sendLockDeletionNotification($intNotificationMessage, $strTable, \Model $objEntity,
		\MemberModel $objFormerEditor, $arrTokens = array())
	{
		if ($intNotificationMessage && ($objMessage = Message::findByPk($intNotificationMessage)) !== null) {
			$objMessage->strEntityTable = $strTable;
			$objMessage->objEntity = $objEntity;
			$objMessage->objFormerEditor = $objFormerEditor;
			$objMessage->send(array_merge($arrTokens, static::generateTokens($strTable, $objEntity, $objFormerEditor)), $GLOBALS['TL_LANGUAGE']);
		}
	}

	public static function generateTokens($strTable, \Model $objEntity, \MemberModel $objFormerEditor)
	{
		// entity
		\Controller::loadDataContainer($strTable);
		\System::loadLanguageFile($strTable);
		$arrDca = $GLOBALS['TL_DCA'][$strTable];

		$objDc = new DC_Hybrid($strTable);
		$objDc->activeRecord = $objEntity;

		$arrSubmissionData = SubmissionModel::prepareData($objEntity, $strTable, $arrDca, $objDc);
		$arrTokens = SubmissionModel::tokenizeData($arrSubmissionData, 'entity');

		// former editor
		\Controller::loadDataContainer('tl_member');
		\System::loadLanguageFile('tl_member');
		$arrDca = $GLOBALS['TL_DCA']['tl_member'];

		$objDc = new DC_Hybrid('tl_member');
		$objDc->activeRecord = $objFormerEditor;

		$arrSubmissionData = SubmissionModel::prepareData($objFormerEditor, 'tl_member', $arrDca, $objDc);
		$arrTokens = array_merge(SubmissionModel::tokenizeData($arrSubmissionData, 'former_editor'), $arrTokens);
		$arrTokens['salutation_former_editor'] = NotificationCenterPlus::createSalutation($GLOBALS['TL_LANGUAGE'], $objFormerEditor);

		return $arrTokens;
	}
}
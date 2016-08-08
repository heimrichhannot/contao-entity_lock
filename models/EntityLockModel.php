<?php

namespace HeimrichHannot\EntityLock;

use HeimrichHannot\Haste\DateUtil;

class EntityLockModel extends \Model
{

	protected static $strTable = 'tl_entity_lock';

	public static function create($strTable, $intEntity, \Module $objModule = null, $blnForce = false)
	{
		$blnCreate = true;
		$objLock = null;
		$intTime = time();
		list($strEditorType, $intEditor) = static::getCurrentEditor();

		if (!$blnForce)
		{
			$objLock = static::findActiveLock($strTable, $intEntity, $objModule, true);

			if ($objLock === null)
			{
				$blnCreate = true;
				$objLock = new static();
			}
			else
			{
				// throw an exception if there is already a lock linked to another member/user
				// -> this can never be the case!
				if ($objLock->editorType != $strEditorType || $objLock->editor != $intEditor)
				{
					throw new \Exception('Do not run EntityLockModel::create() if the corresponding entity is locked already by someone else!');
				}

				// if the lock is linked to the current editor, the locked time is increased
				$blnCreate = false;
			}
		}

		$objLock->tstamp = $objLock->locked = $intTime;

		if ($blnCreate)
		{
			$objLock->dateAdded = $intTime;
			$objLock->parentTable = $strTable;
			$objLock->pid = $intEntity;
			$objLock->editorType = $strEditorType;
			$objLock->editor = $intEditor;
		}

		$objLock->save();

		return $objLock;
	}

	/**
	 * Check if an entity is locked
	 *
	 * @param $strTable string The table name (e.g. tl_calendar_events)
	 * @param $intEntity int The entity's id
	 *
	 * @return bool
	 */
	public static function isLocked($strTable, $intEntity, \Module $objModule = null)
	{
		$objLock = static::findActiveLock($strTable, $intEntity, $objModule);

		return $objLock !== null && !static::isEditor($objLock);
	}

	/**
	 * Checks if the currently logged in user is the editor of a certain lock
	 * @param $objLock
	 */
	public static function isEditor($objLock)
	{
		list($strEditorType, $intEditor) = static::getCurrentEditor();

		return $objLock->editorType == $strEditorType && $objLock->editor == $intEditor;
	}

	public static function findActiveLock($strTable, $intEntity, \Module $objModule = null)
	{
		$t = static::$strTable;

		$intLockInterval = static::getLockIntervalInSeconds($strTable, $objModule);

		$arrColumns = array("$t.parentTable=?", "$t.pid=?");
		$arrValues = array($strTable, $intEntity);

		if ($intLockInterval !== null && $intLockInterval > 0)
		{
			$arrColumns[] = "UNIX_TIMESTAMP() < $t.locked + ?";
			$arrValues[] = $intLockInterval;
		}

		return static::findBy($arrColumns, $arrValues);
	}

	public static function findLock($strTable, $intEntity)
	{
		$t = static::$strTable;

		$arrColumns = array("$t.parentTable=?", "$t.pid=?");
		$arrValues = array($strTable, $intEntity);

		return static::findBy($arrColumns, $arrValues);
	}

	public static function deleteLocks($strTable, $intEntity)
	{
		if (($objLock = EntityLockModel::findLock($strTable, $intEntity)) !== null)
		{
			while ($objLock->next())
			{
				$objLock->delete();
			}
		}
	}

	public static function getCurrentEditor()
	{
		switch (TL_MODE)
		{
			case 'FE':
				$strEditorType = EntityLock::EDITOR_TYPE_MEMBER;
				$intEditor = \FrontendUser::getInstance()->id;
				break;
			default:
				$strEditorType = EntityLock::EDITOR_TYPE_USER;
				$intEditor = \BackendUser::getInstance()->id;
				break;
		}

		return array($strEditorType, $intEditor);
	}

	public static function getEditor($intLock)
	{
		if (($objLock = static::findByPk($intLock)) === null)
			return null;

		return $objLock->editorType == EntityLock::EDITOR_TYPE_MEMBER ? \MemberModel::findByPk($objLock->editor) :
			\UserModel::findByPk($objLock->editor);
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

}
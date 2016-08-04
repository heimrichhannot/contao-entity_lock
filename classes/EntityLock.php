<?php

namespace HeimrichHannot\EntityLock;

class EntityLock
{
	const DEFAULT_PALETTE = '{locked_legend},addEntityLock;';

	const EDITOR_TYPE_USER = 'user';
	const EDITOR_TYPE_MEMBER = 'member';

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
}
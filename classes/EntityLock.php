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
}
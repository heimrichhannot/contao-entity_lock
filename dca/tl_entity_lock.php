<?php

$GLOBALS['TL_DCA']['tl_entity_lock'] = [
    'config'   => [
        'dataContainer'     => 'Table',
        'enableVersioning'  => true,
        'onload_callback' => [
            ['tl_entity_lock', 'modifyPalette'],
            ['tl_entity_lock', 'setParentEntityTitleField']],
        'onsubmit_callback' => [
            ['HeimrichHannot\Haste\Dca\General', 'setDateAdded'],],
        'sql' => [
			'keys' => [
				'id' => 'primary']]],
    'list'     => [
        'label' => [
            'fields' => ['id'],
            'format' => '%s'],
        'sorting'           => [
            'mode'                  => 1,
            'fields'                => ['dateAdded'],
            'headerFields'          => ['dateAdded'],
            'panelLayout'           => 'filter;search,limit'],
        'global_operations' => [
            'all'    => [
				'label'      => &$GLOBALS['TL_LANG']['MSC']['all'],
				'href'       => 'act=select',
				'class'      => 'header_edit_all',
				'attributes' => 'onclick="Backend.getScrollOffset();"'],],
        'operations' => [
            'edit'   => [
				'label' => &$GLOBALS['TL_LANG']['tl_entity_lock']['edit'],
				'href'  => 'act=edit',
				'icon'  => 'edit.gif'],
            'copy'   => [
				'label' => &$GLOBALS['TL_LANG']['tl_entity_lock']['copy'],
				'href'  => 'act=copy',
				'icon'  => 'copy.gif'],
            'delete' => [
				'label'      => &$GLOBALS['TL_LANG']['tl_entity_lock']['delete'],
				'href'       => 'act=delete',
				'icon'       => 'delete.gif',
				'attributes' => 'onclick="if(!confirm(\'' . $GLOBALS['TL_LANG']['MSC']['deleteConfirm'] . '\'))return false;Backend.getScrollOffset()"'],
            'show'   => [
				'label' => &$GLOBALS['TL_LANG']['tl_entity_lock']['show'],
				'href'  => 'act=show',
				'icon'  => 'show.gif'],]],
    'palettes' => [
		'default' => '{editor_legend},editorType,editor;{entity_legend},parentTable,pid;{lock_legend},locked;'
    ],
    'fields'   => [
        'id' => [
			'sql'                     => "int(10) unsigned NOT NULL auto_increment"],
        'tstamp' => [
			'label'                   => &$GLOBALS['TL_LANG']['tl_entity_lock']['tstamp'],
			'sql'                     => "int(10) unsigned NOT NULL default '0'"],
        'dateAdded' => [
            'label'                   => &$GLOBALS['TL_LANG']['MSC']['dateAdded'],
            'sorting'                 => true,
            'flag'                    => 6,
            'eval'                    => ['rgxp' =>'datim', 'doNotCopy' => true],
            'sql'                     => "int(10) unsigned NOT NULL default '0'"],
        'parentTable' => [
            'label'            => &$GLOBALS['TL_LANG']['tl_entity_lock']['parentTable'],
            'inputType'        => 'select',
            'options_callback' => ['HeimrichHannot\Haste\Dca\General', 'getDataContainers'],
            'sql'              => "varchar(255) NOT NULL default ''",
            'eval'             => [
                'tl_class'  => 'w50', 'chosen' => true, 'submitOnChange' => true,
                'mandatory' => true, 'includeBlankOption' => true
            ]],
        'pid' => [
            'label' => &$GLOBALS['TL_LANG']['tl_entity_lock']['pid'],
            'inputType' => 'tagsinput',
            // string since 0 would be a default value
            'sql' => "varchar(10) NOT NULL default ''",
            'eval' => [
                'placeholder' => &$GLOBALS['TL_LANG']['tl_entity_lock']['placeholders']['pid'],
                'freeInput' => false,
                'mode' => \TagsInput::MODE_REMOTE,
                'remote' => [
                    'fields' => ['id'],
                    'format' => 'ID:%s',
                    'queryField' => 'id',
                    'foreignKey' => '%parentTable%.id',
                    'limit'      => 10,],
                'mandatory'   => true,
                'tl_class'    => 'w50',
            ],],
        'editorType' => [
            'label'      => &$GLOBALS['TL_LANG']['tl_entity_lock']['editorType'],
            'exclude'    => true,
            'filter'     => true,
            'default'    => \HeimrichHannot\EntityLock\EntityLock::EDITOR_TYPE_USER,
            'inputType'  => 'select',
            'options'    => [
				\HeimrichHannot\EntityLock\EntityLock::EDITOR_TYPE_USER,
				\HeimrichHannot\EntityLock\EntityLock::EDITOR_TYPE_MEMBER
            ],
            'reference'  => $GLOBALS['TL_LANG']['tl_entity_lock']['editorType'],
            'eval'       => ['doNotCopy' => true, 'submitOnChange' => true, 'mandatory' => true, 'tl_class' => 'w50 clr'],
            'sql'        => "varchar(255) NOT NULL default 'user'",
        ],
        'editor' => [
            'label'      => &$GLOBALS['TL_LANG']['tl_entity_lock']['editor'],
            'default'    => BackendUser::getInstance()->id,
            'exclude'    => true,
            'search'     => true,
            'filter'     => true,
            'sorting'    => true,
            'flag'       => 11,
            'inputType'  => 'select',
            'options_callback' => ['HeimrichHannot\Haste\Dca\User', 'getUsersAsOptions'],
            'eval'       => [
                'doNotCopy' => true, 'chosen' => true, 'includeBlankOption' => true,
                'mandatory' => true, 'tl_class' => 'w50'
            ],
            'sql'        => "int(10) unsigned NOT NULL default '0'"],
        'locked'      => [
            'label'         => &$GLOBALS['TL_LANG']['tl_entity_lock']['locked'],
            'default'       => time(),
            'exclude'       => true,
            'inputType'     => 'text',
            'eval'          => ['rgxp' => 'datim', 'doNotCopy' => true, 'datepicker' => true, 'tl_class' => 'w50'],
            'sql'           => "int(10) unsigned NULL"],]];


class tl_entity_lock extends \Backend
{
	public static function getParentEntitiesAsOptions(\DataContainer $objDc)
	{
		$arrOptions = [];
		$arrTitleSynonyms = ['title', 'headline', 'name'];

		if (($strParentTable = $objDc->activeRecord->parentTable) && ($strClass = \Model::getClassFromTable($strParentTable)))
		{
			\Controller::loadDataContainer($strParentTable);

			if (($objEntities = $strClass::findAll()) !== null)
			{
				foreach ($arrTitleSynonyms as $strField)
				{
					if (\Database::getInstance()->fieldExists($strField, $strParentTable))
					{
						$arrOptions = $objEntities->fetchEach($strField);
						asort($arrOptions);
						break;
					}
				}
			}
		}

		return $arrOptions;
	}

	public function modifyPalette()
	{
		$objLock = \HeimrichHannot\EntityLock\EntityLockModel::findByPk(\Input::get('id'));
		$arrDca = &$GLOBALS['TL_DCA']['tl_entity_lock'];

		if ($objLock->editorType == \HeimrichHannot\EntityLock\EntityLock::EDITOR_TYPE_MEMBER)
		{
			$arrDca['fields']['editor']['options_callback'] = ['HeimrichHannot\Haste\Dca\Member', 'getMembersAsOptions'];
		}
	}

	public function setParentEntityTitleField()
	{
		$objLock = \HeimrichHannot\EntityLock\EntityLockModel::findByPk(\Input::get('id'));
		$arrDca = &$GLOBALS['TL_DCA']['tl_entity_lock'];

		if ($objLock->parentTable)
		{
			$arrEntityLockEntityTitleFields = \Config::get('entityLockEntityTitleFields');

			if (!isset($arrEntityLockEntityTitleFields[$objLock->parentTable]))
			{
				$arrEntityLockEntityTitleFields[$objLock->parentTable] = [
                    'fields' => ['id'],
                    'format' => 'ID:%s',
                    'queryField' => 'id',
                ];
			}

			$arrDca['fields']['pid']['eval']['remote'] = array_merge($arrDca['fields']['pid']['eval']['remote'], $arrEntityLockEntityTitleFields[$objLock->parentTable]);
		}
	}
}

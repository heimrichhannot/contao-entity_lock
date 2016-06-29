<?php

$GLOBALS['TL_DCA']['tl_entity_lock'] = array
(
	'config'   => array
	(
		'dataContainer'     => 'Table',
		'enableVersioning'  => true,
		'onload_callback' => array
		(
			array('tl_entity_lock', 'modifyPalette'),
		),
		'onsubmit_callback' => array
		(
			array('HeimrichHannot\Haste\Dca\General', 'setDateAdded'),
		),
		'sql' => array
		(
			'keys' => array
			(
				'id' => 'primary'
			)
		)
	),
	'list'     => array
	(
		'label' => array
		(
			'fields' => array('id'),
			'format' => '%s'
		),
		'sorting'           => array
		(
			'mode'                  => 1,
			'fields'                => array('dateAdded'),
			'headerFields'          => array('dateAdded'),
			'panelLayout'           => 'filter;search,limit'
		),
		'global_operations' => array
		(
			'all'    => array
			(
				'label'      => &$GLOBALS['TL_LANG']['MSC']['all'],
				'href'       => 'act=select',
				'class'      => 'header_edit_all',
				'attributes' => 'onclick="Backend.getScrollOffset();"'
			),
		),
		'operations' => array
		(
			'edit'   => array
			(
				'label' => &$GLOBALS['TL_LANG']['tl_entity_lock']['edit'],
				'href'  => 'act=edit',
				'icon'  => 'edit.gif'
			),
			'copy'   => array
			(
				'label' => &$GLOBALS['TL_LANG']['tl_entity_lock']['copy'],
				'href'  => 'act=copy',
				'icon'  => 'copy.gif'
			),
			'delete' => array
			(
				'label'      => &$GLOBALS['TL_LANG']['tl_entity_lock']['delete'],
				'href'       => 'act=delete',
				'icon'       => 'delete.gif',
				'attributes' => 'onclick="if(!confirm(\'' . $GLOBALS['TL_LANG']['MSC']['deleteConfirm'] . '\'))return false;Backend.getScrollOffset()"'
			),
			'show'   => array
			(
				'label' => &$GLOBALS['TL_LANG']['tl_entity_lock']['show'],
				'href'  => 'act=show',
				'icon'  => 'show.gif'
			),
		)
	),
	'palettes' => array(
		'default' => '{editor_legend},editorType,editor;{entity_legend},parentTable,pid;{lock_legend},locked;'
	),
	'fields'   => array
	(
		'id' => array
		(
			'sql'                     => "int(10) unsigned NOT NULL auto_increment"
		),
		'tstamp' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_entity_lock']['tstamp'],
			'sql'                     => "int(10) unsigned NOT NULL default '0'"
		),
		'dateAdded' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['MSC']['dateAdded'],
			'sorting'                 => true,
			'flag'                    => 6,
			'eval'                    => array('rgxp'=>'datim', 'doNotCopy' => true),
			'sql'                     => "int(10) unsigned NOT NULL default '0'"
		),
		'parentTable' => array
		(
			'label'            => &$GLOBALS['TL_LANG']['tl_entity_lock']['parentTable'],
			'inputType'        => 'select',
			'options_callback' => array('HeimrichHannot\Haste\Dca\General', 'getDataContainers'),
			'sql'              => "varchar(255) NOT NULL default ''",
			'eval'             => array('tl_class' => 'w50', 'chosen' => true, 'submitOnChange' => true,
										'mandatory' => true, 'includeBlankOption' => true)
		),
		'pid' => array
		(
			'label'     => &$GLOBALS['TL_LANG']['tl_entity_lock']['pid'],
			'inputType' => 'text',
			'eval'      => array(
				'placeholder'           => &$GLOBALS['TL_LANG']['tl_member']['placeholders']['locations'],
				'freeInput'             => false,
				'mode'                  => \TagsInput::MODE_REMOTE,
				'remoteOptionsCallback' => array('tl_entity_lock', 'getParentEntitiesAsOptions'),
				'remoteLabelAttribute' => 'title',
				'mandatory' => true,
				'tl_class'              => 'w50'
			),
			'sql'       => "int(10) unsigned NOT NULL default '0'",
		),
		'editorType' => array(
			'label'      => &$GLOBALS['TL_LANG']['tl_entity_lock']['editorType'],
			'exclude'    => true,
			'filter'     => true,
			'default'    => \HeimrichHannot\EntityLock\EntityLock::EDITOR_TYPE_USER,
			'inputType'  => 'select',
			'options'    => array(
				\HeimrichHannot\EntityLock\EntityLock::EDITOR_TYPE_USER,
				\HeimrichHannot\EntityLock\EntityLock::EDITOR_TYPE_MEMBER
			),
			'reference'  => $GLOBALS['TL_LANG']['tl_entity_lock']['editorType'],
			'eval'       => array('doNotCopy' => true, 'submitOnChange' => true, 'mandatory' => true, 'tl_class'  => 'w50 clr'),
			'sql'        => "varchar(255) NOT NULL default 'user'",
		),
		'editor' => array
		(
			'label'      => &$GLOBALS['TL_LANG']['tl_entity_lock']['editor'],
			'default'    => BackendUser::getInstance()->id,
			'exclude'    => true,
			'search'     => true,
			'filter'     => true,
			'sorting'    => true,
			'flag'       => 11,
			'inputType'  => 'select',
			'options_callback' => array('HeimrichHannot\Haste\Dca\User', 'getUsersAsOptions'),
			'eval'       => array('doNotCopy' => true, 'chosen' => true, 'includeBlankOption' => true,
								  'mandatory' => true, 'tl_class'  => 'w50'
			),
			'sql'        => "int(10) unsigned NOT NULL default '0'"
		),
		'locked'      => array
		(
			'label'         => &$GLOBALS['TL_LANG']['tl_entity_lock']['locked'],
			'default'       => time(),
			'exclude'       => true,
			'inputType'     => 'text',
			'eval'          => array('rgxp' => 'datim', 'doNotCopy' => true, 'datepicker' => true, 'tl_class' => 'w50'),
			'sql'           => "int(10) unsigned NULL"
		),
	)
);


class tl_entity_lock extends \Backend
{
	public static function getParentEntitiesAsOptions(\DataContainer $objDc)
	{
		$arrOptions = array();
		$arrTitleSynonyms = array('title', 'headline', 'name');

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
			$arrDca['fields']['editor']['options_callback'] = array('HeimrichHannot\Haste\Dca\Member', 'getMembersAsOptions');
		}
	}
}

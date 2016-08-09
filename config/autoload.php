<?php

/**
 * Contao Open Source CMS
 *
 * Copyright (c) 2005-2016 Leo Feyer
 *
 * @license LGPL-3.0+
 */


/**
 * Register the namespaces
 */
ClassLoader::addNamespaces(array
(
	'HeimrichHannot',
));


/**
 * Register the classes
 */
ClassLoader::addClasses(array
(
	// Classes
	'HeimrichHannot\EntityLock\EntityLock'      => 'system/modules/entity_lock/classes/EntityLock.php',
	'HeimrichHannot\EntityLock\Hooks'           => 'system/modules/entity_lock/classes/Hooks.php',

	// Models
	'HeimrichHannot\EntityLock\EntityLockModel' => 'system/modules/entity_lock/models/EntityLockModel.php',
));


/**
 * Register the templates
 */
TemplateLoader::addFiles(array
(
	'entity_lock_unlock_form' => 'system/modules/entity_lock/templates',
));

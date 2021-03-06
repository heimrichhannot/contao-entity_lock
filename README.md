# Entity Lock

A generic module to store arbitrary entity locks in Contao.

## Known limitations

- backend user support is not done, yet -> currently frontend handling only

## Features

- adds a lock entity for storing the current editor, lock time, locked entity, ...
- offers a rich model interface to easily handle creation, update and deletion of locks for any entity
- read the "Usage" chapter for more details on the functionality

## Usage

The module is just a helper module for storing lock relevant information like the editor, the lock time, ...

The intended usage is as follows:

- Some kind of edit form is opened -> Hence the currently edited record (aka entity) should be locked from another concurrent editing.
- A lock is created in the moment of the form's loading.
- On submit of the form the lock is removed and a the user has to be redirected to some other page in order to prevent the form from locking the entity again as happened in the previous step.
- In case of deletion of the entity, of course, all linked locks are also removed.
- The developer can specify how long the lock interval is (in the global settings or overrride it in the module config using *EntityLock::DEFAULT_PALETTE*). After the age of a lock passed this interval it isn't active anymore (it times out).
- The developer can specify in a module's config whether any frontend user can delete active locks (e.g. if the lock is more a hint than a hard barrier)

A module developer using entity_lock can store a new lock, check for their existance in the appropriate places and could use
[heimrichhannot/contao-entity_cleaner](https://github.com/heimrichhannot/contao-entity_cleaner)
in order to remove elapsed locks.

In addition you could use [heimrichhannot/contao-frontendedit](https://github.com/heimrichhannot/contao-frontendedit) to build your frontend module,
since it already supports entity_lock, i.e. new locks are created automatically in frontend.

### Defining custom title fields for auto completion in the parent entity field in a lock

Extend ```$GLOBALS['TL_CONFIG']['entityLockEntityTitleFields']``` defined in config/config.php in order to define mapping for your custom entities. Otherwise auto completion will only use the id field.

## Technical instructions

Do the following in your frontend module (or use [heimrichhannot/contao-frontendedit](https://github.com/heimrichhannot/contao-frontendedit) since it already does that for you):

1. Add the necessary fields to tl_module and check addEntityLock in the module config in Contao:

```
$GLOBALS['TL_DCA']['tl_module']['palettes']['my_module'] .= \HeimrichHannot\EntityLock\EntityLock::DEFAULT_PALETTE;
```

2. Check for existing locks and create one if necessary:

    ```
    if ($this->addEntityLock && EntityLockModel::isLocked('tl_calendar_events', $objEvent->id, $this))
    {
        // do something like display a message that the entity is locked (or check for lock removal being allowed -> see 4.)
    }
    else
    {
        EntityLockModel::create('tl_calendar_events', $objEvent->id, $this);
    }
    ```

3. Remove all locks linked to a certain entity after submission of the edit form and on deletion of the entity:

    ```
    EntityLockModel::deleteLocks('tl_calendar_events', $objEvent->id);
    ```

4. If a frontend user should be able to take over some other user's record (i.e. delete a lock), you can check for that in the module as follows:
 
    ```
    $strMessage = EntityLock::generateErrorMessage('tl_calendar_events', $objEvent->id, $this);
    
    if ($this->allowLockDeletion)
    {
        // generateUnlockForm() also does the actual deletion of the lock and the sending of a notification to the former editor
        $strUnlockForm = $this->generateUnlockForm($objItem, $objLock);
        $strMessage .= $strUnlockForm;
    }
    ```

## Hooks

Name | Arguments | Description
---- | --------- | -----------
customizeLockErrorMessage | $strMessage, $objLock, $objEditor, $objModule | Hook for customizing the error message
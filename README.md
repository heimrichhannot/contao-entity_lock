# Entity Lock

A generic module store arbitrary entity locks in Contao.

## Known limitations

- backend user support is not done, yet -> currently frontend handling only

## Features

- adds a lock entity for storing the current editor, lock time, locked entity, ...
- offers a rich model interface to easily handle creation, update and deletion of locks for any entity

## Usage

The module is just a helper module for storing lock relevant information like the editor, the lock time, ...

The intended usage is as follows:

- Some kind of edit form is opened -> Hence the currently edited record (aka entity) should be locked from another concurrent editing.
- A lock is created in the moment of the form's loading.
- On submit of the form the lock is removed and a the user has to be redirected to some other page in order to prevent the form from locking the entity again as happened in the previous step.
- In case of deletion of the entity, of course, all linked locks are also removed.

A module developer using entity_lock can store a new lock, check for their existance in the appropriate places and could use
[heimrichhannot/contao-entity_cleaner](https://github.com/heimrichhannot/contao-entity_cleaner)
in order to remove elapsed locks.

In addition you could use [heimrichhannot/contao-frontendedit](https://github.com/heimrichhannot/contao-frontendedit) to build your frontend module,
since it already supports entity_lock, i.e. new locks are created automatically in frontend.

## Technical instructions

Do the following in your frontend module (or use [heimrichhannot/contao-frontendedit](https://github.com/heimrichhannot/contao-frontendedit) since it already does that for you):

1. Check for existing locks and create one if necessary:

    ```
    if ($this->addEntityLock && EntityLockModel::isLocked('tl_calendar_events', $objEvent->id, $this))
    {
        // do something like display a message that the entity is locked
    }
    else
    {
        EntityLockModel::create('tl_calendar_events', $objEvent->id, $this);
    }
    ```

2. Remove all locks linked to a certain entity after submission of the edit form and on deletion of the entity:

    ```
    EntityLockModel::deleteLocks('tl_calendar_events', $objEvent->id);
    ```
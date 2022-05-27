<?php

/**
 * `RESTORE` statement.
 */
declare (strict_types=1);
namespace PhpMyAdmin\SqlParser\Statements;

/**
 * `RESTORE` statement.
 *
 * RESTORE TABLE tbl_name [, tbl_name] ... FROM '/path/to/backup/directory'
 */
class RestoreStatement extends MaintenanceStatement
{
    /**
     * Options of this statement.
     *
     * @var array
     */
    public static $OPTIONS = array('TABLE' => 1, 'FROM' => array(2, 'var'));
}
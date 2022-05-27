<?php

/**
 * `SET` statement.
 */
declare (strict_types=1);
namespace PhpMyAdmin\SqlParser\Statements;

use PhpMyAdmin\SqlParser\Components\OptionsArray;
use PhpMyAdmin\SqlParser\Components\SetOperation;
use PhpMyAdmin\SqlParser\Statement;
use function trim;
/**
 * `SET` statement.
 */
class SetStatement extends Statement
{
    /**
     * The clauses of this statement, in order.
     *
     * @see Statement::$CLAUSES
     *
     * @var array
     */
    public static $CLAUSES = array('SET' => array('SET', 3), '_END_OPTIONS' => array('_END_OPTIONS', 1));
    /**
     * Possible exceptions in SET statement.
     *
     * @var array
     */
    public static $OPTIONS = array('CHARSET' => array(3, 'var'), 'CHARACTER SET' => array(3, 'var'), 'NAMES' => array(3, 'var'), 'PASSWORD' => array(3, 'expr'), 'SESSION' => 3, 'GLOBAL' => 3, 'PERSIST' => 3, 'PERSIST_ONLY' => 3, '@@SESSION' => 3, '@@GLOBAL' => 3, '@@PERSIST' => 3, '@@PERSIST_ONLY' => 3);
    /** @var array */
    public static $END_OPTIONS = array('COLLATE' => array(1, 'var'), 'DEFAULT' => 1);
    /**
     * Options used in current statement.
     *
     * @var OptionsArray[]
     */
    public $options;
    /**
     * The end options of this query.
     *
     * @see static::$END_OPTIONS
     *
     * @var OptionsArray
     */
    public $end_options;
    /**
     * The updated values.
     *
     * @var SetOperation[]
     */
    public $set;
    /**
     * @return string
     */
    public function build()
    {
        $ret = 'SET ' . OptionsArray::build($this->options) . ' ' . SetOperation::build($this->set) . ' ' . OptionsArray::build($this->end_options);
        return trim($ret);
    }
}
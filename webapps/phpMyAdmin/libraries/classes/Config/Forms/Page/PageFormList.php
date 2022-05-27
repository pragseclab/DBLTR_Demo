<?php

/**
 * Page preferences form
 */
declare (strict_types=1);
namespace PhpMyAdmin\Config\Forms\Page;

use PhpMyAdmin\Config\Forms\BaseFormList;
class PageFormList extends BaseFormList
{
    /** @var array */
    protected static $all = array('Browse', 'DbStructure', 'Edit', 'Export', 'Import', 'Navi', 'Sql', 'TableStructure');
    /** @var string */
    protected static $ns = '\\PhpMyAdmin\\Config\\Forms\\Page\\';
}
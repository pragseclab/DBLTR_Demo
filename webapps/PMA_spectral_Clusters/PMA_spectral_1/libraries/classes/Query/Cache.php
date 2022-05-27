<?php

declare (strict_types=1);
namespace PhpMyAdmin\Query;

use PhpMyAdmin\Util;
use function array_shift;
use function count;
use function is_array;
/**
 * Handles caching results
 */
class Cache
{
    /** @var array Table data cache */
    private $tableCache = [];
    /**
     * Caches table data so Table does not require to issue
     * SHOW TABLE STATUS again
     *
     * @param array       $tables information for tables of some databases
     * @param string|bool $table  table name
     */
    public function cacheTableData(array $tables, $table) : void
    {
        // Note: I don't see why we would need array_merge_recursive() here,
        // as it creates double entries for the same table (for example a double
        // entry for Comment when changing the storage engine in Operations)
        // Note 2: Instead of array_merge(), simply use the + operator because
        //  array_merge() renumbers numeric keys starting with 0, therefore
        //  we would lose a db name that consists only of numbers
        foreach ($tables as $one_database => $_) {
            if (isset($this->tableCache[$one_database])) {
                // the + operator does not do the intended effect
                // when the cache for one table already exists
                if ($table && isset($this->tableCache[$one_database][$table])) {
                    unset($this->tableCache[$one_database][$table]);
                }
                $this->tableCache[$one_database] += $tables[$one_database];
            } else {
                $this->tableCache[$one_database] = $tables[$one_database];
            }
        }
    }
    /**
     * Set an item in table cache using dot notation.
     *
     * @param array|null $contentPath Array with the target path
     * @param mixed      $value       Target value
     */
    public function cacheTableContent(?array $contentPath, $value) : void
    {
        $loc =& $this->tableCache;
        if (!isset($contentPath)) {
            $loc = $value;
            return;
        }
        while (count($contentPath) > 1) {
            $key = array_shift($contentPath);
            // If the key doesn't exist at this depth, we will just create an empty
            // array to hold the next value, allowing us to create the arrays to hold
            // final values at the correct depth. Then we'll keep digging into the
            // array.
            if (!isset($loc[$key]) || !is_array($loc[$key])) {
                $loc[$key] = [];
            }
            $loc =& $loc[$key];
        }
        $loc[array_shift($contentPath)] = $value;
    }
    /**
     * Get a cached value from table cache.
     *
     * @param array $contentPath Array of the name of the target value
     * @param mixed $default     Return value on cache miss
     *
     * @return mixed cached value or default
     */
    public function getCachedTableContent(array $contentPath, $default = null)
    {
        return Util::getValueByKey($this->tableCache, $contentPath, $default);
    }
    public function getCache() : array
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("getCache") from ("/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_1/libraries/classes/Query/Cache.php at line 85")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called getCache:85@/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_1/libraries/classes/Query/Cache.php');
        die();
    }
    public function clearTableCache() : void
    {
        $this->tableCache = [];
    }
}
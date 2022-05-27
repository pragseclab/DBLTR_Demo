<?php

declare (strict_types=1);
namespace PhpMyAdmin;

use function array_pop;
use function count;
use function htmlspecialchars;
use function strlen;
/**
 * Index manipulation class
 */
class Index
{
    public const PRIMARY = 1;
    public const UNIQUE = 2;
    public const INDEX = 4;
    public const SPATIAL = 8;
    public const FULLTEXT = 16;
    /**
     * Class-wide storage container for indexes (caching, singleton)
     *
     * @var array
     */
    private static $registry = [];
    /** @var string The name of the schema */
    private $schema = '';
    /** @var string The name of the table */
    private $table = '';
    /** @var string The name of the index */
    private $name = '';
    /**
     * Columns in index
     *
     * @var array
     */
    private $columns = [];
    /**
     * The index method used (BTREE, HASH, RTREE).
     *
     * @var string
     */
    private $type = '';
    /**
     * The index choice (PRIMARY, UNIQUE, INDEX, SPATIAL, FULLTEXT)
     *
     * @var string
     */
    private $choice = '';
    /**
     * Various remarks.
     *
     * @var string
     */
    private $remarks = '';
    /**
     * Any comment provided for the index with a COMMENT attribute when the
     * index was created.
     *
     * @var string
     */
    private $comment = '';
    /** @var int 0 if the index cannot contain duplicates, 1 if it can. */
    private $nonUnique = 0;
    /**
     * Indicates how the key is packed. NULL if it is not.
     *
     * @var string
     */
    private $packed = null;
    /**
     * Block size for the index
     *
     * @var int
     */
    private $keyBlockSize = null;
    /**
     * Parser option for the index
     *
     * @var string
     */
    private $parser = null;
    /**
     * @param array $params parameters
     */
    public function __construct(array $params = [])
    {
        $this->set($params);
    }
    /**
     * Creates(if not already created) and returns the corresponding Index object
     *
     * @param string $schema     database name
     * @param string $table      table name
     * @param string $index_name index name
     *
     * @return Index corresponding Index object
     */
    public static function singleton($schema, $table, $index_name = '')
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("singleton") from ("/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_5/libraries/classes/Index.php at line 101")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called singleton:101@/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_5/libraries/classes/Index.php');
        die();
    }
    /**
     * returns an array with all indexes from the given table
     *
     * @param string $table  table
     * @param string $schema schema
     *
     * @return Index[]  array of indexes
     */
    public static function getFromTable($table, $schema)
    {
        self::loadIndexes($table, $schema);
        if (isset(self::$registry[$schema][$table])) {
            return self::$registry[$schema][$table];
        }
        return [];
    }
    /**
     * Returns an array with all indexes from the given table of the requested types
     *
     * @param string $table   table
     * @param string $schema  schema
     * @param int    $choices choices
     *
     * @return Index[] array of indexes
     */
    public static function getFromTableByChoice($table, $schema, $choices = 31)
    {
        $indexes = [];
        foreach (self::getFromTable($table, $schema) as $index) {
            if ($choices & self::PRIMARY && $index->getChoice() === 'PRIMARY') {
                $indexes[] = $index;
            }
            if ($choices & self::UNIQUE && $index->getChoice() === 'UNIQUE') {
                $indexes[] = $index;
            }
            if ($choices & self::INDEX && $index->getChoice() === 'INDEX') {
                $indexes[] = $index;
            }
            if ($choices & self::SPATIAL && $index->getChoice() === 'SPATIAL') {
                $indexes[] = $index;
            }
            if (!($choices & self::FULLTEXT) || $index->getChoice() !== 'FULLTEXT') {
                continue;
            }
            $indexes[] = $index;
        }
        return $indexes;
    }
    /**
     * return primary if set, false otherwise
     *
     * @param string $table  table
     * @param string $schema schema
     *
     * @return mixed primary index or false if no one exists
     */
    public static function getPrimary($table, $schema)
    {
        self::loadIndexes($table, $schema);
        if (isset(self::$registry[$schema][$table]['PRIMARY'])) {
            return self::$registry[$schema][$table]['PRIMARY'];
        }
        return false;
    }
    /**
     * Load index data for table
     *
     * @param string $table  table
     * @param string $schema schema
     *
     * @return bool whether loading was successful
     */
    private static function loadIndexes($table, $schema)
    {
        global $dbi;
        if (isset(self::$registry[$schema][$table])) {
            return true;
        }
        $_raw_indexes = $dbi->getTableIndexes($schema, $table);
        foreach ($_raw_indexes as $_each_index) {
            $_each_index['Schema'] = $schema;
            $keyName = $_each_index['Key_name'];
            if (!isset(self::$registry[$schema][$table][$keyName])) {
                $key = new Index($_each_index);
                self::$registry[$schema][$table][$keyName] = $key;
            } else {
                $key = self::$registry[$schema][$table][$keyName];
            }
            $key->addColumn($_each_index);
        }
        return true;
    }
    /**
     * Add column to index
     *
     * @param array $params column params
     *
     * @return void
     */
    public function addColumn(array $params)
    {
        if (!isset($params['Column_name']) || strlen($params['Column_name']) <= 0) {
            return;
        }
        $this->columns[$params['Column_name']] = new IndexColumn($params);
    }
    /**
     * Adds a list of columns to the index
     *
     * @param array $columns array containing details about the columns
     *
     * @return void
     */
    public function addColumns(array $columns)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("addColumns") from ("/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_5/libraries/classes/Index.php at line 227")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called addColumns:227@/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_5/libraries/classes/Index.php');
        die();
    }
    /**
     * Returns true if $column indexed in this index
     *
     * @param string $column the column
     *
     * @return bool true if $column indexed in this index
     */
    public function hasColumn($column)
    {
        return isset($this->columns[$column]);
    }
    /**
     * Sets index details
     *
     * @param array $params index details
     *
     * @return void
     */
    public function set(array $params)
    {
        if (isset($params['columns'])) {
            $this->addColumns($params['columns']);
        }
        if (isset($params['Schema'])) {
            $this->schema = $params['Schema'];
        }
        if (isset($params['Table'])) {
            $this->table = $params['Table'];
        }
        if (isset($params['Key_name'])) {
            $this->name = $params['Key_name'];
        }
        if (isset($params['Index_type'])) {
            $this->type = $params['Index_type'];
        }
        if (isset($params['Comment'])) {
            $this->remarks = $params['Comment'];
        }
        if (isset($params['Index_comment'])) {
            $this->comment = $params['Index_comment'];
        }
        if (isset($params['Non_unique'])) {
            $this->nonUnique = $params['Non_unique'];
        }
        if (isset($params['Packed'])) {
            $this->packed = $params['Packed'];
        }
        if (isset($params['Index_choice'])) {
            $this->choice = $params['Index_choice'];
        } elseif ($this->name === 'PRIMARY') {
            $this->choice = 'PRIMARY';
        } elseif ($this->type === 'FULLTEXT') {
            $this->choice = 'FULLTEXT';
            $this->type = '';
        } elseif ($this->type === 'SPATIAL') {
            $this->choice = 'SPATIAL';
            $this->type = '';
        } elseif ($this->nonUnique == '0') {
            $this->choice = 'UNIQUE';
        } else {
            $this->choice = 'INDEX';
        }
        if (isset($params['Key_block_size'])) {
            $this->keyBlockSize = $params['Key_block_size'];
        }
        if (!isset($params['Parser'])) {
            return;
        }
        $this->parser = $params['Parser'];
    }
    /**
     * Returns the number of columns of the index
     *
     * @return int the number of the columns
     */
    public function getColumnCount()
    {
        return count($this->columns);
    }
    /**
     * Returns the index comment
     *
     * @return string index comment
     */
    public function getComment()
    {
        return $this->comment;
    }
    /**
     * Returns index remarks
     *
     * @return string index remarks
     */
    public function getRemarks()
    {
        return $this->remarks;
    }
    /**
     * Return the key block size
     *
     * @return int
     */
    public function getKeyBlockSize()
    {
        return $this->keyBlockSize;
    }
    /**
     * Return the parser
     *
     * @return string
     */
    public function getParser()
    {
        return $this->parser;
    }
    /**
     * Returns concatenated remarks and comment
     *
     * @return string concatenated remarks and comment
     */
    public function getComments()
    {
        $comments = $this->getRemarks();
        if (strlen($comments) > 0) {
            $comments .= "\n";
        }
        $comments .= $this->getComment();
        return $comments;
    }
    /**
     * Returns index type (BTREE, HASH, RTREE)
     *
     * @return string index type
     */
    public function getType()
    {
        return $this->type;
    }
    /**
     * Returns index choice (PRIMARY, UNIQUE, INDEX, SPATIAL, FULLTEXT)
     *
     * @return string index choice
     */
    public function getChoice()
    {
        return $this->choice;
    }
    /**
     * Returns a lit of all index types
     *
     * @return string[] index types
     */
    public static function getIndexTypes()
    {
        return ['BTREE', 'HASH'];
    }
    public function hasPrimary() : bool
    {
        return (bool) self::getPrimary($this->table, $this->schema);
    }
    /**
     * Returns how the index is packed
     *
     * @return string how the index is packed
     */
    public function getPacked()
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("getPacked") from ("/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_5/libraries/classes/Index.php at line 414")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called getPacked:414@/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_5/libraries/classes/Index.php');
        die();
    }
    /**
     * Returns 'No' if the index is not packed,
     * how the index is packed if packed
     *
     * @return string
     */
    public function isPacked()
    {
        if ($this->packed === null) {
            return __('No');
        }
        return htmlspecialchars($this->packed);
    }
    /**
     * Returns integer 0 if the index cannot contain duplicates, 1 if it can
     *
     * @return int 0 if the index cannot contain duplicates, 1 if it can
     */
    public function getNonUnique()
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("getNonUnique") from ("/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_5/libraries/classes/Index.php at line 436")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called getNonUnique:436@/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_5/libraries/classes/Index.php');
        die();
    }
    /**
     * Returns whether the index is a 'Unique' index
     *
     * @param bool $as_text whether to output should be in text
     *
     * @return mixed whether the index is a 'Unique' index
     */
    public function isUnique($as_text = false)
    {
        if ($as_text) {
            $r = ['0' => __('Yes'), '1' => __('No')];
        } else {
            $r = ['0' => true, '1' => false];
        }
        return $r[$this->nonUnique];
    }
    /**
     * Returns the name of the index
     *
     * @return string the name of the index
     */
    public function getName()
    {
        return $this->name;
    }
    /**
     * Sets the name of the index
     *
     * @param string $name index name
     *
     * @return void
     */
    public function setName($name)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("setName") from ("/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_5/libraries/classes/Index.php at line 472")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called setName:472@/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_5/libraries/classes/Index.php');
        die();
    }
    /**
     * Returns the columns of the index
     *
     * @return IndexColumn[] the columns of the index
     */
    public function getColumns()
    {
        return $this->columns;
    }
    /**
     * Gets the properties in an array for comparison purposes
     *
     * @return array an array containing the properties of the index
     */
    public function getCompareData()
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("getCompareData") from ("/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_5/libraries/classes/Index.php at line 490")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called getCompareData:490@/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_5/libraries/classes/Index.php');
        die();
    }
    /**
     * Function to check over array of indexes and look for common problems
     *
     * @param string $table  table name
     * @param string $schema schema name
     *
     * @return string  Output HTML
     *
     * @access public
     */
    public static function findDuplicates($table, $schema)
    {
        $indexes = self::getFromTable($table, $schema);
        $output = '';
        // count($indexes) < 2:
        //   there is no need to check if there less than two indexes
        if (count($indexes) < 2) {
            return $output;
        }
        // remove last index from stack and ...
        while ($while_index = array_pop($indexes)) {
            // ... compare with every remaining index in stack
            foreach ($indexes as $each_index) {
                if ($each_index->getCompareData() !== $while_index->getCompareData()) {
                    continue;
                }
                // did not find any difference
                // so it makes no sense to have this two equal indexes
                $message = Message::notice(__('The indexes %1$s and %2$s seem to be equal and one of them ' . 'could possibly be removed.'));
                $message->addParam($each_index->getName());
                $message->addParam($while_index->getName());
                $output .= $message->getDisplay();
                // there is no need to check any further indexes if we have already
                // found that this one has a duplicate
                continue 2;
            }
        }
        return $output;
    }
}
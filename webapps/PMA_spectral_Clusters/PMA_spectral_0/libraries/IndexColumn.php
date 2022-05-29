<?php

/* vim: set expandtab sw=4 ts=4 sts=4: */
/**
 * holds the database index columns class
 *
 * @package PhpMyAdmin
 */
namespace PMA\libraries;

/**
 * Index column wrapper
 *
 * @package PhpMyAdmin
 */
class IndexColumn
{
    /**
     * @var string The column name
     */
    private $_name = '';
    /**
     * @var integer The column sequence number in the index, starting with 1.
     */
    private $_seq_in_index = 1;
    /**
     * @var string How the column is sorted in the index. “A” (Ascending) or
     * NULL (Not sorted)
     */
    private $_collation = null;
    /**
     * The number of indexed characters if the column is only partly indexed,
     * NULL if the entire column is indexed.
     *
     * @var integer
     */
    private $_sub_part = null;
    /**
     * Contains YES if the column may contain NULL.
     * If not, the column contains NO.
     *
     * @var string
     */
    private $_null = '';
    /**
     * An estimate of the number of unique values in the index. This is updated
     * by running ANALYZE TABLE or myisamchk -a. Cardinality is counted based on
     * statistics stored as integers, so the value is not necessarily exact even
     * for small tables. The higher the cardinality, the greater the chance that
     * MySQL uses the index when doing joins.
     *
     * @var integer
     */
    private $_cardinality = null;
    /**
     * Constructor
     *
     * @param array $params an array containing the parameters of the index column
     */
    public function __construct($params = array())
    {
        $this->set($params);
    }
    /**
     * Sets parameters of the index column
     *
     * @param array $params an array containing the parameters of the index column
     *
     * @return void
     */
    public function set($params)
    {
        if (isset($params['Column_name'])) {
            $this->_name = $params['Column_name'];
        }
        if (isset($params['Seq_in_index'])) {
            $this->_seq_in_index = $params['Seq_in_index'];
        }
        if (isset($params['Collation'])) {
            $this->_collation = $params['Collation'];
        }
        if (isset($params['Cardinality'])) {
            $this->_cardinality = $params['Cardinality'];
        }
        if (isset($params['Sub_part'])) {
            $this->_sub_part = $params['Sub_part'];
        }
        if (isset($params['Null'])) {
            $this->_null = $params['Null'];
        }
    }
    /**
     * Returns the column name
     *
     * @return string column name
     */
    public function getName()
    {
        return $this->_name;
    }
    /**
     * Return the column collation
     *
     * @return string column collation
     */
    public function getCollation()
    {
        return $this->_collation;
    }
    /**
     * Returns the cardinality of the column
     *
     * @return int cardinality of the column
     */
    public function getCardinality()
    {
        return $this->_cardinality;
    }
    /**
     * Returns whether the column is nullable
     *
     * @param boolean $as_text whether to returned the string representation
     *
     * @return mixed nullability of the column. True/false or Yes/No depending
     *               on the value of the $as_text parameter
     */
    public function getNull($as_text = false)
    {
        if ($as_text) {
            if (!$this->_null || $this->_null == 'NO') {
                return __('No');
            } else {
                return __('Yes');
            }
        } else {
            return $this->_null;
        }
    }
    /**
     * Returns the sequence number of the column in the index
     *
     * @return int sequence number of the column in the index
     */
    public function getSeqInIndex()
    {
        return $this->_seq_in_index;
    }
    /**
     * Returns the number of indexed characters if the column is only
     * partly indexed
     *
     * @return int the number of indexed characters
     */
    public function getSubPart()
    {
        return $this->_sub_part;
    }
    /**
     * Gets the properties in an array for comparison purposes
     *
     * @return array an array containing the properties of the index column
     */
    public function getCompareData()
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("getCompareData") from ("/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_0/libraries/IndexColumn.php at line 178")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called getCompareData:178@/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_0/libraries/IndexColumn.php');
        die();
    }
}
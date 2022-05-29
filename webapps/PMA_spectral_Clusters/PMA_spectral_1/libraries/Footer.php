<?php

/* vim: set expandtab sw=4 ts=4 sts=4: */
/**
 * Used to render the footer of PMA's pages
 *
 * @package PhpMyAdmin
 */
namespace PMA\libraries;

use Traversable;
use PMA\libraries\URL;
use PMA\libraries\Sanitize;
use PMA\libraries\Config;
/**
 * Class used to output the footer
 *
 * @package PhpMyAdmin
 */
class Footer
{
    /**
     * Scripts instance
     *
     * @access private
     * @var Scripts
     */
    private $_scripts;
    /**
     * Whether we are servicing an ajax request.
     *
     * @access private
     * @var bool
     */
    private $_isAjax;
    /**
     * Whether to only close the BODY and HTML tags
     * or also include scripts, errors and links
     *
     * @access private
     * @var bool
     */
    private $_isMinimal;
    /**
     * Whether to display anything
     *
     * @access private
     * @var bool
     */
    private $_isEnabled;
    /**
     * Creates a new class instance
     */
    public function __construct()
    {
        $this->_isEnabled = true;
        $this->_scripts = new Scripts();
        $this->_isMinimal = false;
    }
    /**
     * Returns the message for demo server to error messages
     *
     * @return string
     */
    private function _getDemoMessage()
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("_getDemoMessage") from ("/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_1/libraries/Footer.php at line 69")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called _getDemoMessage:69@/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_1/libraries/Footer.php');
        die();
    }
    /**
     * Remove recursions and iterator objects from an object
     *
     * @param object|array &$object Object to clean
     * @param array        $stack   Stack used to keep track of recursion,
     *                              need not be passed for the first time
     *
     * @return object Reference passed object
     */
    private static function _removeRecursion(&$object, $stack = array())
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("_removeRecursion") from ("/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_1/libraries/Footer.php at line 97")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called _removeRecursion:97@/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_1/libraries/Footer.php');
        die();
    }
    /**
     * Renders the debug messages
     *
     * @return string
     */
    public function getDebugMessage()
    {
        $retval = '\'null\'';
        if ($GLOBALS['cfg']['DBG']['sql'] && empty($_REQUEST['no_debug']) && !empty($_SESSION['debug'])) {
            // Remove recursions and iterators from $_SESSION['debug']
            self::_removeRecursion($_SESSION['debug']);
            $retval = JSON_encode($_SESSION['debug']);
            $_SESSION['debug'] = array();
            return json_last_error() ? '\'false\'' : $retval;
        }
        $_SESSION['debug'] = array();
        return $retval;
    }
    /**
     * Returns the url of the current page
     *
     * @return string
     */
    public function getSelfUrl()
    {
        $db = !empty($GLOBALS['db']) ? $GLOBALS['db'] : '';
        $table = !empty($GLOBALS['table']) ? $GLOBALS['table'] : '';
        $target = !empty($_REQUEST['target']) ? $_REQUEST['target'] : '';
        $params = array('db' => $db, 'table' => $table, 'server' => $GLOBALS['server'], 'target' => $target);
        // needed for server privileges tabs
        if (isset($_REQUEST['viewing_mode']) && in_array($_REQUEST['viewing_mode'], array('server', 'db', 'table'))) {
            $params['viewing_mode'] = $_REQUEST['viewing_mode'];
        }
        /*
         * @todo    coming from server_privileges.php, here $db is not set,
         *          add the following condition below when that is fixed
         *          && $_REQUEST['checkprivsdb'] == $db
         */
        if (isset($_REQUEST['checkprivsdb'])) {
            $params['checkprivsdb'] = $_REQUEST['checkprivsdb'];
        }
        /*
         * @todo    coming from server_privileges.php, here $table is not set,
         *          add the following condition below when that is fixed
         *          && $_REQUEST['checkprivstable'] == $table
         */
        if (isset($_REQUEST['checkprivstable'])) {
            $params['checkprivstable'] = $_REQUEST['checkprivstable'];
        }
        if (isset($_REQUEST['single_table']) && in_array($_REQUEST['single_table'], array(true, false))) {
            $params['single_table'] = $_REQUEST['single_table'];
        }
        return basename(PMA_getenv('SCRIPT_NAME')) . URL::getCommonRaw($params);
    }
    /**
     * Renders the link to open a new page
     *
     * @param string $url The url of the page
     *
     * @return string
     */
    private function _getSelfLink($url)
    {
        $retval = '';
        $retval .= '<div id="selflink" class="print_ignore">';
        $retval .= '<a href="' . htmlspecialchars($url) . '"' . ' title="' . __('Open new phpMyAdmin window') . '" target="_blank" rel="noopener noreferrer">';
        if (Util::showIcons('TabsMode')) {
            $retval .= Util::getImage('window-new.png', __('Open new phpMyAdmin window'));
        } else {
            $retval .= __('Open new phpMyAdmin window');
        }
        $retval .= '</a>';
        $retval .= '</div>';
        return $retval;
    }
    /**
     * Renders the link to open a new page
     *
     * @return string
     */
    public function getErrorMessages()
    {
        $retval = '';
        if ($GLOBALS['error_handler']->hasDisplayErrors()) {
            $retval .= $GLOBALS['error_handler']->getDispErrors();
        }
        /**
         * Report php errors
         */
        $GLOBALS['error_handler']->reportErrors();
        return $retval;
    }
    /**
     * Saves query in history
     *
     * @return void
     */
    private function _setHistory()
    {
        if (!PMA_isValid($_REQUEST['no_history']) && empty($GLOBALS['error_message']) && !empty($GLOBALS['sql_query']) && (isset($GLOBALS['dbi']) && ($GLOBALS['dbi']->getLink() || isset($GLOBALS['controllink']) && $GLOBALS['controllink']))) {
            PMA_setHistory(PMA_ifSetOr($GLOBALS['db'], ''), PMA_ifSetOr($GLOBALS['table'], ''), $GLOBALS['cfg']['Server']['user'], $GLOBALS['sql_query']);
        }
    }
    /**
     * Disables the rendering of the footer
     *
     * @return void
     */
    public function disable()
    {
        $this->_isEnabled = false;
    }
    /**
     * Set the ajax flag to indicate whether
     * we are servicing an ajax request
     *
     * @param bool $isAjax Whether we are servicing an ajax request
     *
     * @return void
     */
    public function setAjax($isAjax)
    {
        $this->_isAjax = (bool) $isAjax;
    }
    /**
     * Turn on minimal display mode
     *
     * @return void
     */
    public function setMinimal()
    {
        $this->_isMinimal = true;
    }
    /**
     * Returns the Scripts object
     *
     * @return Scripts object
     */
    public function getScripts()
    {
        return $this->_scripts;
    }
    /**
     * Renders the footer
     *
     * @return string
     */
    public function getDisplay()
    {
        $retval = '';
        $this->_setHistory();
        if ($this->_isEnabled) {
            if (!$this->_isAjax) {
                $retval .= "</div>";
            }
            if (!$this->_isAjax && !$this->_isMinimal) {
                if (PMA_getenv('SCRIPT_NAME') && empty($_POST) && empty($GLOBALS['checked_special']) && !$this->_isAjax) {
                    $url = $this->getSelfUrl();
                    $header = Response::getInstance()->getHeader();
                    $scripts = $header->getScripts()->getFiles();
                    $menuHash = $header->getMenu()->getHash();
                    // prime the client-side cache
                    $this->_scripts->addCode(sprintf('if (! (history && history.pushState)) ' . 'PMA_MicroHistory.primer = {' . ' url: "%s",' . ' scripts: %s,' . ' menuHash: "%s"' . '};', Sanitize::escapeJsString($url), json_encode($scripts), Sanitize::escapeJsString($menuHash)));
                }
                if (PMA_getenv('SCRIPT_NAME') && !$this->_isAjax) {
                    $url = $this->getSelfUrl();
                    $retval .= $this->_getSelfLink($url);
                }
                $this->_scripts->addCode('var debugSQLInfo = ' . $this->getDebugMessage() . ';');
                $retval .= '<div class="clearfloat" id="pma_errors">';
                $retval .= $this->getErrorMessages();
                $retval .= '</div>';
                $retval .= $this->_scripts->getDisplay();
                if ($GLOBALS['cfg']['DBG']['demo']) {
                    $retval .= '<div id="pma_demo">';
                    $retval .= $this->_getDemoMessage();
                    $retval .= '</div>';
                }
                $retval .= Config::renderFooter();
            }
            if (!$this->_isAjax) {
                $retval .= "</body></html>";
            }
        }
        return $retval;
    }
}
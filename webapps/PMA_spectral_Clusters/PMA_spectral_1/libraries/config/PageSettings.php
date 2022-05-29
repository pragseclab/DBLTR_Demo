<?php

/* vim: set expandtab sw=4 ts=4 sts=4: */
/**
 * Page-related settings
 *
 * @package PhpMyAdmin
 */
namespace PMA\libraries\config;

use PMA\libraries\Message;
use PMA\libraries\Response;
require_once 'libraries/user_preferences.lib.php';
require_once 'libraries/config/config_functions.lib.php';
require_once 'libraries/config/messages.inc.php';
require 'libraries/config/user_preferences.forms.php';
require 'libraries/config/page_settings.forms.php';
/**
 * Page-related settings
 *
 * @package PhpMyAdmin
 */
class PageSettings
{
    /**
     * Contains id of the form element
     * @var string
     */
    private $_elemId = 'page_settings_modal';
    /**
     * Name of the group to show
     * @var string
     */
    private $_groupName = '';
    /**
     * Contains HTML of errors
     * @var string
     */
    private $_errorHTML = '';
    /**
     * Contains HTML of settings
     * @var string
     */
    private $_HTML = '';
    /**
     * Constructor
     *
     * @param string $formGroupName The name of config form group to display
     * @param string $elemId        Id of the div containing settings
     */
    public function __construct($formGroupName, $elemId = null)
    {
        global $forms;
        if (empty($forms[$formGroupName])) {
            return;
        }
        if (isset($_REQUEST['printview']) && $_REQUEST['printview'] == '1') {
            return;
        }
        if (!empty($elemId)) {
            $this->_elemId = $elemId;
        }
        $this->_groupName = $formGroupName;
        $cf = new ConfigFile($GLOBALS['PMA_Config']->base_settings);
        PMA_userprefsPageInit($cf);
        $form_display = new FormDisplay($cf);
        foreach ($forms[$formGroupName] as $form_name => $form) {
            // skip Developer form if no setting is available
            if ($form_name == 'Developer' && !$GLOBALS['cfg']['UserprefsDeveloperTab']) {
                continue;
            }
            $form_display->registerForm($form_name, $form, 1);
        }
        // Process form
        $error = null;
        if (isset($_POST['submit_save']) && $_POST['submit_save'] == $formGroupName) {
            $this->_processPageSettings($form_display, $cf, $error);
        }
        // Display forms
        $this->_HTML = $this->_getPageSettingsDisplay($form_display, $error);
    }
    /**
     * Process response to form
     *
     * @param FormDisplay  &$form_display Form
     * @param ConfigFile   &$cf           Configuration file
     * @param Message|null &$error        Error message
     * @param FormDisplay $form_display
     * @param ConfigFile $cf
     *
     * @return void
     */
    private function _processPageSettings(&$form_display, &$cf, &$error)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("_processPageSettings") from ("/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_1/libraries/config/PageSettings.php at line 112")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called _processPageSettings:112@/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_1/libraries/config/PageSettings.php');
        die();
    }
    /**
     * Store errors in _errorHTML
     *
     * @param FormDisplay  &$form_display Form
     * @param Message|null &$error        Error message
     *
     * @return void
     */
    private function _storeError(&$form_display, &$error)
    {
        $retval = '';
        if ($error) {
            $retval .= $error->getDisplay();
        }
        if ($form_display->hasErrors()) {
            // form has errors
            $retval .= '<div class="error config-form">' . '<b>' . __('Cannot save settings, submitted configuration form contains ' . 'errors!') . '</b>' . $form_display->displayErrors() . '</div>';
        }
        $this->_errorHTML = $retval;
    }
    /**
     * Display page-related settings
     *
     * @param FormDisplay &$form_display Form
     * @param Message     &$error        Error message
     *
     * @return string
     */
    private function _getPageSettingsDisplay(&$form_display, &$error)
    {
        $response = Response::getInstance();
        $retval = '';
        $this->_storeError($form_display, $error);
        $retval .= '<div id="' . $this->_elemId . '">';
        $retval .= '<div class="page_settings">';
        $retval .= $form_display->getDisplay(true, true, false, $response->getFooter()->getSelfUrl(), array('submit_save' => $this->_groupName));
        $retval .= '</div>';
        $retval .= '</div>';
        return $retval;
    }
    /**
     * Get HTML output
     *
     * @return string
     */
    public function getHTML()
    {
        return $this->_HTML;
    }
    /**
     * Get error HTML output
     *
     * @return string
     */
    public function getErrorHTML()
    {
        return $this->_errorHTML;
    }
    /**
     * Group to show for Page-related settings
     * @param string $formGroupName The name of config form group to display
     * @return PageSettings
     */
    public static function showGroup($formGroupName)
    {
        $object = new PageSettings($formGroupName);
        $response = Response::getInstance();
        $response->addHTML($object->getErrorHTML());
        $response->addHTML($object->getHTML());
        return $object;
    }
    /**
     * Get HTML for navigation settings
     * @return string
     */
    public static function getNaviSettings()
    {
        $object = new PageSettings('Navi_panel', 'pma_navigation_settings');
        $response = Response::getInstance();
        $response->addHTML($object->getErrorHTML());
        return $object->getHTML();
    }
}
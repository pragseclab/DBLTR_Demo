<?php

/**
 * Page-related settings
 */
declare (strict_types=1);
namespace PhpMyAdmin\Config;

use PhpMyAdmin\Config\Forms\Page\PageFormList;
use PhpMyAdmin\Core;
use PhpMyAdmin\Message;
use PhpMyAdmin\Response;
use PhpMyAdmin\UserPreferences;
/**
 * Page-related settings
 */
class PageSettings
{
    /**
     * Contains id of the form element
     *
     * @var string
     */
    private $elemId = 'page_settings_modal';
    /**
     * Name of the group to show
     *
     * @var string
     */
    private $groupName = '';
    /**
     * Contains HTML of errors
     *
     * @var string
     */
    private $errorHTML = '';
    /**
     * Contains HTML of settings
     *
     * @var string
     */
    private $HTML = '';
    /** @var UserPreferences */
    private $userPreferences;
    /**
     * @param string $formGroupName The name of config form group to display
     * @param string $elemId        Id of the div containing settings
     */
    public function __construct($formGroupName, $elemId = null)
    {
        $this->userPreferences = new UserPreferences();
        $formClass = PageFormList::get($formGroupName);
        if ($formClass === null) {
            return;
        }
        if (isset($_REQUEST['printview']) && $_REQUEST['printview'] == '1') {
            return;
        }
        if (!empty($elemId)) {
            $this->elemId = $elemId;
        }
        $this->groupName = $formGroupName;
        $cf = new ConfigFile($GLOBALS['PMA_Config']->baseSettings);
        $this->userPreferences->pageInit($cf);
        $formDisplay = new $formClass($cf);
        // Process form
        $error = null;
        if (isset($_POST['submit_save']) && $_POST['submit_save'] == $formGroupName) {
            $this->processPageSettings($formDisplay, $cf, $error);
        }
        // Display forms
        $this->HTML = $this->getPageSettingsDisplay($formDisplay, $error);
    }
    /**
     * Process response to form
     *
     * @param FormDisplay  $formDisplay Form
     * @param ConfigFile   $cf          Configuration file
     * @param Message|null $error       Error message
     *
     * @return void
     */
    private function processPageSettings(&$formDisplay, &$cf, &$error)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("processPageSettings") from ("/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_0/libraries/classes/Config/PageSettings.php at line 85")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called processPageSettings:85@/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_0/libraries/classes/Config/PageSettings.php');
        die();
    }
    /**
     * Store errors in _errorHTML
     *
     * @param FormDisplay  $formDisplay Form
     * @param Message|null $error       Error message
     *
     * @return void
     */
    private function storeError(&$formDisplay, &$error)
    {
        $retval = '';
        if ($error) {
            $retval .= $error->getDisplay();
        }
        if ($formDisplay->hasErrors()) {
            // form has errors
            $retval .= '<div class="alert alert-danger config-form" role="alert">' . '<b>' . __('Cannot save settings, submitted configuration form contains ' . 'errors!') . '</b>' . $formDisplay->displayErrors() . '</div>';
        }
        $this->errorHTML = $retval;
    }
    /**
     * Display page-related settings
     *
     * @param FormDisplay $formDisplay Form
     * @param Message     $error       Error message
     *
     * @return string
     */
    private function getPageSettingsDisplay(&$formDisplay, &$error)
    {
        $response = Response::getInstance();
        $retval = '';
        $this->storeError($formDisplay, $error);
        $retval .= '<div id="' . $this->elemId . '">';
        $retval .= '<div class="page_settings">';
        $retval .= $formDisplay->getDisplay(true, true, false, $response->getFooter()->getSelfUrl(), ['submit_save' => $this->groupName]);
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
        return $this->HTML;
    }
    /**
     * Get error HTML output
     *
     * @return string
     */
    public function getErrorHTML()
    {
        return $this->errorHTML;
    }
}
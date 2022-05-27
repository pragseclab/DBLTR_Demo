<?php

declare (strict_types=1);
namespace PhpMyAdmin\Controllers\Server;

use PhpMyAdmin\Controllers\AbstractController;
use PhpMyAdmin\DatabaseInterface;
use PhpMyAdmin\Html\Generator;
use PhpMyAdmin\Providers\ServerVariables\ServerVariablesProvider;
use PhpMyAdmin\Response;
use PhpMyAdmin\Template;
use PhpMyAdmin\Url;
use PhpMyAdmin\Util;
use function header;
use function htmlspecialchars;
use function implode;
use function in_array;
use function is_numeric;
use function mb_strtolower;
use function pow;
use function preg_match;
use function str_replace;
use function strtolower;
use function trim;
/**
 * Handles viewing and editing server variables
 */
class VariablesController extends AbstractController
{
    /** @var DatabaseInterface */
    private $dbi;
    /**
     * @param Response          $response
     * @param DatabaseInterface $dbi
     */
    public function __construct($response, Template $template, $dbi)
    {
        parent::__construct($response, $template);
        $this->dbi = $dbi;
    }
    public function index() : void
    {
        global $err_url;
        $params = ['filter' => $_GET['filter'] ?? null];
        $err_url = Url::getFromRoute('/');
        if ($this->dbi->isSuperUser()) {
            $this->dbi->selectDb('mysql');
        }
        $filterValue = !empty($params['filter']) ? $params['filter'] : '';
        $this->addScriptFiles(['server/variables.js']);
        $variables = [];
        $serverVarsResult = $this->dbi->tryQuery('SHOW SESSION VARIABLES;');
        if ($serverVarsResult !== false) {
            $serverVarsSession = [];
            while ($arr = $this->dbi->fetchRow($serverVarsResult)) {
                $serverVarsSession[$arr[0]] = $arr[1];
            }
            $this->dbi->freeResult($serverVarsResult);
            $serverVars = $this->dbi->fetchResult('SHOW GLOBAL VARIABLES;', 0, 1);
            // list of static (i.e. non-editable) system variables
            $staticVariables = ServerVariablesProvider::getImplementation()->getStaticVariables();
            foreach ($serverVars as $name => $value) {
                $hasSessionValue = isset($serverVarsSession[$name]) && $serverVarsSession[$name] !== $value;
                $docLink = Generator::linkToVarDocumentation($name, $this->dbi->isMariaDB(), str_replace('_', '&nbsp;', $name));
                [$formattedValue, $isEscaped] = $this->formatVariable($name, $value);
                if ($hasSessionValue) {
                    [$sessionFormattedValue] = $this->formatVariable($name, $serverVarsSession[$name]);
                }
                $variables[] = ['name' => $name, 'is_editable' => !in_array(strtolower($name), $staticVariables), 'doc_link' => $docLink, 'value' => $formattedValue, 'is_escaped' => $isEscaped, 'has_session_value' => $hasSessionValue, 'session_value' => $sessionFormattedValue ?? null];
            }
        }
        $this->render('server/variables/index', ['variables' => $variables, 'filter_value' => $filterValue, 'is_superuser' => $this->dbi->isSuperUser(), 'is_mariadb' => $this->dbi->isMariaDB()]);
    }
    /**
     * Handle the AJAX request for a single variable value
     *
     * @param array $params Request parameters
     */
    public function getValue(array $params) : void
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("getValue") from ("/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_4/libraries/classes/Controllers/Server/VariablesController.php at line 81")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called getValue:81@/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_4/libraries/classes/Controllers/Server/VariablesController.php');
        die();
    }
    /**
     * Handle the AJAX request for setting value for a single variable
     *
     * @param array $vars Request parameters
     */
    public function setValue(array $vars) : void
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("setValue") from ("/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_4/libraries/classes/Controllers/Server/VariablesController.php at line 103")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called setValue:103@/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_4/libraries/classes/Controllers/Server/VariablesController.php');
        die();
    }
    /**
     * Format Variable
     *
     * @param string     $name  variable name
     * @param int|string $value variable value
     *
     * @return array formatted string and bool if string is HTML formatted
     */
    private function formatVariable($name, $value) : array
    {
        $isHtmlFormatted = false;
        $formattedValue = $value;
        if (is_numeric($value)) {
            $variableType = ServerVariablesProvider::getImplementation()->getVariableType($name);
            if ($variableType === 'byte') {
                $isHtmlFormatted = true;
                $formattedValue = trim($this->template->render('server/variables/format_variable', ['valueTitle' => Util::formatNumber($value, 0), 'value' => implode(' ', Util::formatByteDown($value, 3, 3))]));
            } else {
                $formattedValue = Util::formatNumber($value, 0);
            }
        }
        return [$formattedValue, $isHtmlFormatted];
    }
}
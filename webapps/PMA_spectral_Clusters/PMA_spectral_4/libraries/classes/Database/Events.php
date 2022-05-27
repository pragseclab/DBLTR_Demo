<?php

declare (strict_types=1);
namespace PhpMyAdmin\Database;

use PhpMyAdmin\DatabaseInterface;
use PhpMyAdmin\Html\Generator;
use PhpMyAdmin\Message;
use PhpMyAdmin\Response;
use PhpMyAdmin\Template;
use PhpMyAdmin\Util;
use function count;
use function explode;
use function htmlspecialchars;
use function in_array;
use function intval;
use function mb_strpos;
use function mb_strtoupper;
use function sprintf;
use function strtoupper;
use function trim;
/**
 * Functions for event management.
 */
class Events
{
    /** @var array<string, array<int, string>> */
    private $status = ['query' => ['ENABLE', 'DISABLE', 'DISABLE ON SLAVE'], 'display' => ['ENABLED', 'DISABLED', 'SLAVESIDE_DISABLED']];
    /** @var array<int, string> */
    private $type = ['RECURRING', 'ONE TIME'];
    /** @var array<int, string> */
    private $interval = ['YEAR', 'QUARTER', 'MONTH', 'DAY', 'HOUR', 'MINUTE', 'WEEK', 'SECOND', 'YEAR_MONTH', 'DAY_HOUR', 'DAY_MINUTE', 'DAY_SECOND', 'HOUR_MINUTE', 'HOUR_SECOND', 'MINUTE_SECOND'];
    /** @var DatabaseInterface */
    private $dbi;
    /** @var Template */
    private $template;
    /** @var Response */
    private $response;
    /**
     * @param DatabaseInterface $dbi      DatabaseInterface instance.
     * @param Template          $template Template instance.
     * @param Response          $response Response instance.
     */
    public function __construct(DatabaseInterface $dbi, Template $template, $response)
    {
        $this->dbi = $dbi;
        $this->template = $template;
        $this->response = $response;
    }
    /**
     * Handles editor requests for adding or editing an item
     *
     * @return void
     */
    public function handleEditor()
    {
        global $db, $table, $errors, $message;
        if (!empty($_POST['editor_process_add']) || !empty($_POST['editor_process_edit'])) {
            $sql_query = '';
            $item_query = $this->getQueryFromRequest();
            // set by getQueryFromRequest()
            if (!count($errors)) {
                // Execute the created query
                if (!empty($_POST['editor_process_edit'])) {
                    // Backup the old trigger, in case something goes wrong
                    $create_item = $this->dbi->getDefinition($db, 'EVENT', $_POST['item_original_name']);
                    $drop_item = 'DROP EVENT IF EXISTS ' . Util::backquote($_POST['item_original_name']) . ";\n";
                    $result = $this->dbi->tryQuery($drop_item);
                    if (!$result) {
                        $errors[] = sprintf(__('The following query has failed: "%s"'), htmlspecialchars($drop_item)) . '<br>' . __('MySQL said: ') . $this->dbi->getError();
                    } else {
                        $result = $this->dbi->tryQuery($item_query);
                        if (!$result) {
                            $errors[] = sprintf(__('The following query has failed: "%s"'), htmlspecialchars($item_query)) . '<br>' . __('MySQL said: ') . $this->dbi->getError();
                            // We dropped the old item, but were unable to create
                            // the new one. Try to restore the backup query
                            $result = $this->dbi->tryQuery($create_item);
                            $errors = $this->checkResult($result, $create_item, $errors);
                        } else {
                            $message = Message::success(__('Event %1$s has been modified.'));
                            $message->addParam(Util::backquote($_POST['item_name']));
                            $sql_query = $drop_item . $item_query;
                        }
                    }
                } else {
                    // 'Add a new item' mode
                    $result = $this->dbi->tryQuery($item_query);
                    if (!$result) {
                        $errors[] = sprintf(__('The following query has failed: "%s"'), htmlspecialchars($item_query)) . '<br><br>' . __('MySQL said: ') . $this->dbi->getError();
                    } else {
                        $message = Message::success(__('Event %1$s has been created.'));
                        $message->addParam(Util::backquote($_POST['item_name']));
                        $sql_query = $item_query;
                    }
                }
            }
            if (count($errors)) {
                $message = Message::error('<b>' . __('One or more errors have occurred while processing your request:') . '</b>');
                $message->addHtml('<ul>');
                foreach ($errors as $string) {
                    $message->addHtml('<li>' . $string . '</li>');
                }
                $message->addHtml('</ul>');
            }
            $output = Generator::getMessage($message, $sql_query);
            if ($this->response->isAjax()) {
                if ($message->isSuccess()) {
                    $events = $this->dbi->getEvents($db, $_POST['item_name']);
                    $event = $events[0];
                    $this->response->addJSON('name', htmlspecialchars(mb_strtoupper($_POST['item_name'])));
                    if (!empty($event)) {
                        $sqlDrop = sprintf('DROP EVENT IF EXISTS %s', Util::backquote($event['name']));
                        $this->response->addJSON('new_row', $this->template->render('database/events/row', ['db' => $db, 'table' => $table, 'event' => $event, 'has_privilege' => Util::currentUserHasPrivilege('EVENT', $db), 'sql_drop' => $sqlDrop, 'row_class' => '']));
                    }
                    $this->response->addJSON('insert', !empty($event));
                    $this->response->addJSON('message', $output);
                } else {
                    $this->response->setRequestStatus(false);
                    $this->response->addJSON('message', $message);
                }
                exit;
            }
        }
        /**
         * Display a form used to add/edit a trigger, if necessary
         */
        if (!count($errors) && (!empty($_POST['editor_process_add']) || !empty($_POST['editor_process_edit']) || empty($_REQUEST['add_item']) && empty($_REQUEST['edit_item']) && empty($_POST['item_changetype']))) {
            return;
        }
        // FIXME: this must be simpler than that
        $operation = '';
        $title = '';
        $item = null;
        $mode = '';
        if (!empty($_POST['item_changetype'])) {
            $operation = 'change';
        }
        // Get the data for the form (if any)
        if (!empty($_REQUEST['add_item'])) {
            $title = __('Add event');
            $item = $this->getDataFromRequest();
            $mode = 'add';
        } elseif (!empty($_REQUEST['edit_item'])) {
            $title = __('Edit event');
            if (!empty($_REQUEST['item_name']) && empty($_POST['editor_process_edit']) && empty($_POST['item_changetype'])) {
                $item = $this->getDataFromName($_REQUEST['item_name']);
                if ($item !== null) {
                    $item['item_original_name'] = $item['item_name'];
                }
            } else {
                $item = $this->getDataFromRequest();
            }
            $mode = 'edit';
        }
        $this->sendEditor($mode, $item, $title, $db, $operation);
    }
    /**
     * This function will generate the values that are required to for the editor
     *
     * @return array    Data necessary to create the editor.
     */
    public function getDataFromRequest()
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("getDataFromRequest") from ("/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_4/libraries/classes/Database/Events.php at line 164")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called getDataFromRequest:164@/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_4/libraries/classes/Database/Events.php');
        die();
    }
    /**
     * This function will generate the values that are required to complete
     * the "Edit event" form given the name of a event.
     *
     * @param string $name The name of the event.
     *
     * @return array|null Data necessary to create the editor.
     */
    public function getDataFromName($name) : ?array
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("getDataFromName") from ("/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_4/libraries/classes/Database/Events.php at line 187")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called getDataFromName:187@/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_4/libraries/classes/Database/Events.php');
        die();
    }
    /**
     * Displays a form used to add/edit an event
     *
     * @param string $mode      If the editor will be used to edit an event
     *                          or add a new one: 'edit' or 'add'.
     * @param string $operation If the editor was previously invoked with
     *                          JS turned off, this will hold the name of
     *                          the current operation
     * @param array  $item      Data for the event returned by
     *                          getDataFromRequest() or getDataFromName()
     *
     * @return string   HTML code for the editor.
     */
    public function getEditorForm($mode, $operation, array $item)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("getEditorForm") from ("/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_4/libraries/classes/Database/Events.php at line 233")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called getEditorForm:233@/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_4/libraries/classes/Database/Events.php');
        die();
    }
    /**
     * Composes the query necessary to create an event from an HTTP request.
     *
     * @return string  The CREATE EVENT query.
     */
    public function getQueryFromRequest()
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("getQueryFromRequest") from ("/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_4/libraries/classes/Database/Events.php at line 252")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called getQueryFromRequest:252@/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_4/libraries/classes/Database/Events.php');
        die();
    }
    public function getEventSchedulerStatus() : bool
    {
        $state = $this->dbi->fetchValue('SHOW GLOBAL VARIABLES LIKE \'event_scheduler\'', 0, 1);
        return strtoupper($state) === 'ON' || $state === '1';
    }
    /**
     * @param resource|bool $result          Query result
     * @param string|null   $createStatement Query
     * @param array         $errors          Errors
     *
     * @return array
     */
    private function checkResult($result, $createStatement, array $errors)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("checkResult") from ("/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_4/libraries/classes/Database/Events.php at line 332")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called checkResult:332@/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_4/libraries/classes/Database/Events.php');
        die();
    }
    /**
     * Send editor via ajax or by echoing.
     *
     * @param string     $mode      Editor mode 'add' or 'edit'
     * @param array|null $item      Data necessary to create the editor
     * @param string     $title     Title of the editor
     * @param string     $db        Database
     * @param string     $operation Operation 'change' or ''
     *
     * @return void
     */
    private function sendEditor($mode, ?array $item, $title, $db, $operation)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("sendEditor") from ("/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_4/libraries/classes/Database/Events.php at line 356")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called sendEditor:356@/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_4/libraries/classes/Database/Events.php');
        die();
    }
    public function export() : void
    {
        global $db;
        if (empty($_GET['export_item']) || empty($_GET['item_name'])) {
            return;
        }
        $itemName = $_GET['item_name'];
        $exportData = $this->dbi->getDefinition($db, 'EVENT', $itemName);
        if (!$exportData) {
            $exportData = false;
        }
        $itemName = htmlspecialchars(Util::backquote($_GET['item_name']));
        if ($exportData !== false) {
            $exportData = htmlspecialchars(trim($exportData));
            $title = sprintf(__('Export of event %s'), $itemName);
            if ($this->response->isAjax()) {
                $this->response->addJSON('message', $exportData);
                $this->response->addJSON('title', $title);
                exit;
            }
            $exportData = '<textarea cols="40" rows="15" style="width: 100%;">' . $exportData . '</textarea>';
            echo "<fieldset>\n" . '<legend>' . $title . "</legend>\n" . $exportData . "</fieldset>\n";
            return;
        }
        $message = sprintf(__('Error in processing request: No event with name %1$s found in database %2$s.'), $itemName, htmlspecialchars(Util::backquote($db)));
        $message = Message::error($message);
        if ($this->response->isAjax()) {
            $this->response->setRequestStatus(false);
            $this->response->addJSON('message', $message);
            exit;
        }
        echo $message->getDisplay();
    }
}
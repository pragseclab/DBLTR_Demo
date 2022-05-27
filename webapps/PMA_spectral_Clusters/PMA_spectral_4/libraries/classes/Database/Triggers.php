<?php

declare (strict_types=1);
namespace PhpMyAdmin\Database;

use PhpMyAdmin\DatabaseInterface;
use PhpMyAdmin\Html\Generator;
use PhpMyAdmin\Message;
use PhpMyAdmin\Response;
use PhpMyAdmin\Template;
use PhpMyAdmin\Url;
use PhpMyAdmin\Util;
use const ENT_QUOTES;
use function count;
use function explode;
use function htmlentities;
use function htmlspecialchars;
use function in_array;
use function mb_strpos;
use function mb_strtoupper;
use function sprintf;
use function trim;
/**
 * Functions for trigger management.
 */
class Triggers
{
    /** @var array<int, string> */
    private $time = ['BEFORE', 'AFTER'];
    /** @var array<int, string> */
    private $event = ['INSERT', 'UPDATE', 'DELETE'];
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
     * Main function for the triggers functionality
     *
     * @return void
     */
    public function main()
    {
        global $db, $table, $text_dir, $PMA_Theme;
        /**
         * Process all requests
         */
        $this->handleEditor();
        $this->export();
        $items = $this->dbi->getTriggers($db, $table);
        $hasDropPrivilege = Util::currentUserHasPrivilege('TRIGGER', $db);
        $hasEditPrivilege = Util::currentUserHasPrivilege('TRIGGER', $db, $table);
        $isAjax = $this->response->isAjax() && empty($_REQUEST['ajax_page_request']);
        $rows = '';
        foreach ($items as $item) {
            $rows .= $this->template->render('database/triggers/row', ['db' => $db, 'table' => $table, 'trigger' => $item, 'has_drop_privilege' => $hasDropPrivilege, 'has_edit_privilege' => $hasEditPrivilege, 'row_class' => $isAjax ? 'ajaxInsert hide' : '']);
        }
        echo $this->template->render('database/triggers/list', ['db' => $db, 'table' => $table, 'items' => $items, 'rows' => $rows, 'select_all_arrow_src' => $PMA_Theme->getImgPath() . 'arrow_' . $text_dir . '.png']);
        echo $this->template->render('database/triggers/footer', ['db' => $db, 'table' => $table, 'has_privilege' => Util::currentUserHasPrivilege('TRIGGER', $db, $table)]);
    }
    /**
     * Handles editor requests for adding or editing an item
     *
     * @return void
     */
    public function handleEditor()
    {
        global $db, $errors, $message, $table;
        if (!empty($_POST['editor_process_add']) || !empty($_POST['editor_process_edit'])) {
            $sql_query = '';
            $item_query = $this->getQueryFromRequest();
            // set by getQueryFromRequest()
            if (!count($errors)) {
                // Execute the created query
                if (!empty($_POST['editor_process_edit'])) {
                    // Backup the old trigger, in case something goes wrong
                    $trigger = $this->getDataFromName($_POST['item_original_name']);
                    $create_item = $trigger['create'];
                    $drop_item = $trigger['drop'] . ';';
                    $result = $this->dbi->tryQuery($drop_item);
                    if (!$result) {
                        $errors[] = sprintf(__('The following query has failed: "%s"'), htmlspecialchars($drop_item)) . '<br>' . __('MySQL said: ') . $this->dbi->getError();
                    } else {
                        $result = $this->dbi->tryQuery($item_query);
                        if (!$result) {
                            $errors[] = sprintf(__('The following query has failed: "%s"'), htmlspecialchars($item_query)) . '<br>' . __('MySQL said: ') . $this->dbi->getError();
                            // We dropped the old item, but were unable to create the
                            // new one. Try to restore the backup query.
                            $result = $this->dbi->tryQuery($create_item);
                            $errors = $this->checkResult($result, $create_item, $errors);
                        } else {
                            $message = Message::success(__('Trigger %1$s has been modified.'));
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
                        $message = Message::success(__('Trigger %1$s has been created.'));
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
                    $items = $this->dbi->getTriggers($db, $table, '');
                    $trigger = false;
                    foreach ($items as $value) {
                        if ($value['name'] != $_POST['item_name']) {
                            continue;
                        }
                        $trigger = $value;
                    }
                    $insert = false;
                    if (empty($table) || $trigger !== false && $table == $trigger['table']) {
                        $insert = true;
                        $this->response->addJSON('new_row', $this->template->render('database/triggers/row', ['db' => $db, 'table' => $table, 'trigger' => $trigger, 'has_drop_privilege' => Util::currentUserHasPrivilege('TRIGGER', $db), 'has_edit_privilege' => Util::currentUserHasPrivilege('TRIGGER', $db, $table), 'row_class' => '']));
                        $this->response->addJSON('name', htmlspecialchars(mb_strtoupper($_POST['item_name'])));
                    }
                    $this->response->addJSON('insert', $insert);
                    $this->response->addJSON('message', $output);
                } else {
                    $this->response->addJSON('message', $message);
                    $this->response->setRequestStatus(false);
                }
                exit;
            }
        }
        /**
         * Display a form used to add/edit a trigger, if necessary
         */
        if (!count($errors) && (!empty($_POST['editor_process_add']) || !empty($_POST['editor_process_edit']) || empty($_REQUEST['add_item']) && empty($_REQUEST['edit_item']))) {
            return;
        }
        $mode = '';
        $item = null;
        $title = '';
        // Get the data for the form (if any)
        if (!empty($_REQUEST['add_item'])) {
            $title = __('Add trigger');
            $item = $this->getDataFromRequest();
            $mode = 'add';
        } elseif (!empty($_REQUEST['edit_item'])) {
            $title = __('Edit trigger');
            if (!empty($_REQUEST['item_name']) && empty($_POST['editor_process_edit'])) {
                $item = $this->getDataFromName($_REQUEST['item_name']);
                if ($item !== null) {
                    $item['item_original_name'] = $item['item_name'];
                }
            } else {
                $item = $this->getDataFromRequest();
            }
            $mode = 'edit';
        }
        $this->sendEditor($mode, $item, $title, $db);
    }
    /**
     * This function will generate the values that are required to for the editor
     *
     * @return array    Data necessary to create the editor.
     */
    public function getDataFromRequest()
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("getDataFromRequest") from ("/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_4/libraries/classes/Database/Triggers.php at line 190")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called getDataFromRequest:190@/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_4/libraries/classes/Database/Triggers.php');
        die();
    }
    /**
     * This function will generate the values that are required to complete
     * the "Edit trigger" form given the name of a trigger.
     *
     * @param string $name The name of the trigger.
     *
     * @return array|null Data necessary to create the editor.
     */
    public function getDataFromName($name) : ?array
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("getDataFromName") from ("/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_4/libraries/classes/Database/Triggers.php at line 207")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called getDataFromName:207@/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_4/libraries/classes/Database/Triggers.php');
        die();
    }
    /**
     * Displays a form used to add/edit a trigger
     *
     * @param string $mode If the editor will be used to edit a trigger
     *                     or add a new one: 'edit' or 'add'.
     * @param array  $item Data for the trigger returned by getDataFromRequest()
     *                     or getDataFromName()
     *
     * @return string HTML code for the editor.
     */
    public function getEditorForm($mode, array $item)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("getEditorForm") from ("/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_4/libraries/classes/Database/Triggers.php at line 242")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called getEditorForm:242@/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_4/libraries/classes/Database/Triggers.php');
        die();
    }
    /**
     * Composes the query necessary to create a trigger from an HTTP request.
     *
     * @return string  The CREATE TRIGGER query.
     */
    public function getQueryFromRequest()
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("getQueryFromRequest") from ("/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_4/libraries/classes/Database/Triggers.php at line 348")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called getQueryFromRequest:348@/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_4/libraries/classes/Database/Triggers.php');
        die();
    }
    /**
     * @param resource|bool $result          Query result
     * @param string        $createStatement Query
     * @param array         $errors          Errors
     *
     * @return array
     */
    private function checkResult($result, $createStatement, array $errors)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("checkResult") from ("/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_4/libraries/classes/Database/Triggers.php at line 398")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called checkResult:398@/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_4/libraries/classes/Database/Triggers.php');
        die();
    }
    /**
     * Send editor via ajax or by echoing.
     *
     * @param string     $mode  Editor mode 'add' or 'edit'
     * @param array|null $item  Data necessary to create the editor
     * @param string     $title Title of the editor
     * @param string     $db    Database
     *
     * @return void
     */
    private function sendEditor($mode, ?array $item, $title, $db)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("sendEditor") from ("/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_4/libraries/classes/Database/Triggers.php at line 421")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called sendEditor:421@/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_4/libraries/classes/Database/Triggers.php');
        die();
    }
    private function export() : void
    {
        global $db, $table;
        if (empty($_GET['export_item']) || empty($_GET['item_name'])) {
            return;
        }
        $itemName = $_GET['item_name'];
        $triggers = $this->dbi->getTriggers($db, $table, '');
        $exportData = false;
        foreach ($triggers as $trigger) {
            if ($trigger['name'] === $itemName) {
                $exportData = $trigger['create'];
                break;
            }
        }
        $itemName = htmlspecialchars(Util::backquote($_GET['item_name']));
        if ($exportData !== false) {
            $exportData = htmlspecialchars(trim($exportData));
            $title = sprintf(__('Export of trigger %s'), $itemName);
            if ($this->response->isAjax()) {
                $this->response->addJSON('message', $exportData);
                $this->response->addJSON('title', $title);
                exit;
            }
            $exportData = '<textarea cols="40" rows="15" style="width: 100%;">' . $exportData . '</textarea>';
            echo "<fieldset>\n" . '<legend>' . $title . "</legend>\n" . $exportData . "</fieldset>\n";
            return;
        }
        $message = sprintf(__('Error in processing request: No trigger with name %1$s found in database %2$s.'), $itemName, htmlspecialchars(Util::backquote($db)));
        $message = Message::error($message);
        if ($this->response->isAjax()) {
            $this->response->setRequestStatus(false);
            $this->response->addJSON('message', $message);
            exit;
        }
        echo $message->getDisplay();
    }
}
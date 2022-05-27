<?php

/**
 * function for the main export logic
 */
declare (strict_types=1);
namespace PhpMyAdmin;

use PhpMyAdmin\Controllers\Database\ExportController as DatabaseExportController;
use PhpMyAdmin\Controllers\Server\ExportController as ServerExportController;
use PhpMyAdmin\Controllers\Table\ExportController as TableExportController;
use PhpMyAdmin\Plugins\ExportPlugin;
use PhpMyAdmin\Plugins\SchemaPlugin;
use function array_merge_recursive;
use function error_get_last;
use function fclose;
use function file_exists;
use function fopen;
use function function_exists;
use function fwrite;
use function gzencode;
use function header;
use function htmlentities;
use function htmlspecialchars;
use function implode;
use function in_array;
use function ini_get;
use function is_array;
use function is_file;
use function is_numeric;
use function is_object;
use function is_string;
use function is_writable;
use function mb_strlen;
use function mb_strpos;
use function mb_strtolower;
use function mb_substr;
use function ob_list_handlers;
use function preg_match;
use function preg_replace;
use function strlen;
use function strtolower;
use function substr;
use function time;
use function trim;
use function urlencode;
/**
 * PhpMyAdmin\Export class
 */
class Export
{
    /** @var DatabaseInterface */
    private $dbi;
    /**
     * @param DatabaseInterface $dbi DatabaseInterface instance
     */
    public function __construct($dbi)
    {
        $this->dbi = $dbi;
    }
    /**
     * Sets a session variable upon a possible fatal error during export
     */
    public function shutdown() : void
    {
        $error = error_get_last();
        if ($error == null || !mb_strpos($error['message'], 'execution time')) {
            return;
        }
        //set session variable to check if there was error while exporting
        $_SESSION['pma_export_error'] = $error['message'];
    }
    /**
     * Detect ob_gzhandler
     */
    public function isGzHandlerEnabled() : bool
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("isGzHandlerEnabled") from ("/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_1/libraries/classes/Export.php at line 78")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called isGzHandlerEnabled:78@/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_1/libraries/classes/Export.php');
        die();
    }
    /**
     * Detect whether gzencode is needed; it might not be needed if
     * the server is already compressing by itself
     *
     * @return bool Whether gzencode is needed
     */
    public function gzencodeNeeded() : bool
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("gzencodeNeeded") from ("/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_1/libraries/classes/Export.php at line 95")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called gzencodeNeeded:95@/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_1/libraries/classes/Export.php');
        die();
    }
    /**
     * Output handler for all exports, if needed buffering, it stores data into
     * $dump_buffer, otherwise it prints them out.
     *
     * @param string $line the insert statement
     *
     * @return bool Whether output succeeded
     */
    public function outputHandler(?string $line) : bool
    {
        global $time_start, $dump_buffer, $dump_buffer_len, $save_filename;
        // Kanji encoding convert feature
        if ($GLOBALS['output_kanji_conversion']) {
            $line = Encoding::kanjiStrConv($line, $GLOBALS['knjenc'], $GLOBALS['xkana'] ?? '');
        }
        // If we have to buffer data, we will perform everything at once at the end
        if ($GLOBALS['buffer_needed']) {
            $dump_buffer .= $line;
            if ($GLOBALS['onfly_compression']) {
                $dump_buffer_len += strlen((string) $line);
                if ($dump_buffer_len > $GLOBALS['memory_limit']) {
                    if ($GLOBALS['output_charset_conversion']) {
                        $dump_buffer = Encoding::convertString('utf-8', $GLOBALS['charset'], $dump_buffer);
                    }
                    if ($GLOBALS['compression'] === 'gzip' && $this->gzencodeNeeded()) {
                        // as a gzipped file
                        // without the optional parameter level because it bugs
                        $dump_buffer = gzencode($dump_buffer);
                    }
                    if ($GLOBALS['save_on_server']) {
                        $write_result = @fwrite($GLOBALS['file_handle'], (string) $dump_buffer);
                        // Here, use strlen rather than mb_strlen to get the length
                        // in bytes to compare against the number of bytes written.
                        if ($write_result != strlen((string) $dump_buffer)) {
                            $GLOBALS['message'] = Message::error(__('Insufficient space to save the file %s.'));
                            $GLOBALS['message']->addParam($save_filename);
                            return false;
                        }
                    } else {
                        echo $dump_buffer;
                    }
                    $dump_buffer = '';
                    $dump_buffer_len = 0;
                }
            } else {
                $time_now = time();
                if ($time_start >= $time_now + 30) {
                    $time_start = $time_now;
                    header('X-pmaPing: Pong');
                }
            }
        } elseif ($GLOBALS['asfile']) {
            if ($GLOBALS['output_charset_conversion']) {
                $line = Encoding::convertString('utf-8', $GLOBALS['charset'], $line);
            }
            if ($GLOBALS['save_on_server'] && mb_strlen((string) $line) > 0) {
                if ($GLOBALS['file_handle'] !== null) {
                    $write_result = @fwrite($GLOBALS['file_handle'], (string) $line);
                } else {
                    $write_result = false;
                }
                // Here, use strlen rather than mb_strlen to get the length
                // in bytes to compare against the number of bytes written.
                if (!$write_result || $write_result != strlen((string) $line)) {
                    $GLOBALS['message'] = Message::error(__('Insufficient space to save the file %s.'));
                    $GLOBALS['message']->addParam($save_filename);
                    return false;
                }
                $time_now = time();
                if ($time_start >= $time_now + 30) {
                    $time_start = $time_now;
                    header('X-pmaPing: Pong');
                }
            } else {
                // We export as file - output normally
                echo $line;
            }
        } else {
            // We export as html - replace special chars
            echo htmlspecialchars((string) $line);
        }
        return true;
    }
    /**
     * Returns HTML containing the footer for a displayed export
     *
     * @param string $back_button   the link for going Back
     * @param string $refreshButton the link for refreshing page
     *
     * @return string the HTML output
     */
    public function getHtmlForDisplayedExportFooter(string $back_button, string $refreshButton) : string
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("getHtmlForDisplayedExportFooter") from ("/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_1/libraries/classes/Export.php at line 195")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called getHtmlForDisplayedExportFooter:195@/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_1/libraries/classes/Export.php');
        die();
    }
    /**
     * Computes the memory limit for export
     *
     * @return int the memory limit
     */
    public function getMemoryLimit() : int
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("getMemoryLimit") from ("/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_1/libraries/classes/Export.php at line 204")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called getMemoryLimit:204@/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_1/libraries/classes/Export.php');
        die();
    }
    /**
     * Returns the filename and MIME type for a compression and an export plugin
     *
     * @param ExportPlugin $exportPlugin the export plugin
     * @param string       $compression  compression asked
     * @param string       $filename     the filename
     *
     * @return string[]    the filename and mime type
     */
    public function getFinalFilenameAndMimetypeForFilename(ExportPlugin $exportPlugin, string $compression, string $filename) : array
    {
        // Grab basic dump extension and mime type
        // Check if the user already added extension;
        // get the substring where the extension would be if it was included
        $extensionStartPos = mb_strlen($filename) - mb_strlen($exportPlugin->getProperties()->getExtension()) - 1;
        $userExtension = mb_substr($filename, $extensionStartPos, mb_strlen($filename));
        $requiredExtension = '.' . $exportPlugin->getProperties()->getExtension();
        if (mb_strtolower($userExtension) != $requiredExtension) {
            $filename .= $requiredExtension;
        }
        $mime_type = $exportPlugin->getProperties()->getMimeType();
        // If dump is going to be compressed, set correct mime_type and add
        // compression to extension
        if ($compression === 'gzip') {
            $filename .= '.gz';
            $mime_type = 'application/x-gzip';
        } elseif ($compression === 'zip') {
            $filename .= '.zip';
            $mime_type = 'application/zip';
        }
        return [$filename, $mime_type];
    }
    /**
     * Return the filename and MIME type for export file
     *
     * @param string       $export_type       type of export
     * @param string       $remember_template whether to remember template
     * @param ExportPlugin $export_plugin     the export plugin
     * @param string       $compression       compression asked
     * @param string       $filename_template the filename template
     *
     * @return string[] the filename template and mime type
     */
    public function getFilenameAndMimetype(string $export_type, string $remember_template, ExportPlugin $export_plugin, string $compression, string $filename_template) : array
    {
        if ($export_type === 'server') {
            if (!empty($remember_template)) {
                $GLOBALS['PMA_Config']->setUserValue('pma_server_filename_template', 'Export/file_template_server', $filename_template);
            }
        } elseif ($export_type === 'database') {
            if (!empty($remember_template)) {
                $GLOBALS['PMA_Config']->setUserValue('pma_db_filename_template', 'Export/file_template_database', $filename_template);
            }
        } elseif ($export_type === 'raw') {
            if (!empty($remember_template)) {
                $GLOBALS['PMA_Config']->setUserValue('pma_raw_filename_template', 'Export/file_template_raw', $filename_template);
            }
        } else {
            if (!empty($remember_template)) {
                $GLOBALS['PMA_Config']->setUserValue('pma_table_filename_template', 'Export/file_template_table', $filename_template);
            }
        }
        $filename = Util::expandUserString($filename_template);
        // remove dots in filename (coming from either the template or already
        // part of the filename) to avoid a remote code execution vulnerability
        $filename = Sanitize::sanitizeFilename($filename, true);
        return $this->getFinalFilenameAndMimetypeForFilename($export_plugin, $compression, $filename);
    }
    /**
     * Open the export file
     *
     * @param string $filename     the export filename
     * @param bool   $quick_export whether it's a quick export or not
     *
     * @return array the full save filename, possible message and the file handle
     */
    public function openFile(string $filename, bool $quick_export) : array
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("openFile") from ("/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_1/libraries/classes/Export.php at line 307")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called openFile:307@/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_1/libraries/classes/Export.php');
        die();
    }
    /**
     * Close the export file
     *
     * @param resource $file_handle   the export file handle
     * @param string   $dump_buffer   the current dump buffer
     * @param string   $save_filename the export filename
     *
     * @return Message a message object (or empty string)
     */
    public function closeFile($file_handle, string $dump_buffer, string $save_filename) : Message
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("closeFile") from ("/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_1/libraries/classes/Export.php at line 340")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called closeFile:340@/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_1/libraries/classes/Export.php');
        die();
    }
    /**
     * Compress the export buffer
     *
     * @param array|string $dump_buffer the current dump buffer
     * @param string       $compression the compression mode
     * @param string       $filename    the filename
     *
     * @return array|string|bool
     */
    public function compress($dump_buffer, string $compression, string $filename)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("compress") from ("/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_1/libraries/classes/Export.php at line 362")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called compress:362@/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_1/libraries/classes/Export.php');
        die();
    }
    /**
     * Saves the dump_buffer for a particular table in an array
     * Used in separate files export
     *
     * @param string $object_name the name of current object to be stored
     * @param bool   $append      optional boolean to append to an existing index or not
     */
    public function saveObjectInBuffer(string $object_name, bool $append = false) : void
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("saveObjectInBuffer") from ("/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_1/libraries/classes/Export.php at line 382")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called saveObjectInBuffer:382@/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_1/libraries/classes/Export.php');
        die();
    }
    /**
     * Returns HTML containing the header for a displayed export
     *
     * @param string $export_type the export type
     * @param string $db          the database name
     * @param string $table       the table name
     *
     * @return string[] the generated HTML and back button
     */
    public function getHtmlForDisplayedExportHeader(string $export_type, string $db, string $table) : array
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("getHtmlForDisplayedExportHeader") from ("/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_1/libraries/classes/Export.php at line 405")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called getHtmlForDisplayedExportHeader:405@/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_1/libraries/classes/Export.php');
        die();
    }
    /**
     * Export at the server level
     *
     * @param string|array $db_select       the selected databases to export
     * @param string       $whatStrucOrData structure or data or both
     * @param ExportPlugin $export_plugin   the selected export plugin
     * @param string       $crlf            end of line character(s)
     * @param string       $err_url         the URL in case of error
     * @param string       $export_type     the export type
     * @param bool         $do_relation     whether to export relation info
     * @param bool         $do_comments     whether to add comments
     * @param bool         $do_mime         whether to add MIME info
     * @param bool         $do_dates        whether to add dates
     * @param array        $aliases         alias information for db/table/column
     * @param string       $separate_files  whether it is a separate-files export
     */
    public function exportServer($db_select, string $whatStrucOrData, ExportPlugin $export_plugin, string $crlf, string $err_url, string $export_type, bool $do_relation, bool $do_comments, bool $do_mime, bool $do_dates, array $aliases, string $separate_files) : void
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("exportServer") from ("/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_1/libraries/classes/Export.php at line 470")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called exportServer:470@/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_1/libraries/classes/Export.php');
        die();
    }
    /**
     * Export at the database level
     *
     * @param string       $db              the database to export
     * @param array        $tables          the tables to export
     * @param string       $whatStrucOrData structure or data or both
     * @param array        $table_structure whether to export structure for each table
     * @param array        $table_data      whether to export data for each table
     * @param ExportPlugin $export_plugin   the selected export plugin
     * @param string       $crlf            end of line character(s)
     * @param string       $err_url         the URL in case of error
     * @param string       $export_type     the export type
     * @param bool         $do_relation     whether to export relation info
     * @param bool         $do_comments     whether to add comments
     * @param bool         $do_mime         whether to add MIME info
     * @param bool         $do_dates        whether to add dates
     * @param array        $aliases         Alias information for db/table/column
     * @param string       $separate_files  whether it is a separate-files export
     */
    public function exportDatabase(string $db, array $tables, string $whatStrucOrData, array $table_structure, array $table_data, ExportPlugin $export_plugin, string $crlf, string $err_url, string $export_type, bool $do_relation, bool $do_comments, bool $do_mime, bool $do_dates, array $aliases, string $separate_files) : void
    {
        $db_alias = !empty($aliases[$db]['alias']) ? $aliases[$db]['alias'] : '';
        if (!$export_plugin->exportDBHeader($db, $db_alias)) {
            return;
        }
        if (!$export_plugin->exportDBCreate($db, $export_type, $db_alias)) {
            return;
        }
        if ($separate_files === 'database') {
            $this->saveObjectInBuffer('database', true);
        }
        if (($GLOBALS['sql_structure_or_data'] === 'structure' || $GLOBALS['sql_structure_or_data'] === 'structure_and_data') && isset($GLOBALS['sql_procedure_function'])) {
            $export_plugin->exportRoutines($db, $aliases);
            if ($separate_files === 'database') {
                $this->saveObjectInBuffer('routines');
            }
        }
        $views = [];
        foreach ($tables as $table) {
            $_table = new Table($table, $db);
            // if this is a view, collect it for later;
            // views must be exported after the tables
            $is_view = $_table->isView();
            if ($is_view) {
                $views[] = $table;
            }
            if (($whatStrucOrData === 'structure' || $whatStrucOrData === 'structure_and_data') && in_array($table, $table_structure)) {
                // for a view, export a stand-in definition of the table
                // to resolve view dependencies (only when it's a single-file export)
                if ($is_view) {
                    if ($separate_files == '' && isset($GLOBALS['sql_create_view']) && !$export_plugin->exportStructure($db, $table, $crlf, $err_url, 'stand_in', $export_type, $do_relation, $do_comments, $do_mime, $do_dates, $aliases)) {
                        break;
                    }
                } elseif (isset($GLOBALS['sql_create_table'])) {
                    $table_size = $GLOBALS['maxsize'];
                    // Checking if the maximum table size constrain has been set
                    // And if that constrain is a valid number or not
                    if ($table_size !== '' && is_numeric($table_size)) {
                        // This obtains the current table's size
                        $query = 'SELECT data_length + index_length
                              from information_schema.TABLES
                              WHERE table_schema = "' . $this->dbi->escapeString($db) . '"
                              AND table_name = "' . $this->dbi->escapeString($table) . '"';
                        $size = $this->dbi->fetchValue($query);
                        //Converting the size to MB
                        $size /= 1024 / 1024;
                        if ($size > $table_size) {
                            continue;
                        }
                    }
                    if (!$export_plugin->exportStructure($db, $table, $crlf, $err_url, 'create_table', $export_type, $do_relation, $do_comments, $do_mime, $do_dates, $aliases)) {
                        break;
                    }
                }
            }
            // if this is a view or a merge table, don't export data
            if (($whatStrucOrData === 'data' || $whatStrucOrData === 'structure_and_data') && in_array($table, $table_data) && !$is_view) {
                $tableObj = new Table($table, $db);
                $nonGeneratedCols = $tableObj->getNonGeneratedColumns(true);
                $local_query = 'SELECT ' . implode(', ', $nonGeneratedCols) . ' FROM ' . Util::backquote($db) . '.' . Util::backquote($table);
                if (!$export_plugin->exportData($db, $table, $crlf, $err_url, $local_query, $aliases)) {
                    break;
                }
            }
            // this buffer was filled, we save it and go to the next one
            if ($separate_files === 'database') {
                $this->saveObjectInBuffer('table_' . $table);
            }
            // now export the triggers (needs to be done after the data because
            // triggers can modify already imported tables)
            if (!isset($GLOBALS['sql_create_trigger']) || $whatStrucOrData !== 'structure' && $whatStrucOrData !== 'structure_and_data' || !in_array($table, $table_structure)) {
                continue;
            }
            if (!$export_plugin->exportStructure($db, $table, $crlf, $err_url, 'triggers', $export_type, $do_relation, $do_comments, $do_mime, $do_dates, $aliases)) {
                break;
            }
            if ($separate_files !== 'database') {
                continue;
            }
            $this->saveObjectInBuffer('table_' . $table, true);
        }
        if (isset($GLOBALS['sql_create_view'])) {
            foreach ($views as $view) {
                // no data export for a view
                if ($whatStrucOrData !== 'structure' && $whatStrucOrData !== 'structure_and_data') {
                    continue;
                }
                if (!$export_plugin->exportStructure($db, $view, $crlf, $err_url, 'create_view', $export_type, $do_relation, $do_comments, $do_mime, $do_dates, $aliases)) {
                    break;
                }
                if ($separate_files !== 'database') {
                    continue;
                }
                $this->saveObjectInBuffer('view_' . $view);
            }
        }
        if (!$export_plugin->exportDBFooter($db)) {
            return;
        }
        // export metadata related to this db
        if (isset($GLOBALS['sql_metadata'])) {
            // Types of metadata to export.
            // In the future these can be allowed to be selected by the user
            $metadataTypes = $this->getMetadataTypes();
            $export_plugin->exportMetadata($db, $tables, $metadataTypes);
            if ($separate_files === 'database') {
                $this->saveObjectInBuffer('metadata');
            }
        }
        if ($separate_files === 'database') {
            $this->saveObjectInBuffer('extra');
        }
        if ($GLOBALS['sql_structure_or_data'] !== 'structure' && $GLOBALS['sql_structure_or_data'] !== 'structure_and_data' || !isset($GLOBALS['sql_procedure_function'])) {
            return;
        }
        $export_plugin->exportEvents($db);
        if ($separate_files !== 'database') {
            return;
        }
        $this->saveObjectInBuffer('events');
    }
    /**
     * Export a raw query
     *
     * @param string       $whatStrucOrData whether to export structure for each table or raw
     * @param ExportPlugin $export_plugin   the selected export plugin
     * @param string       $crlf            end of line character(s)
     * @param string       $err_url         the URL in case of error
     * @param string       $sql_query       the query to be executed
     * @param string       $export_type     the export type
     */
    public static function exportRaw(string $whatStrucOrData, ExportPlugin $export_plugin, string $crlf, string $err_url, string $sql_query, string $export_type) : void
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("exportRaw") from ("/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_1/libraries/classes/Export.php at line 641")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called exportRaw:641@/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_1/libraries/classes/Export.php');
        die();
    }
    /**
     * Export at the table level
     *
     * @param string       $db              the database to export
     * @param string       $table           the table to export
     * @param string       $whatStrucOrData structure or data or both
     * @param ExportPlugin $export_plugin   the selected export plugin
     * @param string       $crlf            end of line character(s)
     * @param string       $err_url         the URL in case of error
     * @param string       $export_type     the export type
     * @param bool         $do_relation     whether to export relation info
     * @param bool         $do_comments     whether to add comments
     * @param bool         $do_mime         whether to add MIME info
     * @param bool         $do_dates        whether to add dates
     * @param string|null  $allrows         whether "dump all rows" was ticked
     * @param string       $limit_to        upper limit
     * @param string       $limit_from      starting limit
     * @param string       $sql_query       query for which exporting is requested
     * @param array        $aliases         Alias information for db/table/column
     */
    public function exportTable(string $db, string $table, string $whatStrucOrData, ExportPlugin $export_plugin, string $crlf, string $err_url, string $export_type, bool $do_relation, bool $do_comments, bool $do_mime, bool $do_dates, ?string $allrows, string $limit_to, string $limit_from, string $sql_query, array $aliases) : void
    {
        $db_alias = !empty($aliases[$db]['alias']) ? $aliases[$db]['alias'] : '';
        if (!$export_plugin->exportDBHeader($db, $db_alias)) {
            return;
        }
        if (isset($allrows) && $allrows == '0' && $limit_to > 0 && $limit_from >= 0) {
            $add_query = ' LIMIT ' . ($limit_from > 0 ? $limit_from . ', ' : '') . $limit_to;
        } else {
            $add_query = '';
        }
        $_table = new Table($table, $db);
        $is_view = $_table->isView();
        if ($whatStrucOrData === 'structure' || $whatStrucOrData === 'structure_and_data') {
            if ($is_view) {
                if (isset($GLOBALS['sql_create_view'])) {
                    if (!$export_plugin->exportStructure($db, $table, $crlf, $err_url, 'create_view', $export_type, $do_relation, $do_comments, $do_mime, $do_dates, $aliases)) {
                        return;
                    }
                }
            } elseif (isset($GLOBALS['sql_create_table'])) {
                if (!$export_plugin->exportStructure($db, $table, $crlf, $err_url, 'create_table', $export_type, $do_relation, $do_comments, $do_mime, $do_dates, $aliases)) {
                    return;
                }
            }
        }
        // If this is an export of a single view, we have to export data;
        // for example, a PDF report
        // if it is a merge table, no data is exported
        if ($whatStrucOrData === 'data' || $whatStrucOrData === 'structure_and_data') {
            if (!empty($sql_query)) {
                // only preg_replace if needed
                if (!empty($add_query)) {
                    // remove trailing semicolon before adding a LIMIT
                    $sql_query = preg_replace('%;\\s*$%', '', $sql_query);
                }
                $local_query = $sql_query . $add_query;
                $this->dbi->selectDb($db);
            } else {
                // Data is exported only for Non-generated columns
                $tableObj = new Table($table, $db);
                $nonGeneratedCols = $tableObj->getNonGeneratedColumns(true);
                $local_query = 'SELECT ' . implode(', ', $nonGeneratedCols) . ' FROM ' . Util::backquote($db) . '.' . Util::backquote($table) . $add_query;
            }
            if (!$export_plugin->exportData($db, $table, $crlf, $err_url, $local_query, $aliases)) {
                return;
            }
        }
        // now export the triggers (needs to be done after the data because
        // triggers can modify already imported tables)
        if (isset($GLOBALS['sql_create_trigger']) && ($whatStrucOrData === 'structure' || $whatStrucOrData === 'structure_and_data')) {
            if (!$export_plugin->exportStructure($db, $table, $crlf, $err_url, 'triggers', $export_type, $do_relation, $do_comments, $do_mime, $do_dates, $aliases)) {
                return;
            }
        }
        if (!$export_plugin->exportDBFooter($db)) {
            return;
        }
        if (!isset($GLOBALS['sql_metadata'])) {
            return;
        }
        // Types of metadata to export.
        // In the future these can be allowed to be selected by the user
        $metadataTypes = $this->getMetadataTypes();
        $export_plugin->exportMetadata($db, $table, $metadataTypes);
    }
    /**
     * Loads correct page after doing export
     */
    public function showPage(string $exportType) : void
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("showPage") from ("/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_1/libraries/classes/Export.php at line 744")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called showPage:744@/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_1/libraries/classes/Export.php');
        die();
    }
    /**
     * Merge two alias arrays, if array1 and array2 have
     * conflicting alias then array2 value is used if it
     * is non empty otherwise array1 value.
     *
     * @param array $aliases1 first array of aliases
     * @param array $aliases2 second array of aliases
     *
     * @return array resultant merged aliases info
     */
    public function mergeAliases(array $aliases1, array $aliases2) : array
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("mergeAliases") from ("/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_1/libraries/classes/Export.php at line 778")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called mergeAliases:778@/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_1/libraries/classes/Export.php');
        die();
    }
    /**
     * Locks tables
     *
     * @param string $db       database name
     * @param array  $tables   list of table names
     * @param string $lockType lock type; "[LOW_PRIORITY] WRITE" or "READ [LOCAL]"
     *
     * @return mixed result of the query
     */
    public function lockTables(string $db, array $tables, string $lockType = 'WRITE')
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("lockTables") from ("/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_1/libraries/classes/Export.php at line 826")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called lockTables:826@/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_1/libraries/classes/Export.php');
        die();
    }
    /**
     * Releases table locks
     *
     * @return mixed result of the query
     */
    public function unlockTables()
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("unlockTables") from ("/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_1/libraries/classes/Export.php at line 840")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called unlockTables:840@/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_1/libraries/classes/Export.php');
        die();
    }
    /**
     * Returns all the metadata types that can be exported with a database or a table
     *
     * @return string[] metadata types.
     */
    public function getMetadataTypes() : array
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("getMetadataTypes") from ("/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_1/libraries/classes/Export.php at line 849")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called getMetadataTypes:849@/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_1/libraries/classes/Export.php');
        die();
    }
    /**
     * Returns the checked clause, depending on the presence of key in array
     *
     * @param string $key   the key to look for
     * @param array  $array array to verify
     *
     * @return string the checked clause
     */
    public function getCheckedClause(string $key, array $array) : string
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("getCheckedClause") from ("/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_1/libraries/classes/Export.php at line 861")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called getCheckedClause:861@/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_1/libraries/classes/Export.php');
        die();
    }
    /**
     * get all the export options and verify
     * call and include the appropriate Schema Class depending on $export_type
     *
     * @param string|null $export_type format of the export
     */
    public function processExportSchema(?string $export_type) : void
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("processExportSchema") from ("/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_1/libraries/classes/Export.php at line 877")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called processExportSchema:877@/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_1/libraries/classes/Export.php');
        die();
    }
}
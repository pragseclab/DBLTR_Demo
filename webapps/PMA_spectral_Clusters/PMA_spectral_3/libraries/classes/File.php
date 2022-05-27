<?php

declare (strict_types=1);
namespace PhpMyAdmin;

use ZipArchive;
use const UPLOAD_ERR_CANT_WRITE;
use const UPLOAD_ERR_EXTENSION;
use const UPLOAD_ERR_FORM_SIZE;
use const UPLOAD_ERR_INI_SIZE;
use const UPLOAD_ERR_NO_FILE;
use const UPLOAD_ERR_NO_TMP_DIR;
use const UPLOAD_ERR_OK;
use const UPLOAD_ERR_PARTIAL;
use function basename;
use function bin2hex;
use function bzopen;
use function bzread;
use function extension_loaded;
use function fclose;
use function feof;
use function file_get_contents;
use function filesize;
use function fopen;
use function fread;
use function function_exists;
use function gzopen;
use function gzread;
use function is_link;
use function is_readable;
use function is_string;
use function is_uploaded_file;
use function mb_strcut;
use function move_uploaded_file;
use function ob_end_clean;
use function ob_start;
use function sprintf;
use function strlen;
use function tempnam;
use function trim;
use function unlink;
/**
 * File wrapper class
 *
 * @todo when uploading a file into a blob field, should we also consider using
 *       chunks like in import? UPDATE `table` SET `field` = `field` + [chunk]
 */
class File
{
    /**
     * @var string the temporary file name
     * @access protected
     */
    protected $name = null;
    /**
     * @var string the content
     * @access protected
     */
    protected $content = null;
    /**
     * @var Message|null the error message
     * @access protected
     */
    protected $errorMessage = null;
    /**
     * @var bool whether the file is temporary or not
     * @access protected
     */
    protected $isTemp = false;
    /**
     * @var string type of compression
     * @access protected
     */
    protected $compression = null;
    /** @var int */
    protected $offset = 0;
    /** @var int size of chunk to read with every step */
    protected $chunkSize = 32768;
    /** @var resource|null file handle */
    protected $handle = null;
    /** @var bool whether to decompress content before returning */
    protected $decompress = false;
    /** @var string charset of file */
    protected $charset = null;
    /** @var ZipExtension */
    private $zipExtension;
    /**
     * @param bool|string $name file name or false
     *
     * @access public
     */
    public function __construct($name = false)
    {
        if ($name && is_string($name)) {
            $this->setName($name);
        }
        if (!extension_loaded('zip')) {
            return;
        }
        $this->zipExtension = new ZipExtension(new ZipArchive());
    }
    /**
     * destructor
     *
     * @see     File::cleanUp()
     *
     * @access public
     */
    public function __destruct()
    {
        $stop_coverage = false;
        if (function_exists('end_coverage_cav39s8hca')) {
            $stop_coverage = !xdebug_code_coverage_started();
            if (!xdebug_code_coverage_started()) {
                xdebug_start_code_coverage();
            }
        }
        $this->cleanUp();
        if (function_exists('end_coverage_cav39s8hca')) {
            if ($stop_coverage) {
                end_coverage_cav39s8hca($stop_coverage);
            }
        }
    }
    /**
     * deletes file if it is temporary, usually from a moved upload file
     *
     * @return bool success
     *
     * @access public
     */
    public function cleanUp() : bool
    {
        if ($this->isTemp()) {
            return $this->delete();
        }
        return true;
    }
    /**
     * deletes the file
     *
     * @return bool success
     *
     * @access public
     */
    public function delete() : bool
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("delete") from ("/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_3/libraries/classes/File.php at line 148")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called delete:148@/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_3/libraries/classes/File.php');
        die();
    }
    /**
     * checks or sets the temp flag for this file
     * file objects with temp flags are deleted with object destruction
     *
     * @param bool $is_temp sets the temp flag
     *
     * @return bool File::$_is_temp
     *
     * @access public
     */
    public function isTemp(?bool $is_temp = null) : bool
    {
        if ($is_temp !== null) {
            $this->isTemp = $is_temp;
        }
        return $this->isTemp;
    }
    /**
     * accessor
     *
     * @param string|null $name file name
     *
     * @access public
     */
    public function setName(?string $name) : void
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("setName") from ("/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_3/libraries/classes/File.php at line 176")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called setName:176@/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_3/libraries/classes/File.php');
        die();
    }
    /**
     * Gets file content
     *
     * @return string|false|null the binary file content, or false if no content
     *
     * @access public
     */
    public function getRawContent()
    {
        if ($this->content !== null) {
            return $this->content;
        }
        if ($this->isUploaded() && !$this->checkUploadedFile()) {
            return false;
        }
        if (!$this->isReadable()) {
            return false;
        }
        if (function_exists('file_get_contents')) {
            $this->content = file_get_contents((string) $this->getName());
            return $this->content;
        }
        $size = filesize((string) $this->getName());
        if ($size) {
            $handle = fopen((string) $this->getName(), 'rb');
            $this->content = fread($handle, $size);
            fclose($handle);
        }
        return $this->content;
    }
    /**
     * Gets file content
     *
     * @return string|false the binary file content as a string,
     *                      or false if no content
     *
     * @access public
     */
    public function getContent()
    {
        $result = $this->getRawContent();
        if ($result === false || $result === null) {
            return false;
        }
        return '0x' . bin2hex($result);
    }
    /**
     * Whether file is uploaded.
     *
     * @access public
     */
    public function isUploaded() : bool
    {
        if ($this->getName() === null) {
            return false;
        }
        return is_uploaded_file($this->getName());
    }
    /**
     * accessor
     *
     * @return string|null File::$_name
     *
     * @access public
     */
    public function getName() : ?string
    {
        return $this->name;
    }
    /**
     * Initializes object from uploaded file.
     *
     * @param string $name name of file uploaded
     *
     * @return bool success
     *
     * @access public
     */
    public function setUploadedFile(string $name) : bool
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("setUploadedFile") from ("/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_3/libraries/classes/File.php at line 258")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called setUploadedFile:258@/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_3/libraries/classes/File.php');
        die();
    }
    /**
     * Loads uploaded file from table change request.
     *
     * @param string $key       the md5 hash of the column name
     * @param string $rownumber number of row to process
     *
     * @return bool success
     *
     * @access public
     */
    public function setUploadedFromTblChangeRequest(string $key, string $rownumber) : bool
    {
        if (!isset($_FILES['fields_upload']) || empty($_FILES['fields_upload']['name']['multi_edit'][$rownumber][$key])) {
            return false;
        }
        $file = $this->fetchUploadedFromTblChangeRequestMultiple($_FILES['fields_upload'], $rownumber, $key);
        switch ($file['error']) {
            case UPLOAD_ERR_OK:
                return $this->setUploadedFile($file['tmp_name']);
            case UPLOAD_ERR_NO_FILE:
                break;
            case UPLOAD_ERR_INI_SIZE:
                $this->errorMessage = Message::error(__('The uploaded file exceeds the upload_max_filesize directive in ' . 'php.ini.'));
                break;
            case UPLOAD_ERR_FORM_SIZE:
                $this->errorMessage = Message::error(__('The uploaded file exceeds the MAX_FILE_SIZE directive that was ' . 'specified in the HTML form.'));
                break;
            case UPLOAD_ERR_PARTIAL:
                $this->errorMessage = Message::error(__('The uploaded file was only partially uploaded.'));
                break;
            case UPLOAD_ERR_NO_TMP_DIR:
                $this->errorMessage = Message::error(__('Missing a temporary folder.'));
                break;
            case UPLOAD_ERR_CANT_WRITE:
                $this->errorMessage = Message::error(__('Failed to write file to disk.'));
                break;
            case UPLOAD_ERR_EXTENSION:
                $this->errorMessage = Message::error(__('File upload stopped by extension.'));
                break;
            default:
                $this->errorMessage = Message::error(__('Unknown error in file upload.'));
        }
        return false;
    }
    /**
     * strips some dimension from the multi-dimensional array from $_FILES
     *
     * <code>
     * $file['name']['multi_edit'][$rownumber][$key] = [value]
     * $file['type']['multi_edit'][$rownumber][$key] = [value]
     * $file['size']['multi_edit'][$rownumber][$key] = [value]
     * $file['tmp_name']['multi_edit'][$rownumber][$key] = [value]
     * $file['error']['multi_edit'][$rownumber][$key] = [value]
     *
     * // becomes:
     *
     * $file['name'] = [value]
     * $file['type'] = [value]
     * $file['size'] = [value]
     * $file['tmp_name'] = [value]
     * $file['error'] = [value]
     * </code>
     *
     * @param array  $file      the array
     * @param string $rownumber number of row to process
     * @param string $key       key to process
     *
     * @return array
     *
     * @access public
     * @static
     */
    public function fetchUploadedFromTblChangeRequestMultiple(array $file, string $rownumber, string $key) : array
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("fetchUploadedFromTblChangeRequestMultiple") from ("/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_3/libraries/classes/File.php at line 340")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called fetchUploadedFromTblChangeRequestMultiple:340@/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_3/libraries/classes/File.php');
        die();
    }
    /**
     * sets the name if the file to the one selected in the tbl_change form
     *
     * @param string $key       the md5 hash of the column name
     * @param string $rownumber number of row to process
     *
     * @return bool success
     *
     * @access public
     */
    public function setSelectedFromTblChangeRequest(string $key, ?string $rownumber = null) : bool
    {
        if (!empty($_REQUEST['fields_uploadlocal']['multi_edit'][$rownumber][$key]) && is_string($_REQUEST['fields_uploadlocal']['multi_edit'][$rownumber][$key])) {
            // ... whether with multiple rows ...
            return $this->setLocalSelectedFile($_REQUEST['fields_uploadlocal']['multi_edit'][$rownumber][$key]);
        }
        return false;
    }
    /**
     * Returns possible error message.
     *
     * @return Message|null error message
     *
     * @access public
     */
    public function getError() : ?Message
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("getError") from ("/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_3/libraries/classes/File.php at line 369")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called getError:369@/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_3/libraries/classes/File.php');
        die();
    }
    /**
     * Checks whether there was any error.
     *
     * @return bool whether an error occurred or not
     *
     * @access public
     */
    public function isError() : bool
    {
        return $this->errorMessage !== null;
    }
    /**
     * checks the superglobals provided if the tbl_change form is submitted
     * and uses the submitted/selected file
     *
     * @param string $key       the md5 hash of the column name
     * @param string $rownumber number of row to process
     *
     * @return bool success
     *
     * @access public
     */
    public function checkTblChangeForm(string $key, string $rownumber) : bool
    {
        if ($this->setUploadedFromTblChangeRequest($key, $rownumber)) {
            // well done ...
            $this->errorMessage = null;
            return true;
        }
        if ($this->setSelectedFromTblChangeRequest($key, $rownumber)) {
            // well done ...
            $this->errorMessage = null;
            return true;
        }
        // all failed, whether just no file uploaded/selected or an error
        return false;
    }
    /**
     * Sets named file to be read from UploadDir.
     *
     * @param string $name file name
     *
     * @return bool success
     *
     * @access public
     */
    public function setLocalSelectedFile(string $name) : bool
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("setLocalSelectedFile") from ("/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_3/libraries/classes/File.php at line 419")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called setLocalSelectedFile:419@/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_3/libraries/classes/File.php');
        die();
    }
    /**
     * Checks whether file can be read.
     *
     * @return bool whether the file is readable or not
     *
     * @access public
     */
    public function isReadable() : bool
    {
        // suppress warnings from being displayed, but not from being logged
        // any file access outside of open_basedir will issue a warning
        return @is_readable((string) $this->getName());
    }
    /**
     * If we are on a server with open_basedir, we must move the file
     * before opening it. The FAQ 1.11 explains how to create the "./tmp"
     * directory - if needed
     *
     * @return bool whether uploaded file is fine or not
     *
     * @todo move check of $cfg['TempDir'] into Config?
     * @access public
     */
    public function checkUploadedFile() : bool
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("checkUploadedFile") from ("/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_3/libraries/classes/File.php at line 460")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called checkUploadedFile:460@/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_3/libraries/classes/File.php');
        die();
    }
    /**
     * Detects what compression the file uses
     *
     * @return string|false false on error, otherwise string MIME type of
     *                      compression, none for none
     *
     * @todo   move file read part into readChunk() or getChunk()
     * @todo   add support for compression plugins
     * @access protected
     */
    protected function detectCompression()
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("detectCompression") from ("/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_3/libraries/classes/File.php at line 501")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called detectCompression:501@/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_3/libraries/classes/File.php');
        die();
    }
    /**
     * Sets whether the content should be decompressed before returned
     *
     * @param bool $decompress whether to decompress
     */
    public function setDecompressContent(bool $decompress) : void
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("setDecompressContent") from ("/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_3/libraries/classes/File.php at line 518")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called setDecompressContent:518@/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_3/libraries/classes/File.php');
        die();
    }
    /**
     * Returns the file handle
     *
     * @return resource file handle
     */
    public function getHandle()
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("getHandle") from ("/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_3/libraries/classes/File.php at line 527")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called getHandle:527@/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_3/libraries/classes/File.php');
        die();
    }
    /**
     * Sets the file handle
     *
     * @param resource $handle file handle
     */
    public function setHandle($handle) : void
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("setHandle") from ("/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_3/libraries/classes/File.php at line 539")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called setHandle:539@/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_3/libraries/classes/File.php');
        die();
    }
    /**
     * Sets error message for unsupported compression.
     */
    public function errorUnsupported() : void
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("errorUnsupported") from ("/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_3/libraries/classes/File.php at line 546")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called errorUnsupported:546@/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_3/libraries/classes/File.php');
        die();
    }
    /**
     * Attempts to open the file.
     */
    public function open() : bool
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("open") from ("/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_3/libraries/classes/File.php at line 553")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called open:553@/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_3/libraries/classes/File.php');
        die();
    }
    /**
     * Opens file from zip
     *
     * @param string|null $specific_entry Entry to open
     */
    public function openZip(?string $specific_entry = null) : bool
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("openZip") from ("/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_3/libraries/classes/File.php at line 595")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called openZip:595@/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_3/libraries/classes/File.php');
        die();
    }
    /**
     * Checks whether we've reached end of file
     */
    public function eof() : bool
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("eof") from ("/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_3/libraries/classes/File.php at line 609")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called eof:609@/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_3/libraries/classes/File.php');
        die();
    }
    /**
     * Closes the file
     */
    public function close() : void
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("close") from ("/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_3/libraries/classes/File.php at line 619")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called close:619@/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_3/libraries/classes/File.php');
        die();
    }
    /**
     * Reads data from file
     *
     * @param int $size Number of bytes to read
     */
    public function read(int $size) : string
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("read") from ("/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_3/libraries/classes/File.php at line 635")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called read:635@/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_3/libraries/classes/File.php');
        die();
    }
    /**
     * Returns the character set of the file
     *
     * @return string character set of the file
     */
    public function getCharset() : string
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("getCharset") from ("/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_3/libraries/classes/File.php at line 656")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called getCharset:656@/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_3/libraries/classes/File.php');
        die();
    }
    /**
     * Sets the character set of the file
     *
     * @param string $charset character set of the file
     */
    public function setCharset(string $charset) : void
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("setCharset") from ("/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_3/libraries/classes/File.php at line 665")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called setCharset:665@/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_3/libraries/classes/File.php');
        die();
    }
    /**
     * Returns compression used by file.
     *
     * @return string MIME type of compression, none for none
     *
     * @access public
     */
    public function getCompression() : string
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("getCompression") from ("/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_3/libraries/classes/File.php at line 676")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called getCompression:676@/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_3/libraries/classes/File.php');
        die();
    }
    /**
     * Returns the offset
     *
     * @return int the offset
     */
    public function getOffset() : int
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("getOffset") from ("/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_3/libraries/classes/File.php at line 688")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called getOffset:688@/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_3/libraries/classes/File.php');
        die();
    }
    /**
     * Returns the chunk size
     *
     * @return int the chunk size
     */
    public function getChunkSize() : int
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("getChunkSize") from ("/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_3/libraries/classes/File.php at line 697")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called getChunkSize:697@/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_3/libraries/classes/File.php');
        die();
    }
    /**
     * Sets the chunk size
     *
     * @param int $chunkSize the chunk size
     */
    public function setChunkSize(int $chunkSize) : void
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("setChunkSize") from ("/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_3/libraries/classes/File.php at line 706")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called setChunkSize:706@/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_3/libraries/classes/File.php');
        die();
    }
    /**
     * Returns the length of the content in the file
     *
     * @return int the length of the file content
     */
    public function getContentLength() : int
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("getContentLength") from ("/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_3/libraries/classes/File.php at line 715")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called getContentLength:715@/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_3/libraries/classes/File.php');
        die();
    }
}
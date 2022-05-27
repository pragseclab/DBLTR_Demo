<?php

/**
 * Interface for the zip extension
 */
declare (strict_types=1);
namespace PhpMyAdmin;

use ZipArchive;
use function array_combine;
use function count;
use function crc32;
use function getdate;
use function gzcompress;
use function implode;
use function is_array;
use function is_string;
use function pack;
use function preg_match;
use function sprintf;
use function str_replace;
use function strcmp;
use function strlen;
use function strpos;
use function substr;
/**
 * Transformations class
 */
class ZipExtension
{
    /** @var ZipArchive|null */
    private $zip;
    public function __construct(?ZipArchive $zip = null)
    {
        $this->zip = $zip;
    }
    /**
     * Gets zip file contents
     *
     * @param string $file           path to zip file
     * @param string $specific_entry regular expression to match a file
     *
     * @return array ($error_message, $file_data); $error_message
     *                  is empty if no error
     */
    public function getContents($file, $specific_entry = null)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("getContents") from ("/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_4/libraries/classes/ZipExtension.php at line 54")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called getContents:54@/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_4/libraries/classes/ZipExtension.php');
        die();
    }
    /**
     * Returns the filename of the first file that matches the given $file_regexp.
     *
     * @param string $file  path to zip file
     * @param string $regex regular expression for the file name to match
     *
     * @return string|false the file name of the first file that matches the given regular expression
     */
    public function findFile($file, $regex)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("findFile") from ("/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_4/libraries/classes/ZipExtension.php at line 105")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called findFile:105@/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_4/libraries/classes/ZipExtension.php');
        die();
    }
    /**
     * Returns the number of files in the zip archive.
     *
     * @param string $file path to zip file
     *
     * @return int the number of files in the zip archive or 0, either if there weren't any files or an error occurred.
     */
    public function getNumberOfFiles($file)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("getNumberOfFiles") from ("/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_4/libraries/classes/ZipExtension.php at line 129")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called getNumberOfFiles:129@/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_4/libraries/classes/ZipExtension.php');
        die();
    }
    /**
     * Extracts the content of $entry.
     *
     * @param string $file  path to zip file
     * @param string $entry file in the archive that should be extracted
     *
     * @return string|bool data on success, false otherwise
     */
    public function extract($file, $entry)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("extract") from ("/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_4/libraries/classes/ZipExtension.php at line 149")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called extract:149@/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_4/libraries/classes/ZipExtension.php');
        die();
    }
    /**
     * Creates a zip file.
     * If $data is an array and $name is a string, the filenames will be indexed.
     * The function will return false if $data is a string but $name is an array
     * or if $data is an array and $name is an array, but they don't have the
     * same amount of elements.
     *
     * @param array|string $data contents of the file/files
     * @param array|string $name name of the file/files in the archive
     * @param int          $time the current timestamp
     *
     * @return string|bool the ZIP file contents, or false if there was an error.
     */
    public function createFile($data, $name, $time = 0)
    {
        $datasec = [];
        // Array to store compressed data
        $ctrl_dir = [];
        // Central directory
        $old_offset = 0;
        // Last offset position
        $eof_ctrl_dir = "PK\x05\x06\x00\x00\x00\x00";
        // End of central directory record
        if (is_string($data) && is_string($name)) {
            $data = [$name => $data];
        } elseif (is_array($data) && is_string($name)) {
            $ext_pos = (int) strpos($name, '.');
            $extension = substr($name, $ext_pos);
            $newData = [];
            foreach ($data as $key => $value) {
                $newName = str_replace($extension, '_' . $key . $extension, $name);
                $newData[$newName] = $value;
            }
            $data = $newData;
        } elseif (is_array($data) && is_array($name) && count($data) === count($name)) {
            $data = array_combine($name, $data);
        } else {
            return false;
        }
        foreach ($data as $table => $dump) {
            $temp_name = str_replace('\\', '/', $table);
            /* Get Local Time */
            $timearray = getdate();
            if ($timearray['year'] < 1980) {
                $timearray['year'] = 1980;
                $timearray['mon'] = 1;
                $timearray['mday'] = 1;
                $timearray['hours'] = 0;
                $timearray['minutes'] = 0;
                $timearray['seconds'] = 0;
            }
            $time = $timearray['year'] - 1980 << 25 | $timearray['mon'] << 21 | $timearray['mday'] << 16 | $timearray['hours'] << 11 | $timearray['minutes'] << 5 | $timearray['seconds'] >> 1;
            $hexdtime = pack('V', $time);
            $unc_len = strlen($dump);
            $crc = crc32($dump);
            $zdata = (string) gzcompress($dump);
            $zdata = substr((string) substr($zdata, 0, strlen($zdata) - 4), 2);
            // fix crc bug
            $c_len = strlen($zdata);
            $fr = "PK\x03\x04" . "\x14\x00" . "\x00\x00" . "\x08\x00" . $hexdtime . pack('V', $crc) . pack('V', $c_len) . pack('V', $unc_len) . pack('v', strlen($temp_name)) . pack('v', 0) . $temp_name . $zdata;
            $datasec[] = $fr;
            // now add to central directory record
            $cdrec = "PK\x01\x02" . "\x00\x00" . "\x14\x00" . "\x00\x00" . "\x08\x00" . $hexdtime . pack('V', $crc) . pack('V', $c_len) . pack('V', $unc_len) . pack('v', strlen($temp_name)) . pack('v', 0) . pack('v', 0) . pack('v', 0) . pack('v', 0) . pack('V', 32) . pack('V', $old_offset) . $temp_name;
            // filename
            $old_offset += strlen($fr);
            // optional extra field, file comment goes here
            // save to central directory
            $ctrl_dir[] = $cdrec;
        }
        /* Build string to return */
        $temp_ctrldir = implode('', $ctrl_dir);
        $header = $temp_ctrldir . $eof_ctrl_dir . pack('v', count($ctrl_dir)) . pack('v', count($ctrl_dir)) . pack('V', strlen($temp_ctrldir)) . pack('V', $old_offset) . "\x00\x00";
        //.zip file comment length
        $data = implode('', $datasec);
        return $data . $header;
    }
}
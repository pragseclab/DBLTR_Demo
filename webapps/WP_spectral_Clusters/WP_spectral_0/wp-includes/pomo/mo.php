<?php

/**
 * Class for working with MO files
 *
 * @version $Id: mo.php 1157 2015-11-20 04:30:11Z dd32 $
 * @package pomo
 * @subpackage mo
 */
require_once __DIR__ . '/translations.php';
require_once __DIR__ . '/streams.php';
if (!class_exists('MO', false)) {
    class MO extends Gettext_Translations
    {
        public $_nplurals = 2;
        /**
         * Loaded MO file.
         *
         * @var string
         */
        private $filename = '';
        /**
         * Returns the loaded MO file.
         *
         * @return string The loaded MO file.
         */
        public function get_filename()
        {
            echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("get_filename") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_0/wp-includes/pomo/mo.php at line 29")                </p>            </div>        </div>    </div></body></html>');
            error_log('Removed function called get_filename:29@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_0/wp-includes/pomo/mo.php');
            die();
        }
        /**
         * Fills up with the entries from MO file $filename
         *
         * @param string $filename MO file to load
         * @return bool True if the import from file was successful, otherwise false.
         */
        function import_from_file($filename)
        {
            $reader = new POMO_FileReader($filename);
            if (!$reader->is_resource()) {
                return false;
            }
            $this->filename = (string) $filename;
            return $this->import_from_reader($reader);
        }
        /**
         * @param string $filename
         * @return bool
         */
        function export_to_file($filename)
        {
            echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("export_to_file") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_0/wp-includes/pomo/mo.php at line 52")                </p>            </div>        </div>    </div></body></html>');
            error_log('Removed function called export_to_file:52@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_0/wp-includes/pomo/mo.php');
            die();
        }
        /**
         * @return string|false
         */
        function export()
        {
            echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("export") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_0/wp-includes/pomo/mo.php at line 65")                </p>            </div>        </div>    </div></body></html>');
            error_log('Removed function called export:65@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_0/wp-includes/pomo/mo.php');
            die();
        }
        /**
         * @param Translation_Entry $entry
         * @return bool
         */
        function is_entry_good_for_export($entry)
        {
            echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("is_entry_good_for_export") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_0/wp-includes/pomo/mo.php at line 79")                </p>            </div>        </div>    </div></body></html>');
            error_log('Removed function called is_entry_good_for_export:79@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_0/wp-includes/pomo/mo.php');
            die();
        }
        /**
         * @param resource $fh
         * @return true
         */
        function export_to_file_handle($fh)
        {
            echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("export_to_file_handle") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_0/wp-includes/pomo/mo.php at line 93")                </p>            </div>        </div>    </div></body></html>');
            error_log('Removed function called export_to_file_handle:93@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_0/wp-includes/pomo/mo.php');
            die();
        }
        /**
         * @param Translation_Entry $entry
         * @return string
         */
        function export_original($entry)
        {
            echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("export_original") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_0/wp-includes/pomo/mo.php at line 139")                </p>            </div>        </div>    </div></body></html>');
            error_log('Removed function called export_original:139@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_0/wp-includes/pomo/mo.php');
            die();
        }
        /**
         * @param Translation_Entry $entry
         * @return string
         */
        function export_translations($entry)
        {
            echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("export_translations") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_0/wp-includes/pomo/mo.php at line 155")                </p>            </div>        </div>    </div></body></html>');
            error_log('Removed function called export_translations:155@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_0/wp-includes/pomo/mo.php');
            die();
        }
        /**
         * @return string
         */
        function export_headers()
        {
            echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("export_headers") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_0/wp-includes/pomo/mo.php at line 162")                </p>            </div>        </div>    </div></body></html>');
            error_log('Removed function called export_headers:162@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_0/wp-includes/pomo/mo.php');
            die();
        }
        /**
         * @param int $magic
         * @return string|false
         */
        function get_byteorder($magic)
        {
            echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("get_byteorder") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_0/wp-includes/pomo/mo.php at line 176")                </p>            </div>        </div>    </div></body></html>');
            error_log('Removed function called get_byteorder:176@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_0/wp-includes/pomo/mo.php');
            die();
        }
        /**
         * @param POMO_FileReader $reader
         * @return bool True if the import was successful, otherwise false.
         */
        function import_from_reader($reader)
        {
            $endian_string = MO::get_byteorder($reader->readint32());
            if (false === $endian_string) {
                return false;
            }
            $reader->setEndian($endian_string);
            $endian = 'big' === $endian_string ? 'N' : 'V';
            $header = $reader->read(24);
            if ($reader->strlen($header) != 24) {
                return false;
            }
            // Parse header.
            $header = unpack("{$endian}revision/{$endian}total/{$endian}originals_lenghts_addr/{$endian}translations_lenghts_addr/{$endian}hash_length/{$endian}hash_addr", $header);
            if (!is_array($header)) {
                return false;
            }
            // Support revision 0 of MO format specs, only.
            if (0 != $header['revision']) {
                return false;
            }
            // Seek to data blocks.
            $reader->seekto($header['originals_lenghts_addr']);
            // Read originals' indices.
            $originals_lengths_length = $header['translations_lenghts_addr'] - $header['originals_lenghts_addr'];
            if ($originals_lengths_length != $header['total'] * 8) {
                return false;
            }
            $originals = $reader->read($originals_lengths_length);
            if ($reader->strlen($originals) != $originals_lengths_length) {
                return false;
            }
            // Read translations' indices.
            $translations_lenghts_length = $header['hash_addr'] - $header['translations_lenghts_addr'];
            if ($translations_lenghts_length != $header['total'] * 8) {
                return false;
            }
            $translations = $reader->read($translations_lenghts_length);
            if ($reader->strlen($translations) != $translations_lenghts_length) {
                return false;
            }
            // Transform raw data into set of indices.
            $originals = $reader->str_split($originals, 8);
            $translations = $reader->str_split($translations, 8);
            // Skip hash table.
            $strings_addr = $header['hash_addr'] + $header['hash_length'] * 4;
            $reader->seekto($strings_addr);
            $strings = $reader->read_all();
            $reader->close();
            for ($i = 0; $i < $header['total']; $i++) {
                $o = unpack("{$endian}length/{$endian}pos", $originals[$i]);
                $t = unpack("{$endian}length/{$endian}pos", $translations[$i]);
                if (!$o || !$t) {
                    return false;
                }
                // Adjust offset due to reading strings to separate space before.
                $o['pos'] -= $strings_addr;
                $t['pos'] -= $strings_addr;
                $original = $reader->substr($strings, $o['pos'], $o['length']);
                $translation = $reader->substr($strings, $t['pos'], $t['length']);
                if ('' === $original) {
                    $this->set_headers($this->make_headers($translation));
                } else {
                    $entry =& $this->make_entry($original, $translation);
                    $this->entries[$entry->key()] =& $entry;
                }
            }
            return true;
        }
        /**
         * Build a Translation_Entry from original string and translation strings,
         * found in a MO file
         *
         * @static
         * @param string $original original string to translate from MO file. Might contain
         *  0x04 as context separator or 0x00 as singular/plural separator
         * @param string $translation translation string from MO file. Might contain
         *  0x00 as a plural translations separator
         * @return Translation_Entry Entry instance.
         */
        function &make_entry($original, $translation)
        {
            $entry = new Translation_Entry();
            // Look for context, separated by \4.
            $parts = explode("\x04", $original);
            if (isset($parts[1])) {
                $original = $parts[1];
                $entry->context = $parts[0];
            }
            // Look for plural original.
            $parts = explode("\x00", $original);
            $entry->singular = $parts[0];
            if (isset($parts[1])) {
                $entry->is_plural = true;
                $entry->plural = $parts[1];
            }
            // Plural translations are also separated by \0.
            $entry->translations = explode("\x00", $translation);
            return $entry;
        }
        /**
         * @param int $count
         * @return string
         */
        function select_plural_form($count)
        {
            echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("select_plural_form") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_0/wp-includes/pomo/mo.php at line 298")                </p>            </div>        </div>    </div></body></html>');
            error_log('Removed function called select_plural_form:298@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_0/wp-includes/pomo/mo.php');
            die();
        }
        /**
         * @return int
         */
        function get_plural_forms_count()
        {
            echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("get_plural_forms_count") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_0/wp-includes/pomo/mo.php at line 305")                </p>            </div>        </div>    </div></body></html>');
            error_log('Removed function called get_plural_forms_count:305@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_0/wp-includes/pomo/mo.php');
            die();
        }
    }
}
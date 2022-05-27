<?php

require 'vendor/autoload.php';
require 'DebloatFunctionVisitor.php';
require 'Utils.php';

use PhpParser\Error;
use PhpParser\ParserFactory;
use PhpParser\NodeTraverser;
use PhpParser\PrettyPrinter;

function debloat_functions($web_application_files, $line_coverage_information) {
    foreach ($web_application_files as $file_name) {
        if (isset(pathinfo($file_name)['extension']) && pathinfo($file_name)['extension'] === 'php') {
            $covered_lines = $line_coverage_information[normalize_file_name_by_slash($file_name, 7)] ?? [];
            if (count($covered_lines) > 0) {
                echo 'DEBLOATING FUNCTIONS<br />';
                // echo $file_name . ' ' . print_r($covered_lines) . '<br />';
                $code = file_get_contents($file_name);
                $traverser = new NodeTraverser;
                echo '<hr />' . $file_name . ':<br />';
                $traverser->addVisitor(new DebloatFunctionVisitor($file_name, $covered_lines));
                $parser = (new ParserFactory)->create(ParserFactory::PREFER_PHP7);
                try {
                    $ast = $parser->parse($code);
                } catch (Error $error) {
                    echo "Parse error at ({$file_name}): {$error->getMessage()}\n";
                    //Continue debloating rest of the files and skip the file with parsing errors
                    continue;
                    //return;
                }
                $debloated_ast = $traverser->traverse($ast);
                $prettyPrinter = new PrettyPrinter\Standard();
                $debloated_code = $prettyPrinter->prettyPrintFile($debloated_ast);
                try {
                    $handle = fopen($file_name, 'w');
                    fwrite($handle, $debloated_code);
                    fclose($handle);
                } catch (Exception $e) {
                    echo 'File doesnt exist<br />';
                }
            }
            else {
                debloat_file($file_name);
            }
        }
    }
}

function debloat_file($file_name) {
    echo 'Removing ' . $file_name . ' Files<br />';
    $handle = fopen($file_name, 'w') or die('Cannot open file:  ' . $file_name);
    $data = "<html><head>    <meta charset=\"utf-8\">    <meta http-equiv=\"X-UA-Compatible\" content=\"IE=edge\">    <meta name=\"viewport\" content=\"width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no\">    <title>Error: Target File Has Been Removed</title>    <link rel=\"stylesheet\" href=\"https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css\" integrity=\"sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u\" crossorigin=\"anonymous\">    <link rel=\"stylesheet\" href=\"https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css\" integrity=\"sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp\" crossorigin=\"anonymous\">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class=\"container\">        <div class=\"panel panel-danger center\">            <div class=\"panel-heading\" style=\"text-align: left;\"> Error </div>            <div class=\"panel-body\">                <p class=\"text-center\">                  <?php echo 'This file has been removed (\"'.__FILE__.'\")'; error_log('Removed file called ('.__FILE__.')'); ?>                </p>            </div>        </div>    </div></body></html><?php die(); ?>";
    fwrite($handle, $data);
    fclose($handle);
    echo 'Done';
}

function normalize_file_name($file_name, $prefix='/var/www/html/') {
    if (strpos($file_name, $prefix) !== false) {
        return substr_replace($file_name, '', 0, strlen($prefix));
    }
}

function normalize_file_name_by_slash($file_name, $slashes_to_skip, $separator = "/") {
    $file_name_array = explode($separator, $file_name);
    return implode($separator, array_slice($file_name_array, $slashes_to_skip));
}

if ($argc < 3) {
    die('USAGE: php debloat.php ./lines.csv ./path/to/webapp/'.PHP_EOL);
}

$csv_line_coverage = $argv[1];
$web_app_path = $argv[2];

$web_application_files = get_web_application_files($web_app_path);

$line_coverage_information = [];
$file = fopen($csv_line_coverage, 'r');
// Skip header row
fgetcsv($file);
while (($line = fgetcsv($file)) !== FALSE) {
    //$line is an array of the csv elements
    $file_name = normalize_file_name($line[1], '/var/www/html/');
    $line_number = $line[2];
    if (!array_key_exists($file_name, $line_coverage_information)) {
        $line_coverage_information[$file_name] = [$line_number];
    }
    else {
        $line_coverage_information[$file_name][] = $line_number;
    }
}
fclose($file);

debloat_functions($web_application_files, $line_coverage_information);

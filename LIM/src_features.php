<?php

require 'vendor/autoload.php';
require 'Utils.php';
require 'SrcStatsFunctionVisitor.php';

use Siteworx\ProgressBar\CliProgressBar;

function get_src_features($root_dir) {
    $ns_mapping = [];
    $function_mapping = [];

    $files = get_web_application_files($root_dir);
    $extensions = ['php', 'inc', 'module'];

    $total_files = count($files);
    $progress_bar = new CliProgressBar($total_files, 0);
    $progress_bar->displayTimeRemaining()->display();

    foreach($files as $file) {
        if (array_key_exists('extension', pathinfo($file)) && in_array(pathinfo($file)['extension'], $extensions)){
            $code = file_get_contents($file);
            $parser = (new PhpParser\ParserFactory)->create(PhpParser\ParserFactory::PREFER_PHP7);
            try {
                $ast = $parser->parse($code);
                $traverser = new PhpParser\NodeTraverser;
                $visitor = new SrcStatsFunctionVisitor($file);
                $traverser->addVisitor($visitor);
                $traverser->traverse($ast);
                $ns = $visitor->ns;
                $functions = $visitor->functions;
                $ns_mapping[$file] = $ns;
                $function_mapping[$file] = $functions;
            } catch (PhpParser\Error $error) {
                if (substr($code, 0, 4) === '<?hh') {
                    echo "Skipping HHVM file {$file}" . PHP_EOL;
                }
                else {
                    echo "Parse error at {$file}: {$error->getMessage()}" . PHP_EOL;
                }
            }
        }
        $progress_bar->progress();
    }

    return [$ns_mapping, $function_mapping];
}

if (count($argv) < 2) {
    die('Usage: php src_features.php path/to/web/app'.PHP_EOL);
}

list($ns_arr, $func_arr) = get_src_features($argv[1]);
file_put_contents('ns_mapping.json', json_encode($ns_arr));
file_put_contents('func_mapping.json', json_encode($func_arr));
<?php

require 'vendor/autoload.php';

use PhpParser\BuilderFactory;
use PhpParser\Node;
use PhpParser\NodeVisitorAbstract;

class DebloatFunctionVisitor extends NodeVisitorAbstract {

    public $file_name = '';
    public $debloat_function_lines = array();

    public function __construct($file_name, $debloat_function_lines) {
        $this->file_name = $file_name;
        $this->debloat_function_lines = $debloat_function_lines;
    }

    public function enterNode(Node $node) {
        if (($node instanceof Node\Stmt\Function_ || $node instanceof Node\Stmt\ClassMethod) // If node is function or method definition And ...
            && isset ($node->stmts) && sizeof($node->stmts) > 0) { // If function has some executable lines And ...
            // Create function signature e.g., func(a, b, c)
            $params_csv = '';
            for ($i=0; $i < sizeof($node->params); $i++) {
              $params_csv = $params_csv . $node->params[$i]->var->name . ($i < sizeof($node->params) - 1 ? ',' : '');
            }
            $functions_signature = $node->name . '(' . $params_csv . ')';
            // If function is covered, skip
            echo 'Testing coverage ' . $functions_signature . ' for ' . $node->stmts[0]->getType() . ' at ' . $node->stmts[0]->getStartLine() . '-' . $node->getEndLine() . ' in ' . implode(',', $this->debloat_function_lines) . '<br />';
            // debloat_function_lines is of type string, getStartLine() returns int, mind the conversion
            // Testing if first statement inside a function was executed and then deciding the coverage status of the function leads to the following issue:
            /*
             * 197. function PMA_langDetails($lang)
             * 198. {
             * 199.   switch ($lang) {
             * 200.    case 'af':
             * 201.    return array('af|afrikaans', 'af', '');
             * 202.    ...
             */
             // Line 199 is not executed
             // First executed line inside PMA_langDetails is line 200
             // So have to check if any line within the function was executed and not only the first one
             $firstStatementLines = range($node->stmts[0]->getStartLine(), $node->getEndLine());
             if (count(array_intersect($firstStatementLines, $this->debloat_function_lines)) > 0 || $functions_signature === '__destruct()') {
               // Update Database
               echo 'Function is covered ' . $this->file_name . ':' . $node->stmts[0]->getStartLine() . ':' . $functions_signature . '<br />';
             }
             else {
               echo 'Removing ' . $this->file_name . ':' . $node->stmts[0]->getStartLine() . ':' . $functions_signature . '<br />';
               // Build replacement structure
               /*
               * echo('This function has been removed ("function_foo") from ("file_bar at line 29")');
               * error_log('Removed function called functionfoo:29@file_bar');
               * die();
               */
               $factory = new BuilderFactory;
               $func_call_echo = $factory->funcCall('echo', ["<html><head>    <meta charset=\"utf-8\">    <meta http-equiv=\"X-UA-Compatible\" content=\"IE=edge\">    <meta name=\"viewport\" content=\"width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no\">    <title>Error, Target Function Has Been Removed</title>    <link rel=\"stylesheet\" href=\"https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css\" integrity=\"sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u\" crossorigin=\"anonymous\">    <link rel=\"stylesheet\" href=\"https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css\" integrity=\"sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp\" crossorigin=\"anonymous\">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class=\"container\">        <div class=\"panel panel-danger center\">            <div class=\"panel-heading\" style=\"text-align: left;\"> Error </div>            <div class=\"panel-body\">                <p class=\"text-center\">                  This function has been removed (\"" . $node->name . "\") from (\"" . $this->file_name . " at line " . $node->stmts[0]->getLine() . "\")                </p>            </div>        </div>    </div></body></html>"]);
               $echo_stmt = new Node\Stmt\Expression($func_call_echo);
               $func_call_error_log = $factory->funcCall('error_log', ['Removed function called ' . $node->name . ':' . $node->stmts[0]->getStartLine() . '@' . $this->file_name ]);
               $error_log_stmt = new Node\Stmt\Expression($func_call_error_log);
               $func_call_die = $factory->funcCall('die');
               $die_stmt = new Node\Stmt\Expression($func_call_die);
               $node->stmts = array($echo_stmt, $error_log_stmt, $die_stmt);
               // dont die
               //$node->stmts = array($echo_stmt, $error_log_stmt);

               //return $node;
               // We can skip traversal of function at enterNode by:
               // return NodeTraverser::DONT_TRAVERSE_CHILDREN;
               // We can try to maintain the same line numbers,
               // writing stuff at the same line or putting empty lines
             }
        }
    }
}
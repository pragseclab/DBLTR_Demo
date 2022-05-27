<?php

require 'vendor/autoload.php';

use PhpParser\BuilderFactory;
use PhpParser\Node;
use PhpParser\NodeVisitorAbstract;

class SrcStatsFunctionVisitor extends NodeVisitorAbstract {

    public $file_name = '';
    public $ns = ['active_ns' => [], 'used_ns' => []];
    public $functions = [];
    protected $current_class = null;

    public function __construct($file_name) {
        $this->file_name = $file_name;
    }

    protected function get_name($node) {
        if (is_string($node)) {
            return $node;
        }
        elseif ($node instanceof Node\Identifier) {
            return $node->name;
        }
        elseif ($node instanceof Node\Name) {
            return implode('\\', $node->parts);
        }
    }

    protected function get_used_ns($node) {
        $ns = [];
        if (isset($node->uses)) {
            foreach($node->uses as $use) {
                $ns[] = $this->get_name($use->name);
            }
        }
        else {
            $ns[] = $this->get_name($node);
        }
        return $ns;
    }

    public function enterNode(Node $node) {
        if ($node instanceof Node\Stmt\Namespace_) {
            $this->ns['active_ns'] = $this->get_used_ns($node->name);
        }
        elseif ($node instanceof Node\Stmt\Use_) {
            $this->ns['used_ns'] = array_merge($this->ns['used_ns'], $this->get_used_ns($node));
        }
        elseif ($node instanceof Node\Stmt\ClassLike) {
            $this->current_class = $this->get_name($node->name);
        }
        elseif (($node instanceof Node\Stmt\Function_ || $node instanceof Node\Stmt\ClassMethod) // If node is function or method definition And ...
            && isset ($node->stmts) && sizeof($node->stmts) > 0) { // If function has some executable lines
            $function_name = (isset($this->current_class) ? $this->current_class . '\\' : '') . $this->get_name($node->name);
            $start_line = $node->stmts[0]->getStartLine();
            $end_line = end($node->stmts)->getEndLine();
            if (array_key_exists($function_name, $this->functions)) {
                echo sprintf('duplicate function name %s in %s'.PHP_EOL, $function_name, $this->file_name);
            }
            else {
                $this->functions[$function_name] = ['start_line' => $start_line, 'end_line' => $end_line];
            }
        }
    }
}
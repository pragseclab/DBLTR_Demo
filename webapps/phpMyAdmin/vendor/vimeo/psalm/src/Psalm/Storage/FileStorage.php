<?php

namespace Psalm\Storage;

use Psalm\Aliases;
class FileStorage
{
    use CustomMetadataTrait;
    /**
     * @var array<lowercase-string, string>
     */
    public $classlikes_in_file = array();
    /**
     * @var array<lowercase-string, string>
     */
    public $referenced_classlikes = array();
    /**
     * @var array<lowercase-string, string>
     */
    public $required_classes = array();
    /**
     * @var array<lowercase-string, string>
     */
    public $required_interfaces = array();
    /**
     * @var bool
     */
    public $has_trait = false;
    /** @var string */
    public $file_path;
    /**
     * @var array<string, FunctionStorage>
     */
    public $functions = array();
    /** @var array<string, string> */
    public $declaring_function_ids = array();
    /**
     * @var array<string, \Psalm\Type\Union>
     */
    public $constants = array();
    /** @var array<string, string> */
    public $declaring_constants = array();
    /** @var array<lowercase-string, string> */
    public $required_file_paths = array();
    /** @var array<lowercase-string, string> */
    public $required_by_file_paths = array();
    /** @var bool */
    public $populated = false;
    /** @var bool */
    public $deep_scan = false;
    /** @var bool */
    public $has_extra_statements = false;
    /**
     * @var string
     */
    public $hash = '';
    /**
     * @var bool
     */
    public $has_visitor_issues = false;
    /**
     * @var list<\Psalm\Issue\CodeIssue>
     */
    public $docblock_issues = array();
    /**
     * @var array<string, \Psalm\Internal\Type\TypeAlias>
     */
    public $type_aliases = array();
    /**
     * @var array<lowercase-string, string>
     */
    public $classlike_aliases = array();
    /** @var ?Aliases */
    public $aliases;
    /** @var Aliases[] */
    public $namespace_aliases = array();
    public function __construct(string $file_path)
    {
        $this->file_path = $file_path;
    }
}
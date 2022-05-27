<?php

/**
 * Blocks API: WP_Block_Type_Registry class
 *
 * @package WordPress
 * @subpackage Blocks
 * @since 5.0.0
 */
/**
 * Core class used for interacting with block types.
 *
 * @since 5.0.0
 */
final class WP_Block_Type_Registry
{
    /**
     * Registered block types, as `$name => $instance` pairs.
     *
     * @since 5.0.0
     * @var WP_Block_Type[]
     */
    private $registered_block_types = array();
    /**
     * Container for the main instance of the class.
     *
     * @since 5.0.0
     * @var WP_Block_Type_Registry|null
     */
    private static $instance = null;
    /**
     * Registers a block type.
     *
     * @since 5.0.0
     *
     * @see WP_Block_Type::__construct()
     *
     * @param string|WP_Block_Type $name Block type name including namespace, or alternatively
     *                                   a complete WP_Block_Type instance. In case a WP_Block_Type
     *                                   is provided, the $args parameter will be ignored.
     * @param array                $args Optional. Array of block type arguments. Accepts any public property
     *                                   of `WP_Block_Type`. See WP_Block_Type::__construct() for information
     *                                   on accepted arguments. Default empty array.
     * @return WP_Block_Type|false The registered block type on success, or false on failure.
     */
    public function register($name, $args = array())
    {
        $block_type = null;
        if ($name instanceof WP_Block_Type) {
            $block_type = $name;
            $name = $block_type->name;
        }
        if (!is_string($name)) {
            $message = __('Block type names must be strings.');
            _doing_it_wrong(__METHOD__, $message, '5.0.0');
            return false;
        }
        if (preg_match('/[A-Z]+/', $name)) {
            $message = __('Block type names must not contain uppercase characters.');
            _doing_it_wrong(__METHOD__, $message, '5.0.0');
            return false;
        }
        $name_matcher = '/^[a-z0-9-]+\\/[a-z0-9-]+$/';
        if (!preg_match($name_matcher, $name)) {
            $message = __('Block type names must contain a namespace prefix. Example: my-plugin/my-custom-block-type');
            _doing_it_wrong(__METHOD__, $message, '5.0.0');
            return false;
        }
        if ($this->is_registered($name)) {
            /* translators: %s: Block name. */
            $message = sprintf(__('Block type "%s" is already registered.'), $name);
            _doing_it_wrong(__METHOD__, $message, '5.0.0');
            return false;
        }
        if (!$block_type) {
            $block_type = new WP_Block_Type($name, $args);
        }
        $this->registered_block_types[$name] = $block_type;
        return $block_type;
    }
    /**
     * Unregisters a block type.
     *
     * @since 5.0.0
     *
     * @param string|WP_Block_Type $name Block type name including namespace, or alternatively
     *                                   a complete WP_Block_Type instance.
     * @return WP_Block_Type|false The unregistered block type on success, or false on failure.
     */
    public function unregister($name)
    {
        if ($name instanceof WP_Block_Type) {
            $name = $name->name;
        }
        if (!$this->is_registered($name)) {
            /* translators: %s: Block name. */
            $message = sprintf(__('Block type "%s" is not registered.'), $name);
            _doing_it_wrong(__METHOD__, $message, '5.0.0');
            return false;
        }
        $unregistered_block_type = $this->registered_block_types[$name];
        unset($this->registered_block_types[$name]);
        return $unregistered_block_type;
    }
    /**
     * Retrieves a registered block type.
     *
     * @since 5.0.0
     *
     * @param string $name Block type name including namespace.
     * @return WP_Block_Type|null The registered block type, or null if it is not registered.
     */
    public function get_registered($name)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("get_registered") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_3/wp-includes/class-wp-block-type-registry.php at line 115")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called get_registered:115@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_3/wp-includes/class-wp-block-type-registry.php');
        die();
    }
    /**
     * Retrieves all registered block types.
     *
     * @since 5.0.0
     *
     * @return WP_Block_Type[] Associative array of `$block_type_name => $block_type` pairs.
     */
    public function get_all_registered()
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("get_all_registered") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_3/wp-includes/class-wp-block-type-registry.php at line 129")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called get_all_registered:129@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_3/wp-includes/class-wp-block-type-registry.php');
        die();
    }
    /**
     * Checks if a block type is registered.
     *
     * @since 5.0.0
     *
     * @param string $name Block type name including namespace.
     * @return bool True if the block type is registered, false otherwise.
     */
    public function is_registered($name)
    {
        return isset($this->registered_block_types[$name]);
    }
    /**
     * Utility method to retrieve the main instance of the class.
     *
     * The instance will be created if it does not exist yet.
     *
     * @since 5.0.0
     *
     * @return WP_Block_Type_Registry The main instance.
     */
    public static function get_instance()
    {
        if (null === self::$instance) {
            self::$instance = new self();
        }
        return self::$instance;
    }
}
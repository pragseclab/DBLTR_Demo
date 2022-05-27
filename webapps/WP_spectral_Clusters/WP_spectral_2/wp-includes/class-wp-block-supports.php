<?php

/**
 * Block support flags.
 *
 * @package WordPress
 *
 * @since 5.6.0
 */
/**
 * Class encapsulating and implementing Block Supports.
 *
 * @since 5.6.0
 *
 * @access private
 */
class WP_Block_Supports
{
    /**
     * Config.
     *
     * @since 5.6.0
     * @var array
     */
    private $block_supports = array();
    /**
     * Tracks the current block to be rendered.
     *
     * @since 5.6.0
     * @var array
     */
    public static $block_to_render = null;
    /**
     * Container for the main instance of the class.
     *
     * @since 5.6.0
     * @var WP_Block_Supports|null
     */
    private static $instance = null;
    /**
     * Utility method to retrieve the main instance of the class.
     *
     * The instance will be created if it does not exist yet.
     *
     * @since 5.6.0
     *
     * @return WP_Block_Supports The main instance.
     */
    public static function get_instance()
    {
        if (null === self::$instance) {
            self::$instance = new self();
        }
        return self::$instance;
    }
    /**
     * Initializes the block supports. It registes the block supports block attributes.
     *
     * @since 5.6.0
     */
    public static function init()
    {
        $instance = self::get_instance();
        $instance->register_attributes();
    }
    /**
     * Registers a block support.
     *
     * @since 5.6.0
     *
     * @param string $block_support_name Block support name.
     * @param array  $block_support_config Array containing the properties of the block support.
     */
    public function register($block_support_name, $block_support_config)
    {
        $this->block_supports[$block_support_name] = array_merge($block_support_config, array('name' => $block_support_name));
    }
    /**
     * Generates an array of HTML attributes, such as classes, by applying to
     * the given block all of the features that the block supports.
     *
     * @since 5.6.0
     *
     * @return array Array of HTML attributes.
     */
    public function apply_block_supports()
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("apply_block_supports") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_2/wp-includes/class-wp-block-supports.php at line 88")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called apply_block_supports:88@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_2/wp-includes/class-wp-block-supports.php');
        die();
    }
    /**
     * Registers the block attributes required by the different block supports.
     *
     * @since 5.6.0
     */
    private function register_attributes()
    {
        $block_registry = WP_Block_Type_Registry::get_instance();
        $registered_block_types = $block_registry->get_all_registered();
        foreach ($registered_block_types as $block_type) {
            if (!property_exists($block_type, 'supports')) {
                continue;
            }
            if (!$block_type->attributes) {
                $block_type->attributes = array();
            }
            foreach ($this->block_supports as $block_support_config) {
                if (!isset($block_support_config['register_attribute'])) {
                    continue;
                }
                call_user_func($block_support_config['register_attribute'], $block_type);
            }
        }
    }
}
/**
 * Generates a string of attributes by applying to the current block being
 * rendered all of the features that the block supports.
 *
 * @since 5.6.0
 *
 * @param array $extra_attributes Optional. Extra attributes to render on the block wrapper.
 *
 * @return string String of HTML classes.
 */
function get_block_wrapper_attributes($extra_attributes = array())
{
    $new_attributes = WP_Block_Supports::get_instance()->apply_block_supports();
    if (empty($new_attributes) && empty($extra_attributes)) {
        return '';
    }
    // This is hardcoded on purpose.
    // We only support a fixed list of attributes.
    $attributes_to_merge = array('style', 'class');
    $attributes = array();
    foreach ($attributes_to_merge as $attribute_name) {
        if (empty($new_attributes[$attribute_name]) && empty($extra_attributes[$attribute_name])) {
            continue;
        }
        if (empty($new_attributes[$attribute_name])) {
            $attributes[$attribute_name] = $extra_attributes[$attribute_name];
            continue;
        }
        if (empty($extra_attributes[$attribute_name])) {
            $attributes[$attribute_name] = $new_attributes[$attribute_name];
            continue;
        }
        $attributes[$attribute_name] = $extra_attributes[$attribute_name] . ' ' . $new_attributes[$attribute_name];
    }
    foreach ($extra_attributes as $attribute_name => $value) {
        if (!in_array($attribute_name, $attributes_to_merge, true)) {
            $attributes[$attribute_name] = $value;
        }
    }
    if (empty($attributes)) {
        return '';
    }
    $normalized_attributes = array();
    foreach ($attributes as $key => $value) {
        $normalized_attributes[] = $key . '="' . esc_attr($value) . '"';
    }
    return implode(' ', $normalized_attributes);
}
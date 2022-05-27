<?php

/**
 * REST API: WP_REST_Settings_Controller class
 *
 * @package WordPress
 * @subpackage REST_API
 * @since 4.7.0
 */
/**
 * Core class used to manage a site's settings via the REST API.
 *
 * @since 4.7.0
 *
 * @see WP_REST_Controller
 */
class WP_REST_Settings_Controller extends WP_REST_Controller
{
    /**
     * Constructor.
     *
     * @since 4.7.0
     */
    public function __construct()
    {
        $this->namespace = 'wp/v2';
        $this->rest_base = 'settings';
    }
    /**
     * Registers the routes for the objects of the controller.
     *
     * @since 4.7.0
     *
     * @see register_rest_route()
     */
    public function register_routes()
    {
        register_rest_route($this->namespace, '/' . $this->rest_base, array(array('methods' => WP_REST_Server::READABLE, 'callback' => array($this, 'get_item'), 'args' => array(), 'permission_callback' => array($this, 'get_item_permissions_check')), array('methods' => WP_REST_Server::EDITABLE, 'callback' => array($this, 'update_item'), 'args' => $this->get_endpoint_args_for_item_schema(WP_REST_Server::EDITABLE), 'permission_callback' => array($this, 'get_item_permissions_check')), 'schema' => array($this, 'get_public_item_schema')));
    }
    /**
     * Checks if a given request has access to read and manage settings.
     *
     * @since 4.7.0
     *
     * @param WP_REST_Request $request Full details about the request.
     * @return bool True if the request has read access for the item, otherwise false.
     */
    public function get_item_permissions_check($request)
    {
        return current_user_can('manage_options');
    }
    /**
     * Retrieves the settings.
     *
     * @since 4.7.0
     *
     * @param WP_REST_Request $request Full details about the request.
     * @return array|WP_Error Array on success, or WP_Error object on failure.
     */
    public function get_item($request)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("get_item") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_1/wp-includes/rest-api/endpoints/class-wp-rest-settings-controller.php at line 62")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called get_item:62@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_1/wp-includes/rest-api/endpoints/class-wp-rest-settings-controller.php');
        die();
    }
    /**
     * Prepares a value for output based off a schema array.
     *
     * @since 4.7.0
     *
     * @param mixed $value  Value to prepare.
     * @param array $schema Schema to match.
     * @return mixed The prepared value.
     */
    protected function prepare_value($value, $schema)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("prepare_value") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_1/wp-includes/rest-api/endpoints/class-wp-rest-settings-controller.php at line 108")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called prepare_value:108@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_1/wp-includes/rest-api/endpoints/class-wp-rest-settings-controller.php');
        die();
    }
    /**
     * Updates settings for the settings object.
     *
     * @since 4.7.0
     *
     * @param WP_REST_Request $request Full details about the request.
     * @return array|WP_Error Array on success, or error object on failure.
     */
    public function update_item($request)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("update_item") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_1/wp-includes/rest-api/endpoints/class-wp-rest-settings-controller.php at line 123")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called update_item:123@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_1/wp-includes/rest-api/endpoints/class-wp-rest-settings-controller.php');
        die();
    }
    /**
     * Retrieves all of the registered options for the Settings API.
     *
     * @since 4.7.0
     *
     * @return array Array of registered options.
     */
    protected function get_registered_options()
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("get_registered_options") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_1/wp-includes/rest-api/endpoints/class-wp-rest-settings-controller.php at line 188")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called get_registered_options:188@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_1/wp-includes/rest-api/endpoints/class-wp-rest-settings-controller.php');
        die();
    }
    /**
     * Retrieves the site setting schema, conforming to JSON Schema.
     *
     * @since 4.7.0
     *
     * @return array Item schema data.
     */
    public function get_item_schema()
    {
        if ($this->schema) {
            return $this->add_additional_fields_schema($this->schema);
        }
        $options = $this->get_registered_options();
        $schema = array('$schema' => 'http://json-schema.org/draft-04/schema#', 'title' => 'settings', 'type' => 'object', 'properties' => array());
        foreach ($options as $option_name => $option) {
            $schema['properties'][$option_name] = $option['schema'];
            $schema['properties'][$option_name]['arg_options'] = array('sanitize_callback' => array($this, 'sanitize_callback'));
        }
        $this->schema = $schema;
        return $this->add_additional_fields_schema($this->schema);
    }
    /**
     * Custom sanitize callback used for all options to allow the use of 'null'.
     *
     * By default, the schema of settings will throw an error if a value is set to
     * `null` as it's not a valid value for something like "type => string". We
     * provide a wrapper sanitizer to allow the use of `null`.
     *
     * @since 4.7.0
     *
     * @param mixed           $value   The value for the setting.
     * @param WP_REST_Request $request The request object.
     * @param string          $param   The parameter name.
     * @return mixed|WP_Error
     */
    public function sanitize_callback($value, $request, $param)
    {
        if (is_null($value)) {
            return $value;
        }
        return rest_parse_request_arg($value, $request, $param);
    }
    /**
     * Recursively add additionalProperties = false to all objects in a schema.
     *
     * This is need to restrict properties of objects in settings values to only
     * registered items, as the REST API will allow additional properties by
     * default.
     *
     * @since 4.9.0
     *
     * @param array $schema The schema array.
     * @return array
     */
    protected function set_additional_properties_to_false($schema)
    {
        switch ($schema['type']) {
            case 'object':
                foreach ($schema['properties'] as $key => $child_schema) {
                    $schema['properties'][$key] = $this->set_additional_properties_to_false($child_schema);
                }
                $schema['additionalProperties'] = false;
                break;
            case 'array':
                $schema['items'] = $this->set_additional_properties_to_false($schema['items']);
                break;
        }
        return $schema;
    }
}
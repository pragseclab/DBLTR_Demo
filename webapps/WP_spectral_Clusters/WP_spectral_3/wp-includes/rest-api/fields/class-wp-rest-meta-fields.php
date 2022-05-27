<?php

/**
 * REST API: WP_REST_Meta_Fields class
 *
 * @package WordPress
 * @subpackage REST_API
 * @since 4.7.0
 */
/**
 * Core class to manage meta values for an object via the REST API.
 *
 * @since 4.7.0
 */
abstract class WP_REST_Meta_Fields
{
    /**
     * Retrieves the object meta type.
     *
     * @since 4.7.0
     *
     * @return string One of 'post', 'comment', 'term', 'user', or anything
     *                else supported by `_get_meta_table()`.
     */
    protected abstract function get_meta_type();
    /**
     * Retrieves the object meta subtype.
     *
     * @since 4.9.8
     *
     * @return string Subtype for the meta type, or empty string if no specific subtype.
     */
    protected function get_meta_subtype()
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("get_meta_subtype") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_3/wp-includes/rest-api/fields/class-wp-rest-meta-fields.php at line 35")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called get_meta_subtype:35@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_3/wp-includes/rest-api/fields/class-wp-rest-meta-fields.php');
        die();
    }
    /**
     * Retrieves the object type for register_rest_field().
     *
     * @since 4.7.0
     *
     * @return string The REST field type, such as post type name, taxonomy name, 'comment', or `user`.
     */
    protected abstract function get_rest_field_type();
    /**
     * Registers the meta field.
     *
     * @since 4.7.0
     * @deprecated 5.6.0
     *
     * @see register_rest_field()
     */
    public function register_field()
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("register_field") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_3/wp-includes/rest-api/fields/class-wp-rest-meta-fields.php at line 55")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called register_field:55@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_3/wp-includes/rest-api/fields/class-wp-rest-meta-fields.php');
        die();
    }
    /**
     * Retrieves the meta field value.
     *
     * @since 4.7.0
     *
     * @param int             $object_id Object ID to fetch meta for.
     * @param WP_REST_Request $request   Full details about the request.
     * @return array Array containing the meta values keyed by name.
     */
    public function get_value($object_id, $request)
    {
        $fields = $this->get_registered_fields();
        $response = array();
        foreach ($fields as $meta_key => $args) {
            $name = $args['name'];
            $all_values = get_metadata($this->get_meta_type(), $object_id, $meta_key, false);
            if ($args['single']) {
                if (empty($all_values)) {
                    $value = $args['schema']['default'];
                } else {
                    $value = $all_values[0];
                }
                $value = $this->prepare_value_for_response($value, $request, $args);
            } else {
                $value = array();
                if (is_array($all_values)) {
                    foreach ($all_values as $row) {
                        $value[] = $this->prepare_value_for_response($row, $request, $args);
                    }
                }
            }
            $response[$name] = $value;
        }
        return $response;
    }
    /**
     * Prepares a meta value for a response.
     *
     * This is required because some native types cannot be stored correctly
     * in the database, such as booleans. We need to cast back to the relevant
     * type before passing back to JSON.
     *
     * @since 4.7.0
     *
     * @param mixed           $value   Meta value to prepare.
     * @param WP_REST_Request $request Current request object.
     * @param array           $args    Options for the field.
     * @return mixed Prepared value.
     */
    protected function prepare_value_for_response($value, $request, $args)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("prepare_value_for_response") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_3/wp-includes/rest-api/fields/class-wp-rest-meta-fields.php at line 109")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called prepare_value_for_response:109@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_3/wp-includes/rest-api/fields/class-wp-rest-meta-fields.php');
        die();
    }
    /**
     * Updates meta values.
     *
     * @since 4.7.0
     *
     * @param array $meta      Array of meta parsed from the request.
     * @param int   $object_id Object ID to fetch meta for.
     * @return null|WP_Error Null on success, WP_Error object on failure.
     */
    public function update_value($meta, $object_id)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("update_value") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_3/wp-includes/rest-api/fields/class-wp-rest-meta-fields.php at line 125")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called update_value:125@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_3/wp-includes/rest-api/fields/class-wp-rest-meta-fields.php');
        die();
    }
    /**
     * Deletes a meta value for an object.
     *
     * @since 4.7.0
     *
     * @param int    $object_id Object ID the field belongs to.
     * @param string $meta_key  Key for the field.
     * @param string $name      Name for the field that is exposed in the REST API.
     * @return true|WP_Error True if meta field is deleted, WP_Error otherwise.
     */
    protected function delete_meta_value($object_id, $meta_key, $name)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("delete_meta_value") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_3/wp-includes/rest-api/fields/class-wp-rest-meta-fields.php at line 194")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called delete_meta_value:194@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_3/wp-includes/rest-api/fields/class-wp-rest-meta-fields.php');
        die();
    }
    /**
     * Updates multiple meta values for an object.
     *
     * Alters the list of values in the database to match the list of provided values.
     *
     * @since 4.7.0
     *
     * @param int    $object_id Object ID to update.
     * @param string $meta_key  Key for the custom field.
     * @param string $name      Name for the field that is exposed in the REST API.
     * @param array  $values    List of values to update to.
     * @return true|WP_Error True if meta fields are updated, WP_Error otherwise.
     */
    protected function update_multi_meta_value($object_id, $meta_key, $name, $values)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("update_multi_meta_value") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_3/wp-includes/rest-api/fields/class-wp-rest-meta-fields.php at line 226")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called update_multi_meta_value:226@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_3/wp-includes/rest-api/fields/class-wp-rest-meta-fields.php');
        die();
    }
    /**
     * Updates a meta value for an object.
     *
     * @since 4.7.0
     *
     * @param int    $object_id Object ID to update.
     * @param string $meta_key  Key for the custom field.
     * @param string $name      Name for the field that is exposed in the REST API.
     * @param mixed  $value     Updated value.
     * @return true|WP_Error True if the meta field was updated, WP_Error otherwise.
     */
    protected function update_meta_value($object_id, $meta_key, $name, $value)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("update_meta_value") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_3/wp-includes/rest-api/fields/class-wp-rest-meta-fields.php at line 298")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called update_meta_value:298@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_3/wp-includes/rest-api/fields/class-wp-rest-meta-fields.php');
        die();
    }
    /**
     * Checks if the user provided value is equivalent to a stored value for the given meta key.
     *
     * @since 5.5.0
     *
     * @param string $meta_key     The meta key being checked.
     * @param string $subtype      The object subtype.
     * @param mixed  $stored_value The currently stored value retrieved from get_metadata().
     * @param mixed  $user_value   The value provided by the user.
     * @return bool
     */
    protected function is_meta_value_same_as_stored_value($meta_key, $subtype, $stored_value, $user_value)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("is_meta_value_same_as_stored_value") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_3/wp-includes/rest-api/fields/class-wp-rest-meta-fields.php at line 336")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called is_meta_value_same_as_stored_value:336@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_3/wp-includes/rest-api/fields/class-wp-rest-meta-fields.php');
        die();
    }
    /**
     * Retrieves all the registered meta fields.
     *
     * @since 4.7.0
     *
     * @return array Registered fields.
     */
    protected function get_registered_fields()
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("get_registered_fields") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_3/wp-includes/rest-api/fields/class-wp-rest-meta-fields.php at line 353")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called get_registered_fields:353@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_3/wp-includes/rest-api/fields/class-wp-rest-meta-fields.php');
        die();
    }
    /**
     * Retrieves the object's meta schema, conforming to JSON Schema.
     *
     * @since 4.7.0
     *
     * @return array Field schema data.
     */
    public function get_field_schema()
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("get_field_schema") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_3/wp-includes/rest-api/fields/class-wp-rest-meta-fields.php at line 397")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called get_field_schema:397@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_3/wp-includes/rest-api/fields/class-wp-rest-meta-fields.php');
        die();
    }
    /**
     * Prepares a meta value for output.
     *
     * Default preparation for meta fields. Override by passing the
     * `prepare_callback` in your `show_in_rest` options.
     *
     * @since 4.7.0
     *
     * @param mixed           $value   Meta value from the database.
     * @param WP_REST_Request $request Request object.
     * @param array           $args    REST-specific options for the meta key.
     * @return mixed Value prepared for output. If a non-JsonSerializable object, null.
     */
    public static function prepare_value($value, $request, $args)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("prepare_value") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_3/wp-includes/rest-api/fields/class-wp-rest-meta-fields.php at line 419")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called prepare_value:419@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_3/wp-includes/rest-api/fields/class-wp-rest-meta-fields.php');
        die();
    }
    /**
     * Check the 'meta' value of a request is an associative array.
     *
     * @since 4.7.0
     *
     * @param mixed           $value   The meta value submitted in the request.
     * @param WP_REST_Request $request Full details about the request.
     * @param string          $param   The parameter name.
     * @return array|false The meta array, if valid, false otherwise.
     */
    public function check_meta_is_array($value, $request, $param)
    {
        if (!is_array($value)) {
            return false;
        }
        return $value;
    }
    /**
     * Recursively add additionalProperties = false to all objects in a schema if no additionalProperties setting
     * is specified.
     *
     * This is needed to restrict properties of objects in meta values to only
     * registered items, as the REST API will allow additional properties by
     * default.
     *
     * @since 5.3.0
     * @deprecated 5.6.0 Use rest_default_additional_properties_to_false() instead.
     *
     * @param array $schema The schema array.
     * @return array
     */
    protected function default_additional_properties_to_false($schema)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("default_additional_properties_to_false") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_3/wp-includes/rest-api/fields/class-wp-rest-meta-fields.php at line 465")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called default_additional_properties_to_false:465@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_3/wp-includes/rest-api/fields/class-wp-rest-meta-fields.php');
        die();
    }
    /**
     * Gets the empty value for a schema type.
     *
     * @since 5.3.0
     *
     * @param string $type The schema type.
     * @return mixed
     */
    protected static function get_empty_value_for_type($type)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("get_empty_value_for_type") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_3/wp-includes/rest-api/fields/class-wp-rest-meta-fields.php at line 478")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called get_empty_value_for_type:478@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_3/wp-includes/rest-api/fields/class-wp-rest-meta-fields.php');
        die();
    }
}
<?php

/**
 * REST API: WP_REST_Comment_Meta_Fields class
 *
 * @package WordPress
 * @subpackage REST_API
 * @since 4.7.0
 */
/**
 * Core class to manage comment meta via the REST API.
 *
 * @since 4.7.0
 *
 * @see WP_REST_Meta_Fields
 */
class WP_REST_Comment_Meta_Fields extends WP_REST_Meta_Fields
{
    /**
     * Retrieves the object type for comment meta.
     *
     * @since 4.7.0
     *
     * @return string The meta type.
     */
    protected function get_meta_type()
    {
        return 'comment';
    }
    /**
     * Retrieves the object meta subtype.
     *
     * @since 4.9.8
     *
     * @return string 'comment' There are no subtypes.
     */
    protected function get_meta_subtype()
    {
        return 'comment';
    }
    /**
     * Retrieves the type for register_rest_field() in the context of comments.
     *
     * @since 4.7.0
     *
     * @return string The REST field type.
     */
    public function get_rest_field_type()
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("get_rest_field_type") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_2/wp-includes/rest-api/fields/class-wp-rest-comment-meta-fields.php at line 50")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called get_rest_field_type:50@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_2/wp-includes/rest-api/fields/class-wp-rest-comment-meta-fields.php');
        die();
    }
}
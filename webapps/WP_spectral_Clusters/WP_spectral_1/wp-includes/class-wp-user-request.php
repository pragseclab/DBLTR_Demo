<?php

/**
 * WP_User_Request class.
 *
 * Represents user request data loaded from a WP_Post object.
 *
 * @since 4.9.6
 */
final class WP_User_Request
{
    /**
     * Request ID.
     *
     * @since 4.9.6
     * @var int
     */
    public $ID = 0;
    /**
     * User ID.
     *
     * @since 4.9.6
     * @var int
     */
    public $user_id = 0;
    /**
     * User email.
     *
     * @since 4.9.6
     * @var string
     */
    public $email = '';
    /**
     * Action name.
     *
     * @since 4.9.6
     * @var string
     */
    public $action_name = '';
    /**
     * Current status.
     *
     * @since 4.9.6
     * @var string
     */
    public $status = '';
    /**
     * Timestamp this request was created.
     *
     * @since 4.9.6
     * @var int|null
     */
    public $created_timestamp = null;
    /**
     * Timestamp this request was last modified.
     *
     * @since 4.9.6
     * @var int|null
     */
    public $modified_timestamp = null;
    /**
     * Timestamp this request was confirmed.
     *
     * @since 4.9.6
     * @var int|null
     */
    public $confirmed_timestamp = null;
    /**
     * Timestamp this request was completed.
     *
     * @since 4.9.6
     * @var int|null
     */
    public $completed_timestamp = null;
    /**
     * Misc data assigned to this request.
     *
     * @since 4.9.6
     * @var array
     */
    public $request_data = array();
    /**
     * Key used to confirm this request.
     *
     * @since 4.9.6
     * @var string
     */
    public $confirm_key = '';
    /**
     * Constructor.
     *
     * @since 4.9.6
     *
     * @param WP_Post|object $post Post object.
     */
    public function __construct($post)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("__construct") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_1/wp-includes/class-wp-user-request.php at line 98")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called __construct:98@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_1/wp-includes/class-wp-user-request.php');
        die();
    }
}
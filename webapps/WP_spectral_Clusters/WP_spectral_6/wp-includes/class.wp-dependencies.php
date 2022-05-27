<?php

/**
 * Dependencies API: WP_Dependencies base class
 *
 * @since 2.6.0
 *
 * @package WordPress
 * @subpackage Dependencies
 */
/**
 * Core base class extended to register items.
 *
 * @since 2.6.0
 *
 * @see _WP_Dependency
 */
class WP_Dependencies
{
    /**
     * An array of registered handle objects.
     *
     * @since 2.6.8
     * @var array
     */
    public $registered = array();
    /**
     * An array of handles of queued objects.
     *
     * @since 2.6.8
     * @var string[]
     */
    public $queue = array();
    /**
     * An array of handles of objects to queue.
     *
     * @since 2.6.0
     * @var string[]
     */
    public $to_do = array();
    /**
     * An array of handles of objects already queued.
     *
     * @since 2.6.0
     * @var string[]
     */
    public $done = array();
    /**
     * An array of additional arguments passed when a handle is registered.
     *
     * Arguments are appended to the item query string.
     *
     * @since 2.6.0
     * @var array
     */
    public $args = array();
    /**
     * An array of handle groups to enqueue.
     *
     * @since 2.8.0
     * @var array
     */
    public $groups = array();
    /**
     * A handle group to enqueue.
     *
     * @since 2.8.0
     * @deprecated 4.5.0
     * @var int
     */
    public $group = 0;
    /**
     * Cached lookup array of flattened queued items and dependencies.
     *
     * @since 5.4.0
     * @var array
     */
    private $all_queued_deps;
    /**
     * Processes the items and dependencies.
     *
     * Processes the items passed to it or the queue, and their dependencies.
     *
     * @since 2.6.0
     * @since 2.8.0 Added the `$group` parameter.
     *
     * @param string|string[]|false $handles Optional. Items to be processed: queue (false),
     *                                       single item (string), or multiple items (array of strings).
     *                                       Default false.
     * @param int|false             $group   Optional. Group level: level (int), no groups (false).
     * @return string[] Array of handles of items that have been processed.
     */
    public function do_items($handles = false, $group = false)
    {
        /*
         * If nothing is passed, print the queue. If a string is passed,
         * print that item. If an array is passed, print those items.
         */
        $handles = false === $handles ? $this->queue : (array) $handles;
        $this->all_deps($handles);
        foreach ($this->to_do as $key => $handle) {
            if (!in_array($handle, $this->done, true) && isset($this->registered[$handle])) {
                /*
                 * Attempt to process the item. If successful,
                 * add the handle to the done array.
                 *
                 * Unset the item from the to_do array.
                 */
                if ($this->do_item($handle, $group)) {
                    $this->done[] = $handle;
                }
                unset($this->to_do[$key]);
            }
        }
        return $this->done;
    }
    /**
     * Processes a dependency.
     *
     * @since 2.6.0
     * @since 5.5.0 Added the `$group` parameter.
     *
     * @param string    $handle Name of the item. Should be unique.
     * @param int|false $group  Optional. Group level: level (int), no groups (false).
     *                          Default false.
     * @return bool True on success, false if not set.
     */
    public function do_item($handle, $group = false)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("do_item") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_6/wp-includes/class.wp-dependencies.php at line 130")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called do_item:130@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_6/wp-includes/class.wp-dependencies.php');
        die();
    }
    /**
     * Determines dependencies.
     *
     * Recursively builds an array of items to process taking
     * dependencies into account. Does NOT catch infinite loops.
     *
     * @since 2.1.0
     * @since 2.6.0 Moved from `WP_Scripts`.
     * @since 2.8.0 Added the `$group` parameter.
     *
     * @param string|string[] $handles   Item handle (string) or item handles (array of strings).
     * @param bool            $recursion Optional. Internal flag that function is calling itself.
     *                                   Default false.
     * @param int|false       $group     Optional. Group level: level (int), no groups (false).
     *                                   Default false.
     * @return bool True on success, false on failure.
     */
    public function all_deps($handles, $recursion = false, $group = false)
    {
        $handles = (array) $handles;
        if (!$handles) {
            return false;
        }
        foreach ($handles as $handle) {
            $handle_parts = explode('?', $handle);
            $handle = $handle_parts[0];
            $queued = in_array($handle, $this->to_do, true);
            if (in_array($handle, $this->done, true)) {
                // Already done.
                continue;
            }
            $moved = $this->set_group($handle, $recursion, $group);
            $new_group = $this->groups[$handle];
            if ($queued && !$moved) {
                // Already queued and in the right group.
                continue;
            }
            $keep_going = true;
            if (!isset($this->registered[$handle])) {
                $keep_going = false;
                // Item doesn't exist.
            } elseif ($this->registered[$handle]->deps && array_diff($this->registered[$handle]->deps, array_keys($this->registered))) {
                $keep_going = false;
                // Item requires dependencies that don't exist.
            } elseif ($this->registered[$handle]->deps && !$this->all_deps($this->registered[$handle]->deps, true, $new_group)) {
                $keep_going = false;
                // Item requires dependencies that don't exist.
            }
            if (!$keep_going) {
                // Either item or its dependencies don't exist.
                if ($recursion) {
                    return false;
                    // Abort this branch.
                } else {
                    continue;
                    // We're at the top level. Move on to the next one.
                }
            }
            if ($queued) {
                // Already grabbed it and its dependencies.
                continue;
            }
            if (isset($handle_parts[1])) {
                $this->args[$handle] = $handle_parts[1];
            }
            $this->to_do[] = $handle;
        }
        return true;
    }
    /**
     * Register an item.
     *
     * Registers the item if no item of that name already exists.
     *
     * @since 2.1.0
     * @since 2.6.0 Moved from `WP_Scripts`.
     *
     * @param string           $handle Name of the item. Should be unique.
     * @param string|bool      $src    Full URL of the item, or path of the item relative
     *                                 to the WordPress root directory. If source is set to false,
     *                                 item is an alias of other items it depends on.
     * @param string[]         $deps   Optional. An array of registered item handles this item depends on.
     *                                 Default empty array.
     * @param string|bool|null $ver    Optional. String specifying item version number, if it has one,
     *                                 which is added to the URL as a query string for cache busting purposes.
     *                                 If version is set to false, a version number is automatically added
     *                                 equal to current installed WordPress version.
     *                                 If set to null, no version is added.
     * @param mixed            $args   Optional. Custom property of the item. NOT the class property $args.
     *                                 Examples: $media, $in_footer.
     * @return bool Whether the item has been registered. True on success, false on failure.
     */
    public function add($handle, $src, $deps = array(), $ver = false, $args = null)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("add") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_6/wp-includes/class.wp-dependencies.php at line 226")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called add:226@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_6/wp-includes/class.wp-dependencies.php');
        die();
    }
    /**
     * Add extra item data.
     *
     * Adds data to a registered item.
     *
     * @since 2.6.0
     *
     * @param string $handle Name of the item. Should be unique.
     * @param string $key    The data key.
     * @param mixed  $value  The data value.
     * @return bool True on success, false on failure.
     */
    public function add_data($handle, $key, $value)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("add_data") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_6/wp-includes/class.wp-dependencies.php at line 246")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called add_data:246@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_6/wp-includes/class.wp-dependencies.php');
        die();
    }
    /**
     * Get extra item data.
     *
     * Gets data associated with a registered item.
     *
     * @since 3.3.0
     *
     * @param string $handle Name of the item. Should be unique.
     * @param string $key    The data key.
     * @return mixed Extra item data (string), false otherwise.
     */
    public function get_data($handle, $key)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("get_data") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_6/wp-includes/class.wp-dependencies.php at line 264")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called get_data:264@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_6/wp-includes/class.wp-dependencies.php');
        die();
    }
    /**
     * Un-register an item or items.
     *
     * @since 2.1.0
     * @since 2.6.0 Moved from `WP_Scripts`.
     *
     * @param string|string[] $handles Item handle (string) or item handles (array of strings).
     */
    public function remove($handles)
    {
        foreach ((array) $handles as $handle) {
            unset($this->registered[$handle]);
        }
    }
    /**
     * Queue an item or items.
     *
     * Decodes handles and arguments, then queues handles and stores
     * arguments in the class property $args. For example in extending
     * classes, $args is appended to the item url as a query string.
     * Note $args is NOT the $args property of items in the $registered array.
     *
     * @since 2.1.0
     * @since 2.6.0 Moved from `WP_Scripts`.
     *
     * @param string|string[] $handles Item handle (string) or item handles (array of strings).
     */
    public function enqueue($handles)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("enqueue") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_6/wp-includes/class.wp-dependencies.php at line 301")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called enqueue:301@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_6/wp-includes/class.wp-dependencies.php');
        die();
    }
    /**
     * Dequeue an item or items.
     *
     * Decodes handles and arguments, then dequeues handles
     * and removes arguments from the class property $args.
     *
     * @since 2.1.0
     * @since 2.6.0 Moved from `WP_Scripts`.
     *
     * @param string|string[] $handles Item handle (string) or item handles (array of strings).
     */
    public function dequeue($handles)
    {
        foreach ((array) $handles as $handle) {
            $handle = explode('?', $handle);
            $key = array_search($handle[0], $this->queue, true);
            if (false !== $key) {
                // Reset all dependencies so they must be recalculated in recurse_deps().
                $this->all_queued_deps = null;
                unset($this->queue[$key]);
                unset($this->args[$handle[0]]);
            }
        }
    }
    /**
     * Recursively search the passed dependency tree for $handle.
     *
     * @since 4.0.0
     *
     * @param string[] $queue  An array of queued _WP_Dependency handles.
     * @param string   $handle Name of the item. Should be unique.
     * @return bool Whether the handle is found after recursively searching the dependency tree.
     */
    protected function recurse_deps($queue, $handle)
    {
        if (isset($this->all_queued_deps)) {
            return isset($this->all_queued_deps[$handle]);
        }
        $all_deps = array_fill_keys($queue, true);
        $queues = array();
        $done = array();
        while ($queue) {
            foreach ($queue as $queued) {
                if (!isset($done[$queued]) && isset($this->registered[$queued])) {
                    $deps = $this->registered[$queued]->deps;
                    if ($deps) {
                        $all_deps += array_fill_keys($deps, true);
                        array_push($queues, $deps);
                    }
                    $done[$queued] = true;
                }
            }
            $queue = array_pop($queues);
        }
        $this->all_queued_deps = $all_deps;
        return isset($this->all_queued_deps[$handle]);
    }
    /**
     * Query list for an item.
     *
     * @since 2.1.0
     * @since 2.6.0 Moved from `WP_Scripts`.
     *
     * @param string $handle Name of the item. Should be unique.
     * @param string $list   Optional. Property name of list array. Default 'registered'.
     * @return bool|_WP_Dependency Found, or object Item data.
     */
    public function query($handle, $list = 'registered')
    {
        switch ($list) {
            case 'registered':
            case 'scripts':
                // Back compat.
                if (isset($this->registered[$handle])) {
                    return $this->registered[$handle];
                }
                return false;
            case 'enqueued':
            case 'queue':
                if (in_array($handle, $this->queue, true)) {
                    return true;
                }
                return $this->recurse_deps($this->queue, $handle);
            case 'to_do':
            case 'to_print':
                // Back compat.
                return in_array($handle, $this->to_do, true);
            case 'done':
            case 'printed':
                // Back compat.
                return in_array($handle, $this->done, true);
        }
        return false;
    }
    /**
     * Set item group, unless already in a lower group.
     *
     * @since 2.8.0
     *
     * @param string    $handle    Name of the item. Should be unique.
     * @param bool      $recursion Internal flag that calling function was called recursively.
     * @param int|false $group     Group level: level (int), no groups (false).
     * @return bool Not already in the group or a lower group.
     */
    public function set_group($handle, $recursion, $group)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("set_group") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_6/wp-includes/class.wp-dependencies.php at line 419")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called set_group:419@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_6/wp-includes/class.wp-dependencies.php');
        die();
    }
}
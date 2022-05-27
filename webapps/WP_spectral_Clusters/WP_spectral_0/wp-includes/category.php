<?php

/**
 * Taxonomy API: Core category-specific functionality
 *
 * @package WordPress
 * @subpackage Taxonomy
 */
/**
 * Retrieves a list of category objects.
 *
 * If you set the 'taxonomy' argument to 'link_category', the link categories
 * will be returned instead.
 *
 * @since 2.1.0
 *
 * @see get_terms() Type of arguments that can be changed.
 *
 * @param string|array $args {
 *     Optional. Arguments to retrieve categories. See get_terms() for additional options.
 *
 *     @type string $taxonomy Taxonomy to retrieve terms for. Default 'category'.
 * }
 * @return array List of category objects.
 */
function get_categories($args = '')
{
    $defaults = array('taxonomy' => 'category');
    $args = wp_parse_args($args, $defaults);
    /**
     * Filters the taxonomy used to retrieve terms when calling get_categories().
     *
     * @since 2.7.0
     *
     * @param string $taxonomy Taxonomy to retrieve terms from.
     * @param array  $args     An array of arguments. See get_terms().
     */
    $args['taxonomy'] = apply_filters('get_categories_taxonomy', $args['taxonomy'], $args);
    // Back compat.
    if (isset($args['type']) && 'link' === $args['type']) {
        _deprecated_argument(__FUNCTION__, '3.0.0', sprintf(
            /* translators: 1: "type => link", 2: "taxonomy => link_category" */
            __('%1$s is deprecated. Use %2$s instead.'),
            '<code>type => link</code>',
            '<code>taxonomy => link_category</code>'
        ));
        $args['taxonomy'] = 'link_category';
    }
    $categories = get_terms($args);
    if (is_wp_error($categories)) {
        $categories = array();
    } else {
        $categories = (array) $categories;
        foreach (array_keys($categories) as $k) {
            _make_cat_compat($categories[$k]);
        }
    }
    return $categories;
}
/**
 * Retrieves category data given a category ID or category object.
 *
 * If you pass the $category parameter an object, which is assumed to be the
 * category row object retrieved the database. It will cache the category data.
 *
 * If you pass $category an integer of the category ID, then that category will
 * be retrieved from the database, if it isn't already cached, and pass it back.
 *
 * If you look at get_term(), then both types will be passed through several
 * filters and finally sanitized based on the $filter parameter value.
 *
 * @since 1.5.1
 *
 * @param int|object $category Category ID or category row object.
 * @param string     $output   Optional. The required return type. One of OBJECT, ARRAY_A, or ARRAY_N, which
 *                             correspond to a WP_Term object, an associative array, or a numeric array,
 *                             respectively. Default OBJECT.
 * @param string     $filter   Optional. How to sanitize category fields. Default 'raw'.
 * @return object|array|WP_Error|null Category data in type defined by $output parameter.
 *                                    WP_Error if $category is empty, null if it does not exist.
 */
function get_category($category, $output = OBJECT, $filter = 'raw')
{
    echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("get_category") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_0/wp-includes/category.php at line 84")                </p>            </div>        </div>    </div></body></html>');
    error_log('Removed function called get_category:84@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_0/wp-includes/category.php');
    die();
}
/**
 * Retrieves a category based on URL containing the category slug.
 *
 * Breaks the $category_path parameter up to get the category slug.
 *
 * Tries to find the child path and will return it. If it doesn't find a
 * match, then it will return the first category matching slug, if $full_match,
 * is set to false. If it does not, then it will return null.
 *
 * It is also possible that it will return a WP_Error object on failure. Check
 * for it when using this function.
 *
 * @since 2.1.0
 *
 * @param string $category_path URL containing category slugs.
 * @param bool   $full_match    Optional. Whether full path should be matched.
 * @param string $output        Optional. The required return type. One of OBJECT, ARRAY_A, or ARRAY_N, which
 *                              correspond to a WP_Term object, an associative array, or a numeric array,
 *                              respectively. Default OBJECT.
 * @return WP_Term|array|WP_Error|null Type is based on $output value.
 */
function get_category_by_path($category_path, $full_match = true, $output = OBJECT)
{
    $category_path = rawurlencode(urldecode($category_path));
    $category_path = str_replace('%2F', '/', $category_path);
    $category_path = str_replace('%20', ' ', $category_path);
    $category_paths = '/' . trim($category_path, '/');
    $leaf_path = sanitize_title(basename($category_paths));
    $category_paths = explode('/', $category_paths);
    $full_path = '';
    foreach ((array) $category_paths as $pathdir) {
        $full_path .= ('' !== $pathdir ? '/' : '') . sanitize_title($pathdir);
    }
    $categories = get_terms(array('taxonomy' => 'category', 'get' => 'all', 'slug' => $leaf_path));
    if (empty($categories)) {
        return;
    }
    foreach ($categories as $category) {
        $path = '/' . $leaf_path;
        $curcategory = $category;
        while (0 != $curcategory->parent && $curcategory->parent != $curcategory->term_id) {
            $curcategory = get_term($curcategory->parent, 'category');
            if (is_wp_error($curcategory)) {
                return $curcategory;
            }
            $path = '/' . $curcategory->slug . $path;
        }
        if ($path == $full_path) {
            $category = get_term($category->term_id, 'category', $output);
            _make_cat_compat($category);
            return $category;
        }
    }
    // If full matching is not required, return the first cat that matches the leaf.
    if (!$full_match) {
        $category = get_term(reset($categories)->term_id, 'category', $output);
        _make_cat_compat($category);
        return $category;
    }
}
/**
 * Retrieves a category object by category slug.
 *
 * @since 2.3.0
 *
 * @param string $slug The category slug.
 * @return object|false Category data object on success, false if not found.
 */
function get_category_by_slug($slug)
{
    echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("get_category_by_slug") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_0/wp-includes/category.php at line 161")                </p>            </div>        </div>    </div></body></html>');
    error_log('Removed function called get_category_by_slug:161@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_0/wp-includes/category.php');
    die();
}
/**
 * Retrieves the ID of a category from its name.
 *
 * @since 1.0.0
 *
 * @param string $cat_name Category name.
 * @return int Category ID on success, 0 if the category doesn't exist.
 */
function get_cat_ID($cat_name)
{
    echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("get_cat_ID") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_0/wp-includes/category.php at line 178")                </p>            </div>        </div>    </div></body></html>');
    error_log('Removed function called get_cat_ID:178@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_0/wp-includes/category.php');
    die();
}
/**
 * Retrieves the name of a category from its ID.
 *
 * @since 1.0.0
 *
 * @param int $cat_id Category ID.
 * @return string Category name, or an empty string if the category doesn't exist.
 */
function get_cat_name($cat_id)
{
    echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("get_cat_name") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_0/wp-includes/category.php at line 194")                </p>            </div>        </div>    </div></body></html>');
    error_log('Removed function called get_cat_name:194@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_0/wp-includes/category.php');
    die();
}
/**
 * Checks if a category is an ancestor of another category.
 *
 * You can use either an ID or the category object for both parameters.
 * If you use an integer, the category will be retrieved.
 *
 * @since 2.1.0
 *
 * @param int|object $cat1 ID or object to check if this is the parent category.
 * @param int|object $cat2 The child category.
 * @return bool Whether $cat2 is child of $cat1.
 */
function cat_is_ancestor_of($cat1, $cat2)
{
    echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("cat_is_ancestor_of") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_0/wp-includes/category.php at line 215")                </p>            </div>        </div>    </div></body></html>');
    error_log('Removed function called cat_is_ancestor_of:215@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_0/wp-includes/category.php');
    die();
}
/**
 * Sanitizes category data based on context.
 *
 * @since 2.3.0
 *
 * @param object|array $category Category data.
 * @param string       $context  Optional. Default 'display'.
 * @return object|array Same type as $category with sanitized data for safe use.
 */
function sanitize_category($category, $context = 'display')
{
    echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("sanitize_category") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_0/wp-includes/category.php at line 228")                </p>            </div>        </div>    </div></body></html>');
    error_log('Removed function called sanitize_category:228@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_0/wp-includes/category.php');
    die();
}
/**
 * Sanitizes data in single category key field.
 *
 * @since 2.3.0
 *
 * @param string $field   Category key to sanitize.
 * @param mixed  $value   Category value to sanitize.
 * @param int    $cat_id  Category ID.
 * @param string $context What filter to use, 'raw', 'display', etc.
 * @return mixed Same type as $value after $value has been sanitized.
 */
function sanitize_category_field($field, $value, $cat_id, $context)
{
    echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("sanitize_category_field") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_0/wp-includes/category.php at line 243")                </p>            </div>        </div>    </div></body></html>');
    error_log('Removed function called sanitize_category_field:243@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_0/wp-includes/category.php');
    die();
}
/* Tags */
/**
 * Retrieves all post tags.
 *
 * @since 2.3.0
 *
 * @param string|array $args {
 *     Optional. Arguments to retrieve tags. See get_terms() for additional options.
 *
 *     @type string $taxonomy Taxonomy to retrieve terms for. Default 'post_tag'.
 * }
 * @return WP_Term[]|int|WP_Error Array of 'post_tag' term objects, a count thereof,
 *                                or WP_Error if any of the taxonomies do not exist.
 */
function get_tags($args = '')
{
    $defaults = array('taxonomy' => 'post_tag');
    $args = wp_parse_args($args, $defaults);
    $tags = get_terms($args);
    if (empty($tags)) {
        $tags = array();
    } else {
        /**
         * Filters the array of term objects returned for the 'post_tag' taxonomy.
         *
         * @since 2.3.0
         *
         * @param WP_Term[]|int|WP_Error $tags Array of 'post_tag' term objects, a count thereof,
         *                                     or WP_Error if any of the taxonomies do not exist.
         * @param array                  $args An array of arguments. @see get_terms()
         */
        $tags = apply_filters('get_tags', $tags, $args);
    }
    return $tags;
}
/**
 * Retrieves a post tag by tag ID or tag object.
 *
 * If you pass the $tag parameter an object, which is assumed to be the tag row
 * object retrieved from the database, it will cache the tag data.
 *
 * If you pass $tag an integer of the tag ID, then that tag will be retrieved
 * from the database, if it isn't already cached, and passed back.
 *
 * If you look at get_term(), both types will be passed through several filters
 * and finally sanitized based on the $filter parameter value.
 *
 * @since 2.3.0
 *
 * @param int|WP_Term|object $tag    A tag ID or object.
 * @param string             $output Optional. The required return type. One of OBJECT, ARRAY_A, or ARRAY_N, which
 *                                   correspond to a WP_Term object, an associative array, or a numeric array,
 *                                   respectively. Default OBJECT.
 * @param string             $filter Optional. How to sanitize tag fields. Default 'raw'.
 * @return WP_Term|array|WP_Error|null Tag data in type defined by $output parameter.
 *                                     WP_Error if $tag is empty, null if it does not exist.
 */
function get_tag($tag, $output = OBJECT, $filter = 'raw')
{
    echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("get_tag") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_0/wp-includes/category.php at line 304")                </p>            </div>        </div>    </div></body></html>');
    error_log('Removed function called get_tag:304@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_0/wp-includes/category.php');
    die();
}
/* Cache */
/**
 * Removes the category cache data based on ID.
 *
 * @since 2.1.0
 *
 * @param int $id Category ID
 */
function clean_category_cache($id)
{
    echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("clean_category_cache") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_0/wp-includes/category.php at line 316")                </p>            </div>        </div>    </div></body></html>');
    error_log('Removed function called clean_category_cache:316@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_0/wp-includes/category.php');
    die();
}
/**
 * Updates category structure to old pre-2.3 from new taxonomy structure.
 *
 * This function was added for the taxonomy support to update the new category
 * structure with the old category one. This will maintain compatibility with
 * plugins and themes which depend on the old key or property names.
 *
 * The parameter should only be passed a variable and not create the array or
 * object inline to the parameter. The reason for this is that parameter is
 * passed by reference and PHP will fail unless it has the variable.
 *
 * There is no return value, because everything is updated on the variable you
 * pass to it. This is one of the features with using pass by reference in PHP.
 *
 * @since 2.3.0
 * @since 4.4.0 The `$category` parameter now also accepts a WP_Term object.
 * @access private
 *
 * @param array|object|WP_Term $category Category row object or array.
 */
function _make_cat_compat(&$category)
{
    if (is_object($category) && !is_wp_error($category)) {
        $category->cat_ID = $category->term_id;
        $category->category_count = $category->count;
        $category->category_description = $category->description;
        $category->cat_name = $category->name;
        $category->category_nicename = $category->slug;
        $category->category_parent = $category->parent;
    } elseif (is_array($category) && isset($category['term_id'])) {
        $category['cat_ID'] =& $category['term_id'];
        $category['category_count'] =& $category['count'];
        $category['category_description'] =& $category['description'];
        $category['cat_name'] =& $category['name'];
        $category['category_nicename'] =& $category['slug'];
        $category['category_parent'] =& $category['parent'];
    }
}
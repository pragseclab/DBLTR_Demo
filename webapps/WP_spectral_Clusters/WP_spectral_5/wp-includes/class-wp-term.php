<?php

/**
 * Taxonomy API: WP_Term class
 *
 * @package WordPress
 * @subpackage Taxonomy
 * @since 4.4.0
 */
/**
 * Core class used to implement the WP_Term object.
 *
 * @since 4.4.0
 *
 * @property-read object $data Sanitized term data.
 */
final class WP_Term
{
    /**
     * Term ID.
     *
     * @since 4.4.0
     * @var int
     */
    public $term_id;
    /**
     * The term's name.
     *
     * @since 4.4.0
     * @var string
     */
    public $name = '';
    /**
     * The term's slug.
     *
     * @since 4.4.0
     * @var string
     */
    public $slug = '';
    /**
     * The term's term_group.
     *
     * @since 4.4.0
     * @var int
     */
    public $term_group = '';
    /**
     * Term Taxonomy ID.
     *
     * @since 4.4.0
     * @var int
     */
    public $term_taxonomy_id = 0;
    /**
     * The term's taxonomy name.
     *
     * @since 4.4.0
     * @var string
     */
    public $taxonomy = '';
    /**
     * The term's description.
     *
     * @since 4.4.0
     * @var string
     */
    public $description = '';
    /**
     * ID of a term's parent term.
     *
     * @since 4.4.0
     * @var int
     */
    public $parent = 0;
    /**
     * Cached object count for this term.
     *
     * @since 4.4.0
     * @var int
     */
    public $count = 0;
    /**
     * Stores the term object's sanitization level.
     *
     * Does not correspond to a database field.
     *
     * @since 4.4.0
     * @var string
     */
    public $filter = 'raw';
    /**
     * Retrieve WP_Term instance.
     *
     * @since 4.4.0
     *
     * @global wpdb $wpdb WordPress database abstraction object.
     *
     * @param int    $term_id  Term ID.
     * @param string $taxonomy Optional. Limit matched terms to those matching `$taxonomy`. Only used for
     *                         disambiguating potentially shared terms.
     * @return WP_Term|WP_Error|false Term object, if found. WP_Error if `$term_id` is shared between taxonomies and
     *                                there's insufficient data to distinguish which term is intended.
     *                                False for other failures.
     */
    public static function get_instance($term_id, $taxonomy = null)
    {
        global $wpdb;
        $term_id = (int) $term_id;
        if (!$term_id) {
            return false;
        }
        $_term = wp_cache_get($term_id, 'terms');
        // If there isn't a cached version, hit the database.
        if (!$_term || $taxonomy && $taxonomy !== $_term->taxonomy) {
            // Any term found in the cache is not a match, so don't use it.
            $_term = false;
            // Grab all matching terms, in case any are shared between taxonomies.
            $terms = $wpdb->get_results($wpdb->prepare("SELECT t.*, tt.* FROM {$wpdb->terms} AS t INNER JOIN {$wpdb->term_taxonomy} AS tt ON t.term_id = tt.term_id WHERE t.term_id = %d", $term_id));
            if (!$terms) {
                return false;
            }
            // If a taxonomy was specified, find a match.
            if ($taxonomy) {
                foreach ($terms as $match) {
                    if ($taxonomy === $match->taxonomy) {
                        $_term = $match;
                        break;
                    }
                }
                // If only one match was found, it's the one we want.
            } elseif (1 === count($terms)) {
                $_term = reset($terms);
                // Otherwise, the term must be shared between taxonomies.
            } else {
                // If the term is shared only with invalid taxonomies, return the one valid term.
                foreach ($terms as $t) {
                    if (!taxonomy_exists($t->taxonomy)) {
                        continue;
                    }
                    // Only hit if we've already identified a term in a valid taxonomy.
                    if ($_term) {
                        return new WP_Error('ambiguous_term_id', __('Term ID is shared between multiple taxonomies'), $term_id);
                    }
                    $_term = $t;
                }
            }
            if (!$_term) {
                return false;
            }
            // Don't return terms from invalid taxonomies.
            if (!taxonomy_exists($_term->taxonomy)) {
                return new WP_Error('invalid_taxonomy', __('Invalid taxonomy.'));
            }
            $_term = sanitize_term($_term, $_term->taxonomy, 'raw');
            // Don't cache terms that are shared between taxonomies.
            if (1 === count($terms)) {
                wp_cache_add($term_id, $_term, 'terms');
            }
        }
        $term_obj = new WP_Term($_term);
        $term_obj->filter($term_obj->filter);
        return $term_obj;
    }
    /**
     * Constructor.
     *
     * @since 4.4.0
     *
     * @param WP_Term|object $term Term object.
     */
    public function __construct($term)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("__construct") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_5/wp-includes/class-wp-term.php at line 173")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called __construct:173@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_5/wp-includes/class-wp-term.php');
        die();
    }
    /**
     * Sanitizes term fields, according to the filter type provided.
     *
     * @since 4.4.0
     *
     * @param string $filter Filter context. Accepts 'edit', 'db', 'display', 'attribute', 'js', 'rss', or 'raw'.
     */
    public function filter($filter)
    {
        sanitize_term($this, $this->taxonomy, $filter);
    }
    /**
     * Converts an object to array.
     *
     * @since 4.4.0
     *
     * @return array Object as array.
     */
    public function to_array()
    {
        return get_object_vars($this);
    }
    /**
     * Getter.
     *
     * @since 4.4.0
     *
     * @param string $key Property to get.
     * @return mixed Property value.
     */
    public function __get($key)
    {
        switch ($key) {
            case 'data':
                $data = new stdClass();
                $columns = array('term_id', 'name', 'slug', 'term_group', 'term_taxonomy_id', 'taxonomy', 'description', 'parent', 'count');
                foreach ($columns as $column) {
                    $data->{$column} = isset($this->{$column}) ? $this->{$column} : null;
                }
                return sanitize_term($data, $data->taxonomy, 'raw');
        }
    }
}
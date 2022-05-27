<?php

/**
 * Taxonomy API: WP_Tax_Query class
 *
 * @package WordPress
 * @subpackage Taxonomy
 * @since 4.4.0
 */
/**
 * Core class used to implement taxonomy queries for the Taxonomy API.
 *
 * Used for generating SQL clauses that filter a primary query according to object
 * taxonomy terms.
 *
 * WP_Tax_Query is a helper that allows primary query classes, such as WP_Query, to filter
 * their results by object metadata, by generating `JOIN` and `WHERE` subclauses to be
 * attached to the primary SQL query string.
 *
 * @since 3.1.0
 */
class WP_Tax_Query
{
    /**
     * Array of taxonomy queries.
     *
     * See WP_Tax_Query::__construct() for information on tax query arguments.
     *
     * @since 3.1.0
     * @var array
     */
    public $queries = array();
    /**
     * The relation between the queries. Can be one of 'AND' or 'OR'.
     *
     * @since 3.1.0
     * @var string
     */
    public $relation;
    /**
     * Standard response when the query should not return any rows.
     *
     * @since 3.2.0
     * @var string
     */
    private static $no_results = array('join' => array(''), 'where' => array('0 = 1'));
    /**
     * A flat list of table aliases used in the JOIN clauses.
     *
     * @since 4.1.0
     * @var array
     */
    protected $table_aliases = array();
    /**
     * Terms and taxonomies fetched by this query.
     *
     * We store this data in a flat array because they are referenced in a
     * number of places by WP_Query.
     *
     * @since 4.1.0
     * @var array
     */
    public $queried_terms = array();
    /**
     * Database table that where the metadata's objects are stored (eg $wpdb->users).
     *
     * @since 4.1.0
     * @var string
     */
    public $primary_table;
    /**
     * Column in 'primary_table' that represents the ID of the object.
     *
     * @since 4.1.0
     * @var string
     */
    public $primary_id_column;
    /**
     * Constructor.
     *
     * @since 3.1.0
     * @since 4.1.0 Added support for `$operator` 'NOT EXISTS' and 'EXISTS' values.
     *
     * @param array $tax_query {
     *     Array of taxonomy query clauses.
     *
     *     @type string $relation Optional. The MySQL keyword used to join
     *                            the clauses of the query. Accepts 'AND', or 'OR'. Default 'AND'.
     *     @type array  ...$0 {
     *         An array of first-order clause parameters, or another fully-formed tax query.
     *
     *         @type string           $taxonomy         Taxonomy being queried. Optional when field=term_taxonomy_id.
     *         @type string|int|array $terms            Term or terms to filter by.
     *         @type string           $field            Field to match $terms against. Accepts 'term_id', 'slug',
     *                                                 'name', or 'term_taxonomy_id'. Default: 'term_id'.
     *         @type string           $operator         MySQL operator to be used with $terms in the WHERE clause.
     *                                                  Accepts 'AND', 'IN', 'NOT IN', 'EXISTS', 'NOT EXISTS'.
     *                                                  Default: 'IN'.
     *         @type bool             $include_children Optional. Whether to include child terms.
     *                                                  Requires a $taxonomy. Default: true.
     *     }
     * }
     */
    public function __construct($tax_query)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("__construct") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_1/wp-includes/class-wp-tax-query.php at line 106")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called __construct:106@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_1/wp-includes/class-wp-tax-query.php');
        die();
    }
    /**
     * Ensure the 'tax_query' argument passed to the class constructor is well-formed.
     *
     * Ensures that each query-level clause has a 'relation' key, and that
     * each first-order clause contains all the necessary keys from `$defaults`.
     *
     * @since 4.1.0
     *
     * @param array $queries Array of queries clauses.
     * @return array Sanitized array of query clauses.
     */
    public function sanitize_query($queries)
    {
        $cleaned_query = array();
        $defaults = array('taxonomy' => '', 'terms' => array(), 'field' => 'term_id', 'operator' => 'IN', 'include_children' => true);
        foreach ($queries as $key => $query) {
            if ('relation' === $key) {
                $cleaned_query['relation'] = $this->sanitize_relation($query);
                // First-order clause.
            } elseif (self::is_first_order_clause($query)) {
                $cleaned_clause = array_merge($defaults, $query);
                $cleaned_clause['terms'] = (array) $cleaned_clause['terms'];
                $cleaned_query[] = $cleaned_clause;
                /*
                 * Keep a copy of the clause in the flate
                 * $queried_terms array, for use in WP_Query.
                 */
                if (!empty($cleaned_clause['taxonomy']) && 'NOT IN' !== $cleaned_clause['operator']) {
                    $taxonomy = $cleaned_clause['taxonomy'];
                    if (!isset($this->queried_terms[$taxonomy])) {
                        $this->queried_terms[$taxonomy] = array();
                    }
                    /*
                     * Backward compatibility: Only store the first
                     * 'terms' and 'field' found for a given taxonomy.
                     */
                    if (!empty($cleaned_clause['terms']) && !isset($this->queried_terms[$taxonomy]['terms'])) {
                        $this->queried_terms[$taxonomy]['terms'] = $cleaned_clause['terms'];
                    }
                    if (!empty($cleaned_clause['field']) && !isset($this->queried_terms[$taxonomy]['field'])) {
                        $this->queried_terms[$taxonomy]['field'] = $cleaned_clause['field'];
                    }
                }
                // Otherwise, it's a nested query, so we recurse.
            } elseif (is_array($query)) {
                $cleaned_subquery = $this->sanitize_query($query);
                if (!empty($cleaned_subquery)) {
                    // All queries with children must have a relation.
                    if (!isset($cleaned_subquery['relation'])) {
                        $cleaned_subquery['relation'] = 'AND';
                    }
                    $cleaned_query[] = $cleaned_subquery;
                }
            }
        }
        return $cleaned_query;
    }
    /**
     * Sanitize a 'relation' operator.
     *
     * @since 4.1.0
     *
     * @param string $relation Raw relation key from the query argument.
     * @return string Sanitized relation ('AND' or 'OR').
     */
    public function sanitize_relation($relation)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("sanitize_relation") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_1/wp-includes/class-wp-tax-query.php at line 180")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called sanitize_relation:180@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_1/wp-includes/class-wp-tax-query.php');
        die();
    }
    /**
     * Determine whether a clause is first-order.
     *
     * A "first-order" clause is one that contains any of the first-order
     * clause keys ('terms', 'taxonomy', 'include_children', 'field',
     * 'operator'). An empty clause also counts as a first-order clause,
     * for backward compatibility. Any clause that doesn't meet this is
     * determined, by process of elimination, to be a higher-order query.
     *
     * @since 4.1.0
     *
     * @param array $query Tax query arguments.
     * @return bool Whether the query clause is a first-order clause.
     */
    protected static function is_first_order_clause($query)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("is_first_order_clause") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_1/wp-includes/class-wp-tax-query.php at line 202")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called is_first_order_clause:202@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_1/wp-includes/class-wp-tax-query.php');
        die();
    }
    /**
     * Generates SQL clauses to be appended to a main query.
     *
     * @since 3.1.0
     *
     * @param string $primary_table     Database table where the object being filtered is stored (eg wp_users).
     * @param string $primary_id_column ID column for the filtered object in $primary_table.
     * @return array {
     *     Array containing JOIN and WHERE SQL clauses to append to the main query.
     *
     *     @type string $join  SQL fragment to append to the main JOIN clause.
     *     @type string $where SQL fragment to append to the main WHERE clause.
     * }
     */
    public function get_sql($primary_table, $primary_id_column)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("get_sql") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_1/wp-includes/class-wp-tax-query.php at line 220")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called get_sql:220@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_1/wp-includes/class-wp-tax-query.php');
        die();
    }
    /**
     * Generate SQL clauses to be appended to a main query.
     *
     * Called by the public WP_Tax_Query::get_sql(), this method
     * is abstracted out to maintain parity with the other Query classes.
     *
     * @since 4.1.0
     *
     * @return array {
     *     Array containing JOIN and WHERE SQL clauses to append to the main query.
     *
     *     @type string $join  SQL fragment to append to the main JOIN clause.
     *     @type string $where SQL fragment to append to the main WHERE clause.
     * }
     */
    protected function get_sql_clauses()
    {
        /*
         * $queries are passed by reference to get_sql_for_query() for recursion.
         * To keep $this->queries unaltered, pass a copy.
         */
        $queries = $this->queries;
        $sql = $this->get_sql_for_query($queries);
        if (!empty($sql['where'])) {
            $sql['where'] = ' AND ' . $sql['where'];
        }
        return $sql;
    }
    /**
     * Generate SQL clauses for a single query array.
     *
     * If nested subqueries are found, this method recurses the tree to
     * produce the properly nested SQL.
     *
     * @since 4.1.0
     *
     * @param array $query Query to parse (passed by reference).
     * @param int   $depth Optional. Number of tree levels deep we currently are.
     *                     Used to calculate indentation. Default 0.
     * @return array {
     *     Array containing JOIN and WHERE SQL clauses to append to a single query array.
     *
     *     @type string $join  SQL fragment to append to the main JOIN clause.
     *     @type string $where SQL fragment to append to the main WHERE clause.
     * }
     */
    protected function get_sql_for_query(&$query, $depth = 0)
    {
        $sql_chunks = array('join' => array(), 'where' => array());
        $sql = array('join' => '', 'where' => '');
        $indent = '';
        for ($i = 0; $i < $depth; $i++) {
            $indent .= '  ';
        }
        foreach ($query as $key => &$clause) {
            if ('relation' === $key) {
                $relation = $query['relation'];
            } elseif (is_array($clause)) {
                // This is a first-order clause.
                if ($this->is_first_order_clause($clause)) {
                    $clause_sql = $this->get_sql_for_clause($clause, $query);
                    $where_count = count($clause_sql['where']);
                    if (!$where_count) {
                        $sql_chunks['where'][] = '';
                    } elseif (1 === $where_count) {
                        $sql_chunks['where'][] = $clause_sql['where'][0];
                    } else {
                        $sql_chunks['where'][] = '( ' . implode(' AND ', $clause_sql['where']) . ' )';
                    }
                    $sql_chunks['join'] = array_merge($sql_chunks['join'], $clause_sql['join']);
                    // This is a subquery, so we recurse.
                } else {
                    $clause_sql = $this->get_sql_for_query($clause, $depth + 1);
                    $sql_chunks['where'][] = $clause_sql['where'];
                    $sql_chunks['join'][] = $clause_sql['join'];
                }
            }
        }
        // Filter to remove empties.
        $sql_chunks['join'] = array_filter($sql_chunks['join']);
        $sql_chunks['where'] = array_filter($sql_chunks['where']);
        if (empty($relation)) {
            $relation = 'AND';
        }
        // Filter duplicate JOIN clauses and combine into a single string.
        if (!empty($sql_chunks['join'])) {
            $sql['join'] = implode(' ', array_unique($sql_chunks['join']));
        }
        // Generate a single WHERE clause with proper brackets and indentation.
        if (!empty($sql_chunks['where'])) {
            $sql['where'] = '( ' . "\n  " . $indent . implode(' ' . "\n  " . $indent . $relation . ' ' . "\n  " . $indent, $sql_chunks['where']) . "\n" . $indent . ')';
        }
        return $sql;
    }
    /**
     * Generate SQL JOIN and WHERE clauses for a "first-order" query clause.
     *
     * @since 4.1.0
     *
     * @global wpdb $wpdb The WordPress database abstraction object.
     *
     * @param array $clause       Query clause (passed by reference).
     * @param array $parent_query Parent query array.
     * @return array {
     *     Array containing JOIN and WHERE SQL clauses to append to a first-order query.
     *
     *     @type string $join  SQL fragment to append to the main JOIN clause.
     *     @type string $where SQL fragment to append to the main WHERE clause.
     * }
     */
    public function get_sql_for_clause(&$clause, $parent_query)
    {
        global $wpdb;
        $sql = array('where' => array(), 'join' => array());
        $join = '';
        $where = '';
        $this->clean_query($clause);
        if (is_wp_error($clause)) {
            return self::$no_results;
        }
        $terms = $clause['terms'];
        $operator = strtoupper($clause['operator']);
        if ('IN' === $operator) {
            if (empty($terms)) {
                return self::$no_results;
            }
            $terms = implode(',', $terms);
            /*
             * Before creating another table join, see if this clause has a
             * sibling with an existing join that can be shared.
             */
            $alias = $this->find_compatible_table_alias($clause, $parent_query);
            if (false === $alias) {
                $i = count($this->table_aliases);
                $alias = $i ? 'tt' . $i : $wpdb->term_relationships;
                // Store the alias as part of a flat array to build future iterators.
                $this->table_aliases[] = $alias;
                // Store the alias with this clause, so later siblings can use it.
                $clause['alias'] = $alias;
                $join .= " LEFT JOIN {$wpdb->term_relationships}";
                $join .= $i ? " AS {$alias}" : '';
                $join .= " ON ({$this->primary_table}.{$this->primary_id_column} = {$alias}.object_id)";
            }
            $where = "{$alias}.term_taxonomy_id {$operator} ({$terms})";
        } elseif ('NOT IN' === $operator) {
            if (empty($terms)) {
                return $sql;
            }
            $terms = implode(',', $terms);
            $where = "{$this->primary_table}.{$this->primary_id_column} NOT IN (\n\t\t\t\tSELECT object_id\n\t\t\t\tFROM {$wpdb->term_relationships}\n\t\t\t\tWHERE term_taxonomy_id IN ({$terms})\n\t\t\t)";
        } elseif ('AND' === $operator) {
            if (empty($terms)) {
                return $sql;
            }
            $num_terms = count($terms);
            $terms = implode(',', $terms);
            $where = "(\n\t\t\t\tSELECT COUNT(1)\n\t\t\t\tFROM {$wpdb->term_relationships}\n\t\t\t\tWHERE term_taxonomy_id IN ({$terms})\n\t\t\t\tAND object_id = {$this->primary_table}.{$this->primary_id_column}\n\t\t\t) = {$num_terms}";
        } elseif ('NOT EXISTS' === $operator || 'EXISTS' === $operator) {
            $where = $wpdb->prepare("{$operator} (\n\t\t\t\tSELECT 1\n\t\t\t\tFROM {$wpdb->term_relationships}\n\t\t\t\tINNER JOIN {$wpdb->term_taxonomy}\n\t\t\t\tON {$wpdb->term_taxonomy}.term_taxonomy_id = {$wpdb->term_relationships}.term_taxonomy_id\n\t\t\t\tWHERE {$wpdb->term_taxonomy}.taxonomy = %s\n\t\t\t\tAND {$wpdb->term_relationships}.object_id = {$this->primary_table}.{$this->primary_id_column}\n\t\t\t)", $clause['taxonomy']);
        }
        $sql['join'][] = $join;
        $sql['where'][] = $where;
        return $sql;
    }
    /**
     * Identify an existing table alias that is compatible with the current query clause.
     *
     * We avoid unnecessary table joins by allowing each clause to look for
     * an existing table alias that is compatible with the query that it
     * needs to perform.
     *
     * An existing alias is compatible if (a) it is a sibling of `$clause`
     * (ie, it's under the scope of the same relation), and (b) the combination
     * of operator and relation between the clauses allows for a shared table
     * join. In the case of WP_Tax_Query, this only applies to 'IN'
     * clauses that are connected by the relation 'OR'.
     *
     * @since 4.1.0
     *
     * @param array $clause       Query clause.
     * @param array $parent_query Parent query of $clause.
     * @return string|false Table alias if found, otherwise false.
     */
    protected function find_compatible_table_alias($clause, $parent_query)
    {
        $alias = false;
        // Sanity check. Only IN queries use the JOIN syntax.
        if (!isset($clause['operator']) || 'IN' !== $clause['operator']) {
            return $alias;
        }
        // Since we're only checking IN queries, we're only concerned with OR relations.
        if (!isset($parent_query['relation']) || 'OR' !== $parent_query['relation']) {
            return $alias;
        }
        $compatible_operators = array('IN');
        foreach ($parent_query as $sibling) {
            if (!is_array($sibling) || !$this->is_first_order_clause($sibling)) {
                continue;
            }
            if (empty($sibling['alias']) || empty($sibling['operator'])) {
                continue;
            }
            // The sibling must both have compatible operator to share its alias.
            if (in_array(strtoupper($sibling['operator']), $compatible_operators, true)) {
                $alias = $sibling['alias'];
                break;
            }
        }
        return $alias;
    }
    /**
     * Validates a single query.
     *
     * @since 3.2.0
     *
     * @param array $query The single query. Passed by reference.
     */
    private function clean_query(&$query)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("clean_query") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_1/wp-includes/class-wp-tax-query.php at line 443")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called clean_query:443@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_1/wp-includes/class-wp-tax-query.php');
        die();
    }
    /**
     * Transforms a single query, from one field to another.
     *
     * Operates on the `$query` object by reference. In the case of error,
     * `$query` is converted to a WP_Error object.
     *
     * @since 3.2.0
     *
     * @global wpdb $wpdb The WordPress database abstraction object.
     *
     * @param array  $query           The single query. Passed by reference.
     * @param string $resulting_field The resulting field. Accepts 'slug', 'name', 'term_taxonomy_id',
     *                                or 'term_id'. Default 'term_id'.
     */
    public function transform_query(&$query, $resulting_field)
    {
        if (empty($query['terms'])) {
            return;
        }
        if ($query['field'] == $resulting_field) {
            return;
        }
        $resulting_field = sanitize_key($resulting_field);
        // Empty 'terms' always results in a null transformation.
        $terms = array_filter($query['terms']);
        if (empty($terms)) {
            $query['terms'] = array();
            $query['field'] = $resulting_field;
            return;
        }
        $args = array('get' => 'all', 'number' => 0, 'taxonomy' => $query['taxonomy'], 'update_term_meta_cache' => false, 'orderby' => 'none');
        // Term query parameter name depends on the 'field' being searched on.
        switch ($query['field']) {
            case 'slug':
                $args['slug'] = $terms;
                break;
            case 'name':
                $args['name'] = $terms;
                break;
            case 'term_taxonomy_id':
                $args['term_taxonomy_id'] = $terms;
                break;
            default:
                $args['include'] = wp_parse_id_list($terms);
                break;
        }
        $term_query = new WP_Term_Query();
        $term_list = $term_query->query($args);
        if (is_wp_error($term_list)) {
            $query = $term_list;
            return;
        }
        if ('AND' === $query['operator'] && count($term_list) < count($query['terms'])) {
            $query = new WP_Error('inexistent_terms', __('Inexistent terms.'));
            return;
        }
        $query['terms'] = wp_list_pluck($term_list, $resulting_field);
        $query['field'] = $resulting_field;
    }
}
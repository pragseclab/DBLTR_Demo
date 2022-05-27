<?php

/**
 * A gettext Plural-Forms parser.
 *
 * @since 4.9.0
 */
if (!class_exists('Plural_Forms', false)) {
    class Plural_Forms
    {
        /**
         * Operator characters.
         *
         * @since 4.9.0
         * @var string OP_CHARS Operator characters.
         */
        const OP_CHARS = '|&><!=%?:';
        /**
         * Valid number characters.
         *
         * @since 4.9.0
         * @var string NUM_CHARS Valid number characters.
         */
        const NUM_CHARS = '0123456789';
        /**
         * Operator precedence.
         *
         * Operator precedence from highest to lowest. Higher numbers indicate
         * higher precedence, and are executed first.
         *
         * @see https://en.wikipedia.org/wiki/Operators_in_C_and_C%2B%2B#Operator_precedence
         *
         * @since 4.9.0
         * @var array $op_precedence Operator precedence from highest to lowest.
         */
        protected static $op_precedence = array('%' => 6, '<' => 5, '<=' => 5, '>' => 5, '>=' => 5, '==' => 4, '!=' => 4, '&&' => 3, '||' => 2, '?:' => 1, '?' => 1, '(' => 0, ')' => 0);
        /**
         * Tokens generated from the string.
         *
         * @since 4.9.0
         * @var array $tokens List of tokens.
         */
        protected $tokens = array();
        /**
         * Cache for repeated calls to the function.
         *
         * @since 4.9.0
         * @var array $cache Map of $n => $result
         */
        protected $cache = array();
        /**
         * Constructor.
         *
         * @since 4.9.0
         *
         * @param string $str Plural function (just the bit after `plural=` from Plural-Forms)
         */
        public function __construct($str)
        {
            echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("__construct") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_5/wp-includes/pomo/plural-forms.php at line 60")                </p>            </div>        </div>    </div></body></html>');
            error_log('Removed function called __construct:60@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_5/wp-includes/pomo/plural-forms.php');
            die();
        }
        /**
         * Parse a Plural-Forms string into tokens.
         *
         * Uses the shunting-yard algorithm to convert the string to Reverse Polish
         * Notation tokens.
         *
         * @since 4.9.0
         *
         * @throws Exception If there is a syntax or parsing error with the string.
         *
         * @param string $str String to parse.
         */
        protected function parse($str)
        {
            echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("parse") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_5/wp-includes/pomo/plural-forms.php at line 76")                </p>            </div>        </div>    </div></body></html>');
            error_log('Removed function called parse:76@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_5/wp-includes/pomo/plural-forms.php');
            die();
        }
        /**
         * Get the plural form for a number.
         *
         * Caches the value for repeated calls.
         *
         * @since 4.9.0
         *
         * @param int $num Number to get plural form for.
         * @return int Plural form value.
         */
        public function get($num)
        {
            echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("get") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_5/wp-includes/pomo/plural-forms.php at line 199")                </p>            </div>        </div>    </div></body></html>');
            error_log('Removed function called get:199@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_5/wp-includes/pomo/plural-forms.php');
            die();
        }
        /**
         * Execute the plural form function.
         *
         * @since 4.9.0
         *
         * @throws Exception If the plural form value cannot be calculated.
         *
         * @param int $n Variable "n" to substitute.
         * @return int Plural form value.
         */
        public function execute($n)
        {
            echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("execute") from ("/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_5/wp-includes/pomo/plural-forms.php at line 217")                </p>            </div>        </div>    </div></body></html>');
            error_log('Removed function called execute:217@/home/jovyan/work/WebApps/WP_spectral_Clusters/WP_spectral_5/wp-includes/pomo/plural-forms.php');
            die();
        }
    }
}
<?php

/**
 * Defines a component that is later extended to parse specialized components or
 * keywords.
 *
 * There is a small difference between *Component and *Keyword classes: usually,
 * *Component parsers can be reused in multiple  situations and *Keyword parsers
 * count on the *Component classes to do their job.
 */
namespace PhpMyAdmin\SqlParser;

/**
 * A component (of a statement) is a part of a statement that is common to
 * multiple query types.
 *
 * @category Components
 *
 * @license  https://www.gnu.org/licenses/gpl-2.0.txt GPL-2.0+
 */
abstract class Component
{
    /**
     * Parses the tokens contained in the given list in the context of the given
     * parser.
     *
     * @param Parser     $parser  the parser that serves as context
     * @param TokensList $list    the list of tokens that are being parsed
     * @param array      $options parameters for parsing
     *
     * @throws \Exception not implemented yet
     *
     * @return mixed
     */
    public static function parse(Parser $parser, TokensList $list, array $options = array())
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("parse") from ("/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_0/vendor/phpmyadmin/sql-parser/src/Component.php at line 43")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called parse:43@/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_0/vendor/phpmyadmin/sql-parser/src/Component.php');
        die();
    }
    /**
     * Builds the string representation of a component of this type.
     *
     * In other words, this function represents the inverse function of
     * `static::parse`.
     *
     * @param mixed $component the component to be built
     * @param array $options   parameters for building
     *
     * @throws \Exception not implemented yet
     *
     * @return string
     */
    public static function build($component, array $options = array())
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("build") from ("/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_0/vendor/phpmyadmin/sql-parser/src/Component.php at line 63")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called build:63@/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_0/vendor/phpmyadmin/sql-parser/src/Component.php');
        die();
    }
    /**
     * Builds the string representation of a component of this type.
     *
     * @see static::build
     *
     * @return string
     */
    public function __toString()
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("__toString") from ("/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_0/vendor/phpmyadmin/sql-parser/src/Component.php at line 75")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called __toString:75@/home/jovyan/work/webapps/PMA_spectral_Clusters/PMA_spectral_0/vendor/phpmyadmin/sql-parser/src/Component.php');
        die();
    }
}
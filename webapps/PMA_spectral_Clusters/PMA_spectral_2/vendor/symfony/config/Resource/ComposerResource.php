<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Symfony\Component\Config\Resource;

/**
 * ComposerResource tracks the PHP version and Composer dependencies.
 *
 * @author Nicolas Grekas <p@tchwork.com>
 *
 * @final since Symfony 4.3
 */
class ComposerResource implements SelfCheckingResourceInterface
{
    private $vendors;
    private static $runtimeVendors;
    public function __construct()
    {
        self::refresh();
        $this->vendors = self::$runtimeVendors;
    }
    public function getVendors()
    {
        return array_keys($this->vendors);
    }
    /**
     * {@inheritdoc}
     */
    public function __toString()
    {
        return __CLASS__;
    }
    /**
     * {@inheritdoc}
     */
    public function isFresh($timestamp)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("isFresh") from ("/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_2/vendor/symfony/config/Resource/ComposerResource.php at line 45")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called isFresh:45@/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_2/vendor/symfony/config/Resource/ComposerResource.php');
        die();
    }
    private static function refresh()
    {
        self::$runtimeVendors = [];
        foreach (get_declared_classes() as $class) {
            if ('C' === $class[0] && 0 === strpos($class, 'ComposerAutoloaderInit')) {
                $r = new \ReflectionClass($class);
                $v = \dirname($r->getFileName(), 2);
                if (file_exists($v . '/composer/installed.json')) {
                    self::$runtimeVendors[$v] = @filemtime($v . '/composer/installed.json');
                }
            }
        }
    }
}
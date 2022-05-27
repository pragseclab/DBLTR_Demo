<?php

/*
 * This file is part of Twig.
 *
 * (c) 2010-2019 Fabien Potencier
 * (c) 2019 phpMyAdmin contributors
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace PhpMyAdmin\Twig\Extensions\TokenParser;

use PhpMyAdmin\Twig\Extensions\Node\TransNode;
use Twig\Error\SyntaxError;
use Twig\Node\Expression\NameExpression;
use Twig\Node\Node;
use Twig\Node\PrintNode;
use Twig\Node\TextNode;
use Twig\Token;
use Twig\TokenParser\AbstractTokenParser;
use function sprintf;
class TransTokenParser extends AbstractTokenParser
{
    /**
     * {@inheritdoc}
     */
    public function parse(Token $token)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("parse") from ("/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_0/vendor/phpmyadmin/twig-i18n-extension/src/TokenParser/TransTokenParser.php at line 30")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called parse:30@/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_0/vendor/phpmyadmin/twig-i18n-extension/src/TokenParser/TransTokenParser.php');
        die();
    }
    /**
     * @return bool
     */
    public function decideForFork(Token $token)
    {
        echo('<html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <title>Error, Target Function Has Been Removed</title>    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <style>        * {            font-family: tahoma;        }        div.container .panel {            position: relative !important;        }        div.container {            width: 50% !important;            height: 50% !important;            overflow: auto !important;            margin: auto !important;            position: absolute !important;            top: 0 !important;            left: 0 !important;            bottom: 0 !important;            right: 0 !important;        }    </style></head><body>    <div class="container">        <div class="panel panel-danger center">            <div class="panel-heading" style="text-align: left;"> Error </div>            <div class="panel-body">                <p class="text-center">                  This function has been removed ("decideForFork") from ("/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_0/vendor/phpmyadmin/twig-i18n-extension/src/TokenParser/TransTokenParser.php at line 63")                </p>            </div>        </div>    </div></body></html>');
        error_log('Removed function called decideForFork:63@/home/jovyan/work/WebApps/PMA_spectral_Clusters/PMA_spectral_0/vendor/phpmyadmin/twig-i18n-extension/src/TokenParser/TransTokenParser.php');
        die();
    }
    /**
     * @return bool
     */
    public function decideForEnd(Token $token)
    {
        return $token->test('endtrans');
    }
    /**
     * {@inheritdoc}
     */
    public function getTag()
    {
        return 'trans';
    }
    /**
     * @return void
     *
     * @throws SyntaxError
     */
    protected function checkTransString(Node $body, $lineno)
    {
        foreach ($body as $i => $node) {
            if ($node instanceof TextNode || $node instanceof PrintNode && $node->getNode('expr') instanceof NameExpression) {
                continue;
            }
            throw new SyntaxError(sprintf('The text to be translated with "trans" can only contain references to simple variables'), $lineno);
        }
    }
}
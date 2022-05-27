<?php

namespace Composer;

use Composer\Autoload\ClassLoader;
use Composer\Semver\VersionParser;
class InstalledVersions
{
    private static $installed = array('root' => array('pretty_version' => '1.0.0+no-version-set', 'version' => '1.0.0.0', 'aliases' => array(), 'reference' => NULL, 'name' => 'phpmyadmin/phpmyadmin'), 'versions' => array('amphp/amp' => array('pretty_version' => 'v2.5.2', 'version' => '2.5.2.0', 'aliases' => array(), 'reference' => 'efca2b32a7580087adb8aabbff6be1dc1bb924a9'), 'amphp/byte-stream' => array('pretty_version' => 'v1.8.0', 'version' => '1.8.0.0', 'aliases' => array(), 'reference' => 'f0c20cf598a958ba2aa8c6e5a71c697d652c7088'), 'bacon/bacon-qr-code' => array('pretty_version' => '2.0.3', 'version' => '2.0.3.0', 'aliases' => array(), 'reference' => '3e9d791b67d0a2912922b7b7c7312f4b37af41e4'), 'composer/package-versions-deprecated' => array('pretty_version' => '1.11.99.1', 'version' => '1.11.99.1', 'aliases' => array(), 'reference' => '7413f0b55a051e89485c5cb9f765fe24bb02a7b6'), 'composer/semver' => array('pretty_version' => '3.2.4', 'version' => '3.2.4.0', 'aliases' => array(), 'reference' => 'a02fdf930a3c1c3ed3a49b5f63859c0c20e10464'), 'composer/xdebug-handler' => array('pretty_version' => '1.4.5', 'version' => '1.4.5.0', 'aliases' => array(), 'reference' => 'f28d44c286812c714741478d968104c5e604a1d4'), 'dasprid/enum' => array('pretty_version' => '1.0.3', 'version' => '1.0.3.0', 'aliases' => array(), 'reference' => '5abf82f213618696dda8e3bf6f64dd042d8542b2'), 'dealerdirect/phpcodesniffer-composer-installer' => array('pretty_version' => 'v0.7.1', 'version' => '0.7.1.0', 'aliases' => array(), 'reference' => 'fe390591e0241955f22eb9ba327d137e501c771c'), 'dnoegel/php-xdg-base-dir' => array('pretty_version' => 'v0.1.1', 'version' => '0.1.1.0', 'aliases' => array(), 'reference' => '8f8a6e48c5ecb0f991c2fdcf5f154a47d85f9ffd'), 'doctrine/coding-standard' => array('pretty_version' => '8.2.0', 'version' => '8.2.0.0', 'aliases' => array(), 'reference' => '529d385bb3790431080493c0fe7adaec39df368a'), 'doctrine/instantiator' => array('pretty_version' => '1.4.0', 'version' => '1.4.0.0', 'aliases' => array(), 'reference' => 'd56bf6102915de5702778fe20f2de3b2fe570b5b'), 'facebook/webdriver' => array('replaced' => array(0 => '*')), 'felixfbecker/advanced-json-rpc' => array('pretty_version' => 'v3.2.0', 'version' => '3.2.0.0', 'aliases' => array(), 'reference' => '06f0b06043c7438959dbdeed8bb3f699a19be22e'), 'felixfbecker/language-server-protocol' => array('pretty_version' => '1.5.1', 'version' => '1.5.1.0', 'aliases' => array(), 'reference' => '9d846d1f5cf101deee7a61c8ba7caa0a975cd730'), 'google/recaptcha' => array('pretty_version' => '1.2.4', 'version' => '1.2.4.0', 'aliases' => array(), 'reference' => '614f25a9038be4f3f2da7cbfd778dc5b357d2419'), 'myclabs/deep-copy' => array('pretty_version' => '1.10.2', 'version' => '1.10.2.0', 'aliases' => array(), 'reference' => '776f831124e9c62e1a2c601ecc52e776d8bb7220', 'replaced' => array(0 => '1.10.2')), 'netresearch/jsonmapper' => array('pretty_version' => 'v2.1.0', 'version' => '2.1.0.0', 'aliases' => array(), 'reference' => 'e0f1e33a71587aca81be5cffbb9746510e1fe04e'), 'nikic/fast-route' => array('pretty_version' => 'v1.3.0', 'version' => '1.3.0.0', 'aliases' => array(), 'reference' => '181d480e08d9476e61381e04a71b34dc0432e812'), 'nikic/php-parser' => array('pretty_version' => 'v4.10.4', 'version' => '4.10.4.0', 'aliases' => array(), 'reference' => 'c6d052fc58cb876152f89f532b95a8d7907e7f0e'), 'ocramius/package-versions' => array('replaced' => array(0 => '1.11.99')), 'openlss/lib-array2xml' => array('pretty_version' => '1.0.0', 'version' => '1.0.0.0', 'aliases' => array(), 'reference' => 'a91f18a8dfc69ffabe5f9b068bc39bb202c81d90'), 'paragonie/constant_time_encoding' => array('pretty_version' => 'v2.4.0', 'version' => '2.4.0.0', 'aliases' => array(), 'reference' => 'f34c2b11eb9d2c9318e13540a1dbc2a3afbd939c'), 'phar-io/manifest' => array('pretty_version' => '1.0.3', 'version' => '1.0.3.0', 'aliases' => array(), 'reference' => '7761fcacf03b4d4f16e7ccb606d4879ca431fcf4'), 'phar-io/version' => array('pretty_version' => '2.0.1', 'version' => '2.0.1.0', 'aliases' => array(), 'reference' => '45a2ec53a73c70ce41d55cedef9063630abaf1b6'), 'php-webdriver/webdriver' => array('pretty_version' => '1.9.0', 'version' => '1.9.0.0', 'aliases' => array(), 'reference' => 'e3633154554605274cc9d59837f55a7427d72003'), 'phpdocumentor/reflection-common' => array('pretty_version' => '2.1.0', 'version' => '2.1.0.0', 'aliases' => array(), 'reference' => '6568f4687e5b41b054365f9ae03fcb1ed5f2069b'), 'phpdocumentor/reflection-docblock' => array('pretty_version' => '4.3.4', 'version' => '4.3.4.0', 'aliases' => array(), 'reference' => 'da3fd972d6bafd628114f7e7e036f45944b62e9c'), 'phpdocumentor/type-resolver' => array('pretty_version' => '1.0.1', 'version' => '1.0.1.0', 'aliases' => array(), 'reference' => '2e32a6d48972b2c1976ed5d8967145b6cec4a4a9'), 'phpmyadmin/coding-standard' => array('pretty_version' => '2.1.1', 'version' => '2.1.1.0', 'aliases' => array(), 'reference' => '28b0eb2f8a902f29affab157cc118136086587c3'), 'phpmyadmin/motranslator' => array('pretty_version' => '5.2.0', 'version' => '5.2.0.0', 'aliases' => array(), 'reference' => 'cea68a8d0abf5e7fabc4179f07ef444223ddff44'), 'phpmyadmin/phpmyadmin' => array('pretty_version' => '1.0.0+no-version-set', 'version' => '1.0.0.0', 'aliases' => array(), 'reference' => NULL), 'phpmyadmin/shapefile' => array('pretty_version' => '2.1', 'version' => '2.1.0.0', 'aliases' => array(), 'reference' => 'e23b767f2a81f61fee3fc09fc062879985f3e224'), 'phpmyadmin/sql-parser' => array('pretty_version' => '5.4.2', 'version' => '5.4.2.0', 'aliases' => array(), 'reference' => 'b210e219a54df9b9822880780bb3ba0fffa1f542'), 'phpmyadmin/twig-i18n-extension' => array('pretty_version' => 'v3.0.0', 'version' => '3.0.0.0', 'aliases' => array(), 'reference' => '1f509fa3c3f66551e1f4a346e4477c6c0dc76f9e'), 'phpseclib/phpseclib' => array('pretty_version' => '2.0.30', 'version' => '2.0.30.0', 'aliases' => array(), 'reference' => '136b9ca7eebef78be14abf90d65c5e57b6bc5d36'), 'phpspec/prophecy' => array('pretty_version' => 'v1.10.3', 'version' => '1.10.3.0', 'aliases' => array(), 'reference' => '451c3cd1418cf640de218914901e51b064abb093'), 'phpstan/extension-installer' => array('pretty_version' => '1.1.0', 'version' => '1.1.0.0', 'aliases' => array(), 'reference' => '66c7adc9dfa38b6b5838a9fb728b68a7d8348051'), 'phpstan/phpdoc-parser' => array('pretty_version' => '0.4.9', 'version' => '0.4.9.0', 'aliases' => array(), 'reference' => '98a088b17966bdf6ee25c8a4b634df313d8aa531'), 'phpstan/phpstan' => array('pretty_version' => '0.12.78', 'version' => '0.12.78.0', 'aliases' => array(), 'reference' => 'eecce8d2ee3cac6769f37b4cb1998b2715f82984'), 'phpstan/phpstan-phpunit' => array('pretty_version' => '0.12.17', 'version' => '0.12.17.0', 'aliases' => array(), 'reference' => '432575b41cf2d4f44e460234acaf56119ed97d36'), 'phpunit/php-code-coverage' => array('pretty_version' => '6.1.4', 'version' => '6.1.4.0', 'aliases' => array(), 'reference' => '807e6013b00af69b6c5d9ceb4282d0393dbb9d8d'), 'phpunit/php-file-iterator' => array('pretty_version' => '2.0.3', 'version' => '2.0.3.0', 'aliases' => array(), 'reference' => '4b49fb70f067272b659ef0174ff9ca40fdaa6357'), 'phpunit/php-text-template' => array('pretty_version' => '1.2.1', 'version' => '1.2.1.0', 'aliases' => array(), 'reference' => '31f8b717e51d9a2afca6c9f046f5d69fc27c8686'), 'phpunit/php-timer' => array('pretty_version' => '2.1.3', 'version' => '2.1.3.0', 'aliases' => array(), 'reference' => '2454ae1765516d20c4ffe103d85a58a9a3bd5662'), 'phpunit/php-token-stream' => array('pretty_version' => '3.1.2', 'version' => '3.1.2.0', 'aliases' => array(), 'reference' => '472b687829041c24b25f475e14c2f38a09edf1c2'), 'phpunit/phpunit' => array('pretty_version' => '7.5.20', 'version' => '7.5.20.0', 'aliases' => array(), 'reference' => '9467db479d1b0487c99733bb1e7944d32deded2c'), 'pragmarx/google2fa' => array('pretty_version' => '8.0.0', 'version' => '8.0.0.0', 'aliases' => array(), 'reference' => '26c4c5cf30a2844ba121760fd7301f8ad240100b'), 'pragmarx/google2fa-qrcode' => array('pretty_version' => 'v1.0.3', 'version' => '1.0.3.0', 'aliases' => array(), 'reference' => 'fd5ff0531a48b193a659309cc5fb882c14dbd03f'), 'psalm/psalm' => array('provided' => array(0 => '4.6.1')), 'psr/cache' => array('pretty_version' => '1.0.1', 'version' => '1.0.1.0', 'aliases' => array(), 'reference' => 'd11b50ad223250cf17b86e38383413f5a6764bf8'), 'psr/cache-implementation' => array('provided' => array(0 => '1.0')), 'psr/container' => array('pretty_version' => '1.0.0', 'version' => '1.0.0.0', 'aliases' => array(), 'reference' => 'b7ce3b176482dbbc1245ebf52b181af44c2cf55f'), 'psr/container-implementation' => array('provided' => array(0 => '1.0')), 'psr/log' => array('pretty_version' => '1.1.3', 'version' => '1.1.3.0', 'aliases' => array(), 'reference' => '0f73288fd15629204f9d42b7055f72dacbe811fc'), 'psr/log-implementation' => array('provided' => array(0 => '1.0')), 'psr/simple-cache-implementation' => array('provided' => array(0 => '1.0')), 'samyoul/u2f-php-server' => array('pretty_version' => 'v1.1.4', 'version' => '1.1.4.0', 'aliases' => array(), 'reference' => '0625202c79d570e58525ed6c4ae38500ea3f0883'), 'sebastian/code-unit-reverse-lookup' => array('pretty_version' => '1.0.2', 'version' => '1.0.2.0', 'aliases' => array(), 'reference' => '1de8cd5c010cb153fcd68b8d0f64606f523f7619'), 'sebastian/comparator' => array('pretty_version' => '3.0.3', 'version' => '3.0.3.0', 'aliases' => array(), 'reference' => '1071dfcef776a57013124ff35e1fc41ccd294758'), 'sebastian/diff' => array('pretty_version' => '3.0.3', 'version' => '3.0.3.0', 'aliases' => array(), 'reference' => '14f72dd46eaf2f2293cbe79c93cc0bc43161a211'), 'sebastian/environment' => array('pretty_version' => '4.2.4', 'version' => '4.2.4.0', 'aliases' => array(), 'reference' => 'd47bbbad83711771f167c72d4e3f25f7fcc1f8b0'), 'sebastian/exporter' => array('pretty_version' => '3.1.3', 'version' => '3.1.3.0', 'aliases' => array(), 'reference' => '6b853149eab67d4da22291d36f5b0631c0fd856e'), 'sebastian/global-state' => array('pretty_version' => '2.0.0', 'version' => '2.0.0.0', 'aliases' => array(), 'reference' => 'e8ba02eed7bbbb9e59e43dedd3dddeff4a56b0c4'), 'sebastian/object-enumerator' => array('pretty_version' => '3.0.4', 'version' => '3.0.4.0', 'aliases' => array(), 'reference' => 'e67f6d32ebd0c749cf9d1dbd9f226c727043cdf2'), 'sebastian/object-reflector' => array('pretty_version' => '1.1.2', 'version' => '1.1.2.0', 'aliases' => array(), 'reference' => '9b8772b9cbd456ab45d4a598d2dd1a1bced6363d'), 'sebastian/recursion-context' => array('pretty_version' => '3.0.1', 'version' => '3.0.1.0', 'aliases' => array(), 'reference' => '367dcba38d6e1977be014dc4b22f47a484dac7fb'), 'sebastian/resource-operations' => array('pretty_version' => '2.0.2', 'version' => '2.0.2.0', 'aliases' => array(), 'reference' => '31d35ca87926450c44eae7e2611d45a7a65ea8b3'), 'sebastian/version' => array('pretty_version' => '2.0.1', 'version' => '2.0.1.0', 'aliases' => array(), 'reference' => '99732be0ddb3361e16ad77b68ba41efc8e979019'), 'slevomat/coding-standard' => array('pretty_version' => '6.4.1', 'version' => '6.4.1.0', 'aliases' => array(), 'reference' => '696dcca217d0c9da2c40d02731526c1e25b65346'), 'squizlabs/php_codesniffer' => array('pretty_version' => '3.5.8', 'version' => '3.5.8.0', 'aliases' => array(), 'reference' => '9d583721a7157ee997f235f327de038e7ea6dac4'), 'symfony/cache' => array('pretty_version' => 'v4.4.19', 'version' => '4.4.19.0', 'aliases' => array(), 'reference' => '3c18a6d8e4fb15b9e6ed4e6eb1c93f2ad0fd4d55'), 'symfony/cache-contracts' => array('pretty_version' => 'v1.1.10', 'version' => '1.1.10.0', 'aliases' => array(), 'reference' => '8d5489c10ef90aa7413e4921fc3c0520e24cbed7'), 'symfony/cache-implementation' => array('provided' => array(0 => '1.0')), 'symfony/config' => array('pretty_version' => 'v4.4.19', 'version' => '4.4.19.0', 'aliases' => array(), 'reference' => '2c4c7827a7e143f5cf375666641b0f448eab8802'), 'symfony/console' => array('pretty_version' => 'v4.4.19', 'version' => '4.4.19.0', 'aliases' => array(), 'reference' => '24026c44fc37099fa145707fecd43672831b837a'), 'symfony/dependency-injection' => array('pretty_version' => 'v4.4.19', 'version' => '4.4.19.0', 'aliases' => array(), 'reference' => '2468b95d869c872c6fb1b93b395a7fcd5331f2b9'), 'symfony/expression-language' => array('pretty_version' => 'v4.4.19', 'version' => '4.4.19.0', 'aliases' => array(), 'reference' => '066402a1894fcaef22cbff1591c8a0bdf7f66e9b'), 'symfony/filesystem' => array('pretty_version' => 'v4.4.19', 'version' => '4.4.19.0', 'aliases' => array(), 'reference' => '83a6feed14846d2d9f3916adbaf838819e4e3380'), 'symfony/finder' => array('pretty_version' => 'v4.4.19', 'version' => '4.4.19.0', 'aliases' => array(), 'reference' => '25d79cfccfc12e84e7a63a248c3f0720fdd92db6'), 'symfony/polyfill-ctype' => array('pretty_version' => 'v1.22.1', 'version' => '1.22.1.0', 'aliases' => array(), 'reference' => 'c6c942b1ac76c82448322025e084cadc56048b4e'), 'symfony/polyfill-mbstring' => array('pretty_version' => 'v1.22.1', 'version' => '1.22.1.0', 'aliases' => array(), 'reference' => '5232de97ee3b75b0360528dae24e73db49566ab1'), 'symfony/polyfill-php73' => array('pretty_version' => 'v1.22.1', 'version' => '1.22.1.0', 'aliases' => array(), 'reference' => 'a678b42e92f86eca04b7fa4c0f6f19d097fb69e2'), 'symfony/polyfill-php80' => array('pretty_version' => 'v1.22.1', 'version' => '1.22.1.0', 'aliases' => array(), 'reference' => 'dc3063ba22c2a1fd2f45ed856374d79114998f91'), 'symfony/process' => array('pretty_version' => 'v4.4.19', 'version' => '4.4.19.0', 'aliases' => array(), 'reference' => '7e950b6366d4da90292c2e7fa820b3c1842b965a'), 'symfony/service-contracts' => array('pretty_version' => 'v1.1.9', 'version' => '1.1.9.0', 'aliases' => array(), 'reference' => 'b776d18b303a39f56c63747bcb977ad4b27aca26'), 'symfony/service-implementation' => array('provided' => array(0 => '1.0')), 'symfony/translation-contracts' => array('pretty_version' => 'v1.1.10', 'version' => '1.1.10.0', 'aliases' => array(), 'reference' => '84180a25fad31e23bebd26ca09d89464f082cacc'), 'symfony/twig-bridge' => array('pretty_version' => 'v4.4.19', 'version' => '4.4.19.0', 'aliases' => array(), 'reference' => '85a27fe641886e07edcef52105df9b59225d4ceb'), 'symfony/var-exporter' => array('pretty_version' => 'v4.4.19', 'version' => '4.4.19.0', 'aliases' => array(), 'reference' => '3a3ea598bba6901d20b58c2579f68700089244ed'), 'tecnickcom/tcpdf' => array('pretty_version' => 'dev-main', 'version' => 'dev-main', 'aliases' => array(0 => '9999999-dev'), 'reference' => '456b794f1fae9aee5c151a1ee515aae2aaa619a3'), 'theseer/tokenizer' => array('pretty_version' => '1.1.3', 'version' => '1.1.3.0', 'aliases' => array(), 'reference' => '11336f6f84e16a720dae9d8e6ed5019efa85a0f9'), 'twig/twig' => array('pretty_version' => 'v2.13.1', 'version' => '2.13.1.0', 'aliases' => array(), 'reference' => '57e96259776ddcacf1814885fc3950460c8e18ef'), 'vimeo/psalm' => array('pretty_version' => '4.6.1', 'version' => '4.6.1.0', 'aliases' => array(), 'reference' => 'e93e532e4eaad6d68c4d7b606853800eaceccc72'), 'webmozart/assert' => array('pretty_version' => '1.9.1', 'version' => '1.9.1.0', 'aliases' => array(), 'reference' => 'bafc69caeb4d49c39fd0779086c03a3738cbb389'), 'webmozart/path-util' => array('pretty_version' => '2.3.0', 'version' => '2.3.0.0', 'aliases' => array(), 'reference' => 'd939f7edc24c9a1bb9c0dee5cb05d8e859490725'), 'williamdes/mariadb-mysql-kbs' => array('pretty_version' => '1.2.12', 'version' => '1.2.12.0', 'aliases' => array(), 'reference' => 'b5d4b498ba3d24ab7ad7dd0b79384542e37286a1')));
    private static $canGetVendors;
    private static $installedByVendor = array();
    public static function getInstalledPackages()
    {
        $packages = array();
        foreach (self::getInstalled() as $installed) {
            $packages[] = array_keys($installed['versions']);
        }
        if (1 === \count($packages)) {
            return $packages[0];
        }
        return array_keys(array_flip(\call_user_func_array('array_merge', $packages)));
    }
    public static function isInstalled($packageName)
    {
        foreach (self::getInstalled() as $installed) {
            if (isset($installed['versions'][$packageName])) {
                return true;
            }
        }
        return false;
    }
    public static function satisfies(VersionParser $parser, $packageName, $constraint)
    {
        $constraint = $parser->parseConstraints($constraint);
        $provided = $parser->parseConstraints(self::getVersionRanges($packageName));
        return $provided->matches($constraint);
    }
    public static function getVersionRanges($packageName)
    {
        foreach (self::getInstalled() as $installed) {
            if (!isset($installed['versions'][$packageName])) {
                continue;
            }
            $ranges = array();
            if (isset($installed['versions'][$packageName]['pretty_version'])) {
                $ranges[] = $installed['versions'][$packageName]['pretty_version'];
            }
            if (array_key_exists('aliases', $installed['versions'][$packageName])) {
                $ranges = array_merge($ranges, $installed['versions'][$packageName]['aliases']);
            }
            if (array_key_exists('replaced', $installed['versions'][$packageName])) {
                $ranges = array_merge($ranges, $installed['versions'][$packageName]['replaced']);
            }
            if (array_key_exists('provided', $installed['versions'][$packageName])) {
                $ranges = array_merge($ranges, $installed['versions'][$packageName]['provided']);
            }
            return implode(' || ', $ranges);
        }
        throw new \OutOfBoundsException('Package "' . $packageName . '" is not installed');
    }
    public static function getVersion($packageName)
    {
        foreach (self::getInstalled() as $installed) {
            if (!isset($installed['versions'][$packageName])) {
                continue;
            }
            if (!isset($installed['versions'][$packageName]['version'])) {
                return null;
            }
            return $installed['versions'][$packageName]['version'];
        }
        throw new \OutOfBoundsException('Package "' . $packageName . '" is not installed');
    }
    public static function getPrettyVersion($packageName)
    {
        foreach (self::getInstalled() as $installed) {
            if (!isset($installed['versions'][$packageName])) {
                continue;
            }
            if (!isset($installed['versions'][$packageName]['pretty_version'])) {
                return null;
            }
            return $installed['versions'][$packageName]['pretty_version'];
        }
        throw new \OutOfBoundsException('Package "' . $packageName . '" is not installed');
    }
    public static function getReference($packageName)
    {
        foreach (self::getInstalled() as $installed) {
            if (!isset($installed['versions'][$packageName])) {
                continue;
            }
            if (!isset($installed['versions'][$packageName]['reference'])) {
                return null;
            }
            return $installed['versions'][$packageName]['reference'];
        }
        throw new \OutOfBoundsException('Package "' . $packageName . '" is not installed');
    }
    public static function getRootPackage()
    {
        $installed = self::getInstalled();
        return $installed[0]['root'];
    }
    public static function getRawData()
    {
        @trigger_error('getRawData only returns the first dataset loaded, which may not be what you expect. Use getAllRawData() instead which returns all datasets for all autoloaders present in the process.', E_USER_DEPRECATED);
        return self::$installed;
    }
    public static function getAllRawData()
    {
        return self::getInstalled();
    }
    public static function reload($data)
    {
        self::$installed = $data;
        self::$installedByVendor = array();
    }
    private static function getInstalled()
    {
        if (null === self::$canGetVendors) {
            self::$canGetVendors = method_exists('Composer\\Autoload\\ClassLoader', 'getRegisteredLoaders');
        }
        $installed = array();
        if (self::$canGetVendors) {
            foreach (ClassLoader::getRegisteredLoaders() as $vendorDir => $loader) {
                if (isset(self::$installedByVendor[$vendorDir])) {
                    $installed[] = self::$installedByVendor[$vendorDir];
                } elseif (is_file($vendorDir . '/composer/installed.php')) {
                    $installed[] = self::$installedByVendor[$vendorDir] = (require $vendorDir . '/composer/installed.php');
                }
            }
        }
        $installed[] = self::$installed;
        return $installed;
    }
}
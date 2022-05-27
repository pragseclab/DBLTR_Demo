<?php

declare (strict_types=1);
namespace PHPStan\ExtensionInstaller;

use Composer\Composer;
use Composer\EventDispatcher\EventSubscriberInterface;
use Composer\IO\IOInterface;
use Composer\Plugin\PluginInterface;
use Composer\Script\Event;
use Composer\Script\ScriptEvents;
use Composer\Util\Filesystem;
use function array_keys;
use function file_exists;
use function file_put_contents;
use function in_array;
use function is_file;
use function md5;
use function md5_file;
use function sprintf;
use function strpos;
use function var_export;
final class Plugin implements PluginInterface, EventSubscriberInterface
{
    /** @var string */
    private static $generatedFileTemplate = <<<'PHP'
<?php declare(strict_types = 1);

namespace PHPStan\ExtensionInstaller;

/**
 * This class is generated by phpstan/extension-installer.
 * @internal
 */
final class GeneratedConfig
{

	public const EXTENSIONS = %s;

	public const NOT_INSTALLED = %s;

	private function __construct()
	{
	}

}

PHP;
    public function activate(Composer $composer, IOInterface $io) : void
    {
        // noop
    }
    public function deactivate(Composer $composer, IOInterface $io) : void
    {
        // noop
    }
    public function uninstall(Composer $composer, IOInterface $io) : void
    {
        // noop
    }
    /**
     * @return array<string, string>
     */
    public static function getSubscribedEvents() : array
    {
        return [ScriptEvents::POST_INSTALL_CMD => 'process', ScriptEvents::POST_UPDATE_CMD => 'process'];
    }
    public function process(Event $event) : void
    {
        $io = $event->getIO();
        if (!file_exists(__DIR__)) {
            $io->write('<info>phpstan/extension-installer:</info> Package not found (probably scheduled for removal); extensions installation skipped.');
            return;
        }
        $composer = $event->getComposer();
        $installationManager = $composer->getInstallationManager();
        $generatedConfigFilePath = __DIR__ . '/GeneratedConfig.php';
        $oldGeneratedConfigFileHash = null;
        if (is_file($generatedConfigFilePath)) {
            $oldGeneratedConfigFileHash = md5_file($generatedConfigFilePath);
        }
        $notInstalledPackages = [];
        $installedPackages = [];
        $data = [];
        $fs = new Filesystem();
        foreach ($composer->getRepositoryManager()->getLocalRepository()->getPackages() as $package) {
            if ($package->getType() !== 'phpstan-extension' && !isset($package->getExtra()['phpstan'])) {
                if (strpos($package->getName(), 'phpstan') !== false && !in_array($package->getName(), ['phpstan/phpstan', 'phpstan/phpstan-shim', 'phpstan/phpdoc-parser', 'phpstan/extension-installer'], true)) {
                    $notInstalledPackages[$package->getName()] = $package->getFullPrettyVersion();
                }
                continue;
            }
            $absoluteInstallPath = $installationManager->getInstallPath($package);
            $data[$package->getName()] = ['install_path' => $absoluteInstallPath, 'relative_install_path' => $fs->findShortestPath(dirname($generatedConfigFilePath), $absoluteInstallPath, true), 'extra' => $package->getExtra()['phpstan'] ?? null, 'version' => $package->getFullPrettyVersion()];
            $installedPackages[$package->getName()] = true;
        }
        ksort($data);
        ksort($installedPackages);
        ksort($notInstalledPackages);
        $generatedConfigFileContents = sprintf(self::$generatedFileTemplate, var_export($data, true), var_export($notInstalledPackages, true));
        file_put_contents($generatedConfigFilePath, $generatedConfigFileContents);
        $io->write('<info>phpstan/extension-installer:</info> Extensions installed');
        if ($oldGeneratedConfigFileHash === md5($generatedConfigFileContents)) {
            return;
        }
        foreach (array_keys($installedPackages) as $name) {
            $io->write(sprintf('> <info>%s:</info> installed', $name));
        }
        foreach (array_keys($notInstalledPackages) as $name) {
            $io->write(sprintf('> <comment>%s:</comment> not supported', $name));
        }
    }
}
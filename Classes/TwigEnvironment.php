<?php

namespace PrototypeIntegration\Twig;

use Twig\Environment;
use Twig\Extension\DebugExtension;
use Twig\Loader\ChainLoader;
use Twig\Loader\FilesystemLoader;
use Twig\Loader\LoaderInterface;
use TYPO3\CMS\Core\Configuration\ExtensionConfiguration;
use TYPO3\CMS\Core\SingletonInterface;
use TYPO3\CMS\Core\Utility\GeneralUtility;

class TwigEnvironment extends Environment implements SingletonInterface
{
    /**
     * @var array
     */
    protected $configuration;

    public function __construct()
    {
        $this->configuration = GeneralUtility::makeInstance(ExtensionConfiguration::class)->get('pti_twig');

        $additionalLoaders = $this->getAdditionalLoaders();
        $loader = new ChainLoader($additionalLoaders);

        $typo3Loader = GeneralUtility::makeInstance(Typo3Loader::class);
        $loader->addLoader($typo3Loader);

        if ($storagePath = $this->getTemplateStoragePath()) {
            $loader->addLoader(new FilesystemLoader($storagePath));
        }

        parent::__construct($loader, [
            // fixme use TYPO3’s cache framework instead of filesystem for caching
            'cache' => $this->configuration['disableCache']? false : static::getCacheDirectory(),
            'debug' => $GLOBALS['TYPO3_CONF_VARS']['FE']['debug'],
        ]);

        if ($this->isDebug()) {
            $this->addExtension(new DebugExtension());
        }
    }

    /**
     * Returns the path to the twig cache directory.
     *
     * @return string
     */
    public static function getCacheDirectory(): string
    {
        return PATH_site.'typo3temp/var/Cache/Code/twig';
    }

    /**
     * @return LoaderInterface[]
     */
    protected function getAdditionalLoaders(): array
    {
        $loaderClasses = $this->configuration['loader'] ?: [];
        $loader = array_map(function (string $loaderClass) {
            return GeneralUtility::makeInstance($loaderClass);
        }, $loaderClasses);

        return $loader;
    }

    /**
     * @return string/null
     */
    protected function getTemplateStoragePath()
    {
        $rootTemplatePath = GeneralUtility::makeInstance(ExtensionConfiguration::class)->get(
            'pti_twig',
            'rootTemplatePath'
        );
        if (!isset($rootTemplatePath)) {
            return null;
        }

        return GeneralUtility::getFileAbsFileName($rootTemplatePath);
    }
}

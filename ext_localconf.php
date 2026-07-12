<?php

defined('TYPO3') or die();

$GLOBALS['TYPO3_CONF_VARS']['EXTENSIONS']['pti_twig']['disableCache'] = false;
$GLOBALS['TYPO3_CONF_VARS']['EXTENSIONS']['pti_twig']['rootTemplatePath'] = '';
$GLOBALS['TYPO3_CONF_VARS']['EXTENSIONS']['pti_twig']['loader'] = [];
$GLOBALS['TYPO3_CONF_VARS']['EXTENSIONS']['pti_twig']['namespaces'] = [];

$GLOBALS['TYPO3_CONF_VARS']['SYS']['caching']['cacheConfigurations']['pti_twig'] ??= [];
$GLOBALS['TYPO3_CONF_VARS']['SYS']['caching']['cacheConfigurations']['pti_twig']['frontend'] ??= \TYPO3\CMS\Core\Cache\Frontend\PhpFrontend::class;
$GLOBALS['TYPO3_CONF_VARS']['SYS']['caching']['cacheConfigurations']['pti_twig']['backend'] ??= \TYPO3\CMS\Core\Cache\Backend\SimpleFileBackend::class;
$GLOBALS['TYPO3_CONF_VARS']['SYS']['caching']['cacheConfigurations']['pti_twig']['options']['defaultLifetime'] ??= 0;
$GLOBALS['TYPO3_CONF_VARS']['SYS']['caching']['cacheConfigurations']['pti_twig']['groups'] ??= ['system'];

$GLOBALS['TYPO3_CONF_VARS']['EXTENSIONS']['pti']['defaultView'] = \PrototypeIntegration\Twig\TwigView::class;

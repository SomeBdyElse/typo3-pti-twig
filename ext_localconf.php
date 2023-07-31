<?php

defined('TYPO3') or die();

$GLOBALS['TYPO3_CONF_VARS']['EXTENSIONS']['pti_twig']['disableCache'] = false;
$GLOBALS['TYPO3_CONF_VARS']['EXTENSIONS']['pti_twig']['rootTemplatePath'] = '';
$GLOBALS['TYPO3_CONF_VARS']['EXTENSIONS']['pti_twig']['loader'] = [];
$GLOBALS['TYPO3_CONF_VARS']['EXTENSIONS']['pti_twig']['namespaces'] = [];

$GLOBALS['TYPO3_CONF_VARS']['EXTENSIONS']['pti']['defaultView'] = \PrototypeIntegration\Twig\TwigView::class;

<?php
defined('TYPO3_MODE') || die();

$GLOBALS['TYPO3_CONF_VARS']['EXTENSIONS']['pti_twig']['disableCache'] = false;
$GLOBALS['TYPO3_CONF_VARS']['EXTENSIONS']['pti_twig']['rootTemplatePath'] = '';
$GLOBALS['TYPO3_CONF_VARS']['EXTENSIONS']['pti_twig']['loader'] = [];

$GLOBALS['TYPO3_CONF_VARS']['EXTENSIONS']['pti']['view']['defaultView'] = \PrototypeIntegration\Twig\TwigView::class;

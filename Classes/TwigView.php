<?php
namespace PrototypeIntegration\Twig;

use PrototypeIntegration\PrototypeIntegration\View\TemplateBasedView;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Mvc\View\AbstractView;
use TYPO3\CMS\Extbase\Mvc\View\ViewInterface;

class TwigView extends AbstractView implements ViewInterface, TemplateBasedView
{
    /**
     * @var TwigEnvironment
     */
    protected $twigEnvironment;

    /**
     * @var string
     */
    protected $template;

    public function __construct(string $template = '')
    {
        $this->template = $template;
        $this->twigEnvironment = GeneralUtility::makeInstance(TwigEnvironment::class);
    }

    public function render(): string
    {
        if (empty($this->template)) {
            throw new \RuntimeException('Template file missing.', 1519205250412);
        }

        try {
            return $this->twigEnvironment->render($this->template, $this->variables);
        } catch (\Exception $exception) {
            throw new \RuntimeException('Twig view error: ' . $exception->getMessage(), 1519205228169, $exception);
        }
    }

    /**
     * @return string
     */
    public function getTemplate(): string
    {
        return $this->template;
    }

    /**
     * @param string $template
     */
    public function setTemplate(string $template): void
    {
        $this->template = $template;
    }

    /**
     * @return array
     */
    public function getVariables(): array
    {
        return $this->variables;
    }

    /**
     * @param array $variables
     */
    public function setVariables(array $variables): void
    {
        $this->variables = $variables;
    }
}

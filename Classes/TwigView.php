<?php

namespace PrototypeIntegration\Twig;

use PrototypeIntegration\PrototypeIntegration\View\PtiViewInterface;
use PrototypeIntegration\PrototypeIntegration\View\TemplateBasedViewInterface;
use TYPO3\CMS\Core\Utility\GeneralUtility;

class TwigView implements PtiViewInterface, TemplateBasedViewInterface
{
    protected TwigEnvironment $twigEnvironment;

    protected string $template;

    protected array $variables = [];

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

    public function getTemplate(): string
    {
        return $this->template;
    }

    public function setTemplate(string $template): void
    {
        $this->template = $template;
    }

    public function getVariables(): array
    {
        return $this->variables;
    }

    public function setVariables(array $variables): void
    {
        $this->variables = $variables;
    }
}

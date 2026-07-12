<?php

namespace PrototypeIntegration\Twig;

use Twig\Cache\CacheInterface;
use Twig\Cache\RemovableCacheInterface;
use TYPO3\CMS\Core\Cache\CacheManager;
use TYPO3\CMS\Core\Cache\Frontend\PhpFrontend;
use TYPO3\CMS\Core\Utility\GeneralUtility;

class TwigCache implements CacheInterface, RemovableCacheInterface
{
    private const CACHE_IDENTIFIER = 'pti_twig';
    private const TIMESTAMP_MARKER = 'pti_twig_timestamp:';

    protected ?PhpFrontend $cache = null;

    public function generateKey(string $name, string $className): string
    {
        return 'twig_' . \hash(\PHP_VERSION_ID < 80100 ? 'sha256' : 'xxh128', $className);
    }

    public function write(string $key, string $content): void
    {
        $content = $this->removeOpeningPhpTag($content);
        $content = '// ' . self::TIMESTAMP_MARKER . ' ' . time() . "\n" . $content;

        $this->getCache()->set($key, $content);
    }

    public function load(string $key): void
    {
        $this->getCache()->requireOnce($key);
    }

    public function getTimestamp(string $key): int
    {
        $backend = $this->getCache()->getBackend();
        if (\is_callable([$backend, 'getCacheDirectory'])) {
            $cacheFile = $backend->getCacheDirectory() . $key . '.php';
            if (\is_file($cacheFile)) {
                return (int)\filemtime($cacheFile);
            }
        }

        $content = $this->getCache()->get($key);
        if (! \is_string($content)) {
            return 0;
        }

        if (\preg_match('/' . \preg_quote(self::TIMESTAMP_MARKER, '/') . '\\s+(\\d+)/', $content, $matches) !== 1) {
            return 0;
        }

        return (int)$matches[1];
    }

    public function remove(string $name, string $cls): void
    {
        $this->getCache()->remove($this->generateKey($name, $cls));
    }

    protected function getCache(): PhpFrontend
    {
        if ($this->cache instanceof PhpFrontend) {
            return $this->cache;
        }

        $cache = GeneralUtility::makeInstance(CacheManager::class)->getCache(self::CACHE_IDENTIFIER);
        if (!$cache instanceof PhpFrontend) {
            throw new \RuntimeException(\sprintf('The "%s" cache must use "%s" as frontend.', self::CACHE_IDENTIFIER, PhpFrontend::class), 1780003901);
        }

        $this->cache = $cache;

        return $this->cache;
    }

    protected function removeOpeningPhpTag(string $content): string
    {
        return (string)\preg_replace('/^<\\?php\\s*/', '', $content, 1);
    }
}

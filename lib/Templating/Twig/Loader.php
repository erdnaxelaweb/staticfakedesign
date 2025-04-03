<?php

declare(strict_types=1);

/*
 * Static Fake Design Bundle.
 *
 * @author    Florian ALEXANDRE
 * @copyright 2023-present Florian ALEXANDRE
 * @license   https://github.com/erdnaxelaweb/staticfakedesign/blob/main/LICENSE
 */

namespace ErdnaxelaWeb\StaticFakeDesign\Templating\Twig;

use Twig\Loader\LoaderInterface;
use Twig\Source;

class Loader implements LoaderInterface
{
    public function __construct(
        protected LoaderInterface $innerLoader
    ) {
    }

    public function getSourceContext(string $name): Source
    {
        $source = $this->innerLoader->getSourceContext($name);
        return $this->replaceFakeComments($source);
    }

    public function getCacheKey(string $name): string
    {
        return $this->innerLoader->getCacheKey($name);
    }

    public function isFresh(string $name, int $time): bool
    {
        return $this->innerLoader->isFresh($name, $time);
    }

    public function exists(string $name): bool
    {
        return $this->innerLoader->exists($name);
    }

    public function replaceFakeComments(Source $source): Source
    {
        $code = $source->getCode();

        $replacer = new CommentReplacer();
        $code = $replacer->replaceInString($code);

        return new Source($code, $source->getName(), $source->getPath());
    }
}

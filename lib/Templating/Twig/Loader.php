<?php
/*
 * DesignBundle.
 *
 * @package   DesignBundle
 *
 * @author    florian
 * @copyright 2018 Novactive
 * @license   https://github.com/Novactive/NovaHtmlIntegrationBundle/blob/master/LICENSE
 */

declare( strict_types=1 );

namespace ErdnaxelaWeb\StaticFakeDesign\Templating\Twig;

use Twig\Loader\LoaderInterface;
use Twig\Source;

class Loader implements LoaderInterface
{

    /**
     * @param \Twig\Loader\LoaderInterface $innerLoader
     */
    public function __construct( protected LoaderInterface $innerLoader )
    {
    }

    public function getSourceContext( string $name ): Source
    {
        $source = $this->innerLoader->getSourceContext($name);
        return $this->replaceFakeComments( $source);
    }

    public function getCacheKey( string $name ): string
    {
        return $this->innerLoader->getCacheKey($name);
    }

    public function isFresh( string $name, int $time ): bool
    {
        return $this->innerLoader->isFresh($name, $time);
    }

    public function exists( string $name )
    {
        return $this->innerLoader->exists($name);
    }

    public function replaceFakeComments( Source $source): Source
    {
        $code = $source->getCode();

        $replacer = new CommentReplacer();
        $code = $replacer->replaceInString($code);

        return new Source($code, $source->getName(), $source->getPath());
    }

}

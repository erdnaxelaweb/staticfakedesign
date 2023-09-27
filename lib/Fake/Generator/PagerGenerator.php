<?php
declare( strict_types=1 );

namespace ErdnaxelaWeb\StaticFakeDesign\Fake\Generator;

use ErdnaxelaWeb\StaticFakeDesign\Fake\AbstractGenerator;
use ErdnaxelaWeb\StaticFakeDesign\Fake\FakerGenerator;
use Pagerfanta\Adapter\CallbackAdapter;
use Pagerfanta\Pagerfanta;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PagerGenerator extends AbstractGenerator
{

    public function __construct(
        protected ContentGenerator $contentGenerator,
        FakerGenerator             $fakerGenerator
    )
    {
        parent::__construct( $fakerGenerator );
    }

    public function configureOptions(OptionsResolver $optionResolver): void
    {
        parent::configureOptions($optionResolver);
        $optionResolver->define('type')
            ->required()
            ->allowedTypes('string')
            ->info('Identifier of the content to generate. See erdnaxelaweb.static_fake_design.content_definition');

        $optionResolver->define('maxPerPage')
            ->default(null)
            ->allowedTypes('int', 'null');

        $optionResolver->define('pagesCount')
            ->default(null)
            ->allowedTypes('int', 'null');

    }

    public function __invoke(string $type, ?int $maxPerPage = null, ?int $pagesCount = null): Pagerfanta
    {
        $maxPerPage = $maxPerPage ?? rand( 1, 10 );
        $pagesCount = $pagesCount ?? rand( 1, 10 );

        $adapter = new CallbackAdapter(
            static function () use ( $maxPerPage, $pagesCount ) {
                return $maxPerPage * $pagesCount;
            },
            function ( $offset, $length ) use ( $type ) {
                $contents = [];
                for ( $i = 0; $i < $length; ++$i )
                {
                    $contents[] = ($this->contentGenerator)( $type );
                }
                return $contents;
            }
        );
        $pager = new Pagerfanta( $adapter );
        $pager->setMaxPerPage( $maxPerPage );

        return $pager;
    }
}

<?php
declare( strict_types=1 );

namespace ErdnaxelaWeb\StaticFakeDesign\Fake\ContentGenerator\Field;


use ErdnaxelaWeb\StaticFakeDesign\Fake\Generator\ContentGenerator;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ContentFieldGenerator extends AbstractFieldGenerator
{

    public function __construct( protected ContentGenerator $contentGenerator )
    {
    }

    public function configureOptions(OptionsResolver $optionResolver): void
    {
        parent::configureOptions($optionResolver);
        $optionResolver->define('type')
            ->required()
            ->allowedTypes('string');

        $optionResolver->define('max')
            ->default(1)
            ->allowedTypes('int');

    }

    /**
     * @throws \ErdnaxelaWeb\StaticFakeDesign\Exception\ConfigurationNotFoundException
     */
    public function __invoke( string $type, int $max = 1 )
    {
        if($max === 1){
            return ($this->contentGenerator)($type);
        }

        $contents = [];
        $count = rand(1, $max);
        for ($i = 0; $i < $count; ++$i) {
            $contents[] = ($this->contentGenerator)($type);
        }

        return $contents;
    }
}

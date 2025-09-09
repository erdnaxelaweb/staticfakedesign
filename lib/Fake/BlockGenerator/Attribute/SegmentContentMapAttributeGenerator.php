<?php
/*
 * Static Fake Design Bundle.
 *
 * @author    Florian ALEXANDRE
 * @copyright 2023-present Florian ALEXANDRE
 * @license   https://github.com/erdnaxelaweb/staticfakedesign/blob/main/LICENSE
 */

declare( strict_types=1 );

namespace ErdnaxelaWeb\StaticFakeDesign\Fake\BlockGenerator\Attribute;

use ErdnaxelaWeb\StaticFakeDesign\Fake\Generator\ContentGenerator;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SegmentContentMapAttributeGenerator extends AbstractAttributeGenerator
{
    public function __construct(
        protected ContentGenerator $contentGenerator
    ) {
    }

    public function configureOptions(OptionsResolver $optionsResolver): void
    {
        parent::configureOptions($optionsResolver);
        $optionsResolver->define('type')
                        ->required()
                        ->allowedTypes('string', 'string[]');
    }

    public function __invoke($type, int $max = 1)
    {
        return ($this->contentGenerator)($type);
    }
}

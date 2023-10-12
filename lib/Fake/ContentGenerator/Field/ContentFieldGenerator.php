<?php
/*
 * staticfakedesignbundle.
 *
 * @package   DesignBundle
 *
 * @author    florian
 * @copyright 2023-present Florian ALEXANDRE
 * @license   https://github.com/erdnaxelaweb/staticfakedesign/blob/main/LICENSE
 */

declare(strict_types=1);

namespace ErdnaxelaWeb\StaticFakeDesign\Fake\ContentGenerator\Field;

use ErdnaxelaWeb\StaticFakeDesign\Fake\Generator\ContentGenerator;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ContentFieldGenerator extends AbstractFieldGenerator
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

        $optionsResolver->define('max')
            ->default(1)
            ->allowedTypes('int');
    }

    public function __invoke($type, int $max = 1)
    {
        if ($max === 1) {
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

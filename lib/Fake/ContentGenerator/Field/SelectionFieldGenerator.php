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

use ErdnaxelaWeb\StaticFakeDesign\Fake\FakerGenerator;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SelectionFieldGenerator extends AbstractFieldGenerator
{
    public function __construct(
        protected FakerGenerator $fakerGenerator
    ) {
    }

    public function configureOptions(OptionsResolver $optionsResolver): void
    {
        parent::configureOptions($optionsResolver);
        $optionsResolver->define('options')
            ->required()
            ->allowedTypes('string[]');

        $optionsResolver->define('isMultiple')
            ->default(false)
            ->allowedTypes('bool');
    }

    public function __invoke(array $options, bool $isMultiple = false): array
    {
        $count = $isMultiple ? $this->fakerGenerator->numberBetween(1, count($options)) : 1;
        $selection = $this->fakerGenerator->randomElements(array_keys($options), $count, false);

        return array_intersect_key($options, array_flip($selection));
    }
}

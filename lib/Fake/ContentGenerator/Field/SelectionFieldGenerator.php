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

    public function configureOptions(OptionsResolver $optionResolver): void
    {
        parent::configureOptions($optionResolver);
        $optionResolver->define('options')
            ->required()
            ->allowedTypes('string[]');

        $optionResolver->define('isMultiple')
            ->default(false)
            ->allowedTypes('bool');
    }

    public function __invoke(array $options, bool $isMultiple = false): array
    {
        $count = $isMultiple ? $this->fakerGenerator->numberBetween(1, count($options)) : 1;
        return $this->fakerGenerator->randomElements($options, $count, false);
    }
}

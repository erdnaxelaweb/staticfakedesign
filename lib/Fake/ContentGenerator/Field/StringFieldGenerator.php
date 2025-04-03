<?php

declare(strict_types=1);

/*
 * Static Fake Design Bundle.
 *
 * @author    Florian ALEXANDRE
 * @copyright 2023-present Florian ALEXANDRE
 * @license   https://github.com/erdnaxelaweb/staticfakedesign/blob/main/LICENSE
 */

namespace ErdnaxelaWeb\StaticFakeDesign\Fake\ContentGenerator\Field;

use ErdnaxelaWeb\StaticFakeDesign\Fake\FakerGenerator;
use Symfony\Component\OptionsResolver\OptionsResolver;

class StringFieldGenerator extends AbstractFieldGenerator
{
    public function __construct(
        protected FakerGenerator $fakerGenerator
    ) {
    }

    public function __invoke(int $maxLength = 100): string
    {
        return $this->fakerGenerator->text($maxLength);
    }

    public function configureOptions(OptionsResolver $optionsResolver): void
    {
        parent::configureOptions($optionsResolver);

        $optionsResolver->define('maxLength')
            ->default(100)
            ->allowedTypes('int');
    }

    /**
     * @param string|string[] $value
     */
    public function getForcedValue(mixed $value): string
    {
        return is_array($value) ? $this->fakerGenerator->randomElement($value) : $value;
    }
}

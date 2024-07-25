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

class TextFieldGenerator extends AbstractFieldGenerator
{
    public function __construct(
        protected FakerGenerator $fakerGenerator
    ) {
    }

    public function configureOptions(OptionsResolver $optionsResolver): void
    {
        parent::configureOptions($optionsResolver);
        $optionsResolver->define('max')
            ->default(10)
            ->allowedTypes('int');
    }

    public function __invoke(int $max = 10): string
    {
        $count = rand(1, $max);
        $paragraphes = $this->fakerGenerator->paragraphs($count);

        return new class (implode(PHP_EOL, $paragraphes))
        {
            public string $rawText;
            public function __construct(string $text)
            {
                $this->rawText = $text;
            }

            public function __toString(): string
            {
                return sprintf('<p>%s</p>', nl2br($this->rawText));
            }
        };
    }
}

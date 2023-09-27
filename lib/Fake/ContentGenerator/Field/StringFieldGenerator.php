<?php
declare( strict_types=1 );

namespace ErdnaxelaWeb\StaticFakeDesign\Fake\ContentGenerator\Field;

use ErdnaxelaWeb\StaticFakeDesign\Fake\FakerGenerator;
use Symfony\Component\OptionsResolver\OptionsResolver;

class StringFieldGenerator extends AbstractFieldGenerator
{

    /**
     * @param \ErdnaxelaWeb\StaticFakeDesign\Fake\FakerGenerator $fakerGenerator
     */
    public function __construct( protected FakerGenerator $fakerGenerator )
    {
    }

    public function configureOptions(OptionsResolver $optionResolver): void
    {
        parent::configureOptions($optionResolver);

        $optionResolver->define('maxLength')
            ->default(255)
            ->allowedTypes('int');

    }

    public function __invoke(int $maxLength = 255): string
    {
        return $this->fakerGenerator->text($maxLength);
    }
}

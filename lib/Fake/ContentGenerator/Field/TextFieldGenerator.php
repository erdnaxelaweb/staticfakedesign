<?php
declare( strict_types=1 );

namespace ErdnaxelaWeb\StaticFakeDesign\Fake\ContentGenerator\Field;

use ErdnaxelaWeb\StaticFakeDesign\Fake\FakerGenerator;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TextFieldGenerator extends AbstractFieldGenerator
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
        $optionResolver->define('maxRows')
            ->default(10)
            ->allowedTypes('int');

    }

    public function __invoke( int $maxRows = 10): string
    {
        $count = rand(1,$maxRows);
        $paragraphes = $this->fakerGenerator->paragraphs($count);

        return sprintf('<p>%s</p>', implode('<br/>', $paragraphes));
    }

}

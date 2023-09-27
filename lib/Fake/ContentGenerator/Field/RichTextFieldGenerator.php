<?php
declare( strict_types=1 );

namespace ErdnaxelaWeb\StaticFakeDesign\Fake\ContentGenerator\Field;


use ErdnaxelaWeb\StaticFakeDesign\Fake\Generator\RichTextGenerator;

class RichTextFieldGenerator extends AbstractFieldGenerator
{

    /**
     * @param \ErdnaxelaWeb\StaticFakeDesign\Fake\Generator\RichTextGenerator $richTextGenerator
     */
    public function __construct( protected RichTextGenerator $richTextGenerator )
    {
    }


    public function __invoke( ): string
    {
        return ($this->richTextGenerator)();
    }
}

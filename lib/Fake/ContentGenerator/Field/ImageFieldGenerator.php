<?php
declare( strict_types=1 );

namespace ErdnaxelaWeb\StaticFakeDesign\Fake\ContentGenerator\Field;

use ErdnaxelaWeb\StaticFakeDesign\Fake\Generator\ImageGenerator;

class ImageFieldGenerator extends AbstractFieldGenerator
{

    /**
     * @param \ErdnaxelaWeb\StaticFakeDesign\Fake\Generator\ImageGenerator $imageGenerator
     */
    public function __construct( protected ImageGenerator $imageGenerator )
    {
    }

    public function __invoke(): ImageGenerator
    {
        return $this->imageGenerator;
    }
}

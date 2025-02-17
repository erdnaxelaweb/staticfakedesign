<?php

namespace ErdnaxelaWeb\StaticFakeDesign\Fake\BlockGenerator\Attribute;

use ErdnaxelaWeb\StaticFakeDesign\Fake\FakerGenerator;

class BooleanAttributeGenerator extends AbstractAttributeGenerator
{
    public function __construct(
        protected FakerGenerator $fakerGenerator
    ) {
    }

    public function __invoke(): bool
    {
        return $this->fakerGenerator->boolean();
    }
}

<?php

namespace ErdnaxelaWeb\StaticFakeDesign\Fake\BlockGenerator\Attribute;

class BooleanAttributeGenerator extends AbstractAttributeGenerator
{
    public function __invoke(): bool
    {
        return $this->fakerGenerator->boolean();
    }
}

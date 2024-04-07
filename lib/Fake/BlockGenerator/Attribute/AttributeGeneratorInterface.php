<?php

namespace ErdnaxelaWeb\StaticFakeDesign\Fake\BlockGenerator\Attribute;

use ErdnaxelaWeb\StaticFakeDesign\Fake\GeneratorInterface;

interface AttributeGeneratorInterface extends GeneratorInterface
{
    public function getForcedValue($value);
}

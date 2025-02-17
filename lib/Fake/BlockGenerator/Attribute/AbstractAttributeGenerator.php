<?php

namespace ErdnaxelaWeb\StaticFakeDesign\Fake\BlockGenerator\Attribute;

use ErdnaxelaWeb\StaticFakeDesign\Fake\AbstractGenerator;

abstract class AbstractAttributeGenerator extends AbstractGenerator implements AttributeGeneratorInterface
{
    public function getForcedValue($value)
    {
        return $value;
    }
}

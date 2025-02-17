<?php

namespace ErdnaxelaWeb\StaticFakeDesign\Fake\ContentGenerator\Field;

use ErdnaxelaWeb\StaticFakeDesign\Fake\FakerGenerator;
use ErdnaxelaWeb\StaticFakeDesign\Fake\Generator\LinkGenerator;
use Knp\Menu\MenuItem;

class UrlFieldGenerator extends AbstractFieldGenerator
{
    public function __construct(
        protected FakerGenerator $fakerGenerator,
        protected LinkGenerator $linkGenerator
    ) {
    }

    public function __invoke(): MenuItem
    {
        return ($this->linkGenerator)();
    }
}

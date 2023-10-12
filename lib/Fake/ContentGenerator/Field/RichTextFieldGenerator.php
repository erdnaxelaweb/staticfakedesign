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

use ErdnaxelaWeb\StaticFakeDesign\Fake\Generator\RichTextGenerator;

class RichTextFieldGenerator extends AbstractFieldGenerator
{
    public function __construct(
        protected RichTextGenerator $richTextGenerator
    ) {
    }

    public function __invoke(): string
    {
        return ($this->richTextGenerator)();
    }
}

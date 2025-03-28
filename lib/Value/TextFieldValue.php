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

namespace ErdnaxelaWeb\StaticFakeDesign\Value;

class TextFieldValue extends StringableValue
{
    public function __construct(
        public string $rawText
    ) {
    }

    public function __toString(): string
    {
        return sprintf('<p>%s</p>', nl2br($this->rawText));
    }
}

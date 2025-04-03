<?php

declare(strict_types=1);

/*
 * Static Fake Design Bundle.
 *
 * @author    Florian ALEXANDRE
 * @copyright 2023-present Florian ALEXANDRE
 * @license   https://github.com/erdnaxelaweb/staticfakedesign/blob/main/LICENSE
 */

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

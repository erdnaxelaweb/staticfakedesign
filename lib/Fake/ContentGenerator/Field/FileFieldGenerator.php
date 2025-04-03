<?php

declare(strict_types=1);

/*
 * Static Fake Design Bundle.
 *
 * @author    Florian ALEXANDRE
 * @copyright 2023-present Florian ALEXANDRE
 * @license   https://github.com/erdnaxelaweb/staticfakedesign/blob/main/LICENSE
 */

namespace ErdnaxelaWeb\StaticFakeDesign\Fake\ContentGenerator\Field;

use ErdnaxelaWeb\StaticFakeDesign\Fake\FakerGenerator;
use ErdnaxelaWeb\StaticFakeDesign\Value\File;

class FileFieldGenerator extends AbstractFieldGenerator
{
    public function __construct(
        protected FakerGenerator $fakerGenerator
    ) {
    }

    public function __invoke(): File
    {
        return new File(
            "{$this->fakerGenerator->uuid()}.{$this->fakerGenerator->fileExtension()}",
            $this->fakerGenerator->randomNumber(),
            $this->fakerGenerator->mimeType(),
            $this->fakerGenerator->url()
        );
    }
}

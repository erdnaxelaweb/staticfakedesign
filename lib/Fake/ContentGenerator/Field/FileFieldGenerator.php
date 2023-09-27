<?php
/*
 * DesignBundle.
 *
 * @package   DesignBundle
 *
 * @author    florian
 * @copyright 2018 Novactive
 * @license   https://github.com/Novactive/NovaHtmlIntegrationBundle/blob/master/LICENSE
 */

declare( strict_types=1 );

namespace ErdnaxelaWeb\StaticFakeDesign\Fake\ContentGenerator\Field;

use ErdnaxelaWeb\StaticFakeDesign\Fake\FakerGenerator;
use ErdnaxelaWeb\StaticFakeDesign\Value\File;

class FileFieldGenerator extends AbstractFieldGenerator
{

    public function __construct(
        protected FakerGenerator $fakerGenerator
    )
    {
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

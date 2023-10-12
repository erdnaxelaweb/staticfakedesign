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

use ErdnaxelaWeb\StaticFakeDesign\Fake\Generator\ImageGenerator;

class ImageFieldGenerator extends AbstractFieldGenerator
{
    public function __construct(
        protected ImageGenerator $imageGenerator
    ) {
    }

    public function __invoke(): ImageGenerator
    {
        return $this->imageGenerator;
    }
}

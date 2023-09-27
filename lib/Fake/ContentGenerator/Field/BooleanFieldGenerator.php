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

class BooleanFieldGenerator extends AbstractFieldGenerator
{

    public function __construct(
        protected FakerGenerator $fakerGenerator
    )
    {
    }

    public function __invoke(): bool
    {
        return $this->fakerGenerator->boolean();
    }
}

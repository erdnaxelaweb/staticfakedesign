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

use ErdnaxelaWeb\StaticFakeDesign\Fake\Generator\CoordinatesGenerator;
use ErdnaxelaWeb\StaticFakeDesign\Value\Coordinates;

class LocationFieldGenerator extends AbstractFieldGenerator
{

    public function __construct( protected CoordinatesGenerator $coordinatesGenerator )
    {
    }

    public function __invoke(): Coordinates
    {
        return ( $this->coordinatesGenerator )();
    }
}

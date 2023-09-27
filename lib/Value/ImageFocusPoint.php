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

namespace ErdnaxelaWeb\StaticFakeDesign\Value;

class ImageFocusPoint
{
    /**
     * FocusPoint constructor.
     */
    public function __construct( public readonly float $posX = 0.0, public readonly float $posY = 0.0 )
    {
    }
}

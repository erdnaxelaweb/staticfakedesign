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

namespace ErdnaxelaWeb\StaticFakeDesign\Fake;

use Faker\Generator as BaseGenerator;

class FakerGenerator extends BaseGenerator
{
    protected array $imageProviderParameters = [];

    /**
     * @param array $imageProviderParameters
     */
    public function __construct( array $imageProviderParameters )
    {
        $this->imageProviderParameters = $imageProviderParameters;
        parent::__construct();
    }

    public function imagePlaceholder( int $width, int $height )
    {
        return $this->__call('imageUrl', ['width' => $width, 'height' => $height, ...$this->imageProviderParameters]);
    }
}

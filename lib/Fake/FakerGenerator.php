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

declare(strict_types=1);

namespace ErdnaxelaWeb\StaticFakeDesign\Fake;

use Faker\Generator as BaseGenerator;
use ReflectionMethod;

class FakerGenerator extends BaseGenerator
{
    protected array $imageProviderParameters = [];

    /**
     * @param array $imageProviderParameters
     */
    public function __construct(array $imageProviderParameters)
    {
        $this->imageProviderParameters = $imageProviderParameters;
        parent::__construct();
    }

    public function imagePlaceholder(int $width, int $height, $id)
    {
        $method = new ReflectionMethod($this->getFormatter('imageUrl')[0], 'imageUrl');
        $parameters = ['width' => $width, 'height' => $height, ...$this->imageProviderParameters];
        if (!empty(array_filter(
            $method->getParameters(),
            function (\ReflectionParameter $reflectionParameter) {
                return $reflectionParameter->getName() === "id";
            }))) {
            $parameters['id'] = $id;
        }
        return $this->__call('imageUrl', $parameters);
    }
}

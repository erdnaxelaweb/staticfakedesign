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

namespace ErdnaxelaWeb\StaticFakeDesign\Fake;

use Faker\Generator as BaseGenerator;
use ReflectionMethod;

class FakerGenerator extends BaseGenerator
{
    protected array $imageProviderParameters = [];

    public function __construct(array $imageProviderParameters)
    {
        $this->imageProviderParameters = $imageProviderParameters;
        parent::__construct();
    }

    public function imagePlaceholder(int $width, int $height, $id)
    {
        $method = new ReflectionMethod($this->getFormatter('imageUrl')[0], 'imageUrl');
        $parameters = [
            'width' => $width,
            'height' => $height,
            ...$this->imageProviderParameters,
        ];
        if (! empty(array_filter(
            $method->getParameters(),
            function (\ReflectionParameter $reflectionParameter) {
                return $reflectionParameter->getName() === "id";
            }
        ))) {
            $parameters['id'] = $id;
        }
        return $this->__call('imageUrl', $parameters);
    }

    public function smallString(int $maxLength = 100): string
    {
        return $this->text($maxLength);
    }

    public function string(int $maxLength = 255): string
    {
        return $this->text($maxLength);
    }
}

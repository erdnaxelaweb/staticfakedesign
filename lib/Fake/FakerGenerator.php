<?php

declare(strict_types=1);

/*
 * Static Fake Design Bundle.
 *
 * @author    Florian ALEXANDRE
 * @copyright 2023-present Florian ALEXANDRE
 * @license   https://github.com/erdnaxelaweb/staticfakedesign/blob/main/LICENSE
 */

namespace ErdnaxelaWeb\StaticFakeDesign\Fake;

use Faker\Generator as BaseGenerator;
use ReflectionMethod;
use ReflectionParameter;

class FakerGenerator extends BaseGenerator
{
    /**
     * @var array<string, mixed>
     */
    protected array $imageProviderParameters = [];

    /**
     * @param array<string, mixed> $imageProviderParameters
     */
    public function __construct(array $imageProviderParameters)
    {
        $this->imageProviderParameters = $imageProviderParameters;
        parent::__construct();
    }

    public function imagePlaceholder(int $width, int $height, string|int|null $id = null): string
    {
        $method = new ReflectionMethod($this->getFormatter('imageUrl')[0], 'imageUrl');
        $parameters = [
            'width' => $width,
            'height' => $height,
            ...$this->imageProviderParameters,
        ];
        if ($id && !empty(
            array_filter(
                $method->getParameters(),
                function (ReflectionParameter $reflectionParameter) {
                    return $reflectionParameter->getName() === "id";
                }
            )
        )) {
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

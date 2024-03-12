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

namespace ErdnaxelaWeb\StaticFakeDesign\Component;

use ErdnaxelaWeb\StaticFakeDesign\Value\ComponentParameterType;

class ComponentParameterTypeParser
{
    public function fromString(string $typeExpression): ComponentParameterType
    {
        preg_match('/(\w+)(?:\(([^)]+)\))?(?:\[(\d*)\])?/', $typeExpression, $matches);

        $fakeParameters = $matches[2] ?? null;
        if ($fakeParameters === null || ! str_starts_with($fakeParameters, "{")) {
            $fakeParameters = sprintf('[%s]', $fakeParameters);
        }
        return new ComponentParameterType(
            $typeExpression,
            $matches[1],
            json_decode($fakeParameters, true, 512, JSON_THROW_ON_ERROR),
            isset($matches[3]),
            $matches[3] ?? null,
        );
    }
}

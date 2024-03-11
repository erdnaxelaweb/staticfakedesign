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

namespace ErdnaxelaWeb\StaticFakeDesign\Fake;

class FakeTypeMatcher
{
    public function __invoke(string $type): array
    {
        preg_match('/(\w+)(?:\(([^)]+)\))?(?:\[(\d*)\])?/', $type, $matches);

        $fakeParameters = $matches[2] ?? null;
        if ($fakeParameters === null || strpos($fakeParameters, "{") !== 0) {
            $fakeParameters = sprintf('[%s]', $fakeParameters);
        }
        return [
            "fake_type" => $matches[1],
            "fake_parameters" => json_decode($fakeParameters, true, 512, JSON_THROW_ON_ERROR),
            "is_array" => isset($matches[3]),
            "array_size" => $matches[3] ?? null,
        ];
    }
}

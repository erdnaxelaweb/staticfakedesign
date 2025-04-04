<?php

declare(strict_types=1);

/*
 * Static Fake Design Bundle.
 *
 * @author    Florian ALEXANDRE
 * @copyright 2023-present Florian ALEXANDRE
 * @license   https://github.com/erdnaxelaweb/staticfakedesign/blob/main/LICENSE
 */

namespace ErdnaxelaWeb\StaticFakeDesign\Fake\ContentGenerator\Field;

use Symfony\Component\OptionsResolver\OptionsResolver;

class SvgFieldGenerator extends AbstractFieldGenerator
{
    public function __invoke(
        int $width = 200,
        int $height = 200,
        int $numShapes = 10
    ): string {
        // Start the SVG file
        $svg = '<svg width="' . $width . '" height="' . $height . '" xmlns="http://www.w3.org/2000/svg">';

        for ($i = 0; $i < $numShapes; $i++) {
            // Random shape type: 0 for circle, 1 for rectangle
            $shapeType = mt_rand(0, 1);

            if ($shapeType === 0) {
                // Circle
                $cx = $this->randomPosition(0, $width);
                $cy = $this->randomPosition(0, $height);
                $r = $this->randomPosition(10, 50);
                $color = $this->randomColor();
                $svg .= '<circle cx="' . $cx . '" cy="' . $cy . '" r="' . $r . '" fill="' . $color . '" />';
            } else {
                // Rectangle
                $x = $this->randomPosition(0, $width);
                $y = $this->randomPosition(0, $height);
                $widthRect = $this->randomPosition(10, 50);
                $heightRect = $this->randomPosition(10, 50);
                $color = $this->randomColor();
                $svg .= '<rect x="' . $x . '" y="' . $y . '" width="' . $widthRect . '" height="' . $heightRect . '" fill="' . $color . '" />';
            }
        }

        // End the SVG file
        $svg .= '</svg>';
        return $svg;
    }
    public function configureOptions(OptionsResolver $optionsResolver): void
    {
        parent::configureOptions($optionsResolver);
        $optionsResolver->define('width')
            ->default(200)
            ->allowedTypes('int');
        $optionsResolver->define('height')
            ->default(200)
            ->allowedTypes('int');
        $optionsResolver->define('numShapes')
            ->default(10)
            ->allowedTypes('int');
    }

    protected function randomColor(): string
    {
        return sprintf('#%06X', mt_rand(0, 0xFFFFFF));
    }

    protected function randomPosition(int $min, int $max): int
    {
        return mt_rand($min, $max);
    }
}

<?php

declare(strict_types=1);

/*
 * Static Fake Design Bundle.
 *
 * @author    Florian ALEXANDRE
 * @copyright 2023-present Florian ALEXANDRE
 * @license   https://github.com/erdnaxelaweb/staticfakedesign/blob/main/LICENSE
 */

namespace ErdnaxelaWeb\StaticFakeDesign\Configuration;

use ErdnaxelaWeb\StaticFakeDesign\Definition\ImageVariationSourceDefinition;
use ErdnaxelaWeb\StaticFakeDesign\Exception\VariationConfigurationNotFoundException;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * @phpstan-type breakpoint array{suffix: string, media: string, previewSize: string, use_webp: bool|string}
 * @phpstan-type variation array<array{0: int|null, 1: int|null}>
 */
class ImageConfiguration
{
    public const FORCE_WEBP = 'force';

    /**
     * @var array<breakpoint>
     */
    protected array $breakpoints = [];

    /**
     * @var array<string, variation>
     */
    protected array $variations = [];

    /**
     * @var array{breakpoints: array<breakpoint>, variations: array<string, variation>}
     */
    protected array $configuration;

    /**
     * @param array{breakpoints: array<array{suffix: string, media: string, previewSize?: string, use_webp?: bool|string}>, variations: array<string, variation>} $configuration
     */
    public function __construct(array $configuration)
    {
        $this->configuration = $configuration;
        $optionsResolver = new OptionsResolver();
        $optionsResolver->setDefault('breakpoints', function (OptionsResolver $breakpointsOptionsResolver): void {
            $breakpointsOptionsResolver->setPrototype(true);
            $this->configureBreakpointsOptions($breakpointsOptionsResolver);
        });
        $optionsResolver->define('variations')
                        ->default([])->allowedTypes('array');

        $this->configuration = $optionsResolver->resolve($configuration);
    }

    /**
     * @return array<breakpoint>
     */
    public function getBreakpoints(): array
    {
        return $this->configuration['breakpoints'];
    }

    /**
     * @return array<string, variation>
     */
    public function getVariations(): array
    {
        return $this->configuration['variations'];
    }

    /**
     * @param array<string, variation> $variations
     */
    public function setVariations(array $variations): void
    {
        $this->configuration['variations'] = $variations;
    }

    /**
     * Get the configuration for a specific variation.
     *
     * @param string $variationName The name of the variation
     *
     * @return ImageVariationSourceDefinition[] The configuration for the variation
     */
    public function getVariationConfig(string $variationName): array
    {
        $variations = $this->getVariations();
        if (!isset($variations[$variationName])) {
            throw new VariationConfigurationNotFoundException($variationName);
        }
        $sizes = $variations[$variationName];
        $config = [];

        $breakpoints = $this->getBreakpoints();
        foreach ($sizes as $i => $size) {
            $breakpoint = $breakpoints[$i];
            if ($breakpoint['use_webp'] !== self::FORCE_WEBP) {
                $config[] = new ImageVariationSourceDefinition(
                    $breakpoint['suffix'],
                    $size[0],
                    $size[1],
                    $breakpoint['media']
                );
            }
            if (in_array($breakpoint['use_webp'], [true, self::FORCE_WEBP], true)) {
                $config[] = new ImageVariationSourceDefinition(
                    $breakpoint['suffix'] . '_webp',
                    $size[0],
                    $size[1],
                    $breakpoint['media']
                );
            }
        }

        return $config;
    }

    protected function configureBreakpointsOptions(OptionsResolver $optionsResolver): void
    {
        $optionsResolver->define('suffix')
            ->required()
            ->allowedTypes('string');
        $optionsResolver->define('media')
            ->required()
            ->allowedTypes('string');
        $optionsResolver->define('previewSize')
            ->default('100%')
            ->allowedTypes('string');
        $optionsResolver->define('use_webp')
            ->default(true)
            ->allowedValues(true, false, self::FORCE_WEBP);
    }

    /**
     * @param array<breakpoint> $breakpoints
     *
     * @return array<breakpoint>
     */
    protected function resolveBreakPoints(array $breakpoints): array
    {
        $optionsResolver = new OptionsResolver();
        $this->configureBreakpointsOptions($optionsResolver);
        return $optionsResolver->resolve($breakpoints);
    }
}

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

namespace ErdnaxelaWeb\StaticFakeDesign\Fake\ContentGenerator\Field;

use ErdnaxelaWeb\StaticFakeDesign\Fake\FakerGenerator;
use ErdnaxelaWeb\StaticFakeDesign\Fake\Generator\BlockGenerator;
use Symfony\Component\OptionsResolver\OptionsResolver;

class BlocksFieldGenerator extends AbstractFieldGenerator
{
    public function __construct(
        protected BlockGenerator $blockGenerator,
        protected FakerGenerator $fakerGenerator
    ) {
    }

    public function configureOptions(OptionsResolver $optionsResolver): void
    {
        parent::configureOptions($optionsResolver);
        $optionsResolver->define('allowedTypes')
            ->required()
            ->allowedTypes('string[]');
    }

    public function __invoke(array $allowedTypes): array
    {
        $count = $this->fakerGenerator->numberBetween(1, 10);
        $blocks = [];
        for ($i = 0; $i < $count; $i++) {
            $type = $this->fakerGenerator->randomElement($allowedTypes);
            $blocks[] = ($this->blockGenerator)($type);
        }
        return $blocks;
    }
}

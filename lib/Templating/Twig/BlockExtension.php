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

namespace ErdnaxelaWeb\StaticFakeDesign\Templating\Twig;

use ErdnaxelaWeb\StaticFakeDesign\Configuration\BlockLayoutConfigurationManager;
use ErdnaxelaWeb\StaticFakeDesign\Value\Block;
use ErdnaxelaWeb\StaticFakeDesign\Value\Layout;
use Symfony\Component\HttpFoundation\RequestStack;
use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

class BlockExtension extends AbstractExtension
{
    public function __construct(
        protected BlockLayoutConfigurationManager $blockLayoutConfigurationManager,
        protected RequestStack $requestStack
    ) {
    }

    public function getFilters(): array
    {
        return [new TwigFilter('group_blocks_by_section', [$this, 'groupBlocksBySection'])];
    }

    /**
     * @param \ErdnaxelaWeb\StaticFakeDesign\Value\Block[] $blocks
     * @return list<array{identifier: string, template: string, blocks: Block[]}>
     */
    public function groupBlocksBySection(array $blocks, Layout $layout): array
    {
        $sections = [];
        /** @var array{identifier: string, template: string, blocks: Block[]}|null $currentSection */
        $currentSection = null;
        /** @var array{identifier: string, template: string, blocks: Block[]}|null $previousSection */
        $previousSection = null;

        foreach ($blocks as $block) {
            $blockSection = $this->getBlockSection($block, $layout->sections);

            if ($currentSection && $currentSection['identifier'] !== $blockSection['identifier']) {
                $previousSection = $currentSection;
                $sections[] = $previousSection;
                $currentSection = null;
            }

            if (null === $currentSection) {
                $currentSection = $blockSection;
            }

            $currentSection['blocks'][] = $block;
        }

        if (null !== $currentSection) {
            $sections[] = $currentSection;
        }

        return $sections;
    }

    /**
     * @param array<string,array{blocks: string[], template: string}> $blockSections
     * @return array{identifier: string, template: string, blocks: Block[]}
     */
    protected function getBlockSection(Block $block, array $blockSections): array
    {
        if (! $this->inEditorialMode()) {
            foreach ($blockSections as $blockSectionId => $blockSection) {
                if (
                    in_array($block->type, $blockSection['blocks']) ||
                    in_array(sprintf('%s/%s', $block->type, $block->view), $blockSection['blocks'])
                ) {
                    return $this->getNewSection($blockSectionId, $blockSection['template']);
                }
            }
        }
        return $this->getNewSection('default', $blockSections['default']['template']);
    }

    /**
     * @return array{identifier: string, template: string, blocks: Block[]}
     */
    protected function getNewSection(string $identifier, string $template): array
    {
        return [
            'identifier' => $identifier,
            'template' => $template,
            'blocks' => [],
        ];
    }

    /**
     * Determines if the application is in editorial mode based on the 'editorial_mode' request attribute.
     *
     * @return bool True if in editorial mode, false otherwise.
     */
    private function inEditorialMode(): bool
    {
        $masterRequest = $this->requestStack->getMainRequest();

        return (bool) $masterRequest->attributes->get('editorial_mode', false);
    }
}

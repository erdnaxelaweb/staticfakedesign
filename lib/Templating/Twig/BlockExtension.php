<?php

declare(strict_types=1);

/*
 * Static Fake Design Bundle.
 *
 * @author    Florian ALEXANDRE
 * @copyright 2023-present Florian ALEXANDRE
 * @license   https://github.com/erdnaxelaweb/staticfakedesign/blob/main/LICENSE
 */

namespace ErdnaxelaWeb\StaticFakeDesign\Templating\Twig;

use ErdnaxelaWeb\StaticFakeDesign\Definition\BlockLayoutSectionDefinition;
use ErdnaxelaWeb\StaticFakeDesign\Value\Block;
use ErdnaxelaWeb\StaticFakeDesign\Value\Layout;
use Symfony\Component\HttpFoundation\RequestStack;
use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

class BlockExtension extends AbstractExtension
{
    public function __construct(
        protected RequestStack $requestStack
    ) {
    }

    public function getFilters(): array
    {
        return [new TwigFilter('group_blocks_by_section', [$this, 'groupBlocksBySection'])];
    }

    /**
     * @param \ErdnaxelaWeb\StaticFakeDesign\Value\Block[] $blocks
     *
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
     * @param array<string, BlockLayoutSectionDefinition> $blockSections
     *
     * @return array{identifier: string, template: string, blocks: Block[]}
     */
    protected function getBlockSection(Block $block, array $blockSections): array
    {
        if (!$this->inEditorialMode()) {
            foreach ($blockSections as $blockSectionId => $blockSection) {
                if (
                    in_array($block->type, $blockSection->getBlocksIdentifier(), true) ||
                    in_array(sprintf('%s/%s', $block->type, $block->view), $blockSection->getBlocksIdentifier(), true)
                ) {
                    return $this->getNewSection($blockSectionId, $blockSection->getTemplate());
                }
            }
        }
        return $this->getNewSection('default', $blockSections['default']->getTemplate());
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

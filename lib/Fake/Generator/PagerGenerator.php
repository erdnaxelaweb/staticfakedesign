<?php

declare(strict_types=1);

/*
 * Static Fake Design Bundle.
 *
 * @author    Florian ALEXANDRE
 * @copyright 2023-present Florian ALEXANDRE
 * @license   https://github.com/erdnaxelaweb/staticfakedesign/blob/main/LICENSE
 */

namespace ErdnaxelaWeb\StaticFakeDesign\Fake\Generator;

use ErdnaxelaWeb\StaticFakeDesign\Configuration\DefinitionManager;
use ErdnaxelaWeb\StaticFakeDesign\Definition\PagerDefinition;
use ErdnaxelaWeb\StaticFakeDesign\Fake\AbstractGenerator;
use ErdnaxelaWeb\StaticFakeDesign\Fake\FakerGenerator;
use ErdnaxelaWeb\StaticFakeDesign\Value\Pager;
use ErdnaxelaWeb\StaticFakeDesign\Value\PagerAdapter;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PagerGenerator extends AbstractGenerator
{
    public function __construct(
        protected RequestStack        $requestStack,
        protected ContentGenerator    $contentGenerator,
        protected SearchFormGenerator $searchFormGenerator,
        protected LinkGenerator       $linkGenerator,
        protected DefinitionManager   $definitionManager,
        FakerGenerator                $fakerGenerator
    ) {
        parent::__construct($fakerGenerator);
    }

    /**
     * @return \ErdnaxelaWeb\StaticFakeDesign\Value\Pager<\ErdnaxelaWeb\StaticFakeDesign\Value\Content>
     */
    public function __invoke(string $type, ?int $pagesCount = null): Pager
    {
        $currentPage = (int) $this->requestStack->getCurrentRequest()
            ->query->get('page', 1);
        $pagerDefinition = $this->definitionManager->getDefinition(PagerDefinition::class, $type);
        $sorts = $pagerDefinition->getSorts();
        $filters = $pagerDefinition->getFilters();
        $contentTypes = $pagerDefinition->getContentTypes();
        $maxPerPage = $pagerDefinition->getMaxPerPage();
        $headlineCount = $pagerDefinition->getHeadlineCount();
        $pagesCount = $pagesCount ?? rand(1, 10);

        $adapter = new PagerAdapter(
            static function () use ($maxPerPage, $pagesCount) {
                return $maxPerPage * $pagesCount;
            },
            function ($offset, $length) use ($contentTypes) {
                $contents = [];
                for ($i = 0; $i < $length; ++$i) {
                    $contents[] = ($this->contentGenerator)($this->fakerGenerator->randomElement($contentTypes));
                }
                return $contents;
            },
            function () use ($filters, $sorts, $type) {
                return ($this->searchFormGenerator)($filters, $sorts, $type);
            },
            function () use ($filters) {
                $count = $this->fakerGenerator->numberBetween(0, 10);
                $links = [];
                for ($i = 0; $i < $count; ++$i) {
                    $link = ($this->linkGenerator)();
                    $link->setExtras([
                        'filter' => $this->fakerGenerator->randomElement(array_keys($filters)),
                        'value' => $this->fakerGenerator->word,
                    ]);
                    $links[] = $link;
                }

                return $links;
            }
        );

        $pager = new Pager($type, $adapter);
        $pager->setCurrentPage($currentPage);
        $pager->setMaxPerPage($maxPerPage);
        $pager->setHeadlineCount($headlineCount);

        return $pager;
    }

    public function configureOptions(OptionsResolver $optionsResolver): void
    {
        parent::configureOptions($optionsResolver);
        $optionsResolver->define('type')
            ->required()
            ->allowedTypes('string')
            ->info('Identifier of the content to generate. See erdnaxelaweb.static_fake_design.content_definition');

        $optionsResolver->define('pagesCount')
            ->default(null)
            ->allowedTypes('int', 'null');
    }
}

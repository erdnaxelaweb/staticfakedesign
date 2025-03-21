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

namespace ErdnaxelaWeb\StaticFakeDesign\Fake\Generator;

use ErdnaxelaWeb\StaticFakeDesign\Configuration\PagerConfigurationManager;
use ErdnaxelaWeb\StaticFakeDesign\Fake\AbstractGenerator;
use ErdnaxelaWeb\StaticFakeDesign\Fake\FakerGenerator;
use ErdnaxelaWeb\StaticFakeDesign\Value\Pager;
use ErdnaxelaWeb\StaticFakeDesign\Value\PagerAdapter;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PagerGenerator extends AbstractGenerator
{
    public function __construct(
        protected RequestStack $requestStack,
        protected ContentGenerator $contentGenerator,
        protected SearchFormGenerator $searchFormGenerator,
        protected LinkGenerator $linkGenerator,
        protected PagerConfigurationManager $pagerConfigurationManager,
        FakerGenerator             $fakerGenerator
    ) {
        parent::__construct($fakerGenerator);
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

    public function __invoke(string $type, ?int $pagesCount = null): Pager
    {
        $currentPage = (int) $this->requestStack->getCurrentRequest()
            ->query->get('page', 1);
        $configuration = $this->pagerConfigurationManager->getConfiguration($type);
        $sorts = $configuration['sorts'];
        $filters = $configuration['filters'];
        $contentTypes = $configuration['contentTypes'];
        $maxPerPage = $configuration['maxPerPage'];
        $headlineCount = $configuration['headlineCount'];
        $pagesCount = $pagesCount ?? rand($currentPage, 10);

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
            function () use ($filters, $sorts) {
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
        $pager = new Pager($adapter);
        $pager->setCurrentPage($currentPage);
        $pager->setMaxPerPage($maxPerPage);
        $pager->setHeadlineCount($headlineCount);

        return $pager;
    }
}

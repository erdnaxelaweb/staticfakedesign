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
use ErdnaxelaWeb\StaticFakeDesign\Value\PagerAdapter;
use Pagerfanta\Pagerfanta;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PagerGenerator extends AbstractGenerator
{
    public function __construct(
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

    public function __invoke(string $type, ?int $pagesCount = null): Pagerfanta
    {
        $configuration = $this->pagerConfigurationManager->getConfiguration($type);
        $sorts = $configuration['sorts'];
        $filters = $configuration['filters'];
        $contentTypes = $configuration['contentTypes'];
        $maxPerPage = $configuration['maxPerPage'];
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
            function () use ($filters, $sorts) {
                return ($this->searchFormGenerator)($filters, $sorts);
            },
            function () use ($filters, $sorts) {
                return [
                    ($this->linkGenerator)(),
                    ($this->linkGenerator)(),
                    ($this->linkGenerator)(),
                    ($this->linkGenerator)(),
                ];
            }
        );
        $pager = new Pagerfanta($adapter);
        $pager->setMaxPerPage($maxPerPage);

        return $pager;
    }
}

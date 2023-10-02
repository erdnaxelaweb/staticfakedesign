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

namespace ErdnaxelaWeb\StaticFakeDesign\Fake\Generator;

use ErdnaxelaWeb\StaticFakeDesign\Configuration\ContentConfigurationManager;
use ErdnaxelaWeb\StaticFakeDesign\Fake\ContentGenerator\ContentFieldGeneratorRegistry;
use ErdnaxelaWeb\StaticFakeDesign\Fake\FakerGenerator;
use ErdnaxelaWeb\StaticFakeDesign\Value\Content;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ContentGenerator extends AbstractContentGenerator
{
    public function __construct(
        protected ContentConfigurationManager $contentConfigurationManager,
        protected BreadcrumbGenerator         $breadcrumbGenerator,
        FakerGenerator                        $fakerGenerator,
        ContentFieldGeneratorRegistry         $fieldGeneratorRegistry,
    ) {
        parent::__construct($fakerGenerator, $fieldGeneratorRegistry);
    }

    public function configureOptions(OptionsResolver $optionsResolver): void
    {
        parent::configureOptions($optionsResolver);
        $optionsResolver->define('identifier')
            ->required()
            ->allowedTypes('string')
            ->info('Identifier of the content to generate. See erdnaxelaweb.static_fake_design.content_definition');
    }

    public function __invoke(string $type): Content
    {
        $configuration = $this->contentConfigurationManager->getConfiguration($type);
        return Content::createLazyGhost(function (Content $instance) use ($type, $configuration) {
            $instance->__construct(
                $this->fakerGenerator->sentence(),
                $type,
                $this->fakerGenerator->dateTime(),
                $this->fakerGenerator->dateTime(),
                $this->generateFieldsValue($configuration['fields']),
                $this->fakerGenerator->url(),
                ($this->breadcrumbGenerator)()
            );
        });
    }
}

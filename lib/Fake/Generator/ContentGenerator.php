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

use ErdnaxelaWeb\StaticFakeDesign\Configuration\ContentConfigurationManager;
use ErdnaxelaWeb\StaticFakeDesign\Fake\ContentGenerator\FieldGeneratorRegistry;
use ErdnaxelaWeb\StaticFakeDesign\Fake\FakerGenerator;
use ErdnaxelaWeb\StaticFakeDesign\Value\Content;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ContentGenerator extends AbstractContentGenerator
{
    public function __construct(
        protected ContentConfigurationManager $contentConfigurationManager,
        protected BreadcrumbGenerator         $breadcrumbGenerator,
        FieldGeneratorRegistry                $fieldGeneratorRegistry,
        FakerGenerator                        $fakerGenerator,
    ) {
        parent::__construct($fakerGenerator, $fieldGeneratorRegistry);
    }

    public function configureOptions(OptionsResolver $optionsResolver): void
    {
        parent::configureOptions($optionsResolver);
        $optionsResolver->define('identifier')
            ->required()
            ->allowedTypes('string', 'string[]')
            ->info('Identifier of the content to generate. See erdnaxelaweb.static_fake_design.content_definition');
    }

    public function __invoke($type): Content
    {
        if (is_array($type)) {
            $type = $this->fakerGenerator->randomElement($type);
        }
        $configuration = $this->contentConfigurationManager->getConfiguration($type);
        return Content::createLazyGhost(function (Content $instance) use ($type, $configuration) {
            $instance->__construct(
                $this->fakerGenerator->randomNumber(),
                $this->fakerGenerator->sentence(),
                $type,
                $this->fakerGenerator->dateTime(),
                $this->fakerGenerator->dateTime(),
                $this->generateFieldsValue($configuration['fields'], $configuration['models']),
                $this->fakerGenerator->url(),
                ($this->breadcrumbGenerator)()
            );
        });
    }
}

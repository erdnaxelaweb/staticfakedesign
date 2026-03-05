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
use ErdnaxelaWeb\StaticFakeDesign\Definition\ContentDefinition;
use ErdnaxelaWeb\StaticFakeDesign\Fake\ContentGenerator\FieldGeneratorRegistry;
use ErdnaxelaWeb\StaticFakeDesign\Fake\FakerGenerator;
use ErdnaxelaWeb\StaticFakeDesign\Value\Content;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ContentGenerator extends AbstractContentGenerator
{
    public function __construct(
        protected DefinitionManager $definitionManager,
        protected BreadcrumbGenerator $breadcrumbGenerator,
        FieldGeneratorRegistry $fieldGeneratorRegistry,
        FakerGenerator $fakerGenerator,
    ) {
        parent::__construct($fakerGenerator, $fieldGeneratorRegistry);
    }

    /**
     * @param string|string[] $type
     */
    public function __invoke(array|string $type): Content|null
    {
        if (is_array($type)) {
            $type = $this->fakerGenerator->randomElement($type);
        }
        if ($type === null) {
            return null;
        }
        $configuration = $this->definitionManager->getDefinition(ContentDefinition::class, $type);

        $baseProperties = [
            'type' => $type,
            'languageCode' => ['eng-GB', 'fre-FR'],
            'mainLanguageCode' => 'eng-GB',
            'alwaysAvailable' => true,
            'hidden' => false,
        ];

        $initializers = [
            'id' => fn () => $this->fakerGenerator->randomNumber(),
            'name' => fn () => $this->fakerGenerator->sentence(),
            'creationDate' => fn () => $this->fakerGenerator->dateTime(),
            'modificationDate' => fn () => $this->fakerGenerator->dateTime(),
            'fields' => fn (Content $instance) => $this->generateFieldsValue(
                $instance,
                $configuration->getFields(),
                $configuration->getModels()
            ),
            'url' => fn () => $this->fakerGenerator->url(),
            'breadcrumb' => fn () => ($this->breadcrumbGenerator)(),
            'parent' => fn () => !empty($configuration->getParent()) ? ($this)($configuration->getParent()) : null,
        ];

        return Content::instantiate($baseProperties, $initializers);
    }

    public function configureOptions(OptionsResolver $optionsResolver): void
    {
        parent::configureOptions($optionsResolver);
        $optionsResolver->define('type')
            ->required()
            ->allowedTypes('string', 'string[]')
            ->info('Identifier of the content to generate. See erdnaxelaweb.static_fake_design.content_definition');
    }
}

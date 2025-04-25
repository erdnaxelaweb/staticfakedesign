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
use ErdnaxelaWeb\StaticFakeDesign\Definition\DocumentDefinition;
use ErdnaxelaWeb\StaticFakeDesign\Document\DocumentBuilder;
use ErdnaxelaWeb\StaticFakeDesign\Fake\AbstractGenerator;
use ErdnaxelaWeb\StaticFakeDesign\Fake\FakerGenerator;
use ErdnaxelaWeb\StaticFakeDesign\Value\Document;

class DocumentGenerator extends AbstractGenerator
{
    public function __construct(
        protected DefinitionManager $definitionManager,
        protected DocumentBuilder   $documentBuilder,
        protected ContentGenerator  $contentGenerator,
        FakerGenerator              $fakerGenerator
    ) {
        parent::__construct($fakerGenerator);
    }

    /**
     * Generates a document based on the provided type
     *
     * @param string|array<string> $documentType
     */
    public function __invoke(string|array $documentType): Document
    {
        $selectedType = is_array($documentType)
            ? $this->fakerGenerator->randomElement($documentType)
            : $documentType;

        $configuration = $this->definitionManager->getDefinition(DocumentDefinition::class, $selectedType);
        $content = ($this->contentGenerator)($configuration->getSource());
        return ($this->documentBuilder)(
            $selectedType,
            $content,
            $configuration->getFields(),
            $content->mainLanguageCode
        );
    }
}

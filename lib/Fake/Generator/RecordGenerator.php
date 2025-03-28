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

use ErdnaxelaWeb\StaticFakeDesign\Component\ComponentParameterTypeParser;
use ErdnaxelaWeb\StaticFakeDesign\Definition\Transformer\RecordDefinitionTransformer;
use ErdnaxelaWeb\StaticFakeDesign\Fake\AbstractGenerator;
use ErdnaxelaWeb\StaticFakeDesign\Fake\ChainGenerator;
use ErdnaxelaWeb\StaticFakeDesign\Fake\FakerGenerator;
use ErdnaxelaWeb\StaticFakeDesign\Record\RecordBuilder;
use ErdnaxelaWeb\StaticFakeDesign\Value\Record;

class RecordGenerator extends AbstractGenerator
{
    public function __construct(
        protected DefinitionManager   $definitionManager,
        protected RecordBuilder                $recordBuilder,
        protected ChainGenerator               $chainGenerator,
        protected ComponentParameterTypeParser $componentParameterTypeParser,
        FakerGenerator                         $fakerGenerator
    ) {
        parent::__construct($fakerGenerator);
    }

    /**
     * Generates a record based on the provided type
     *
     * @param string|array<string> $recordType
     */
    public function __invoke(string|array $recordType): Record
    {
        $selectedType = is_array($recordType)
            ? $this->fakerGenerator->randomElement($recordType)
            : $recordType;

        $configuration = $this->definitionManager->getConfiguration(RecordDefinition::class, $selectedType);
        $sources = [];
        foreach ($configuration->getSources() as $sourceName => $sourceType) {
            $parsedType = $this->componentParameterTypeParser->fromString($sourceType);
            $sources[$sourceName] = $this->chainGenerator->generateFromTypeExpression($parsedType);
        }

        return ($this->recordBuilder)((object) $sources, $configuration->getAttributes());
    }
}

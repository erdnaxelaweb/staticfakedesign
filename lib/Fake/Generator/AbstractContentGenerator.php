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

use ErdnaxelaWeb\StaticFakeDesign\Definition\ContentFieldDefinition;
use ErdnaxelaWeb\StaticFakeDesign\Fake\AbstractGenerator;
use ErdnaxelaWeb\StaticFakeDesign\Fake\ContentGenerator\Field\FieldGeneratorInterface;
use ErdnaxelaWeb\StaticFakeDesign\Fake\ContentGenerator\FieldGeneratorRegistry;
use ErdnaxelaWeb\StaticFakeDesign\Fake\FakerGenerator;
use ErdnaxelaWeb\StaticFakeDesign\Value\ContentFieldsCollection;
use InvalidArgumentException;

abstract class AbstractContentGenerator extends AbstractGenerator
{
    public function __construct(
        FakerGenerator                   $fakerGenerator,
        protected FieldGeneratorRegistry $fieldGeneratorRegistry
    ) {
        parent::__construct($fakerGenerator);
    }

    /**
     * Generate the fields value.
     *
     * @param array<string, ContentFieldDefinition> $fieldsDefinition Array of field definitions
     * @param array<mixed>                          $models           Array of model data used when generating content
     */
    protected function generateFieldsValue(array $fieldsDefinition, array $models = []): ContentFieldsCollection
    {
        $model = $this->fakerGenerator->randomElement($models);

        $fieldsValue = new ContentFieldsCollection();
        foreach ($fieldsDefinition as $fieldIdentifier => $fieldDefinition) {
            $fieldValue = $fieldDefinition->getValue() ?? ($model[$fieldIdentifier] ?? null);
            $required = $fieldDefinition->isRequired();
            $type = $fieldDefinition->getType();
            $options = $fieldDefinition->getOptions();

            try {
                $generator = $this->getFieldGenerator($type);
                if (!$fieldValue && is_callable($generator)) {
                    $fieldValue = ($required || $this->fakerGenerator->boolean()) ? $generator(...$options) : null;
                } else {
                    $fieldValue = $generator->getForcedValue($fieldValue);
                }
            } catch (InvalidArgumentException $e) {
                $fieldValue = $e->getMessage();
            }

            $fieldsValue->{$fieldIdentifier} = $fieldValue;
        }
        return $fieldsValue;
    }

    /**
     * Get the field generator.
     *
     * @param string $type Type of the field
     */
    protected function getFieldGenerator(string $type): FieldGeneratorInterface
    {
        return $this->fieldGeneratorRegistry->getGenerator($type);
    }
}

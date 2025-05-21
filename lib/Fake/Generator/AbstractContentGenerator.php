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
use ErdnaxelaWeb\StaticFakeDesign\Value\AbstractContent;
use ErdnaxelaWeb\StaticFakeDesign\Value\ContentFieldsCollection;
use ErdnaxelaWeb\StaticFakeDesign\Value\LazyValue;
use InvalidArgumentException;
use ReflectionClass;

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
    protected function generateFieldsValue(
        AbstractContent $content,
        array $fieldsDefinition,
        array $models = []
    ): ContentFieldsCollection {
        $model = $this->fakerGenerator->randomElement($models);

        $fieldsValue = new ContentFieldsCollection();
        foreach ($fieldsDefinition as $fieldIdentifier => $fieldDefinition) {
            $fieldsValue->set(
                $fieldIdentifier,
                new LazyValue(
                    function () use ($model, $fieldDefinition, $fieldIdentifier, $content) {
                        try {
                            $generator = $this->getFieldGenerator($fieldDefinition->getType());
                            if (!$fieldDefinition->isRequired() && $this->fakerGenerator->boolean()) {
                                return null;
                            }

                            $fieldValue = $fieldDefinition->getValue();
                            if ($model && array_key_exists($fieldIdentifier, $model)) {
                                return $generator->getForcedValue($model[$fieldIdentifier]);
                            }

                            if (!$fieldValue && is_callable($generator)) {
                                $options = $fieldDefinition->getOptions();
                                $reflectionFunction = new ReflectionClass($generator);
                                foreach ($reflectionFunction->getMethod('__invoke')->getParameters() as $parameter) {
                                    if ($parameter->getName() === 'content') {
                                        $options['content'] = $content;
                                    }
                                }
                                return $generator(...$options);
                            }

                            return $generator->getForcedValue($fieldValue);
                        } catch (InvalidArgumentException $e) {
                            return $e->getMessage();
                        }
                    }
                )
            );
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

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

use ErdnaxelaWeb\StaticFakeDesign\Fake\AbstractGenerator;
use ErdnaxelaWeb\StaticFakeDesign\Fake\ContentGenerator\Field\FieldGeneratorInterface;
use ErdnaxelaWeb\StaticFakeDesign\Fake\ContentGenerator\FieldGeneratorRegistry;
use ErdnaxelaWeb\StaticFakeDesign\Fake\FakerGenerator;
use ErdnaxelaWeb\StaticFakeDesign\Value\ContentFieldsCollection;
use ErdnaxelaWeb\StaticFakeDesign\Value\FieldsCollection;

abstract class AbstractContentGenerator extends AbstractGenerator
{
    public function __construct(
        FakerGenerator                          $fakerGenerator,
        protected FieldGeneratorRegistry $fieldGeneratorRegistry
    ) {
        parent::__construct($fakerGenerator);
    }

    protected function getCollection(): FieldsCollection
    {
        return new ContentFieldsCollection();
    }

    protected function generateFieldsValue(array $fieldsDefinition, array $models = []): FieldsCollection
    {
        $model = $this->fakerGenerator->randomElement($models);

        $fieldsValue = $this->getCollection();
        foreach ($fieldsDefinition as $fieldIdentifier => $fieldDefinition) {
            $fieldValue = $fieldDefinition['value'] ?? ($model[$fieldIdentifier] ?? null);
            $required = $fieldDefinition['required'] ?? false;
            $type = $fieldDefinition['type'];
            $options = $fieldDefinition['options'] ?? [];

            try {
                $generator = $this->getFieldGenerator($type);
                if (! $fieldValue && is_callable($generator)) {
                    $fieldValue = ($required || $this->fakerGenerator->boolean()) ? $generator(...$options) : null;
                } else {
                    $fieldValue = $generator->getForcedValue($fieldValue);
                }
            } catch (\InvalidArgumentException $e) {
                $fieldValue = $e->getMessage();
            }

            $fieldsValue->set($fieldIdentifier, $fieldValue);
        }
        return $fieldsValue;
    }

    protected function getFieldGenerator(string $type): FieldGeneratorInterface
    {
        return $this->fieldGeneratorRegistry->getGenerator($type);
    }
}

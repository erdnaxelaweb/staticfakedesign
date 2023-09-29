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

use ErdnaxelaWeb\StaticFakeDesign\Fake\AbstractGenerator;
use ErdnaxelaWeb\StaticFakeDesign\Fake\ContentGenerator\ContentFieldGeneratorRegistry;
use ErdnaxelaWeb\StaticFakeDesign\Fake\FakerGenerator;
use ErdnaxelaWeb\StaticFakeDesign\Value\ContentFieldsCollection;

abstract class AbstractContentGenerator extends AbstractGenerator
{
    public function __construct(
        FakerGenerator                $fakerGenerator,
        protected ContentFieldGeneratorRegistry $fieldGeneratorRegistry
    ) {
        parent::__construct($fakerGenerator);
    }

    protected function generateFieldsValue(array $fieldsDefinition): ContentFieldsCollection
    {
        $fieldsValue = new ContentFieldsCollection();
        foreach ($fieldsDefinition as $fieldIdentifier => $fieldDefinition) {
            $required = $fieldDefinition['required'] ?? false;
            $type = $fieldDefinition['type'];
            $options = $fieldDefinition['options'] ?? [];

            $fieldValue = ($required || $this->fakerGenerator->boolean()) ?
                $this->generateFieldValue($type, $options) :
                null;

            $fieldsValue->set($fieldIdentifier, $fieldValue);
        }
        return $fieldsValue;
    }

    protected function generateFieldValue(string $type, array $options)
    {
        try {
            $generator = $this->fieldGeneratorRegistry->getGenerator($type);
        } catch (\InvalidArgumentException $e) {
            return $e->getMessage();
        }
        return is_callable($generator) ? $generator(...$options) : null;
    }
}

<?php

declare(strict_types=1);

/*
 * Static Fake Design Bundle.
 *
 * @author    Florian ALEXANDRE
 * @copyright 2023-present Florian ALEXANDRE
 * @license   https://github.com/erdnaxelaweb/staticfakedesign/blob/main/LICENSE
 */

namespace ErdnaxelaWeb\StaticFakeDesign\Record;

use ErdnaxelaWeb\StaticFakeDesign\Expression\ExpressionResolver;
use ErdnaxelaWeb\StaticFakeDesign\Value\Record;
use Symfony\Component\PropertyAccess\PropertyAccess;
use Symfony\Component\PropertyAccess\PropertyAccessorInterface;

class RecordBuilder
{
    protected PropertyAccessorInterface $propertyAccessor;

    public function __construct(
        protected ExpressionResolver $expressionResolver
    ) {
        $this->propertyAccessor = PropertyAccess::createPropertyAccessorBuilder()
                                                ->getPropertyAccessor();
    }

    /**
     * @param array<string, mixed> $source
     * @param array<string, string> $attributesMapping
     */
    public function __invoke(array $source, array $attributesMapping): Record
    {
        $record = new Record();
        foreach ($attributesMapping as $attribute => $path) {
            $value = ($this->expressionResolver)($source, $path);
            $this->propertyAccessor->setValue($record, $attribute, $value);
        }
        return $record;
    }
}

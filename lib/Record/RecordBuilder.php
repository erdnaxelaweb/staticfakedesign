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

use ErdnaxelaWeb\StaticFakeDesign\Exception\InvalidArgumentException;
use ErdnaxelaWeb\StaticFakeDesign\Value\Record;
use Symfony\Component\PropertyAccess\Exception\InvalidPropertyPathException;
use Symfony\Component\PropertyAccess\Exception\NoSuchIndexException;
use Symfony\Component\PropertyAccess\Exception\NoSuchPropertyException;
use Symfony\Component\PropertyAccess\PropertyAccess;
use Symfony\Component\PropertyAccess\PropertyAccessorInterface;

class RecordBuilder
{
    protected PropertyAccessorInterface $propertyAccessor;

    public function __construct()
    {
        $this->propertyAccessor = PropertyAccess::createPropertyAccessorBuilder()
            ->getPropertyAccessor();
    }

    /**
     * @param array<string, string>         $attributesMapping
     */
    public function __invoke(mixed $source, array $attributesMapping): Record
    {
        $record = new Record();
        foreach ($attributesMapping as $attribute => $path) {
            $value = $this->getSourceValue($source, $path);
            $this->propertyAccessor->setValue($record, $attribute, $value);
        }
        return $record;
    }

    protected function getSourceValue(mixed $source, string $path): mixed
    {
        try {
            if (str_contains($path, '[*]')) {
                $wildcardPosition = strpos($path, '[*]');
                $pathBeforeWildCard = substr($path, 0, $wildcardPosition);
                $pathAfterWildCard = substr($path, $wildcardPosition + 3);

                $values = [];
                $array = $this->propertyAccessor->getValue($source, $pathBeforeWildCard);
                if (!is_array($array)) {
                    throw new InvalidArgumentException(
                        'The path before the wildcard must be an array in source path : ' . $pathBeforeWildCard
                    );
                }
                foreach ($array as $value) {
                    if (empty($pathAfterWildCard)) {
                        $values[] = $value;
                    } else {
                        $values[] = $this->getSourceValue($value, ltrim($pathAfterWildCard, '.'));
                    }
                }
                return $values;
            }
            return $this->propertyAccessor->getValue($source, $path);
        } catch (InvalidPropertyPathException  $exception) {
            throw new InvalidPropertyPathException(sprintf(
                '[%s] %s',
                $path,
                $exception->getMessage()
            ), $exception->getCode(), $exception);
        } catch (NoSuchIndexException|NoSuchPropertyException  $exception) {
            return null;
        }
    }
}

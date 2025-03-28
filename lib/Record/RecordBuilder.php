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
     * @param array<string, string> $attributesMapping
     */
    public function __invoke($sources, array $attributesMapping): Record
    {
        $record = new Record();
        foreach ($attributesMapping as $attribute => $path) {
            $value = $this->getSourceValue($sources, $path);
            $this->propertyAccessor->setValue($record, $attribute, $value);
        }
        return $record;
    }

    protected function getSourceValue($sources, string $path)
    {
        try {
            if (str_contains($path, '[*]')) {
                $wildcardPosition = strpos($path, '[*]');
                $pathBeforeWildCard = substr($path, 0, $wildcardPosition);
                $pathAfterWildCard = substr($path, $wildcardPosition + 3);

                $values = [];
                $array = $this->propertyAccessor->getValue($sources, $pathBeforeWildCard);
                if (! is_array($array)) {
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
            return $this->propertyAccessor->getValue($sources, $path);
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

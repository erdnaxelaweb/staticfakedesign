<?php

declare(strict_types=1);

/*
 * Static Fake Design Bundle.
 *
 * @author    Florian ALEXANDRE
 * @copyright 2023-present Florian ALEXANDRE
 * @license   https://github.com/erdnaxelaweb/staticfakedesign/blob/main/LICENSE
 */

namespace ErdnaxelaWeb\StaticFakeDesign\Expression;

use ErdnaxelaWeb\StaticFakeDesign\Exception\InvalidArgumentException;
use RuntimeException;
use Symfony\Component\ExpressionLanguage\ExpressionFunction;
use Symfony\Component\ExpressionLanguage\ExpressionLanguage;
use Symfony\Component\PropertyAccess\Exception\InvalidPropertyPathException;
use Symfony\Component\PropertyAccess\Exception\NoSuchIndexException;
use Symfony\Component\PropertyAccess\Exception\NoSuchPropertyException;

class ExpressionResolver
{
    protected ExpressionLanguage $expressionLanguage;

    public function __construct()
    {
        $this->expressionLanguage = new ExpressionLanguage();
        $function = ExpressionFunction::fromPhp('array_filter');
        $this->expressionLanguage->register(
            'filter',
            $function->getCompiler(),
            $function->getEvaluator()
        );
        $function = ExpressionFunction::fromPhp('array_unique');
        $this->expressionLanguage->register(
            'unique',
            $function->getCompiler(),
            $function->getEvaluator()
        );
        $function = ExpressionFunction::fromPhp('count');
        $this->expressionLanguage->register(
            'count',
            $function->getCompiler(),
            $function->getEvaluator()
        );
    }

    /**
     * @param array<string, mixed>  $source
     */
    public function __invoke(array $source, string $expression): mixed
    {
        return $this->resolve($expression, $source);
    }

    /**
     * @param array<string, mixed>  $source
     */
    protected function resolve(string $expression, array $source): mixed
    {
        try {
            if (preg_match('/^([^.(]+)\(([^)]+)\)$/', $expression, $matches)) {
                $functionName = $matches[1];
                $functionArgExpression = $matches[2];

                $resolvedFunctionArg = ($this)(
                    $source,
                    $functionArgExpression
                );

                return $this->expressionLanguage->evaluate(
                    sprintf('%s(arg)', $functionName),
                    [
                        'arg' => $resolvedFunctionArg,
                    ],
                );
            }

            if (str_contains($expression, '[*]')) {
                $wildcardPosition = strpos($expression, '[*]');
                $pathBeforeWildCard = substr($expression, 0, $wildcardPosition);
                $pathAfterWildCard = substr($expression, $wildcardPosition + 3);

                $values = [];
                $array = $this->expressionLanguage->evaluate($pathBeforeWildCard, $source);
                if (!is_iterable($array)) {
                    throw new InvalidArgumentException(
                        'The expression before the wildcard must be an array in source expression : ' . $pathBeforeWildCard
                    );
                }

                foreach ($array as $value) {
                    if (empty($pathAfterWildCard)) {
                        $values[] = $value;
                        continue;
                    }

                    $expression = ltrim($pathAfterWildCard, '.');
                    if (!is_array($value)) {
                        $value = [
                            'source' => $value,
                        ];
                        $expression = sprintf('source.%s', $expression);
                    }
                    $resolvedValue = ($this)(
                        $value,
                        $expression
                    );
                    if (is_array($resolvedValue)) {
                        $values = array_merge($values, $resolvedValue);
                    } else {
                        $values[] = $resolvedValue;
                    }
                }
                return $values;
            }
            return $this->expressionLanguage->evaluate($expression, $source);
        } catch (InvalidPropertyPathException  $exception) {
            throw new InvalidPropertyPathException(
                sprintf(
                    '[%s] %s',
                    $expression,
                    $exception->getMessage()
                ),
                $exception->getCode(),
                $exception
            );
        } catch (NoSuchIndexException|NoSuchPropertyException  $exception) {
            return null;
        } catch (RuntimeException  $exception) {
            return null;
        }
    }
}

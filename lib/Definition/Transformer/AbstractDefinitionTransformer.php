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

namespace ErdnaxelaWeb\StaticFakeDesign\Definition\Transformer;

use ErdnaxelaWeb\StaticFakeDesign\Definition\AbstractLazyDefinition;
use ErdnaxelaWeb\StaticFakeDesign\Definition\DefinitionInterface;
use InvalidArgumentException;
use Symfony\Component\OptionsResolver\Exception\InvalidOptionsException;
use Symfony\Component\OptionsResolver\Exception\MissingOptionsException;
use Symfony\Component\OptionsResolver\Exception\UndefinedOptionsException;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\VarExporter\Hydrator;

/**
 * @phpstan-import-type definitionHash from DefinitionTransformerInterface
 */
abstract class AbstractDefinitionTransformer implements DefinitionTransformerInterface
{
    /**
     * @template T of DefinitionInterface
     * @param T $instance
     * @param array<string, mixed> $hash
     *
     * @return T
     */
    protected function lazyFromHash(DefinitionInterface $instance, array $hash): DefinitionInterface
    {
        if (! $instance instanceof AbstractLazyDefinition) {
            throw new InvalidArgumentException(
                sprintf('The instance must be an instance of %s', AbstractLazyDefinition::class)
            );
        }

        return AbstractLazyDefinition::createLazyGhost(
            function (AbstractLazyDefinition $lazyInstance) use ($hash) {
                try {
                    return $this->lazyInitialize($lazyInstance, $this->resolveOptions($hash));
                } catch (UndefinedOptionsException|MissingOptionsException|InvalidOptionsException $exception) {
                    throw new InvalidOptionsException(
                        sprintf('[%s] %s', get_class($lazyInstance), $exception->getMessage()),
                        $exception->getCode(),
                        $exception
                    );
                }
            },
            [
                "\0" . AbstractLazyDefinition::class . "\0identifier" => true,
            ],
            $instance
        );
    }

    /**
     * @param array<string, mixed> $options
     */
    protected function lazyInitialize(AbstractLazyDefinition $instance, array $options): DefinitionInterface
    {
        return Hydrator::hydrate($instance, $options);
    }

    /**
     * @param array<string, mixed> $options
     *
     * @return array<string, mixed>
     */
    protected function resolveOptions(array $options): array
    {
        $optionsResolver = new OptionsResolver();
        $this->configureOptions($optionsResolver);
        return $optionsResolver->resolve($options);
    }

    public function configureOptions(OptionsResolver $optionsResolver): void
    {
    }
}

<?php
/*
 * staticfakedesignbundle.
 *
 * @package   DesignBundle
 *
 * @author    florian
 * @copyright 2018 Novactive
 * @license   https://github.com/Novactive/NovaHtmlIntegrationBundle/blob/master/LICENSE
 */

namespace ErdnaxelaWeb\StaticFakeDesign\Configuration;

use ErdnaxelaWeb\StaticFakeDesign\Exception\ConfigurationNotFoundException;
use Symfony\Component\OptionsResolver\Exception\InvalidOptionsException;
use Symfony\Component\OptionsResolver\Exception\MissingOptionsException;
use Symfony\Component\OptionsResolver\Exception\UndefinedOptionsException;
use Symfony\Component\OptionsResolver\OptionsResolver;

abstract class AbstractConfigurationManager
{
    protected array $configurations;

    public function __construct(
        array                                   $definitions
    ) {
        $this->registerConfigurations($definitions);
    }

    public function registerConfigurations(array $definitions)
    {
        foreach ($definitions as $type => $definition) {
            $this->registerConfiguration($type, $definition);
        }
    }

    abstract protected function configureOptions(OptionsResolver $optionResolver): void;

    public function registerConfiguration(string $type, array $definition): void
    {
        $this->configurations[$type] = $definition;
    }

    protected function resolveOptions(string $identifier, OptionsResolver $optionResolver, array $options)
    {
        try {
            return $optionResolver->resolve($options);
        } catch (UndefinedOptionsException $exception) {
            throw new UndefinedOptionsException(
                sprintf('[%s] %s', $identifier, $exception->getMessage()),
                $exception->getCode(),
                $exception
            );
        } catch (MissingOptionsException $exception) {
            throw new MissingOptionsException(
                sprintf('[%s] %s', $identifier, $exception->getMessage()),
                $exception->getCode(),
                $exception
            );
        } catch (InvalidOptionsException $exception) {
            throw new InvalidOptionsException(
                sprintf('[%s] %s', $identifier, $exception->getMessage()),
                $exception->getCode(),
                $exception
            );
        }
    }

    public function getConfiguration(string $type): array
    {
        if (! isset($this->configurations[$type])) {
            throw new ConfigurationNotFoundException($type);
        }
        $optionResolver = new OptionsResolver();
        $this->configureOptions($optionResolver);

        return $this->resolveOptions($type, $optionResolver, $this->configurations[$type]);
    }
}

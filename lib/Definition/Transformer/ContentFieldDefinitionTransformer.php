<?php

namespace ErdnaxelaWeb\StaticFakeDesign\Definition\Transformer;

use ErdnaxelaWeb\StaticFakeDesign\Definition\AbstractLazyDefinition;
use ErdnaxelaWeb\StaticFakeDesign\Definition\ContentFieldDefinition;
use ErdnaxelaWeb\StaticFakeDesign\Definition\DefinitionInterface;
use ErdnaxelaWeb\StaticFakeDesign\Definition\DefinitionOptions;
use ErdnaxelaWeb\StaticFakeDesign\Fake\ContentGenerator\FieldGeneratorRegistry;
use Symfony\Component\OptionsResolver\Options;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\VarExporter\Instantiator;

class ContentFieldDefinitionTransformer extends AbstractDefinitionTransformer
{
    public function __construct(
        protected FieldGeneratorRegistry $fieldGeneratorRegistry
    ) {
    }

    public function configureOptions(OptionsResolver $optionsResolver): void
    {
        parent::configureOptions($optionsResolver);
        $optionsResolver->define('required')
            ->default(false)
            ->allowedTypes('bool')
            ->info('Tell if field is required or not');

        $optionsResolver->define('type')
            ->required()
            ->allowedTypes('string')
            ->info('Field type');

        $optionsResolver->define('value')
            ->default(null)
            ->info('Forced value');

        $optionsResolver->define('options')
            ->default([])
            ->normalize(function (Options $options, $fieldDefinitionOptions) {
                $optionsResolver = new OptionsResolver();
                $fieldGenerator = $this->fieldGeneratorRegistry->getGenerator($options['type']);
                $fieldGenerator->configureOptions($optionsResolver);
                return $optionsResolver->resolve($fieldDefinitionOptions);
            })
            ->allowedTypes('array')
            ->info('Options to pass to the field type generator');
    }

    public function fromHash(array $hash): ContentFieldDefinition
    {
        return $this->lazyFromHash(Instantiator::instantiate(ContentFieldDefinition::class, [
            'identifier' => $hash['identifier'],
        ]), $hash['hash']);
    }

    protected function lazyInitialize(AbstractLazyDefinition $instance, array $options): DefinitionInterface
    {
        $options['options'] = new DefinitionOptions($options['options']);
        return parent::lazyInitialize($instance, $options);
    }

    /**
     * @param ContentFieldDefinition $definition
     */
    public function toHash(DefinitionInterface $definition): array
    {
        return [
            'identifier' => $definition->getIdentifier(),
            'hash' => [
                'type' => $definition->getType(),
                'required' => $definition->isRequired(),
                'value' => $definition->getValue(),
                'options' => $definition->getOptions()
                    ->toArray(),
            ],
        ];
    }
}

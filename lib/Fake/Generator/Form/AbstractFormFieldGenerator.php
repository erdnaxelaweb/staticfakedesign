<?php

declare(strict_types=1);

/*
 * Static Fake Design Bundle.
 *
 * @author    Florian ALEXANDRE
 * @copyright 2023-present Florian ALEXANDRE
 * @license   https://github.com/erdnaxelaweb/staticfakedesign/blob/main/LICENSE
 */

namespace ErdnaxelaWeb\StaticFakeDesign\Fake\Generator\Form;

use ErdnaxelaWeb\StaticFakeDesign\Fake\AbstractGenerator;
use ErdnaxelaWeb\StaticFakeDesign\Fake\FakerGenerator;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\Form\FormRegistryInterface;
use Symfony\Component\Validator\Constraints\NotBlank;

abstract class AbstractFormFieldGenerator extends AbstractGenerator
{
    public function __construct(
        protected FormFactoryInterface  $formFactory,
        protected FormRegistryInterface $registry,
        FakerGenerator                  $fakerGenerator
    ) {
        parent::__construct($fakerGenerator);
    }

    /**
     * @param array<string, mixed> $options
     */
    public function __invoke(string $name, array $options = []): FormBuilderInterface
    {
        $defaultOptions = $this->getFormOptions();
        $options = $options + $defaultOptions;

        $type = $this->registry->getType($this->getFormType());
        $optionsResolver = $type->getOptionsResolver();
        $options = $optionsResolver->resolve($options);

        if ($options['required'] ?? false) {
            $options['constraints'][] = new NotBlank();
        }

        return $this->formFactory->createNamedBuilder($name, $this->getFormType(), null, $options);
    }

    abstract protected function getFormType(): string;

    /**
     * @return array<string, mixed>
     */
    protected function getFormOptions(): array
    {
        return [];
    }
}

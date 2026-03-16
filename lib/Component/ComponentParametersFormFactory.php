<?php

declare(strict_types=1);

/*
 * Static Fake Design Bundle.
 *
 * @author    Florian ALEXANDRE
 * @copyright 2023-present Florian ALEXANDRE
 * @license   https://github.com/erdnaxelaweb/staticfakedesign/blob/main/LICENSE
 */

namespace ErdnaxelaWeb\StaticFakeDesign\Component;

use ErdnaxelaWeb\StaticFakeDesign\Value\Component;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormFactory;
use Symfony\Component\Form\FormInterface;

class ComponentParametersFormFactory
{
    public const FORM_TYPES = [
        'string' => TextType::class,
        'boolean' => CheckboxType::class,
    ];

    public function __construct(
        protected FormFactory                     $formFactory,
        protected ComponentContextResolverFactory $componentContextResolverFactory
    ) {
    }

    /**
     * @param array<string, mixed> $values
     */
    public function __invoke(Component $component, array $values = []): FormInterface
    {
        $data = ($this->componentContextResolverFactory)($component)
            ->resolve($values);

        $formOptions = [
            'method' => 'GET',
        ];
        if ($this->formFactory->createBuilder()->hasOption('csrf_protection')) {
            $formOptions['csrf_protection'] = false;
        }
        $form = $this->formFactory->createNamedBuilder('component_parameters', FormType::class, $data, $formOptions);

        foreach ($component->getParameters() as $parameter) {
            $value = $data[$parameter->getName()] ?? null;
            $formType = $this->getFormType(gettype($value));

            if (!$formType) {
                continue;
            }
            $form->add($parameter->getName(), $formType, [
                'label' => $parameter->getName(),
            ]);
        }

        return $form->getForm();
    }

    protected function getFormType(string $valueType): ?string
    {
        return self::FORM_TYPES[$valueType] ?? null;
    }
}

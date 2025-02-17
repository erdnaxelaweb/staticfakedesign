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

namespace ErdnaxelaWeb\StaticFakeDesign\Component;

use ErdnaxelaWeb\StaticFakeDesign\Value\Component;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormFactory;

class ComponentParametersFormFactory
{
    public const FORM_TYPES = [
        'string' => TextType::class,
        'boolean' => CheckboxType::class,
    ];

    public function __construct(
        protected FormFactory $formFactory,
        protected ComponentContextResolverFactory $componentContextResolverFactory
    ) {
    }

    protected function getFormType(string $valueType): ?string
    {
        return self::FORM_TYPES[$valueType] ?? null;
    }

    public function __invoke(Component $component, array $values = [])
    {
        $data = ($this->componentContextResolverFactory)($component)
            ->resolve($values);
        $form = $this->formFactory->createNamedBuilder('component_parameters', FormType::class, $data, [
            'csrf_protection' => null,
            'method' => 'GET',
        ]);

        foreach ($component->getParameters() as $parameter) {
            $value = $data[$parameter->getName()] ?? null;
            $formType = $this->getFormType(gettype($value));

            if (! $formType) {
                continue;
            }
            $form->add($parameter->getName(), $formType, [
                'label' => $parameter->getName(),
            ]);
        }

        return $form->getForm();
    }
}

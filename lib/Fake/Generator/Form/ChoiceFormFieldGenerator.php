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

namespace ErdnaxelaWeb\StaticFakeDesign\Fake\Generator\Form;

use ErdnaxelaWeb\StaticFakeDesign\Fake\FakerGenerator;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormFactoryInterface;

class ChoiceFormFieldGenerator extends AbstractFormFieldGenerator
{
    public function __construct(
        FormFactoryInterface $formFactory,
        FakerGenerator $fakerGenerator,
        protected bool $expanded = false,
        protected bool $multiple = false,
    ) {
        parent::__construct($formFactory, $fakerGenerator);
    }

    protected function getFormOptions(): array
    {
        return [
            'expanded' => $this->expanded,
            'multiple' => $this->multiple,
            'choices' => array_flip($this->fakerGenerator->words()),
        ];
    }

    protected function getFormType(): string
    {
        return ChoiceType::class;
    }
}

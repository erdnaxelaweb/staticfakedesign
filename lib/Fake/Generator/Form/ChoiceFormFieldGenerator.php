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
use Symfony\Component\Form\FormRegistryInterface;

class ChoiceFormFieldGenerator extends GenericFormFieldGenerator
{
    public function __construct(
        FormFactoryInterface $formFactory,
        FormRegistryInterface $registry,
        FakerGenerator       $fakerGenerator,
        string               $formType = ChoiceType::class,
        array                $formOptions = []
    ) {
        parent::__construct(
            $formFactory,
            $registry,
            $fakerGenerator,
            $formType,
            $formOptions
        );
    }

    protected function getFormOptions(): array
    {
        return parent::getFormOptions() + [
            'expanded' => false,
            'multiple' => false,
            'choices' => array_flip($this->fakerGenerator->words()),
        ];
    }
}

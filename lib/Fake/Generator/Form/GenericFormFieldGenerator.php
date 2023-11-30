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
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\Form\FormRegistryInterface;

class GenericFormFieldGenerator extends AbstractFormFieldGenerator
{
    public function __construct(
        FormFactoryInterface $formFactory,
        FormRegistryInterface $registry,
        FakerGenerator $fakerGenerator,
        protected string $formType,
        protected array $formOptions = []
    ) {
        parent::__construct($formFactory, $registry, $fakerGenerator);
    }

    protected function getFormType(): string
    {
        return $this->formType;
    }

    protected function getFormOptions(): array
    {
        return $this->formOptions;
    }
}

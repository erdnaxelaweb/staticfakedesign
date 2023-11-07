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

use ErdnaxelaWeb\StaticFakeDesign\Fake\AbstractGenerator;
use ErdnaxelaWeb\StaticFakeDesign\Fake\FakerGenerator;
use Symfony\Component\Form\FormFactoryInterface;

abstract class AbstractFormFieldGenerator extends AbstractGenerator
{
    public function __construct(
        protected FormFactoryInterface $formFactory,
        FakerGenerator        $fakerGenerator
    ) {
        parent::__construct($fakerGenerator);
    }

    abstract protected function getFormType(): string;

    protected function getFormOptions(): array
    {
        return [];
    }

    public function __invoke(string $name, array $options = [])
    {
        $defaultOptions = $this->getFormOptions();
        return $this->formFactory->createNamedBuilder($name, $this->getFormType(), null, $options + $defaultOptions);
    }
}

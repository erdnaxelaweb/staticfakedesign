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

namespace ErdnaxelaWeb\StaticFakeDesign\Fake\Generator;

use ErdnaxelaWeb\StaticFakeDesign\Fake\AbstractGenerator;
use ErdnaxelaWeb\StaticFakeDesign\Fake\FakerGenerator;
use ErdnaxelaWeb\StaticFakeDesign\Fake\GeneratorInterface;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\HttpFoundation\RequestStack;

class FormGenerator extends AbstractGenerator
{
    /**
     * @var array<GeneratorInterface>
     */
    protected array $generators = [];

    public function registerGenerator(string $type, GeneratorInterface $generator): void
    {
        $this->generators[$type] = $generator;
    }

    public function getFieldsTypes(): array
    {
        return array_keys($this->generators);
    }

    public function __construct(
        protected RequestStack $requestStack,
        protected FormFactoryInterface $formFactory,
        FakerGenerator        $fakerGenerator,
        iterable                 $generators = []
    ) {
        foreach ($generators as $type => $generator) {
            $this->registerGenerator($type, $generator);
        }

        parent::__construct($fakerGenerator);
    }

    public function __invoke(array $fields = [], ?string $name = null, $data = null): FormView
    {
        $formOptions = [];

        $builder = $name ?
            $this->formFactory->createNamedBuilder($name, FormType::class, $data, $formOptions) :
            $this->formFactory->createBuilder(FormType::class, $data, $formOptions);

        $formFields = $builder->create('fields', FormType::class, [
            'compound' => true,
        ]);
        if (empty($fields)) {
            $fields = array_map(function (string $type) {
                return [
                    'type' => $type,
                    'options' => [],
                ];
            }, $this->getFieldsTypes());
        }
        foreach ($fields as $fieldName => $field) {
            $fieldType = $field['type'];
            $generator = $this->generators[$fieldType];
            $options = $field['options'] + [
                'label' => "{$this->fakerGenerator->word} ($fieldType)",
            ];
            $formFields->add(call_user_func_array($generator, [
                'name' => $fieldName,
                'options' => $options,
            ]));
        }
        $builder->add($formFields);
        $form = $builder->getForm();
        $form->handleRequest($this->requestStack->getCurrentRequest());
        return $form->createView();
    }
}

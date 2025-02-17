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

namespace ErdnaxelaWeb\StaticFakeDesign\Fake\Generator;

use ErdnaxelaWeb\StaticFakeDesign\Fake\AbstractGenerator;
use ErdnaxelaWeb\StaticFakeDesign\Fake\FakerGenerator;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateIntervalType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\RangeType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\HttpFoundation\RequestStack;

class SearchFormGenerator extends AbstractGenerator
{
    public function getFormTypes(): array
    {
        return [
            'text' => [
                'type' => TextType::class,
            ],
            'radio' => [
                'type' => ChoiceType::class,
                'options' => [
                    'expanded' => true,
                    'multiple' => false,
                    'choices' => array_flip($this->fakerGenerator->words()),
                ],
            ],
            'dropdown' => [
                'type' => ChoiceType::class,
                'options' => [
                    'choices' => array_flip($this->fakerGenerator->words()),
                ],
            ],
            'checkbox' => [
                'type' => ChoiceType::class,
                'options' => [
                    'expanded' => true,
                    'multiple' => true,
                    'choices' => array_flip($this->fakerGenerator->words()),
                ],
            ],
            'number' => [
                'type' => NumberType::class,
            ],
            'number_range' => [
                'type' => RangeType::class,
            ],
            'date' => [
                'type' => DateType::class,
                'options' => [
                    'widget' => 'single_text',
                ],
            ],
            'date_range' => [
                'type' => DateIntervalType::class,
            ],
            'bool' => [
                'type' => CheckboxType::class,
            ],
        ];
    }

    public function __construct(
        protected RequestStack $requestStack,
        protected FormFactoryInterface $formFactory,
        FakerGenerator        $fakerGenerator
    ) {
        parent::__construct($fakerGenerator);
    }

    public function __invoke(array $fields = [], array $sorts = [], ?string $name = null): FormView
    {
        $formTypes = $this->getFormTypes();

        $formOptions = [
            'csrf_protection' => false,
            'method' => 'GET',
        ];

        $builder = $name ?
            $this->formFactory->createNamedBuilder($name, FormType::class, null, $formOptions) :
            $this->formFactory->createBuilder(FormType::class, null, $formOptions);
        $formFields = $builder->create('filters', FormType::class, [
            'compound' => true,
            'block_prefix' => 'filters',
        ]);
        if (empty($fields)) {
            $fields = array_keys($formTypes);
        }
        foreach ($fields as $fieldName => $field) {
            if (is_array($field)) {
                ["type" => $field,  "options" => $fieldOptions] = $field;
            }

            $formType = $formTypes[$field];
            $formTypeOptions = ($formType['options'] ?? []) + [
                'label' => "{$this->fakerGenerator->word} ($fieldName)",
            ];
            foreach ($formTypeOptions as $formTypeOption => &$formTypeOptionValue) {
                $formTypeOptionValue = $fieldOptions[$formTypeOption] ?? $formTypeOptionValue;
            }
            $formType['options'] = $formTypeOptions;
            $formType['options']['block_prefix'] = "filter_$fieldName";
            $formFields->add($fieldName, ...$formType);
        }
        $builder->add($formFields);
        if (count($sorts) > 1) {
            $builder->add('sort', ChoiceType::class, [
                'choices' => array_combine(array_keys($sorts), array_keys($sorts)),
                'block_prefix' => 'sort',
            ]);
        }
        $builder->add('search', SubmitType::class, [
            'label' => 'search',
        ]);

        $form = $builder->getForm();
        $form->handleRequest($this->requestStack->getCurrentRequest());
        return $form->createView();
    }
}

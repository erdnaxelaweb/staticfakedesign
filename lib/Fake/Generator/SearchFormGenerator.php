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

class SearchFormGenerator extends AbstractGenerator
{
    public function getFormTypes(): array
    {
        return [
            'fulltext' => [
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
        protected FormFactoryInterface $formFactory,
        FakerGenerator        $fakerGenerator
    ) {
        parent::__construct($fakerGenerator);
    }

    public function __invoke(array $fields = [], array $sorts = []): FormView
    {
        $formTypes = $this->getFormTypes();
        $builder = $this->formFactory->createBuilder(FormType::class, null);
        $formFields = $builder->create('filters', FormType::class, [
            'compound' => true,
        ]);
        if (empty($fields)) {
            $fields = array_keys($formTypes);
        }
        foreach ($fields as $fieldName => $field) {
            $formType = $formTypes[$field];
            $formType['options'] = ($formType['options'] ?? []) + [
                'label' => "{$this->fakerGenerator->word} ($field)",
            ];
            $formFields->add($fieldName, ...$formType);
        }
        $builder->add($formFields);
        if (count($sorts) > 1) {
            $builder->add('sort', ChoiceType::class, [
                'choices' => array_flip($sorts),
            ]);
        }
        $builder->add('search', SubmitType::class, [
            'label' => 'search',
        ]);
        return $builder->getForm()
            ->createView();
    }
}

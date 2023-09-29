<?php
/*
 * DesignBundle.
 *
 * @package   DesignBundle
 *
 * @author    florian
 * @copyright 2018 Novactive
 * @license   https://github.com/Novactive/NovaHtmlIntegrationBundle/blob/master/LICENSE
 */

declare(strict_types=1);

namespace ErdnaxelaWeb\StaticFakeDesign\Fake\Generator;

use ErdnaxelaWeb\StaticFakeDesign\Fake\AbstractGenerator;
use ErdnaxelaWeb\StaticFakeDesign\Fake\FakerGenerator;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\FormFactoryInterface;

class FormGenerator extends AbstractGenerator
{
    public function __construct(
        protected FormFactoryInterface $formFactory,
        FakerGenerator        $fakerGenerator
    ) {
        parent::__construct($fakerGenerator);
    }

    public function __invoke()
    {
        $formTypes = [
            'text' => [
                'type' => TextType::class,
            ],
            'url' => [
                'type' => UrlType::class,
            ],
            'radio' => [
                'type' => ChoiceType::class,
                'options' => [
                    'expanded' => true,
                    'multiple' => false,
                    'choices' => $this->fakerGenerator->words(),
                ],
            ],
            'number' => [
                'type' => NumberType::class,
            ],
            'textarea' => [
                'type' => TextareaType::class,
            ],
            'file' => [
                'type' => FileType::class,
            ],
            'email' => [
                'type' => EmailType::class,
            ],
            'dropdown' => [
                'type' => ChoiceType::class,
                'options' => [
                    'choices' => $this->fakerGenerator->words(),
                ],
            ],
            'date' => [
                'type' => DateType::class,
            ],
            'checkboxes' => [
                'type' => ChoiceType::class,
                'options' => [
                    'expanded' => true,
                    'multiple' => true,
                    'choices' => $this->fakerGenerator->words(),
                ],
            ],

            'checkbox' => [
                'type' => CheckboxType::class,
            ],
            'button' => [
                'type' => SubmitType::class,
            ],
        ];

        $builder = $this->formFactory->createBuilder(FormType::class, null);
        $formFields = $builder->create('fields', FormType::class, [
            'compound' => true,
        ]);
        foreach ($formTypes as $formType) {
            $formFields->add($this->fakerGenerator->word, ...$formType);
        }
        $builder->add($formFields);
        return $builder->getForm()
            ->createView();
    }
}

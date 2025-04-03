<?php

declare(strict_types=1);

/*
 * Static Fake Design Bundle.
 *
 * @author    Florian ALEXANDRE
 * @copyright 2023-present Florian ALEXANDRE
 * @license   https://github.com/erdnaxelaweb/staticfakedesign/blob/main/LICENSE
 */

namespace ErdnaxelaWeb\StaticFakeDesign\Fake\Generator;

use ErdnaxelaWeb\StaticFakeDesign\Fake\AbstractGenerator;
use ErdnaxelaWeb\StaticFakeDesign\Fake\FakerGenerator;
use ErdnaxelaWeb\StaticFakeDesign\Fake\GeneratorInterface;
use Symfony\Component\Form\FormView;

class FormFieldGenerator extends AbstractGenerator
{
    /**
     * @var array<GeneratorInterface>
     */
    protected array $generators = [];

    /**
     * @param iterable<GeneratorInterface> $generators
     */
    public function __construct(
        protected FakerGenerator $fakerGenerator,
        iterable                 $generators = [],
    ) {
        foreach ($generators as $type => $generator) {
            $this->registerGenerator($type, $generator);
        }
    }

    /**
     * @param array<string, mixed> $options
     */
    public function __invoke(string $name = null, ?string $type = null, array $options = []): FormView
    {
        $type = $type ?? $this->fakerGenerator->randomElement(array_keys($this->generators));
        $generator = $this->generators[$type];
        $name = $name ?? $this->fakerGenerator->word();
        $options = $options + [
            'label' => "{$this->fakerGenerator->word} ($name)",
        ];

        return call_user_func_array($generator, [
            'name' => $name,
            'options' => $options,
        ])->getForm()
            ->createView();
    }

    public function registerGenerator(string $type, GeneratorInterface $generator): void
    {
        $this->generators[$type] = $generator;
    }
}

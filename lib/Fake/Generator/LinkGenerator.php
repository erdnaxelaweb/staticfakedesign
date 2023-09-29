<?php

declare(strict_types=1);

namespace ErdnaxelaWeb\StaticFakeDesign\Fake\Generator;

use ErdnaxelaWeb\StaticFakeDesign\Fake\AbstractGenerator;
use ErdnaxelaWeb\StaticFakeDesign\Fake\FakerGenerator;
use Knp\Menu\FactoryInterface;
use Knp\Menu\ItemInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Contracts\Translation\TranslatorInterface;

class LinkGenerator extends AbstractGenerator
{
    public function __construct(
        protected FactoryInterface $factory,
        protected TranslatorInterface $translator,
        FakerGenerator $fakerGenerator
    ) {
        parent::__construct($fakerGenerator);
    }

    public function configureOptions(OptionsResolver $optionResolver): void
    {
        parent::configureOptions($optionResolver);
        $optionResolver->define('target')
            ->default(null)
            ->allowedTypes('string', 'null');
    }

    public function __invoke(?string $target = null): ItemInterface
    {
        $name = $this->fakerGenerator->words(3, true);
        $options = [
            'uri' => $this->fakerGenerator->url(),
            'linkAttributes' => [],
        ];
        if ($target) {
            $options['linkAttributes']['target'] = $target;
            $options['linkAttributes']['title'] = $this->translator->trans('link.blank', [
                '%title%' => $name,
            ]);
        }

        return $this->factory->createItem($name, $options);
    }
}

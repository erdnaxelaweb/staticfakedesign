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

namespace ErdnaxelaWeb\StaticFakeDesignBundle\Controller\Showroom;

use ErdnaxelaWeb\StaticFakeDesign\Component\ComponentFinder;
use ErdnaxelaWeb\StaticFakeDesign\Fake\ChainGenerator;
use ErdnaxelaWeb\StaticFakeDesign\Fake\FakerGenerator;
use ErdnaxelaWeb\StaticFakeDesign\Showroom\ShowroomHelper;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Twig\Environment;
use Twig\Template;

class ComponentController extends AbstractController
{
    public function __construct(
        protected ComponentFinder                        $componentFinder,
        protected ShowroomHelper                         $showroomHelper,
        protected ChainGenerator   $generator,
        protected FakerGenerator   $fakerGenerator,
        protected Environment $twig
    ) {
    }

    public function view(string $path = null): Response
    {
        $component = $path ? $this->componentFinder->getComponentFromPath($path) : null;
        return $this->render('@StaticFakeDesign/showroom/component.html.twig', [
            'path' => $path,
            'component' => $component,
        ]);
    }

    public function preview(string $path, array $parameters = []): Response
    {
        $component = $this->componentFinder->getComponentFromPath($path);
        $isFullTemplate = $this->isFullTemplate($component->getTemplate());
        $this->showroomHelper->setPreviewActive(true);

        $templateParameters = [
            'page_title' => $component->getName(),
        ];

        $context = [];
        foreach ($component->getParameters() as $parameter) {
            $required = ($parameter->isRequired() || $this->fakerGenerator->boolean());
            if ($required) {
                $context[$parameter->getName()] = $parameter->getDefaultValue() ?? $this->generator->generateFromTypeExpression(
                    $parameter->getType()
                );
            }
        }
        if ($isFullTemplate) {
            $templatePath = $component->getTemplate()
                ->getTemplateName();
            $templateParameters = array_merge($templateParameters, $context);
        } else {
            $templatePath = '@StaticFakeDesign/showroom/component-preview.html.twig';
            $templateParameters['templatePath'] = $component->getTemplate()->getTemplateName();
            $templateParameters['templateParameters'] = $context;
        }

        return $this->render($templatePath, $templateParameters);
    }

    protected function isFullTemplate(Template $template): bool
    {
        $parent = $template->getParent($this->twig->mergeGlobals([]));
        if ($parent) {
            return $this->isFullTemplate($parent);
        }
        return str_contains($template->getSourceContext()->getCode(), '</html>');
    }
}

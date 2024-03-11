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

namespace ErdnaxelaWeb\StaticFakeDesign\Showroom;

use ErdnaxelaWeb\StaticFakeDesign\Value\Component;
use Symfony\Component\Finder\Finder;
use Twig\Environment;
use Twig\TemplateWrapper;

class ComponentFinder
{
    public function __construct(
        protected Environment $twig,
        protected string $baseDir
    ) {
    }

    /**
     * @return \ErdnaxelaWeb\StaticFakeDesign\Value\Component[]
     */
    public function findComponents(): array
    {
        $finder = new Finder();

        $finder
            ->in(sprintf('%s', $this->baseDir))
            ->name('*.html.twig')
            ->files();

        $components = [];
        foreach ($finder as $file) {
            $component = $this->getComponentFromTemplatePath($file->getRelativePathname());
            if ($component) {
                $components[rtrim($file->getRelativePathname(), '.html.twig')] = $component;
            }
        }
        return $components;
    }

    public function getComponentFromTemplatePath(string $templatePath): ?Component
    {
        $template = $this->twig->load($templatePath);
        return $this->getComponentFromTemplate($template);
    }

    public function getComponentFromPath(string $path): ?Component
    {
        return $this->getComponentFromTemplatePath(sprintf('%s.html.twig', $path));
    }

    public function getComponentFromTemplate(TemplateWrapper $template): ?Component
    {
        return $template->unwrap()
->component ?? null;
    }
}

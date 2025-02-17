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

namespace ErdnaxelaWeb\StaticFakeDesignBundle\Controller;

use ErdnaxelaWeb\StaticFakeDesign\Configuration\BlockConfigurationManager;
use ErdnaxelaWeb\StaticFakeDesign\Configuration\ContentConfigurationManager;
use ErdnaxelaWeb\StaticFakeDesign\Configuration\ImageConfiguration;
use ErdnaxelaWeb\StaticFakeDesign\Configuration\PagerConfigurationManager;
use ErdnaxelaWeb\StaticFakeDesign\Configuration\TaxonomyEntryConfigurationManager;
use Symfony\Bundle\FrameworkBundle\Controller\TemplateController;
use Symfony\Component\Yaml\Yaml;
use Twig\Environment;

class StaticController extends TemplateController
{
    public function __construct(
        protected BlockConfigurationManager $blockConfigurationManager,
        protected TaxonomyEntryConfigurationManager $taxonomyEntryConfigurationManager,
        protected ContentConfigurationManager $contentConfigurationManager,
        protected PagerConfigurationManager $pagerConfigurationManager,
        protected ImageConfiguration $imageConfiguration,
        Environment $twig = null
    ) {
        parent::__construct($twig);
    }

    public function viewAction(string $path): \Symfony\Component\HttpFoundation\Response
    {
        return $this->templateAction(sprintf("static/%s.html.twig", ! empty($path) ? $path : "index"));
    }

    public function viewExamplesAction(string $path): \Symfony\Component\HttpFoundation\Response
    {
        $exampleParameters = Yaml::parseFile(__DIR__ . '/../Resources/config/examples.yaml');

        $this->imageConfiguration->setVariations(
            $exampleParameters['parameters']['erdnaxelaweb.static_fake_design.image.variations']
        );
        $this->blockConfigurationManager->registerConfigurations(
            $exampleParameters['parameters']['erdnaxelaweb.static_fake_design.block_definition']
        );
        $this->taxonomyEntryConfigurationManager->registerConfigurations(
            $exampleParameters['parameters']['erdnaxelaweb.static_fake_design.taxonomy_entry_definition']
        );
        $this->contentConfigurationManager->registerConfigurations(
            $exampleParameters['parameters']['erdnaxelaweb.static_fake_design.content_definition']
        );
        $this->pagerConfigurationManager->registerConfigurations(
            $exampleParameters['parameters']['erdnaxelaweb.static_fake_design.pager_definition']
        );

        return $this->viewAction("examples/$path");
    }
}

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

use ErdnaxelaWeb\StaticFakeDesign\Configuration\DefinitionManager;
use ErdnaxelaWeb\StaticFakeDesign\Configuration\ImageConfiguration;
use ErdnaxelaWeb\StaticFakeDesign\Definition\BlockDefinition;
use ErdnaxelaWeb\StaticFakeDesign\Definition\ContentDefinition;
use ErdnaxelaWeb\StaticFakeDesign\Definition\PagerDefinition;
use ErdnaxelaWeb\StaticFakeDesign\Definition\TaxonomyEntryDefinition;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Yaml\Yaml;

class StaticController extends AbstractController
{
    public function __construct(
        protected DefinitionManager         $definitionManager,
        protected ImageConfiguration             $imageConfiguration
    ) {
    }

    public function viewAction(string $path): Response
    {
        return $this->render(sprintf("static/%s.html.twig", !empty($path) ? $path : "index"));
    }

    public function viewExamplesAction(string $path): Response
    {
        $exampleParameters = Yaml::parse(file_get_contents(__DIR__ . '/../Resources/config/examples.yaml'));

        $this->imageConfiguration->setVariations(
            $exampleParameters['parameters']['erdnaxelaweb.static_fake_design.image.variations']
        );
        $this->definitionManager->registerDefinitions(
            BlockDefinition::DEFINITION_TYPE,
            $exampleParameters['parameters']['erdnaxelaweb.static_fake_design.block_definition']
        );
        $this->definitionManager->registerDefinitions(
            TaxonomyEntryDefinition::DEFINITION_TYPE,
            $exampleParameters['parameters']['erdnaxelaweb.static_fake_design.taxonomy_entry_definition']
        );
        $this->definitionManager->registerDefinitions(
            ContentDefinition::DEFINITION_TYPE,
            $exampleParameters['parameters']['erdnaxelaweb.static_fake_design.content_definition']
        );
        $this->definitionManager->registerDefinitions(
            PagerDefinition::DEFINITION_TYPE,
            $exampleParameters['parameters']['erdnaxelaweb.static_fake_design.pager_definition']
        );

        return $this->viewAction("examples/$path");
    }
}

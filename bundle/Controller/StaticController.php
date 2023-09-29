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

namespace ErdnaxelaWeb\StaticFakeDesignBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\TemplateController;

class StaticController extends TemplateController
{
    public function viewAction(string $path)
    {
        return $this->templateAction(sprintf("static/%s.html.twig", ! empty($path) ? $path : "index"));
    }
}

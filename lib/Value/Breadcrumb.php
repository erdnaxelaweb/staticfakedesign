<?php
/*
 * staticfakedesignbundle.
 *
 * @package   DesignBundle
 *
 * @author    florian
 * @copyright 2018 Novactive
 * @license   https://github.com/Novactive/NovaHtmlIntegrationBundle/blob/master/LICENSE
 */

namespace ErdnaxelaWeb\StaticFakeDesign\Value;

use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\VarExporter\LazyGhostTrait;

class Breadcrumb extends ArrayCollection
{
    use LazyGhostTrait;
}

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

namespace ErdnaxelaWeb\StaticFakeDesign\Value;

use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\VarExporter\LazyGhostTrait;

class Breadcrumb extends ArrayCollection
{
    use LazyGhostTrait;
}

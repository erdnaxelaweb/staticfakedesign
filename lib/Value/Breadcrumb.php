<?php

declare(strict_types=1);

/*
 * Static Fake Design Bundle.
 *
 * @author    Florian ALEXANDRE
 * @copyright 2023-present Florian ALEXANDRE
 * @license   https://github.com/erdnaxelaweb/staticfakedesign/blob/main/LICENSE
 */

namespace ErdnaxelaWeb\StaticFakeDesign\Value;

use Doctrine\Common\Collections\ArrayCollection;
use Knp\Menu\ItemInterface;
use Symfony\Component\VarExporter\LazyGhostTrait;

/**
 * @extends ArrayCollection<int, ItemInterface>
 */
class Breadcrumb extends ArrayCollection
{
    use LazyGhostTrait;
}

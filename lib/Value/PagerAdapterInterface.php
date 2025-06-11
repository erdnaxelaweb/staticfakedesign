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

use Pagerfanta\Adapter\AdapterInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;

interface PagerAdapterInterface extends AdapterInterface
{
    public function getFilters(): FormView;

    public function getFiltersForm(): FormInterface;

    /**
     * @return \Knp\Menu\ItemInterface[]
     */
    public function getActiveFilters(): array;
}

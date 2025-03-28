<?php

declare(strict_types=1);

namespace ErdnaxelaWeb\StaticFakeDesign\Value;

use Pagerfanta\Adapter\AdapterInterface;
use Symfony\Component\Form\FormView;

interface PagerAdapterInterface extends AdapterInterface
{
    public function getFilters(): FormView;

    /**
     * @return \Knp\Menu\ItemInterface[]
     */
    public function getActiveFilters(): array;
}

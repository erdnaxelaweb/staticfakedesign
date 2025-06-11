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

use Pagerfanta\Adapter\CallbackAdapter;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;

class PagerAdapter extends CallbackAdapter implements PagerAdapterInterface
{
    /**
     * @param callable(): int                                     $nbResultsCallable
     * @param callable(int, int): iterable<mixed> $sliceCallable
     * @param callable(): FormInterface                                $filtersCallback
     * @param callable(): \Knp\Menu\ItemInterface[]               $activeFiltersCallback
     */
    public function __construct(
        $nbResultsCallable,
        $sliceCallable,
        protected $filtersCallback,
        protected $activeFiltersCallback
    ) {
        parent::__construct($nbResultsCallable, $sliceCallable);
    }

    public function getFilters(): FormView
    {
        return $this->getFiltersForm()->createView();
    }

    public function getFiltersForm(): FormInterface
    {
        return ($this->filtersCallback)();
    }

    /**
     * @return \Knp\Menu\ItemInterface[]
     */
    public function getActiveFilters(): array
    {
        return ($this->activeFiltersCallback)();
    }
}

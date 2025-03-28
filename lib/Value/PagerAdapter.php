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

use Pagerfanta\Adapter\CallbackAdapter;
use Symfony\Component\Form\FormView;

class PagerAdapter extends CallbackAdapter implements PagerAdapterInterface
{
    /**
     * @param callable(): int                                     $nbResultsCallable
     * @param callable(int $offset, int $length): iterable<mixed> $sliceCallable
     * @param callable(): FormView                                $filtersCallback
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

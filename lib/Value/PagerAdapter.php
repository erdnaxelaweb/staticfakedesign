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

use Pagerfanta\Adapter\AdapterInterface;
use Pagerfanta\Adapter\CallbackAdapter;
use Symfony\Component\Form\FormView;

class PagerAdapter extends CallbackAdapter implements AdapterInterface
{
    public function __construct(
        $nbResultsCallable,
        $sliceCallable,
        protected $filtersCallback
    ) {
        parent::__construct($nbResultsCallable, $sliceCallable);
    }

    public function getFilters(): FormView
    {
        return ($this->filtersCallback)();
    }
}

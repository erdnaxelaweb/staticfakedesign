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

use Pagerfanta\Adapter\AdapterInterface;
use Pagerfanta\Pagerfanta;
use Symfony\Component\Form\FormView;

class Pager extends Pagerfanta
{
    public function __construct(AdapterInterface $adapter)
    {
        parent::__construct($adapter);
    }

    public function getActiveFilters(): array
    {
        return $this->getAdapter()
            ->getActiveFilters();
    }

    public function getFilters(): FormView
    {
        return $this->getAdapter()
            ->getFilters();
    }
}

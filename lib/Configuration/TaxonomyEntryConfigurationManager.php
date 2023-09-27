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

declare( strict_types=1 );

namespace ErdnaxelaWeb\StaticFakeDesign\Configuration;

use Symfony\Component\OptionsResolver\OptionsResolver;

class TaxonomyEntryConfigurationManager extends ContentConfigurationManager
{
    protected function configureOptions( OptionsResolver $optionResolver ): void
    {
        parent::configureOptions( $optionResolver );
        $optionResolver->remove('parent');
    }

}

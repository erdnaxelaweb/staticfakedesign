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

declare( strict_types=1 );

namespace ErdnaxelaWeb\StaticFakeDesign\Value;

use DateTime;

class TaxonomyEntry extends AbstractContent
{
    public function __construct(
        int                            $id,
        string                         $name,
        string                         $type,
        DateTime                       $creationDate,
        DateTime                       $modificationDate,
        ContentFieldsCollection        $fields,
        public readonly string         $identifier,
        public readonly int            $level = 0,
        public readonly ?TaxonomyEntry $parent = null,
    )
    {
        parent::__construct( $id, $name, $type, $creationDate, $modificationDate, $fields );
    }
}

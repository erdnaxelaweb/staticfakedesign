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

class ContentRelation
{
    /**
     * The relation type COMMON is a general relation between object set by a user.
     *
     * @var int
     */
    public const COMMON = 1;

    /**
     * the relation type EMBED is set for a relation which is anchored as embedded link in an attribute value.
     *
     * @var int
     */
    public const EMBED = 2;

    /**
     * the relation type LINK is set for a relation which is anchored as link in an attribute value.
     *
     * @var int
     */
    public const LINK = 4;

    /**
     * the relation type FIELD is set for a relation which is part of an relation attribute value.
     *
     * @var int
     */
    public const FIELD = 8;

    /**
     * the relation type ASSET is set for a relation to asset in an attribute value.
     *
     * @var int
     */
    public const ASSET = 16;

    
    public function __construct(
        public Content $sourceContent,
        public Content $destinationContent,
        public int     $type,
        public string            $sourceFieldIdenfifier,
    ) {
    }
}

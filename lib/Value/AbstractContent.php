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

declare(strict_types=1);

namespace ErdnaxelaWeb\StaticFakeDesign\Value;

use DateTime;
use Symfony\Component\VarExporter\LazyGhostTrait;

class AbstractContent
{
    use LazyGhostTrait;

    /**
     * @param array $fields
     */
    public function __construct(
        public readonly string $name,
        public readonly string $type,
        public readonly DateTime $creationDate,
        public readonly DateTime $modificationDate,
        public readonly ContentFieldsCollection  $fields
    ) {
    }
}

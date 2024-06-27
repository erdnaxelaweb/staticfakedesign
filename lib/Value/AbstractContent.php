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

declare(strict_types=1);

namespace ErdnaxelaWeb\StaticFakeDesign\Value;

use DateTime;
use Symfony\Component\VarExporter\LazyGhostTrait;

class AbstractContent
{
    use LazyGhostTrait;

    public function __construct(
        public readonly int $id,
        public readonly string $name,
        public readonly string $type,
        public readonly DateTime $creationDate,
        public readonly DateTime $modificationDate,
        public readonly ContentFieldsCollection  $fields
    ) {
    }
}

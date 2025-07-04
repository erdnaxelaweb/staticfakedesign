<?php

declare(strict_types=1);

/*
 * Static Fake Design Bundle.
 *
 * @author    Florian ALEXANDRE
 * @copyright 2023-present Florian ALEXANDRE
 * @license   https://github.com/erdnaxelaweb/staticfakedesign/blob/main/LICENSE
 */

namespace ErdnaxelaWeb\StaticFakeDesign\Event;

use ErdnaxelaWeb\StaticFakeDesign\Value\ContentInterface;
use ErdnaxelaWeb\StaticFakeDesign\Value\Document;

class BuildDocumentEvent
{
    /**
     * @param array<string, string|string[]> $fieldsMapping
     */
    public function __construct(
        protected string           $type,
        protected ContentInterface $content,
        protected array            $fieldsMapping,
        protected string           $languageCode,
        protected Document         $document,
    ) {
    }
}

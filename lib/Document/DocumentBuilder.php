<?php

declare(strict_types=1);

/*
 * Static Fake Design Bundle.
 *
 * @author    Florian ALEXANDRE
 * @copyright 2023-present Florian ALEXANDRE
 * @license   https://github.com/erdnaxelaweb/staticfakedesign/blob/main/LICENSE
 */

namespace ErdnaxelaWeb\StaticFakeDesign\Document;

use ErdnaxelaWeb\StaticFakeDesign\Expression\ExpressionResolver;
use ErdnaxelaWeb\StaticFakeDesign\Value\ContentInterface;
use ErdnaxelaWeb\StaticFakeDesign\Value\Document;

class DocumentBuilder
{
    public function __construct(
        protected ExpressionResolver $expressionResolver
    ) {
    }

    /**
     * @param array<string, string|string[]> $fieldsMapping
     */
    public function __invoke(string $type, ContentInterface $content, array $fieldsMapping, string $languageCode): Document
    {
        $isMainTranslation = ($content->mainLanguageCode === $languageCode);
        $alwaysAvailable = ($isMainTranslation && $content->alwaysAvailable);

        $document = new Document();
        $document->id = strtolower("{$type}_{$content->id}_lang_{$languageCode}");
        $document->contentId = $content->id;
        $document->languageCode = $languageCode;
        $document->isMainTranslation = $isMainTranslation;
        $document->alwaysAvailable = $alwaysAvailable;
        $document->type = $type;
        foreach ($fieldsMapping as $field => $path) {
            if (is_array($path)) {
                $value = [];
                foreach ($path as $pathEl) {
                    $pathElValue = $this->resolveFieldValue($content, $document, $pathEl);
                    if (is_array($pathElValue)) {
                        $value[] = implode(',', $pathElValue);
                    } else {
                        $value[] = $pathElValue;
                    }
                }
            } else {
                $value = $this->resolveFieldValue($content, $document, $path);
            }

            $document->fields->{$field} = $value;
        }
        return $document;
    }

    protected function resolveFieldValue(ContentInterface $content, Document $document, string $path): mixed
    {
        return ($this->expressionResolver)([
            'content' => $content,
            'document' => $document,
        ], $path);
    }
}

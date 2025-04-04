<?php

declare(strict_types=1);

/*
 * Static Fake Design Bundle.
 *
 * @author    Florian ALEXANDRE
 * @copyright 2023-present Florian ALEXANDRE
 * @license   https://github.com/erdnaxelaweb/staticfakedesign/blob/main/LICENSE
 */

namespace ErdnaxelaWeb\StaticFakeDesign\Definition;

use InvalidArgumentException;

/**
 * Class representing a pager definition.
 */
class PagerDefinition extends AbstractLazyDefinition
{
    public const DEFINITION_TYPE = 'pager';

    /**
     * @param array<string>                        $contentTypes         Array of content types to include
     * @param int                                  $maxPerPage           Maximum number of items per page
     * @param array<string, PagerSortDefinition>   $sorts                Array of sort options
     * @param array<string, PagerFilterDefinition> $filters              Array of filter options
     * @param array<string>                        $excludedContentTypes Array of content types to exclude
     * @param int                                  $headlineCount        Number of headline items
     */
    public function __construct(
        string                 $identifier,
        protected readonly array $contentTypes,
        protected readonly int   $maxPerPage,
        protected readonly array $sorts,
        protected readonly array $filters,
        protected readonly array $excludedContentTypes,
        protected readonly int   $headlineCount
    ) {
        parent::__construct($identifier);
    }

    /**
     * Get the content types.
     *
     * @return string[]
     */
    public function getContentTypes(): array
    {
        return $this->contentTypes;
    }

    /**
     * Get the maximum number of items per page.
     */
    public function getMaxPerPage(): int
    {
        return $this->maxPerPage;
    }

    /**
     * Get the sort options.
     *
     * @return array<string, PagerSortDefinition>
     */
    public function getSorts(): array
    {
        return $this->sorts;
    }

    public function getSort(string $name): PagerSortDefinition
    {
        if (!$this->hasSort($name)) {
            throw new InvalidArgumentException("Sort \"$name\" does not exist.");
        }
        return $this->sorts[$name];
    }

    public function hasSort(string $name): bool
    {
        return array_key_exists($name, $this->sorts);
    }

    /**
     * Get the filter options.
     *
     * @return array<string, PagerFilterDefinition>
     */
    public function getFilters(): array
    {
        return $this->filters;
    }

    public function getFilter(string $name): PagerFilterDefinition
    {
        if (!$this->hasFilter($name)) {
            throw new InvalidArgumentException("Filter \"$name\" does not exist.");
        }
        return $this->filters[$name];
    }

    public function hasFilter(string $name): bool
    {
        return array_key_exists($name, $this->filters);
    }

    /**
     * Get the excluded content types.
     *
     * @return string[]
     */
    public function getExcludedContentTypes(): array
    {
        return $this->excludedContentTypes;
    }

    /**
     * Get the headline count.
     */
    public function getHeadlineCount(): int
    {
        return $this->headlineCount;
    }
}

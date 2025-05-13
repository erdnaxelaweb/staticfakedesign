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

use ArrayIterator;
use Countable;
use InvalidArgumentException;
use Iterator;
use IteratorAggregate;
use IteratorIterator;
use JsonSerializable;
use Pagerfanta\Exception\LessThan1CurrentPageException;
use Pagerfanta\Exception\LessThan1MaxPagesException;
use Pagerfanta\Exception\LessThan1MaxPerPageException;
use Pagerfanta\Exception\LogicException;
use Pagerfanta\Exception\OutOfBoundsException;
use Pagerfanta\Exception\OutOfRangeCurrentPageException;
use Pagerfanta\PagerfantaInterface;
use Symfony\Component\Form\FormView;
use function is_array;

/**
 * @template T
 * @implements Iterator<int, T>
 */
class Pager implements Countable, Iterator, JsonSerializable, PagerfantaInterface
{
    private PagerAdapterInterface $adapter;

    private bool $allowOutOfRangePages = false;

    private bool $normalizeOutOfRangePages = false;

    private int $maxPerPage = 10;

    private int $currentPage = 1;

    private ?int $nbResults = null;

    private ?int $maxNbPages = null;

    private int $headlineCount = 0;

    /**
     * @var Iterator<int, T>
     */
    private Iterator $currentPageResults;

    private bool $disablePagination = false;

    public function __construct(PagerAdapterInterface $adapter)
    {
        $this->adapter = $adapter;
    }

    public function getAdapter(): PagerAdapterInterface
    {
        return $this->adapter;
    }


    public function setDisablePagination(bool $disablePagination): void
    {
        $this->disablePagination = $disablePagination;
    }

    /**
     * @return $this
     */
    public function setAllowOutOfRangePages(bool $allowOutOfRangePages): static
    {
        $this->allowOutOfRangePages = $this->filterBoolean($allowOutOfRangePages);

        return $this;
    }

    public function getAllowOutOfRangePages(): bool
    {
        return $this->allowOutOfRangePages;
    }

    /**
     * @return $this
     */
    public function setNormalizeOutOfRangePages(bool $normalizeOutOfRangePages): static
    {
        $this->normalizeOutOfRangePages = $this->filterBoolean($normalizeOutOfRangePages);

        return $this;
    }

    public function getNormalizeOutOfRangePages(): bool
    {
        return $this->normalizeOutOfRangePages;
    }

    /**
     * Sets the maximum number of items per page.
     *
     * Tries to convert from string and float.
     *
     * @return $this
     */
    public function setMaxPerPage(int $maxPerPage): static
    {
        $this->maxPerPage = $maxPerPage === 0 ? $maxPerPage : $this->filterMaxPerPage($maxPerPage);
        $this->resetForMaxPerPageChange();

        return $this;
    }

    public function setHeadlineCount(int $headlineCount): void
    {
        $this->headlineCount = $headlineCount;
    }

    public function isFirstPage(): bool
    {
        return !$this->hasPreviousPage();
    }

    public function getMaxPerPage(): int
    {
        return $this->maxPerPage;
    }

    /**
     * Sets the current page.
     *
     * Tries to convert from string and float.
     *
     * @return $this
     */
    public function setCurrentPage(int $currentPage): static
    {
        $this->currentPage = $this->filterCurrentPage($currentPage);
        $this->resetForCurrentPageChange();

        return $this;
    }

    public function getCurrentPage(): int
    {
        return $this->currentPage;
    }

    /**
     * @return Iterator<int, T>
     */
    public function getCurrentPageResults(): Iterator
    {
        if (!isset($this->currentPageResults)) {
            $this->currentPageResults = $this->buildResultsIterator(
                $this->getCurrentPageResultsFromAdapter()
            );
        }

        return $this->currentPageResults;
    }

    /**
     * @return iterable<array-key, T>
     */
    public function getHeadlineResults(): iterable
    {
        if (!$this->isFirstPage()) {
            return [];
        }
        return $this->adapter->getSlice(0, $this->headlineCount);
    }

    /**
     * Calculates the current page offset start.
     */
    public function getCurrentPageOffsetStart(): int
    {
        return $this->getNbResults() ? $this->calculateOffsetForCurrentPageResults() + 1 : 0;
    }

    /**
     * Calculates the current page offset end.
     */
    public function getCurrentPageOffsetEnd(): int
    {
        return $this->hasNextPage() ? $this->getCurrentPage() * $this->getMaxPerPage() : $this->getNbResults();
    }

    public function getNbResults(): int
    {
        if (null === $this->nbResults) {
            $this->nbResults = $this->getAdapter()
                ->getNbResults();
        }

        return $this->nbResults;
    }

    public function getNbPages(): int
    {
        $nbPages = $this->calculateNbPages();

        if (0 === $nbPages) {
            return $this->minimumNbPages();
        }

        if (null !== $this->maxNbPages && $this->maxNbPages < $nbPages) {
            return $this->maxNbPages;
        }

        return $nbPages;
    }

    public function setMaxNbPages(int $maxNbPages): static
    {
        if ($maxNbPages < 1) {
            throw new LessThan1MaxPagesException();
        }

        $this->maxNbPages = $maxNbPages;

        return $this;
    }

    public function resetMaxNbPages(): static
    {
        $this->maxNbPages = null;

        return $this;
    }

    public function haveToPaginate(): bool
    {
        return $this->getNbResults() > $this->maxPerPage;
    }

    public function hasPreviousPage(): bool
    {
        return $this->currentPage > 1;
    }

    public function getPreviousPage(): int
    {
        if (!$this->hasPreviousPage()) {
            throw new LogicException('There is no previous page.');
        }

        return $this->currentPage - 1;
    }

    public function hasNextPage(): bool
    {
        return $this->currentPage < $this->getNbPages();
    }

    public function getNextPage(): int
    {
        if (!$this->hasNextPage()) {
            throw new LogicException('There is no next page.');
        }

        return $this->currentPage + 1;
    }

    public function count(): int
    {
        return $this->getNbResults();
    }

    public function current(): mixed
    {
        return $this->getCurrentPageResults()->current();
    }

    public function next(): void
    {
        $this->getCurrentPageResults()->next();
        // if pagination is disabled, we automaticaly switch to next page
        if (!$this->getCurrentPageResults()->valid() && $this->hasNextPage() && $this->disablePagination) {
            $this->setCurrentPage($this->getNextPage());
        }
    }

    public function key(): mixed
    {
        return $this->getCurrentPageResults()->key();
    }

    public function valid(): bool
    {
        return $this->getCurrentPageResults()->valid();
    }

    public function rewind(): void
    {
        $this->setCurrentPage(1);
    }

    /**
     * @return iterable<array-key, T>
     */
    public function jsonSerialize(): iterable
    {
        $results = $this->getCurrentPageResults();
        return iterator_to_array($results);
    }

    /**
     * Get page number of the item at specified position (1-based index).
     */
    public function getPageNumberForItemAtPosition(int $position): int
    {
        if ($this->getNbResults() < $position) {
            throw new OutOfBoundsException(
                sprintf(
                    'Item requested at position %d, but there are only %d items.',
                    $position,
                    $this->getNbResults()
                )
            );
        }

        return (int) ceil($position / $this->getMaxPerPage());
    }

    /**
     * @return \Knp\Menu\ItemInterface[]
     */
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

    /**
     * @param iterable<int, T> $results
     *
     * @return Iterator<int, T>
     */
    protected function buildResultsIterator(iterable $results): Iterator
    {
        if ($results instanceof Iterator) {
            return $results;
        }

        if ($results instanceof IteratorAggregate) {
            $iterator = $results->getIterator();
            return $iterator instanceof Iterator ? $iterator : new IteratorIterator($iterator);
        }

        if (is_array($results)) {
            return new ArrayIterator($results);
        }

        throw new InvalidArgumentException(
            sprintf('Cannot create iterator with page results of type "%s".', get_debug_type($results))
        );
    }

    private function filterMaxPerPage(int $maxPerPage): int
    {
        $this->checkMaxPerPage($maxPerPage);

        return $maxPerPage;
    }

    private function checkMaxPerPage(int $maxPerPage): void
    {
        if ($maxPerPage < 1) {
            throw new LessThan1MaxPerPageException();
        }
    }

    private function resetForMaxPerPageChange(): void
    {
        unset($this->currentPageResults);
    }

    private function filterCurrentPage(int $currentPage): int
    {
        $this->checkCurrentPage($currentPage);
        return $this->filterOutOfRangeCurrentPage($currentPage);
    }

    private function checkCurrentPage(int $currentPage): void
    {
        if ($currentPage < 1) {
            throw new LessThan1CurrentPageException();
        }
    }

    private function filterOutOfRangeCurrentPage(int $currentPage): int
    {
        if ($this->notAllowedCurrentPageOutOfRange($currentPage)) {
            return $this->normalizeOutOfRangeCurrentPage($currentPage);
        }

        return $currentPage;
    }

    private function notAllowedCurrentPageOutOfRange(int $currentPage): bool
    {
        return !$this->getAllowOutOfRangePages() && $this->currentPageOutOfRange($currentPage);
    }

    private function currentPageOutOfRange(int $currentPage): bool
    {
        return $currentPage > 1 && $currentPage > $this->getNbPages();
    }

    private function normalizeOutOfRangeCurrentPage(int $currentPage): int
    {
        if ($this->getNormalizeOutOfRangePages()) {
            return $this->getNbPages();
        }

        throw new OutOfRangeCurrentPageException(
            sprintf(
                'Page "%d" does not exist. The currentPage must be inferior to "%d"',
                $currentPage,
                $this->getNbPages()
            )
        );
    }

    private function resetForCurrentPageChange(): void
    {
        unset($this->currentPageResults);
    }

    /**
     * @return iterable<array-key, T>
     */
    private function getCurrentPageResultsFromAdapter(): iterable
    {
        $offset = $this->calculateOffsetForCurrentPageResults();
        $length = $this->getMaxPerPage();
        return $this->adapter->getSlice($offset, $length);
    }

    private function calculateOffsetForCurrentPageResults(): int
    {
        return (($this->getCurrentPage() - 1) * $this->getMaxPerPage()) + $this->headlineCount;
    }

    private function calculateNbPages(): int
    {
        $maxPerPage = $this->getMaxPerPage();
        if ($maxPerPage === 0) {
            return 0;
        }
        return (int) ceil(($this->getNbResults() - $this->headlineCount) / $maxPerPage);
    }

    private function minimumNbPages(): int
    {
        return 1;
    }

    private function filterBoolean(bool $value): bool
    {
        return $value;
    }
}

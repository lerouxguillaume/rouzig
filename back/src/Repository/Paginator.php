<?php


namespace App\Repository;

use ApiPlatform\Core\DataProvider\PaginatorInterface;

class Paginator implements \IteratorAggregate, PaginatorInterface
{
    private $iterator;
    private $firstResult;
    private $maxResults;
    private $totalItems;

    public function __construct(\Generator $results, int $firstResult, int $maxResults, $totalItems)
    {
        $this->iterator = $results;
        $this->firstResult = $firstResult;
        $this->maxResults = $maxResults;
        $this->totalItems = $totalItems;
    }

    /**
     * {@inheritdoc}
     */
    public function getCurrentPage(): float
    {
        if (0 >= $this->maxResults) {
            return 1.;
        }

        return floor($this->firstResult / $this->maxResults) + 1.;
    }

    /**
     * {@inheritdoc}
     */
    public function getLastPage(): float
    {
        if (0 >= $this->maxResults) {
            return 1.;
        }

        return ceil($this->totalItems / $this->maxResults) ?: 1.;
    }

    /**
     * {@inheritdoc}
     */
    public function getItemsPerPage(): float
    {
        return (float)$this->maxResults;
    }

    /**
     * {@inheritdoc}
     */
    public function getTotalItems(): float
    {
        return (float)$this->totalItems;
    }

    /**
     * {@inheritdoc}
     */
    public function count(): int
    {
        return iterator_count($this->iterator);
    }

    /**
     * {@inheritdoc}
     */
    public function getIterator(): \Traversable
    {
        return $this->iterator;
    }
}
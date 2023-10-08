<?php

declare(strict_types=1);

namespace App\Shared\Domain\Repository;

/**
 * @extends \IteratorAggregate<int, PaginatorInterface>
 */
interface PaginatorInterface extends \IteratorAggregate, \Countable
{
    public function getCurrentPage(): int;

    public function getItemsPerPage(): int;

    public function getLastPage(): int;

    public function getTotalItems(): int;
}

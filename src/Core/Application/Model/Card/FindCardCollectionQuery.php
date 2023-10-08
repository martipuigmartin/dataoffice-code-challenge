<?php

declare(strict_types=1);

namespace App\Core\Application\Model\Card;

final readonly class FindCardCollectionQuery
{
    public function __construct(
        private ?string $filter,
        private int $page,
        private int $limit
    ) {
    }

    public function getFilter(): ?string
    {
        return $this->filter;
    }

    public function getPage(): int
    {
        return $this->page;
    }

    public function getLimit(): int
    {
        return $this->limit;
    }
}

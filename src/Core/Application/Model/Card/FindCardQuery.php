<?php

declare(strict_types=1);

namespace App\Core\Application\Model\Card;

final readonly class FindCardQuery
{
    public function __construct(
        private int $cardId
    ) {
    }

    public function getCardId(): int
    {
        return $this->cardId;
    }
}

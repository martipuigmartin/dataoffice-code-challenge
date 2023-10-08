<?php

declare(strict_types=1);

namespace App\Core\Domain\Repository;

use App\Core\Domain\Entity\Card;

interface CardRepositoryInterface
{
    public function save(Card $card): void;

    public function remove(Card $card): void;

    public function ofId(int $cardId): ?Card;

    public function ofUuid(string $cardUuid): ?Card;
}

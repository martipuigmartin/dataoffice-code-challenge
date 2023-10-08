<?php

declare(strict_types=1);

namespace App\Core\Application\Model\Card;

final readonly class UpdateCardCommand
{
    public function __construct(
        private int $cardId,
        private string $text
    ) {
    }

    public function getCardId(): int
    {
        return $this->cardId;
    }

    public function getText(): string
    {
        return $this->text;
    }
}

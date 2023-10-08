<?php

declare(strict_types=1);

namespace App\Core\Application\Service\Card;

use App\Core\Application\Model\Card\UpdateCardCommand;
use App\Core\Domain\Repository\CardRepositoryInterface;
use App\Shared\Domain\Exception\ResourceNotFoundException;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
final readonly class CardUpdater
{
    public function __construct(
        private CardRepositoryInterface $cardRepository
    ) {
    }

    public function __invoke(UpdateCardCommand $updateCardCommand): void
    {
        $cardId = $updateCardCommand->getCardId();
        $text = $updateCardCommand->getText();

        $card = $this->cardRepository->ofId($cardId);

        $card || throw new ResourceNotFoundException(sprintf('Card with id %d not found', $cardId), 404);

        $card->update($text);

        $this->cardRepository->save($card);
    }
}

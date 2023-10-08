<?php

declare(strict_types=1);

namespace App\Core\Application\Service\Card;

use App\Core\Application\Model\Card\FindCardQuery;
use App\Core\Domain\Entity\Card;
use App\Core\Domain\Repository\CardRepositoryInterface;
use App\Shared\Domain\Exception\ResourceNotFoundException;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
final readonly class CardFinder
{
    public function __construct(
        private CardRepositoryInterface $cardRepository
    ) {
    }

    public function __invoke(FindCardQuery $findCardQuery): Card
    {
        $cardId = $findCardQuery->getCardId();

        $card = $this->cardRepository->ofId($cardId);

        $card || throw new ResourceNotFoundException(sprintf('Card with id %d not found', $cardId), 404);

        return $card;
    }
}

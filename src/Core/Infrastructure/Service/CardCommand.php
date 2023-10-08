<?php

declare(strict_types=1);

namespace App\Core\Infrastructure\Service;

use App\Core\Application\Model\Card\UpdateCardCommand;
use App\Core\Domain\Entity\Card;
use Symfony\Component\Messenger\HandleTrait;
use Symfony\Component\Messenger\MessageBusInterface;
use Webmozart\Assert\Assert;

final class CardCommand
{
    use HandleTrait;

    public function __construct(
        MessageBusInterface $commandBus,
        private readonly CardQuery $queryService
    ) {
        $this->messageBus = $commandBus;
    }

    public function putCard(int $cardId, ?string $text): Card
    {
        Assert::positiveInteger($cardId);

        $text && $this->handle(new UpdateCardCommand($cardId, $text));

        return $this->queryService->getCard($cardId);
    }
}

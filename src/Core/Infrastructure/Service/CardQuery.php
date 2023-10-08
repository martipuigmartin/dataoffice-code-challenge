<?php

declare(strict_types=1);

namespace App\Core\Infrastructure\Service;

use App\Core\Application\Model\Card\FindCardCollectionQuery;
use App\Core\Application\Model\Card\FindCardQuery;
use App\Core\Domain\Entity\Card;
use Symfony\Component\Messenger\HandleTrait;
use Symfony\Component\Messenger\MessageBusInterface;
use Webmozart\Assert\Assert;

final class CardQuery
{
    use HandleTrait;

    public function __construct(
        MessageBusInterface $commandBus
    ) {
        $this->messageBus = $commandBus;
    }

    public function getCard(int $cardId): Card
    {
        Assert::positiveInteger($cardId);

        return $this->handle(new FindCardQuery($cardId));
    }

    public function getCardCollection(?string $filter, int $page, int $limit): mixed
    {
        Assert::nullOrStringNotEmpty($filter);
        Assert::positiveInteger($page);
        Assert::positiveInteger($limit);

        return $this->handle(new FindCardCollectionQuery($filter, $page, $limit));
    }
}

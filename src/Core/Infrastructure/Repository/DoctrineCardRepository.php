<?php

declare(strict_types=1);

namespace App\Core\Infrastructure\Repository;

use App\Core\Domain\Entity\Card;
use App\Core\Domain\Repository\CardRepositoryInterface;
use App\Shared\Infrastructure\Repository\DoctrineRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Persistence\ManagerRegistry;

final class DoctrineCardRepository extends DoctrineRepository implements CardRepositoryInterface
{
    private const ENTITY_CLASS = Card::class;
    private const ALIAS = 'card';

    public function __construct(
        protected EntityManagerInterface $em,
        protected ManagerRegistry $registry
    ) {
        parent::__construct($em, $registry, self::ENTITY_CLASS, self::ALIAS);
    }

    public function save(Card $card): void
    {
        $this->em->persist($card);
        $this->em->flush();
    }

    public function remove(Card $card): void
    {
        $this->em->remove($card);
        $this->em->flush();
    }

    public function ofId(int $cardId): ?Card
    {
        return $this->em->find(self::ENTITY_CLASS, $cardId);
    }

    public function ofUuid(string $cardUuid): ?Card
    {
        return $this->filter(static function (QueryBuilder $qb) use ($cardUuid): void {
            $qb->where(sprintf('%s.uuid = :uuid', self::ALIAS))->setParameter('uuid', $cardUuid);
        })->getIterator()->current();
    }
}

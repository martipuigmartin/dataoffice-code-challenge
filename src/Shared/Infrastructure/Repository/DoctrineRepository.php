<?php

declare(strict_types=1);

namespace App\Shared\Infrastructure\Repository;

use App\Shared\Domain\Repository\PaginatorInterface;
use App\Shared\Domain\Repository\RepositoryInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\QueryBuilder;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Doctrine\Persistence\ManagerRegistry;
use Webmozart\Assert\Assert;

abstract class DoctrineRepository extends ServiceEntityRepository implements RepositoryInterface
{
    private ?int $page = null;
    private ?int $itemsPerPage = null;

    private QueryBuilder $queryBuilder;

    public function __construct(
        protected EntityManagerInterface $em,
        protected ManagerRegistry $registry,
        string $entityClass,
        string $alias
    ) {
        parent::__construct($registry, $entityClass);

        $this->queryBuilder = $this->em->createQueryBuilder()
            ->select($alias)
            ->from($entityClass, $alias);
    }

    public function getIterator(): \Iterator
    {
        if (null !== $paginator = $this->paginator()) {
            yield from $paginator;

            return;
        }

        yield from $this->queryBuilder->getQuery()->getResult();
    }

    public function paginator(): ?PaginatorInterface
    {
        if (null === $this->page || null === $this->itemsPerPage) {
            return null;
        }

        $firstResult = ($this->page - 1) * $this->itemsPerPage;
        $maxResults = $this->itemsPerPage;

        $repository = $this->filter(static function (QueryBuilder $qb) use ($firstResult, $maxResults) {
            $qb->setFirstResult($firstResult)->setMaxResults($maxResults);
        });

        $paginator = new Paginator($repository->queryBuilder->getQuery());

        return new DoctrinePaginator($paginator);
    }

    protected function filter(callable $filter): static
    {
        $cloned = clone $this;
        $filter($cloned->queryBuilder);

        return $cloned;
    }

    public function count(mixed $criteria = null): int
    {
        if (null !== $paginator = $this->paginator()) {
            return count($paginator);
        }

        return (int) (clone $this->queryBuilder)
            ->select('count(1)')
            ->getQuery()
            ->getSingleScalarResult();
    }

    public function withoutPagination(): static
    {
        $cloned = clone $this;
        $cloned->page = null;
        $cloned->itemsPerPage = null;

        return $cloned;
    }

    public function withPagination(int $page, int $itemsPerPage): static
    {
        Assert::positiveInteger($page);
        Assert::positiveInteger($itemsPerPage);

        $cloned = clone $this;
        $cloned->page = $page;
        $cloned->itemsPerPage = $itemsPerPage;

        return $cloned;
    }

    public function __clone(): void
    {
        parent::__clone();

        $this->queryBuilder = clone $this->queryBuilder;
    }

    protected function query(): QueryBuilder
    {
        return clone $this->queryBuilder;
    }
}

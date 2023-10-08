<?php

declare(strict_types=1);

namespace App\Core\Application\Service\Card;

use App\Core\Application\Model\Card\FindCardCollectionQuery;
use App\Core\Domain\Repository\CardRepositoryInterface;
use FOS\ElasticaBundle\Finder\PaginatedFinderInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
final readonly class CardCollectionFinder
{
    public function __construct(
        private PaginatedFinderInterface $finder,
        private CardRepositoryInterface $cardRepository
    ) {
    }

    public function __invoke(FindCardCollectionQuery $findCardCollectionQuery): mixed
    {
        $filter = $findCardCollectionQuery->getFilter();
        $page = $findCardCollectionQuery->getPage();
        $limit = $findCardCollectionQuery->getLimit();

        $filter ?
            $cards = $this->finder->findPaginated($filter)->setMaxPerPage($limit)->setCurrentPage($page) :
            $cards = $this->cardRepository->withPagination($page, $limit);

        return $cards;
    }
}

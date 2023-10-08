<?php

declare(strict_types=1);

namespace App\Core\Infrastructure\Controller\Card;

use App\Core\Infrastructure\Service\CardQuery;
use OpenApi\Annotations as OA;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

/**
 * @Route("/api/card", methods={"GET"})
 *
 * @OA\Response(
 *     response=200,
 *     description="Returns a card collection",
 * )
 *
 * @OA\Parameter(
 *      name="filter",
 *      in="query",
 *      description="The filter text",
 *      required=false,
 *
 *      @OA\Schema(type="string")
 *  )
 *
 * @OA\Parameter(
 *     name="page",
 *     in="query",
 *     description="The page number",
 *     required=false,
 *
 *     @OA\Schema(type="integer", format="int64", default=1)
 * )
 *
 * @OA\Parameter(
 *     name="limit",
 *     in="query",
 *     description="The limit of items per page",
 *     required=false,
 *
 *     @OA\Schema(type="integer", format="int64", default=10)
 * )
 *
 * @OA\Tag(name="Card")
 */
final class GetCardCollection extends AbstractController
{
    public function __construct(
        private readonly SerializerInterface $serializer,
        private readonly CardQuery $queryService
    ) {
    }

    public function __invoke(Request $request): JsonResponse
    {
        $params = $request->query->all();

        $filter = $params['filter'] ?? null;
        $page = (int) ($params['page'] ?? 1);
        $limit = (int) ($params['limit'] ?? 10);

        $cards = $this->queryService->getCardCollection($filter, $page, $limit);

        return new JsonResponse($this->serializer->serialize($cards, 'json'), Response::HTTP_OK, [], true);
    }
}

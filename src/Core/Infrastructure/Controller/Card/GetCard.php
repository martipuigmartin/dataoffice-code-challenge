<?php

declare(strict_types=1);

namespace App\Core\Infrastructure\Controller\Card;

use App\Core\Infrastructure\Service\CardQuery;
use OpenApi\Annotations as OA;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

/**
 * @Route("/api/card/{cardId}", methods={"GET"})
 *
 * @OA\Response(
 *     response=200,
 *     description="Returns a card",
 * )
 *
 * @OA\Parameter(
 *     name="cardId",
 *     in="path",
 *     description="The id of the card",
 *     required=true,
 *
 *     @OA\Schema(type="integer", format="int64")
 * )
 *
 * @OA\Tag(name="Card")
 */
final class GetCard extends AbstractController
{
    public function __construct(
        private readonly SerializerInterface $serializer,
        private readonly CardQuery $queryService
    ) {
    }

    public function __invoke(int $cardId): JsonResponse
    {
        $card = $this->queryService->getCard($cardId);

        return new JsonResponse($this->serializer->serialize($card, 'json'), Response::HTTP_OK, [], true);
    }
}

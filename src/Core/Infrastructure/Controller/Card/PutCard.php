<?php

declare(strict_types=1);

namespace App\Core\Infrastructure\Controller\Card;

use App\Core\Infrastructure\Service\CardCommand;
use OpenApi\Annotations as OA;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

/**
 * @Route("/api/card/{cardId}", methods={"PUT"})
 *
 * @OA\Response(
 *     response=200,
 *     description="Update a card",
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
 * @OA\Parameter(
 *       name="text",
 *       in="query",
 *       description="The text to update",
 *       required=false,
 *
 *       @OA\Schema(type="string")
 *   )
 *
 * @OA\Tag(name="Card")
 */
final class PutCard extends AbstractController
{
    public function __construct(
        private readonly SerializerInterface $serializer,
        private readonly CardCommand $commandService
    ) {
    }

    public function __invoke(int $cardId, Request $request): JsonResponse
    {
        $params = $request->query->all();

        $text = $params['text'] ?? null;

        $card = $this->commandService->putCard($cardId, $text);

        return new JsonResponse($this->serializer->serialize($card, 'json'), Response::HTTP_OK, [], true);
    }
}

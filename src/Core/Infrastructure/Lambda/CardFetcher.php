<?php

declare(strict_types=1);

namespace App\Core\Infrastructure\Lambda;

use App\Core\Domain\Entity\Card;
use App\Core\Domain\Repository\CardRepositoryInterface;
use Bref\Context\Context;
use Bref\Event\S3\S3Event;
use Bref\Event\S3\S3Handler;
use Doctrine\ORM\EntityManagerInterface;
use League\Flysystem\FilesystemOperator;

final class CardFetcher extends S3Handler
{
    public function __construct(
        private readonly FilesystemOperator $lambdaStorage,
        private readonly EntityManagerInterface $em,
        private readonly CardRepositoryInterface $cardRepository
    ) {
    }

    public function handleS3(S3Event $event, Context $context): void
    {
        $fn = urldecode($event->getRecords()[0]->getObject()->getKey());

        $file = $this->lambdaStorage->read($fn);

        $sets = json_decode($file, true);

        foreach ($sets as $set) {
            printf('Processing %s...'.PHP_EOL, $set['name']);

            array_map(function (array $card) {
                if ($this->cardRepository->ofUuid($card['uuid'])) {
                    return;
                }

                $this->em->persist(new Card(
                    $card['artist'] ?? null,
                    $card['artistIds'] ?? null,
                    $card['asciiName'] ?? null,
                    $card['attractionLights'] ?? null,
                    $card['availability'] ?? null,
                    $card['boosterTypes'] ?? null,
                    $card['borderColor'] ?? null,
                    $card['cardParts'] ?? null,
                    $card['colorIdentity'] ?? null,
                    $card['colorIndicator'] ?? null,
                    $card['colors'] ?? null,
                    $card['convertedManaCost'] ?? null,
                    $card['defense'] ?? null,
                    $card['duelDeck'] ?? null,
                    $card['edhrecRank'] ?? null,
                    $card['edhrecSaltiness'] ?? null,
                    $card['faceConvertedManaCost'] ?? null,
                    $card['faceFlavorName'] ?? null,
                    $card['faceManaValue'] ?? null,
                    $card['faceName'] ?? null,
                    $card['finishes'] ?? null,
                    $card['flavorName'] ?? null,
                    $card['flavorText'] ?? null,
                    $card['foreignData'] ?? null,
                    $card['frameEffects'] ?? null,
                    $card['frameVersion'] ?? null,
                    $card['hand'] ?? null,
                    $card['hasAlternativeDeckLimit'] ?? null,
                    $card['hasContentWarning'] ?? null,
                    $card['hasFoil'] ?? null,
                    $card['hasNonFoil'] ?? null,
                    $card['identifiers'] ?? null,
                    $card['isAlternative'] ?? null,
                    $card['isFullArt'] ?? null,
                    $card['isFunny'] ?? null,
                    $card['isOnlineOnly'] ?? null,
                    $card['isOversized'] ?? null,
                    $card['isPromo'] ?? null,
                    $card['isRebalanced'] ?? null,
                    $card['isReprint'] ?? null,
                    $card['isReserved'] ?? null,
                    $card['isStarter'] ?? null,
                    $card['isStorySpotlight'] ?? null,
                    $card['isTextless'] ?? null,
                    $card['isTimeshifted'] ?? null,
                    $card['keywords'] ?? null,
                    $card['language'] ?? null,
                    $card['layout'] ?? null,
                    $card['leadershipSkills'] ?? null,
                    $card['legalities'] ?? null,
                    $card['life'] ?? null,
                    $card['loyalty'] ?? null,
                    $card['manaCost'] ?? null,
                    $card['manaValue'] ?? null,
                    $card['name'] ?? null,
                    $card['number'] ?? null,
                    $card['originalPrintings'] ?? null,
                    $card['originalReleaseDate'] ?? null,
                    $card['originalText'] ?? null,
                    $card['originalType'] ?? null,
                    $card['otherFaceIds'] ?? null,
                    $card['power'] ?? null,
                    $card['printings'] ?? null,
                    $card['promoTypes'] ?? null,
                    $card['purchaseUrls'] ?? null,
                    $card['rarity'] ?? null,
                    $card['relatedCards'] ?? null,
                    $card['rebalancedPrintings'] ?? null,
                    $card['rulings'] ?? null,
                    $card['securityStamp'] ?? null,
                    $card['setCode'] ?? null,
                    $card['side'] ?? null,
                    $card['signature'] ?? null,
                    $card['sourceProducts'] ?? null,
                    $card['subsets'] ?? null,
                    $card['subtypes'] ?? null,
                    $card['supertypes'] ?? null,
                    $card['text'] ?? null,
                    $card['toughness'] ?? null,
                    $card['type'] ?? null,
                    $card['types'] ?? null,
                    $card['uuid'],
                    $card['variations'] ?? null,
                    $card['watermark'] ?? null,
                ));
            }, $set['cards']);

            $this->em->flush();
            $this->em->clear();

            printf('Done %s'.PHP_EOL, $set['name']);
        }
    }
}

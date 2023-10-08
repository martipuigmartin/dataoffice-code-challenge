<?php

declare(strict_types=1);

namespace App\Core\Domain\Entity;

trait CardGetters
{
    public function getId(): ?int
    {
        return $this->id;
    }

    public function getArtist(): ?string
    {
        return $this->artist;
    }

    public function getArtistIds(): ?array
    {
        return $this->artistIds;
    }

    public function getAsciiName(): ?string
    {
        return $this->asciiName;
    }

    public function getAttractionLights(): ?array
    {
        return $this->attractionLights;
    }

    public function getAvailability(): ?array
    {
        return $this->availability;
    }

    public function getBoosterTypes(): ?array
    {
        return $this->boosterTypes;
    }

    public function getBorderColor(): ?string
    {
        return $this->borderColor;
    }

    public function getCardParts(): ?array
    {
        return $this->cardParts;
    }

    public function getColorIdentity(): ?array
    {
        return $this->colorIdentity;
    }

    public function getColorIndicator(): ?array
    {
        return $this->colorIndicator;
    }

    public function getColors(): ?array
    {
        return $this->colors;
    }

    public function getConvertedManaCost(): ?float
    {
        return $this->convertedManaCost;
    }

    public function getDefense(): ?string
    {
        return $this->defense;
    }

    public function getDuelDeck(): ?string
    {
        return $this->duelDeck;
    }

    public function getEdhrecRank(): ?int
    {
        return $this->edhrecRank;
    }

    public function getEdhrecSaltiness(): ?int
    {
        return $this->edhrecSaltiness;
    }

    public function getFaceConvertedManaCost(): ?float
    {
        return $this->faceConvertedManaCost;
    }

    public function getFaceFlavorName(): ?string
    {
        return $this->faceFlavorName;
    }

    public function getFaceManaValue(): ?int
    {
        return $this->faceManaValue;
    }

    public function getFaceName(): ?string
    {
        return $this->faceName;
    }

    public function getFinishes(): ?array
    {
        return $this->finishes;
    }

    public function getFlavorName(): ?string
    {
        return $this->flavorName;
    }

    public function getFlavorText(): ?string
    {
        return $this->flavorText;
    }

    public function getForeignData(): ?array
    {
        return $this->foreignData;
    }

    public function getFrameEffects(): ?array
    {
        return $this->frameEffects;
    }

    public function getFrameVersion(): ?string
    {
        return $this->frameVersion;
    }

    public function getHand(): ?string
    {
        return $this->hand;
    }

    public function getHasAlternativeDeckLimit(): ?bool
    {
        return $this->hasAlternativeDeckLimit;
    }

    public function getHasContentWarning(): ?bool
    {
        return $this->hasContentWarning;
    }

    public function getHasFoil(): ?bool
    {
        return $this->hasFoil;
    }

    public function getHasNonFoil(): ?bool
    {
        return $this->hasNonFoil;
    }

    public function getIdentifiers(): ?array
    {
        return $this->identifiers;
    }

    public function getIsAlternative(): ?bool
    {
        return $this->isAlternative;
    }

    public function getIsFullArt(): ?bool
    {
        return $this->isFullArt;
    }

    public function getIsFunny(): ?bool
    {
        return $this->isFunny;
    }

    public function getIsOnlineOnly(): ?bool
    {
        return $this->isOnlineOnly;
    }

    public function getIsOversized(): ?bool
    {
        return $this->isOversized;
    }

    public function getIsPromo(): ?bool
    {
        return $this->isPromo;
    }

    public function getIsRebalanced(): ?bool
    {
        return $this->isRebalanced;
    }

    public function getIsReprint(): ?bool
    {
        return $this->isReprint;
    }

    public function getIsReserved(): ?bool
    {
        return $this->isReserved;
    }

    public function getIsStarter(): ?bool
    {
        return $this->isStarter;
    }

    public function getIsStorySpotlight(): ?bool
    {
        return $this->isStorySpotlight;
    }

    public function getIsTextless(): ?bool
    {
        return $this->isTextless;
    }

    public function getIsTimeshifted(): ?bool
    {
        return $this->isTimeshifted;
    }

    public function getKeywords(): ?array
    {
        return $this->keywords;
    }

    public function getLanguage(): ?string
    {
        return $this->language;
    }

    public function getLayout(): ?string
    {
        return $this->layout;
    }

    public function getLeadershipSkills(): ?array
    {
        return $this->leadershipSkills;
    }

    public function getLegalities(): ?array
    {
        return $this->legalities;
    }

    public function getLife(): ?string
    {
        return $this->life;
    }

    public function getLoyalty(): ?string
    {
        return $this->loyalty;
    }

    public function getManaCost(): ?string
    {
        return $this->manaCost;
    }

    public function getManaValue(): ?int
    {
        return $this->manaValue;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function getNumber(): ?string
    {
        return $this->number;
    }

    public function getOriginalPrintings(): ?array
    {
        return $this->originalPrintings;
    }

    public function getOriginalReleaseDate(): ?string
    {
        return $this->originalReleaseDate;
    }

    public function getOriginalText(): ?string
    {
        return $this->originalText;
    }

    public function getOriginalType(): ?string
    {
        return $this->originalType;
    }

    public function getOtherFaceIds(): ?array
    {
        return $this->otherFaceIds;
    }

    public function getPower(): ?string
    {
        return $this->power;
    }

    public function getPrintings(): ?array
    {
        return $this->printings;
    }

    public function getPromoTypes(): ?array
    {
        return $this->promoTypes;
    }

    public function getPurchaseUrls(): ?array
    {
        return $this->purchaseUrls;
    }

    public function getRarity(): ?string
    {
        return $this->rarity;
    }

    public function getRelatedCards(): ?array
    {
        return $this->relatedCards;
    }

    public function getRebalancedPrintings(): ?array
    {
        return $this->rebalancedPrintings;
    }

    public function getRulings(): ?array
    {
        return $this->rulings;
    }

    public function getSecurityStamp(): ?string
    {
        return $this->securityStamp;
    }

    public function getSetCode(): ?string
    {
        return $this->setCode;
    }

    public function getSide(): ?string
    {
        return $this->side;
    }

    public function getSignature(): ?string
    {
        return $this->signature;
    }

    public function getSourceProducts(): ?array
    {
        return $this->sourceProducts;
    }

    public function getSubsets(): ?array
    {
        return $this->subsets;
    }

    public function getSubtypes(): ?array
    {
        return $this->subtypes;
    }

    public function getSupertypes(): ?array
    {
        return $this->supertypes;
    }

    public function getText(): ?string
    {
        return $this->text;
    }

    public function getToughness(): ?string
    {
        return $this->toughness;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function getTypes(): ?array
    {
        return $this->types;
    }

    public function getUuid(): string
    {
        return $this->uuid;
    }

    public function getVariations(): ?array
    {
        return $this->variations;
    }

    public function getWatermark(): ?string
    {
        return $this->watermark;
    }
}

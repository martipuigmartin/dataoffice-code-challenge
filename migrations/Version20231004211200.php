<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20231004211200 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('CREATE SEQUENCE card_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE card (id INT NOT NULL, artist VARCHAR(255) DEFAULT NULL, artist_ids JSON DEFAULT NULL, ascii_name VARCHAR(255) DEFAULT NULL, attraction_lights JSON DEFAULT NULL, availability JSON DEFAULT NULL, booster_types JSON DEFAULT NULL, border_color VARCHAR(255) DEFAULT NULL, card_parts JSON DEFAULT NULL, color_identity JSON DEFAULT NULL, color_indicator JSON DEFAULT NULL, colors JSON DEFAULT NULL, converted_mana_cost DOUBLE PRECISION DEFAULT NULL, defense VARCHAR(255) DEFAULT NULL, duel_deck VARCHAR(255) DEFAULT NULL, edhrec_rank INT DEFAULT NULL, edhrec_saltiness INT DEFAULT NULL, face_converted_mana_cost DOUBLE PRECISION DEFAULT NULL, face_flavor_name VARCHAR(255) DEFAULT NULL, face_mana_value INT DEFAULT NULL, face_name VARCHAR(255) DEFAULT NULL, finishes JSON DEFAULT NULL, flavor_name VARCHAR(255) DEFAULT NULL, flavor_text TEXT DEFAULT NULL, foreign_data JSON DEFAULT NULL, frame_effects JSON DEFAULT NULL, frame_version VARCHAR(255) DEFAULT NULL, hand VARCHAR(255) DEFAULT NULL, has_alternative_deck_limit BOOLEAN DEFAULT NULL, has_content_warning BOOLEAN DEFAULT NULL, has_foil BOOLEAN DEFAULT NULL, has_non_foil BOOLEAN DEFAULT NULL, identifiers JSON DEFAULT NULL, is_alternative BOOLEAN DEFAULT NULL, is_full_art BOOLEAN DEFAULT NULL, is_funny BOOLEAN DEFAULT NULL, is_online_only BOOLEAN DEFAULT NULL, is_oversized BOOLEAN DEFAULT NULL, is_promo BOOLEAN DEFAULT NULL, is_rebalanced BOOLEAN DEFAULT NULL, is_reprint BOOLEAN DEFAULT NULL, is_reserved BOOLEAN DEFAULT NULL, is_starter BOOLEAN DEFAULT NULL, is_story_spotlight BOOLEAN DEFAULT NULL, is_textless BOOLEAN DEFAULT NULL, is_timeshifted BOOLEAN DEFAULT NULL, keywords JSON DEFAULT NULL, language VARCHAR(255) DEFAULT NULL, layout VARCHAR(255) DEFAULT NULL, leadership_skills JSON DEFAULT NULL, legalities JSON DEFAULT NULL, life VARCHAR(255) DEFAULT NULL, loyalty VARCHAR(255) DEFAULT NULL, mana_cost VARCHAR(255) DEFAULT NULL, mana_value INT DEFAULT NULL, name VARCHAR(255) DEFAULT NULL, number VARCHAR(255) DEFAULT NULL, original_printings JSON DEFAULT NULL, original_release_date VARCHAR(255) DEFAULT NULL, original_text TEXT DEFAULT NULL, original_type VARCHAR(255) DEFAULT NULL, other_face_ids JSON DEFAULT NULL, power VARCHAR(255) DEFAULT NULL, printings JSON DEFAULT NULL, promo_types JSON DEFAULT NULL, purchase_urls JSON DEFAULT NULL, rarity VARCHAR(255) DEFAULT NULL, related_cards JSON DEFAULT NULL, rebalanced_printings JSON DEFAULT NULL, rulings JSON DEFAULT NULL, security_stamp VARCHAR(255) DEFAULT NULL, set_code VARCHAR(255) DEFAULT NULL, side VARCHAR(255) DEFAULT NULL, source_products JSON DEFAULT NULL, subsets JSON DEFAULT NULL, subtypes JSON DEFAULT NULL, supertypes JSON DEFAULT NULL, text TEXT DEFAULT NULL, toughness VARCHAR(255) DEFAULT NULL, type VARCHAR(255) DEFAULT NULL, types JSON DEFAULT NULL, uuid VARCHAR(255) DEFAULT NULL, variations JSON DEFAULT NULL, watermark VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id))');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE card_id_seq CASCADE');
        $this->addSql('DROP TABLE card');
    }
}

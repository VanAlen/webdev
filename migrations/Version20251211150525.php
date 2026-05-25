<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20251211150525 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // Step 1: add column allowing NULL
    $this->addSql("ALTER TABLE user ADD date_created DATETIME DEFAULT NULL COMMENT '(DC2Type:datetime_immutable)'");

    // Step 2: backfill existing rows with current timestamp
    $this->addSql("UPDATE user SET date_created = NOW() WHERE date_created IS NULL");

    // Step 3: enforce NOT NULL after backfill
    $this->addSql("ALTER TABLE user MODIFY date_created DATETIME NOT NULL COMMENT '(DC2Type:datetime_immutable)'");
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE user DROP date_created');
    }
}

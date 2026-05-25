<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20251017043731 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

public function up(Schema $schema): void
{

}

public function down(Schema $schema): void
{
    $this->addSql('CREATE TABLE category (
        id INT AUTO_INCREMENT NOT NULL,
        gemtype VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`,
        jewelrytype VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`,
        PRIMARY KEY(id)
    ) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
    // Removed: ALTER TABLE customjewelries ADD CONSTRAINT FK_customjewelries_customer ...
}

}

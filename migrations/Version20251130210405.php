<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20251130210405 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Clean migration for Gem/Gemtype relation and order table adjustments';
    }

    public function up(Schema $schema): void
    {
        // Ensure gemtype relation
        $this->addSql('CREATE INDEX IDX_GEM_GEMTYPE_ID ON gem (gemtype_id)');
        $this->addSql('ALTER TABLE gem ADD CONSTRAINT FK_GEM_GEMTYPE FOREIGN KEY (gemtype_id) REFERENCES gemtype (id)');

        // Adjust order table columns
        $this->addSql('ALTER TABLE `order` CHANGE status status VARCHAR(100) NOT NULL, CHANGE amount amount NUMERIC(10, 2) NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // Remove gemtype relation
        $this->addSql('ALTER TABLE gem DROP FOREIGN KEY FK_GEM_GEMTYPE');
        $this->addSql('DROP INDEX IDX_GEM_GEMTYPE_ID ON gem');

        // Revert order table columns
        $this->addSql('ALTER TABLE `order` CHANGE status status VARCHAR(255) NOT NULL, CHANGE amount amount NUMERIC(10, 0) NOT NULL');
    }
}

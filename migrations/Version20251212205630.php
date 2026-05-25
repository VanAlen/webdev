<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20251212205630 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // Make sure the column is nullable
        $this->addSql('ALTER TABLE orders CHANGE created_by_id created_by_id INT DEFAULT NULL');

        // Add the foreign key constraint
        $this->addSql('ALTER TABLE orders ADD CONSTRAINT FK_E52FFDEEB03A8386 FOREIGN KEY (created_by_id) REFERENCES user (id)');

        // Add the index
        $this->addSql('CREATE INDEX IDX_E52FFDEEB03A8386 ON orders (created_by_id)');
    }
    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE orders DROP FOREIGN KEY FK_E52FFDEEB03A8386');
        $this->addSql('DROP INDEX IDX_E52FFDEEB03A8386 ON orders');
    }
}

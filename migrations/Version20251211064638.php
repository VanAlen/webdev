<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20251211064638 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE customjewelries ADD jewelrytype_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE customjewelries ADD CONSTRAINT FK_6DFDE93136DC1C2 FOREIGN KEY (jewelrytype_id) REFERENCES jewelrytype (id)');
        $this->addSql('CREATE INDEX IDX_6DFDE93136DC1C2 ON customjewelries (jewelrytype_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE customjewelries DROP FOREIGN KEY FK_6DFDE93136DC1C2');
        $this->addSql('DROP INDEX IDX_6DFDE93136DC1C2 ON customjewelries');
        $this->addSql('ALTER TABLE customjewelries DROP jewelrytype_id');
    }
}

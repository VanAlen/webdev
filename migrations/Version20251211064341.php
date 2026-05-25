<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20251211064341 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE customjewelries DROP FOREIGN KEY FK_6DFDE93C5872B75');
        $this->addSql('DROP INDEX IDX_6DFDE93C5872B75 ON customjewelries');
        $this->addSql('ALTER TABLE customjewelries CHANGE gemtype_id_id gemtype_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE customjewelries ADD CONSTRAINT FK_6DFDE93D58B5513 FOREIGN KEY (gemtype_id) REFERENCES gemtype (id)');
        $this->addSql('CREATE INDEX IDX_6DFDE93D58B5513 ON customjewelries (gemtype_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE customjewelries DROP FOREIGN KEY FK_6DFDE93D58B5513');
        $this->addSql('DROP INDEX IDX_6DFDE93D58B5513 ON customjewelries');
        $this->addSql('ALTER TABLE customjewelries CHANGE gemtype_id gemtype_id_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE customjewelries ADD CONSTRAINT FK_6DFDE93C5872B75 FOREIGN KEY (gemtype_id_id) REFERENCES gemtype (id)');
        $this->addSql('CREATE INDEX IDX_6DFDE93C5872B75 ON customjewelries (gemtype_id_id)');
    }
}

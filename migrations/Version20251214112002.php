<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20251214112002 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE customjewelries ADD customer_id INT NOT NULL');
        $this->addSql('ALTER TABLE customjewelries ADD CONSTRAINT FK_8E1AE00D9395C3F3 FOREIGN KEY (customer_id) REFERENCES User (id)');
        $this->addSql('CREATE INDEX IDX_8E1AE00D9395C3F3 ON customjewelries (customer_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE Customjewelries DROP FOREIGN KEY FK_8E1AE00D9395C3F3');
        $this->addSql('DROP INDEX IDX_8E1AE00D9395C3F3 ON Customjewelries');
        $this->addSql('ALTER TABLE Customjewelries DROP customer_id');
    }
}

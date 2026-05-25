<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20251017052633 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

public function up(Schema $schema): void
{
    // Remove this — table already exists
    // $this->addSql('CREATE TABLE jewelrytype (...)');

    // Remove this — table may already be gone
    // $this->addSql('DROP TABLE category');

    // Remove this — foreign key may not exist
    // $this->addSql('ALTER TABLE customjewelries DROP FOREIGN KEY FK_customjewelries_customer');

    // ✅ Keep these — they add the relation to jewelries
    $this->addSql('ALTER TABLE jewelries ADD jewelrytype_id INT DEFAULT NULL, DROP jewelrytype');
    $this->addSql('ALTER TABLE jewelries ADD CONSTRAINT FK_CDCD7C97136DC1C2 FOREIGN KEY (jewelrytype_id) REFERENCES jewelrytype (id)');
    $this->addSql('CREATE INDEX IDX_CDCD7C97136DC1C2 ON jewelries (jewelrytype_id)');
}


    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE jewelries DROP FOREIGN KEY FK_CDCD7C97136DC1C2');
        $this->addSql('CREATE TABLE category (id INT AUTO_INCREMENT NOT NULL, gemtype VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, jewelrytype VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('DROP TABLE jewelrytype');
        $this->addSql('ALTER TABLE customjewelries ADD CONSTRAINT FK_customjewelries_customer FOREIGN KEY (customer_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('DROP INDEX IDX_CDCD7C97136DC1C2 ON jewelries');
        $this->addSql('ALTER TABLE jewelries ADD jewelrytype VARCHAR(255) NOT NULL, DROP jewelrytype_id');
    }
}

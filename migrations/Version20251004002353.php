<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20251004002353 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE product CHANGE gemtype gemtype VARCHAR(255) NOT NULL, CHANGE carat carat DOUBLE PRECISION NOT NULL, CHANGE size size VARCHAR(100) NOT NULL, CHANGE cut cut VARCHAR(100) NOT NULL, CHANGE color color VARCHAR(100) NOT NULL, CHANGE clarity clarity VARCHAR(255) NOT NULL, CHANGE origin origin VARCHAR(100) NOT NULL, CHANGE description description VARCHAR(255) NOT NULL, CHANGE stock stock INT NOT NULL, CHANGE price price NUMERIC(10, 0) NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE product CHANGE gemtype gemtype VARCHAR(100) DEFAULT \'\' NOT NULL, CHANGE carat carat VARCHAR(100) DEFAULT \'\' NOT NULL, CHANGE size size VARCHAR(100) DEFAULT \'\' NOT NULL, CHANGE cut cut VARCHAR(100) DEFAULT \'\' NOT NULL, CHANGE color color VARCHAR(100) DEFAULT \'\' NOT NULL, CHANGE clarity clarity VARCHAR(255) DEFAULT \'\' NOT NULL, CHANGE origin origin VARCHAR(100) DEFAULT \'\' NOT NULL, CHANGE description description VARCHAR(255) DEFAULT \'\' NOT NULL, CHANGE stock stock INT DEFAULT 0 NOT NULL, CHANGE price price NUMERIC(10, 0) DEFAULT \'0\' NOT NULL');
    }
}

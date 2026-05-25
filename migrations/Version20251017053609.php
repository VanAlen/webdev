<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20251017053609 extends AbstractMigration
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
    $this->addSql('ALTER TABLE jewelries DROP FOREIGN KEY FK_CDCD7C97136DC1C2');
    $this->addSql('ALTER TABLE jewelries DROP FOREIGN KEY FK_Jewelries_Jewelrytype');
    $this->addSql('ALTER TABLE jewelries ADD jewelrytype VARCHAR(255) NOT NULL, DROP jewelrytype_id');
}


}
